<?php
namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\CategoriasModel;
use CodeIgniter\HTTP\RedirectResponse;

class Producto extends BaseController
{
    protected ProductosModel   $productoModel;
    protected CategoriasModel  $categoriaModel;

    public function __construct()
    {
        $this->productoModel  = new ProductosModel();
        $this->categoriaModel = new CategoriasModel();
    }

    /* ---------- catálogo completo ---------- */
    public function catalogo()
    {
        return view('pages/catalogo_vista', [
            'productos'       => $this->productoModel->getProductosConCategoria(),
            'titulo'          => 'Catálogo',
            'categorias_menu' => $this->categoriaModel->getAllCategories(),
        ]);
    }

    /* ---------- búsqueda unificada (ID o nombre) + vista detalle ---------- */
    public function por_producto(?string $valor = null)
    {
        /* 1) Si viene desde /producto/buscar?q=... */
        if ($valor === null) {
            $valor = $this->request->getGet('q');
        }

        /* 2) Nada que buscar → al catálogo */
        if ($valor === null || $valor === '') {
            return redirect()->to(base_url('catalogo'));
        }

        /* 3) Buscar (ID numérico o nombre) */
        $producto = $this->productoModel->buscarProducto($valor);

        /* 4) Si no existe → página “no encontrado” */
        if (!$producto) {
            return view('pages/por_producto', [
                'producto'        => null,
                'titulo'          => 'Producto no encontrado',
                'categorias_menu' => $this->categoriaModel->getAllCategories(),
            ]);
        }

        /* 5) Añadir nombre de la categoría */
        $cat = $this->categoriaModel->find($producto['id_categoria']);
        $producto['nombre_categoria'] = $cat['nombre'] ?? 'Sin categoría';

        /* 6) Render detalle */
        return view('pages/por_producto', [
            'producto'        => $producto,
            'titulo'          => $producto['nombre'],
            'categorias_menu' => $this->categoriaModel->getAllCategories(),
        ]);
    }    /* ---------- Métodos de Administración de Productos ---------- */

