<?php namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\ProductosModel; // <-- AÑADIR ESTA LÍNEA
use App\Models\UsuarioModelo;  // <-- AÑADIR ESTA LÍNEA

class CarritoController extends BaseController
{
    protected CarritoModel $carritoModel;
    protected ProductosModel $productosModel; // <-- AÑADIR ESTA PROPIEDAD
    protected $db; // <-- AÑADIR ESTA PROPIEDAD

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->productosModel = new ProductosModel(); // <-- AÑADIR ESTA LÍNEA para inicializar ProductosModel
        $this->db = \Config\Database::connect(); // <-- AÑADIR ESTA LÍNEA para la conexión a la base de datos para transacciones
    }

    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $idUsuario = $this->session->get('id_usuario');

        if (!$idUsuario) {
            session()->setFlashdata('error', 'Debes iniciar sesión para ver el carrito.');
            return redirect()->to(base_url('ingresar'));
        }

        $carrito = $this->carritoModel->getCarritoPorUsuario((int) $idUsuario);

        $data = [ // <-- AÑADIR/MODIFICAR ESTO para pasar $data a la vista
            'titulo' => 'Tu Carrito de Compras',
            'carrito' => $carrito
        ];
        return view('templates/carrito', $data);
    }

    public function agregar(): \CodeIgniter\HTTP\RedirectResponse
    {
        $idUsuario  = (int) $this->session->get('id_usuario');
        $idProducto = (int) $this->request->getPost('id_producto');
        $cantidad   = (int) ($this->request->getPost('cantidad') ?? 1);

        if ($idUsuario <= 0) {
            session()->setFlashdata('error', 'Debes iniciar sesión para agregar productos al carrito.');
            return redirect()->to(base_url('ingresar'));
        }

        if ($idProducto <= 0 || $cantidad <= 0) {
            session()->setFlashdata('error', 'Producto o cantidad inválidos.');
            return redirect()->back();
        }

        // NO SE AÑADE VERIFICACIÓN DE STOCK AQUÍ POR AHORA para mantener tu versión funcional original.
        // Esto se manejará al finalizar la compra.

        if ($this->carritoModel->agregarProducto($idUsuario, $idProducto, $cantidad)) {
            session()->setFlashdata('success', 'Producto agregado al carrito.');
        } else {
            session()->setFlashdata('error', 'Error al agregar el producto al carrito.');
        }

        return redirect()->back();
    }

    public function actualizar(): \CodeIgniter\HTTP\RedirectResponse
    {
        $idCarrito = (int) $this->request->getPost('id_carrito');
        $cantidad  = (int) ($this->request->getPost('cantidad') ?? 1);
        $idUsuario = (int) $this->session->get('id_usuario');

        if ($idCarrito <= 0 || $cantidad <= 0) {
            session()->setFlashdata('error', 'Datos inválidos para actualizar.');
            return redirect()->back();
        }

        $item = $this->carritoModel->find($idCarrito);

        if (!$item || (int)$item['id_usuario'] !== $idUsuario) {
            session()->setFlashdata('error', 'Acción no autorizada.');
            return redirect()->to(base_url('carrito'));
        }

        // NO SE AÑADE VERIFICACIÓN DE STOCK AQUÍ POR AHORA para mantener tu versión funcional original.

        if ($this->carritoModel->actualizarCantidad($idCarrito, $cantidad)) {
            session()->setFlashdata('success', 'Cantidad actualizada.');
        } else {
            session()->setFlashdata('error', 'No se pudo actualizar la cantidad.');
        }

        return redirect()->to(base_url('carrito'));
    }

    public function eliminar(): \CodeIgniter\HTTP\RedirectResponse
    {
        $idCarrito = (int) $this->request->getPost('id_carrito');
        $idUsuario = (int) $this->session->get('id_usuario');

        if ($idCarrito <= 0) {
            session()->setFlashdata('error', 'ID de carrito inválido.');
            return redirect()->back();
        }

        $item = $this->carritoModel->find($idCarrito);

        if (!$item || (int)$item['id_usuario'] !== $idUsuario) {
            session()->setFlashdata('error', 'Acción no autorizada.');
            return redirect()->to(base_url('carrito'));
        }

        if ($this->carritoModel->eliminarProducto($idCarrito)) {
            session()->setFlashdata('success', 'Producto eliminado.');
        } else {
            session()->setFlashdata('error', 'No se pudo eliminar el producto.');
        }

        return redirect()->to(base_url('carrito'));
    }

    public function vaciar(): \CodeIgniter\HTTP\RedirectResponse
    {
        $idUsuario = (int) $this->session->get('id_usuario');

        if ($idUsuario <= 0) {
            session()->setFlashdata('error', 'No hay usuario válido.');
            return redirect()->to(base_url('ingresar'));
        }

        if ($this->carritoModel->vaciarCarrito($idUsuario)) {
            session()->setFlashdata('success', 'Carrito vaciado.');
        } else {
            session()->setFlashdata('error', 'No se pudo vaciar el carrito.');
        }

        return redirect()->to(base_url('carrito'));
    }

    // <-- INICIO: AÑADIR NUEVO MÉTODO finalizarCompra()
    /**
     * Procesa la finalización de la compra: descuenta stock y vacía el carrito.
     * Genera la factura después de una compra exitosa.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function finalizarCompra(): \CodeIgniter\HTTP\RedirectResponse
    {
        $idUsuario = (int) $this->session->get('id_usuario');

        if ($idUsuario <= 0) {
            session()->setFlashdata('error', 'Debes iniciar sesión para finalizar la compra.');
            return redirect()->to(base_url('ingresar'));
        }

        $carritoItems = $this->carritoModel->getCarritoPorUsuario($idUsuario);

        if (empty($carritoItems)) {
            session()->setFlashdata('error', 'Tu carrito está vacío. No hay productos para comprar.');
            return redirect()->to(base_url('carrito'));
        }

        $this->db->transBegin(); // Iniciar la transacción

        $compraExitosa = true;
        $productosComprados = []; // Para almacenar los detalles para la factura

        foreach ($carritoItems as $item) {
            $producto = $this->productosModel->find($item['id_producto']);

            if (!$producto || $producto['stock'] < $item['cantidad']) {
                session()->setFlashdata('error', 'Stock insuficiente para ' . esc($producto['nombre'] ?? 'un producto') . '. La compra no pudo completarse.');
                $compraExitosa = false;
                break; // Romper el bucle si hay stock insuficiente
            }

            // Descontar el stock
            $nuevoStock = $producto['stock'] - $item['cantidad'];
            $updateResult = $this->productosModel->update($item['id_producto'], ['stock' => $nuevoStock]);

            if (!$updateResult) {
                session()->setFlashdata('error', 'Error al actualizar el stock para ' . esc($producto['nombre']) . '. La compra no pudo completarse.');
                $compraExitosa = false;
                break;
            }

            // Añadir detalles del producto para la factura
            $productosComprados[] = [
                'nombre'          => $producto['nombre'],
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $producto['precio'],
                'subtotal'        => $producto['precio'] * $item['cantidad']
            ];
        }

        if ($compraExitosa) {
            // Vaciar el carrito si la compra fue exitosa
            if ($this->carritoModel->vaciarCarrito($idUsuario)) {
                $this->db->transCommit(); // Confirmar la transacción
                session()->setFlashdata('success', '¡Compra finalizada exitosamente! Aquí está tu factura.');

                // Cargar el modelo de usuario para obtener los datos del cliente
                $usuarioModel = model('App\Models\UsuarioModelo');
                $clienteData = $usuarioModel->find($idUsuario);

                // Guardar los detalles de la compra en la sesión para la factura
                $this->session->set('last_invoice_data', [
                    'cliente_id'     => $idUsuario,
                    'cliente_nombre' => $clienteData['nombre'] ?? 'Desconocido',
                    'cliente_email'  => $clienteData['email'] ?? 'Desconocido',
                    'productos'      => $productosComprados,
                    'fecha'          => date('Y-m-d H:i:s'),
                    'total'          => array_sum(array_column($productosComprados, 'subtotal'))
                ]);

                return redirect()->to(base_url('factura')); // Redirigir a la vista de factura
            } else {
                $this->db->transRollback(); // Revertir si falla el vaciado del carrito
                session()->setFlashdata('error', 'Error al vaciar el carrito después de la compra. Por favor, inténtalo de nuevo.');
            }
        } else {
            $this->db->transRollback(); // Revertir si la compra no fue exitosa (stock, etc.)
        }

        return redirect()->to(base_url('carrito'));
    }
    // <-- FIN: AÑADIR NUEVO MÉTODO finalizarCompra()
}
