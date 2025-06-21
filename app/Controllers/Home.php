<?php

namespace App\Controllers;

use App\Models\CategoriasModel; // Asegúrate de que el nombre del modelo sea correcto

class Home extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriasModel();
    }

    // Método principal para la página de inicio (ruta '/')
    public function index(): string // Cambié a 'index' ya que es la convención para la ruta base
    {
        $categorias = $this->categoriaModel->getAllCategories();

        $data = [
            'titulo' => 'Inicio - SuperCarpi', // Título para la cabecera
            'categorias_menu' => $categorias,   // Categorías para el menú de la cabecera
        ];

        // Retorna la vista que extiende main_layout y define 'content_for_layout'
        // Sugiero crear una vista 'home/inicio.php' que contenga el carrusel y las cards
        return view('home/inicio', $data);
    }

    // Si tu método 'cuerpo' era el que cargaba el inicio, ahora index lo reemplaza o lo llamas desde index
    // Por ejemplo, si tenías una vista 'home/cuerpo.php' con el carrusel y las cards, el método 'index'
    // debería llamarla.
    public function cuerpo(): string // Este método se podría mantener si lo llamas desde otra ruta
    {
        $categorias = $this->categoriaModel->getAllCategories();
        $data = [
            'titulo' => 'Página Principal - SuperCarpi',
            'categorias_menu' => $categorias,
        ];
        // Si 'components/carrousel' y 'components/cards' no extienden main_layout,
        // tendrías que cargarlos dentro de una vista que sí lo extienda.
        // O si son módulos pequeños, podrías incluirlos directamente en el método index
        // pero eso sobrecarga el controlador. Es mejor que una vista los "componga".
        return view('home/inicio', $data); // Asumo que 'home/inicio' contendrá el carrusel y las cards.
    }


    public function quienessomos(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        $data = [
            'titulo' => 'Quiénes Somos - SuperCarpi',
            'categorias_menu' => $categorias,
        ];
        // La vista 'pages/quienessomos' debe extender 'main_layout' y definir su sección 'content_for_layout'
        return view('pages/quienessomos', $data);
    }

    public function comercializacion(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        $data = [
            'titulo' => 'Comercialización - SuperCarpi',
            'categorias_menu' => $categorias,
        ];
        // La vista 'pages/comerce' debe extender 'main_layout' y definir su sección 'content_for_layout'
        return view('pages/comerce', $data);
    }

    // Este método 'inicio' parece que intentaba cargar la cabecera, pero la cabecera
    // ya se carga directamente desde main_layout. Se recomienda eliminarlo o cambiar su propósito.
    // Si quieres una página de "inicio" que no sea la raíz, cámbiale el nombre.
    // Lo comento para evitar confusiones con el 'index' y la carga de la cabecera.
    /*
    public function inicio()
    {
        $categorias = $this->categoriaModel->getAllCategories();
        return view('templates/main_layout' , [
            'ini' => view('components/cabecera'), // La cabecera se carga en el layout principal
            'categorias_menu' => $categorias
        ]);
    }
    */

    public function contacto(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        $data = [
            'titulo' => 'Contacto - SuperCarpi',
            'categorias_menu' => $categorias,
        ];
        // La vista 'pages/contacto' debe extender 'main_layout' y definir su sección 'content_for_layout'
        return view('pages/contacto', $data);
    }

    public function terminos(): string
    {
        $categorias = $this->categoriaModel->getAllCategories();
        $data = [
            'titulo' => 'Términos y Usos - SuperCarpi',
            'categorias_menu' => $categorias,
        ];
        // La vista 'pages/terminos' debe extender 'main_layout' y definir su sección 'content_for_layout'
        return view('pages/terminos', $data);
    }

    // Puedes agregar un método para manejar errores 404 si es necesario,
    // o CodeIgniter tiene uno por defecto.
    /*
    public function error404(): string
    {
        $data['titulo'] = 'Página No Encontrada';
        // Puedes crear una vista personalizada para 404 si lo deseas
        return view('errors/html/error_404', $data);
    }
    */
}