<?php namespace App\Controllers;

use App\Models\CategoriasModel;

class Home extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriasModel();
    }

    public function cuerpo()
    {
        $categorias = $this->categoriaModel->getAllCategories();
        return view('templates/main_layout', [         
            'car' => view('components/carrousel'),
            'card' => view('components/cards'),
            'categorias_menu' => $categorias
        ]);
    }

    public function quienessomos()
    {
        $categorias = $this->categoriaModel->getAllCategories();
        return view('templates/main_layout', [          
            'who' => view('pages/quienessomos'),
            'categorias_menu' => $categorias
        ]);
    }

    public function comercializacion()
    {
        $categorias = $this->categoriaModel->getAllCategories();
        return view('templates/main_layout' , [ 
            'comerc' => view('pages/comerce'),
            'categorias_menu' => $categorias
        ]);
    }

    public function inicio()
    {
        $categorias = $this->categoriaModel->getAllCategories();
        return view('templates/main_layout' , [
            'ini' => view('components/cabecera'),
            'categorias_menu' => $categorias
        ]);
    }

    public function contacto()
    {
        $categorias = $this->categoriaModel->getAllCategories();
        return view('templates/main_layout', [
            'contact' => view('pages/contacto'),
            'categorias_menu' => $categorias
        ]);
    }

    public function terminos()
    {
        $categorias = $this->categoriaModel->getAllCategories();
        return view('templates/main_layout', [
            'term' => view('pages/terminos'),
            'categorias_menu' => $categorias
        ]);
    }

    public function usuario_controller(){
        // Mantén tu código de usuario_controller aquí si lo tienes
    }
}