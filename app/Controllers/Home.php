<?php
namespace App\Controllers;

class Home extends BaseController
{


    public function catalogo()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT id_producto, nombre, descripcion, precio, stock FROM producto");
        $productos = $query->getResult();

        $catal = view('catalogo/catalogo_vista', ['productos' => $productos]);


        return view('templates/main_layout', [
            'titulo' => 'Catalogo de productos', // Puedes seguir usándolo en la etiqueta <title> si lo deseas
            'content' => $catal // Pasa el HTML renderizado de la tabla al slot 'content'
        ]);
    }

    public function cuerpo()
    {
        return view('templates/main_layout', [        
            'car' => view('components/carrousel'),
            'card' => view('components/cards'),         
        ]);
    }


    public function quienessomos()
    {
        return view('templates/main_layout', [            
            'who' => view('pages/quienessomos'),             
        ]);
    }

    public function comercializacion()
    {
        return view('templates/main_layout' , [ 
            'comerc' => view('pages/comerce'),
        ]);
    
    }

    public function inicio()
    {
        return view('templates/main_layout' , [
            'ini' => view('components/cabecera'),
        ]);
    }

    public function contacto()
    {
        return view('templates/main_layout', [
            'contact' => view('pages/contacto'),
        ]);
    }

    public function terminos()
    {
        return view('templates/main_layout', [
            'term' => view('pages/terminos')
        ]);
    }

    public function usuario_controller(){
        
    }

}