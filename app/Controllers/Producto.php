<?php
namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\CategoriasModel;

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
    }

        public function agregar()
    {
        $categoriasModel = new CategoriasModel();
        $data['categorias'] = $categoriasModel->findAll();

        return view('pages/agregar_producto', $data);
    }

    public function guardar()
    {
        $productoModel = new ProductosModel();

        $data = [
            'nombre'        => $this->request->getPost('nombre'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'precio'        => $this->request->getPost('precio'),
            'stock'         => $this->request->getPost('stock'),
            'image_url'     => $this->request->getPost('image_url'),
            'activo'        => $this->request->getPost('activo'),
            'id_categoria'  => $this->request->getPost('id_categoria')
        ];

        $productoModel->save($data);

        return redirect()->to('/productos/listar');
    }

    public function eliminar($id)
    {
        $productoModel = new ProductosModel();
        $productoModel->delete($id);

        return redirect()->to('/productos/listar');
    }

    public function listar()
    {
        $productoModel = new ProductosModel();
        $data['productos'] = $productoModel
            ->select('producto.*, categoria.nombre as nombre_categoria')
            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
            ->findAll();

        return view('pages/listar_productos', $data);
    }
}
