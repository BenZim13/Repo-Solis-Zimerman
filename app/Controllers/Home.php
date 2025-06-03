<?php
namespace App\Controllers;
use App\Models\ProductosModel;


class Home extends BaseController
{


public function catalogo()
{
    $productoModel = new ProductosModel();
    $resultado = $productoModel->findAll();

    $catal_html = view('catalogo/catalogo_vista', ['productos' => $resultado]);

    return view('templates/main_layout', [
        'titulo' => 'Catalogo de productos',
        'content_for_layout' => $catal_html // AHORA ES 'content_for_layout'
    ]);
}

public function por_producto($id_segmento = null)
{
    $request = \Config\Services::request();
    $id_get = $request->getGet('id');
    $id = $id_segmento ?? $id_get;

    if (empty($id)) {
        return redirect()->to('/')->with('error', 'Por favor, ingrese un ID de producto para buscar.');
    }

    $productoModel = new ProductosModel();
    $producto = $productoModel->find($id);

    if (!$producto) {
        return view("templates/main_layout", [
            'titulo' => 'Producto no encontrado',
            'content_for_layout' => '<h2>Producto no encontrado</h2><p>El producto con el ID ' . esc($id) . ' no existe.</p>' // AHORA ES 'content_for_layout'
        ]);
    }

    return view("templates/main_layout", [
        'titulo' => 'Producto en específico',
        'content_for_layout' => view('pages/por_producto', ['producto' => $producto]) // AHORA ES 'content_for_layout'
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