    /**
     * Muestra el formulario para agregar un nuevo producto.
     */
    public function agregar(): string
    {
        $data = [
            'titulo'     => 'Agregar Nuevo Producto',
            'categorias' => $this->categoriaModel->getAllCategories(), // Necesitamos las categorías para el dropdown
            'categorias_menu' => $this->categoriaModel->getAllCategories(), // Para el menú de la cabecera
        ];
        return view('pages/agregar_producto', $data);
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     */
    public function guardar(): RedirectResponse
    {
        // Validar datos del formulario (¡IMPORTANTE!)
        $rules = [
            'nombre'       => 'required|min_length[3]|max_length[255]',
            'descripcion'  => 'required',
            'precio'       => 'required|numeric|greater_than[0]',
            'stock'        => 'required|integer|greater_than_equal_to[0]',
            'id_categoria' => 'required|integer',
            'activo'       => 'required|in_list[0,1]', // 0 o 1
            'image_url'    => 'permit_empty|valid_url_strict', // O 'uploaded[image_url]|max_size[image_url,1024]|is_image[image_url]' si es una carga de archivo
        ];

        if (!$this->validate($rules)) {
            // Si la validación falla, recargar el formulario con los errores
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre'        => $this->request->getPost('nombre'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'precio'        => $this->request->getPost('precio'),
            'stock'         => $this->request->getPost('stock'),
            'image_url'     => $this->request->getPost('image_url'), // Ajustar si es carga de archivo
            'activo'        => $this->request->getPost('activo'),
            'id_categoria'  => $this->request->getPost('id_categoria'),
        ];

        $this->productoModel->save($data); // save() maneja inserción y actualización

        return redirect()->to(base_url('productos/listar'))->with('success', 'Producto agregado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     * @param int $id ID del producto a editar.
     */
    public function editar(int $id): string|RedirectResponse
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            return redirect()->to(base_url('productos/listar'))->with('error', 'Producto no encontrado para editar.');
        }

        $data = [
            'titulo'     => 'Editar Producto',
            'producto'   => $producto,
            'categorias' => $this->categoriaModel->getAllCategories(), // Necesitamos las categorías para el dropdown
            'categorias_menu' => $this->categoriaModel->getAllCategories(), // Para el menú de la cabecera
        ];
        return view('pages/editar_producto', $data);
    }

    /**
     * Actualiza un producto existente en la base de datos.
     * @param int $id ID del producto a actualizar (se pasa oculto en el formulario).
     */
    public function actualizar(): RedirectResponse
    {
        $rules = [
            'id_producto'  => 'required|integer|is_not_unique[producto.id_producto]', // Aseguramos que el ID existe
            'nombre'       => 'required|min_length[3]|max_length[255]',
            'descripcion'  => 'required',
            'precio'       => 'required|numeric|greater_than[0]',
            'stock'        => 'required|integer|greater_than_equal_to[0]',
            'id_categoria' => 'required|integer',
            // 'activo' field is optional because unchecked checkbox won't send it
            'activo'       => 'permit_empty|in_list[0,1]',
            'image_url'    => 'permit_empty|valid_url_strict',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_producto = $this->request->getPost('id_producto');

        // Checkbox unchecked means 'activo' is not sent, so default to 0
        $activo = $this->request->getPost('activo') ?? 0;

        $data = [
            'id_producto'   => $id_producto, // Necesario para que save() sepa que es una actualización
            'nombre'        => $this->request->getPost('nombre'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'precio'        => $this->request->getPost('precio'),
            'stock'         => $this->request->getPost('stock'),
            'image_url'     => $this->request->getPost('image_url'),
            'activo'        => $activo,
            'id_categoria'  => $this->request->getPost('id_categoria'),
        ];

        $this->productoModel->save($data); // save() actualiza si el 'primaryKey' está presente

        return redirect()->to(base_url('productos/listar'))->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Lista todos los productos para la administración.
     */
    public function listar(): string
    {
        $data = [
            'titulo'          => 'Lista de Productos (Admin)',
            'productos'       => $this->productoModel->getAllAdminProductsConCategoria(), // Nuevo método en el modelo
            'categorias_menu' => $this->categoriaModel->getAllCategories(), // Para el menú de la cabecera
        ];
        return view('pages/listar_productos', $data);
    }

 public function eliminar(int $id): RedirectResponse
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            return redirect()->to(base_url('productos/listar'))->with('error', 'Producto no encontrado para eliminar.');
        }

        $this->productoModel->delete($id);

        return redirect()->to(base_url('productos/listar'))->with('success', 'Producto eliminado (ocultado) exitosamente.');
    }

    /**
     * Elimina múltiples productos (soft delete) seleccionados desde la tabla.
     */
    public function eliminar_seleccionados(): RedirectResponse
    {
        $ids = $this->request->getPost('ids_eliminar'); // Obtener el array de IDs seleccionados

        if (empty($ids) || !is_array($ids)) {
            return redirect()->to(base_url('productos/listar'))->with('error', 'No se seleccionaron productos para eliminar.');
        }

        $productos_eliminados_count = 0;
        foreach ($ids as $id) {
            // Opcional: Podrías validar cada ID si existe antes de eliminar.
            // Para simplificar, asumimos que los IDs vienen de la tabla.
            $this->productoModel->delete((int)$id); // Asegurarse de que sea un entero
            $productos_eliminados_count++;
        }

        if ($productos_eliminados_count > 0) {
            return redirect()->to(base_url('productos/listar'))->with('success', $productos_eliminados_count . ' producto(s) eliminado(s) (ocultados) exitosamente.');
        } else {
            return redirect()->to(base_url('productos/listar'))->with('error', 'No se pudo eliminar ningún producto seleccionado.');
        }
    }

    /**
     * Cambia el estado activo/inactivo de un producto.
     * @param int $id ID del producto a cambiar estado.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function toggleActivo(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            return redirect()->to(base_url('productos/listar'))->with('error', 'Producto no encontrado para cambiar estado.');
        }

        $nuevoEstado = $producto['activo'] ? 0 : 1;

        $this->productoModel->update($id, ['activo' => $nuevoEstado]);

        return redirect()->to(base_url('productos/listar'))->with('success', 'Estado del producto actualizado correctamente.');
    }

public function catalogoPorCategoria(int $id_categoria)
{
    $productos = $this->productoModel
                      ->where('id_categoria', $id_categoria)
                      ->where('activo', 1)
                      ->findAll();

    $categoria = $this->categoriaModel->find($id_categoria);
    $nombre_categoria = $categoria['nombre'] ?? 'Categoría desconocida';

    return view('pages/catalogo_vista', [
        'productos'       => $productos,
        'titulo'          => 'Productos en: ' . $nombre_categoria,
        'categorias_menu' => $this->categoriaModel->getAllCategories(),
    ]);
}


}
