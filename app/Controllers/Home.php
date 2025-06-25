<?php

namespace App\Controllers;

use App\Models\CategoriasModel;
use App\Models\ProductosModel; // Importar el modelo de productos

class Home extends BaseController
{
    protected CategoriasModel $categoriaModel;
    protected ProductosModel $productosModel; // Declarar propiedad para el modelo de productos

    public function __construct()
    {
        $this->categoriaModel = new CategoriasModel();
        $this->productosModel = new ProductosModel(); // Inicializar el modelo de productos
    }

    public function index(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        // Obtener productos para la sección de inicio
        $productosDestacados = $this->productosModel->where('activo', 1)
                                                    ->orderBy('fecha_alta', 'DESC') // O cualquier otra lógica de ordenamiento para "más buscados"
                                                    ->limit(6) // Obtener 6 productos para las cards
                                                    ->findAll();
        $data = [
            'titulo' => 'Inicio - SuperCarpi',
            'categorias_menu' => $categorias,
            'productos_destacados' => $productosDestacados, // Pasar los productos destacados a la vista
        ];
        return view('home/inicio', $data);
    }

    public function cuerpo(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        // Obtener productos para la sección de inicio
        $productosDestacados = $this->productosModel->where('activo', 1)
                                                    ->orderBy('fecha_alta', 'DESC') // O cualquier otra lógica de ordenamiento para "más buscados"
                                                    ->limit(6) // Obtener 6 productos para las cards
                                                    ->findAll();
        $data = [
            'titulo' => 'Página Principal - SuperCarpi',
            'categorias_menu' => $categorias,
            'productos_destacados' => $productosDestacados, // Pasar los productos destacados a la vista
        ];
        return view('home/inicio', $data);
    }

    public function quienessomos(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        $data = [
            'titulo' => 'Quiénes Somos - SuperCarpi',
            'categorias_menu' => $categorias,
        ];
        return view('pages/quienessomos', $data);
    }

    public function comercializacion(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        $data = [
            'titulo' => 'Comercialización - SuperCarpi',
            'categorias_menu' => $categorias,
        ];
        return view('pages/comerce', $data);
    }

    public function contacto(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        $data = [
            'titulo' => 'Contacto - SuperCarpi',
            'categorias_menu' => $categorias,
        ];
        return view('pages/contacto', $data);
    }

    public function terminos(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        $data = [
            'titulo' => 'Términos y Usos - SuperCarpi',
            'categorias_menu' => $categorias,
        ];
        return view('pages/terminos', $data);
    }

    /**
     * Manejador para rutas no encontradas (error 404).
     * @return string
     */
    public function error404(): string
    {
        $data = [
            'titulo' => 'Página No Encontrada',
            'categorias_menu' => $this->categoriaModel->getAllCategories(),
            'message' => 'Lo sentimos, la página que estás buscando no pudo ser encontrada.', // <-- ¡AÑADIDO AQUÍ!
        ];
        // Asegúrate de que 'app/Views/errors/html/error_404.php' exista y use esta variable.
        return view('errors/html/error_404', $data);
    }
}
