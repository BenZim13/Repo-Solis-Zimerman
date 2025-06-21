<?php namespace App\Controllers;

use App\Models\CarritoModel;
// use CodeIgniter\Controller; // Eliminado: Redundante ya que BaseController ya lo extiende.
// use CodeIgniter\Session\Session; // Eliminado: La sesión ya se gestiona desde BaseController.

class CarritoController extends BaseController // Extiende de BaseController.
{
    protected CarritoModel $carritoModel;

    public function __construct()
    {
        // No es necesario llamar a parent::__construct() o inicializar $this->session aquí,
        // BaseController ya lo hace en su initController().

        // Cargar el modelo del carrito
        $this->carritoModel = new CarritoModel();
    }

    /**
     * Muestra la página del carrito con los productos del usuario.
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        // Obtener el ID del usuario de la sesión.
        $idUsuario = $this->session->get('id_usuario');
        $carrito = [];

        if (!$idUsuario) {
            log_message('info', 'Acceso al carrito sin usuario logueado. Redirigiendo a la página de ingreso.');
            session()->setFlashdata('error', 'Debes iniciar sesión para gestionar tu carrito.');
            return redirect()->to(base_url('ingresar')); // Mejorado: Redirección explícita a la página de ingreso.
        } else {
            // Obtener los productos del carrito asociados a este usuario
            $carrito = $this->carritoModel->getCarritoPorUsuario($idUsuario);
        }

        $data = [
            'titulo' => 'Tu Carrito de Compras',
            'carrito' => $carrito,
        ];

        // Cargar la vista del carrito.
        return view('templates/carrito', $data);
    }

    /**
     * Agrega un producto al carrito.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function agregar(): \CodeIgniter\HTTP\RedirectResponse
    {
        $idUsuario = $this->session->get('id_usuario');
        $idProducto = (int) $this->request->getPost('id_producto');
        $cantidad = (int) ($this->request->getPost('cantidad') ?? 1); // Por defecto 1

        // Validaciones básicas
        if (empty($idUsuario)) {
            session()->setFlashdata('error', 'Debes iniciar sesión para agregar productos al carrito.');
            return redirect()->to(base_url('ingresar')); // Mejorado: Redirección explícita a la página de ingreso.
        }
        if (empty($idProducto) || $idProducto <= 0 || $cantidad <= 0) {
            session()->setFlashdata('error', 'Datos de producto o cantidad inválidos.');
            return redirect()->back();
        }

        // Opcional: Verificar stock del producto antes de agregar.
        // Necesitarías instanciar tu modelo de Productos aquí:
        // $productoModel = new \App\Models\ProductosModel();
        // $producto = $productoModel->find($idProducto);
        // if (!$producto || $producto['stock'] < $cantidad) {
        //     session()->setFlashdata('error', 'Stock insuficiente para la cantidad solicitada.');
        //     return redirect()->back();
        // }

        if ($this->carritoModel->agregarProducto($idUsuario, $idProducto, $cantidad)) {
            session()->setFlashdata('success', 'Producto agregado al carrito exitosamente.');
        } else {
            session()->setFlashdata('error', 'No se pudo agregar el producto al carrito.');
        }

        return redirect()->back(); // Redirige a la página anterior (catálogo o detalle de producto)
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function actualizar(): \CodeIgniter\HTTP\RedirectResponse
    {
        $idCarrito = (int) $this->request->getPost('id_carrito');
        $cantidad = (int) ($this->request->getPost('cantidad') ?? 1); // Asegurar que sea int y al menos 1

        // Validaciones
        if (empty($idCarrito) || $cantidad <= 0) {
            session()->setFlashdata('error', 'Datos de actualización inválidos.');
            return redirect()->back();
        }

        // Seguridad: Asegurarse de que el ítem del carrito pertenece al usuario logueado
        $itemCarrito = $this->carritoModel->find($idCarrito);
        $idUsuario = $this->session->get('id_usuario');
        if (!$itemCarrito || $itemCarrito['id_usuario'] !== $idUsuario) {
            session()->setFlashdata('error', 'Acción no autorizada sobre el carrito.');
            return redirect()->to(base_url('carrito')); // Redirigir al carrito para evitar errores
        }

        if ($this->carritoModel->actualizarCantidad($idCarrito, $cantidad)) {
            session()->setFlashdata('success', 'Cantidad del producto actualizada.');
        } else {
            session()->setFlashdata('error', 'No se pudo actualizar la cantidad.');
        }

        return redirect()->to(base_url('carrito')); // Redirige de nuevo a la vista del carrito
    }

    /**
     * Elimina un producto específico del carrito.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function eliminar(): \CodeIgniter\HTTP\RedirectResponse
    {
        $idCarrito = (int) $this->request->getPost('id_carrito');

        if (empty($idCarrito)) {
            session()->setFlashdata('error', 'ID de ítem de carrito inválido para eliminar.');
            return redirect()->back();
        }

        // Seguridad: Asegurarse de que el ítem del carrito pertenece al usuario logueado
        $itemCarrito = $this->carritoModel->find($idCarrito);
        $idUsuario = $this->session->get('id_usuario');
        if (!$itemCarrito || $itemCarrito['id_usuario'] !== $idUsuario) {
            session()->setFlashdata('error', 'Acción no autorizada para eliminar este ítem.');
            return redirect()->to(base_url('carrito'));
        }

        if ($this->carritoModel->eliminarProducto($idCarrito)) {
            session()->setFlashdata('success', 'Producto eliminado del carrito.');
        } else {
            session()->setFlashdata('error', 'No se pudo eliminar el producto del carrito.');
        }

        return redirect()->to(base_url('carrito')); // Redirige de nuevo a la vista del carrito
    }

    /**
     * Vacía completamente el carrito del usuario.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function vaciar(): \CodeIgniter\HTTP\RedirectResponse
    {
        $idUsuario = $this->session->get('id_usuario');

        if (empty($idUsuario)) {
            session()->setFlashdata('error', 'No hay un usuario logueado para vaciar el carrito.');
            return redirect()->to(base_url('ingresar')); // Mejorado: Redirección explícita a la página de ingreso.
        }

        if ($this->carritoModel->vaciarCarrito($idUsuario)) {
            session()->setFlashdata('success', 'Tu carrito ha sido vaciado completamente.');
        } else {
            session()->setFlashdata('error', 'No se pudo vaciar el carrito.');
        }

        return redirect()->to(base_url('carrito')); // Redirige de nuevo a la vista del carrito (ahora vacía)
    }
}