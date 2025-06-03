<?php
namespace App\Controllers;
use App\Models\ProductosModel;


class Home extends BaseController
{


    public function catalogo()
    {
        /*$db = \Config\Database::connect();

        $query = $db->query("SELECT id_producto, nombre, descripcion, precio, stock FROM producto");
        $productos = $query->getResultArray();

        $catal = view('catalogo/catalogo_vista', ['productos' => $productos]);
*/
        $productoModel = new ProductosModel(); //instancio objeto del modelo ProductosModel
        $resultado = $productoModel->findAll();//consulta de las n filas de la tabla, tipo array

         $catal = view('catalogo/catalogo_vista', ['productos' => $resultado]);

        return view('templates/main_layout', [
            'titulo' => 'Catalogo de productos', // Puedes seguir usándolo en la etiqueta <title> si lo deseas
            'content' => $catal // Pasa el HTML renderizado de la tabla al slot 'content'
        ]);
    }

public function por_producto($id_segmento = null) // Puede ser null si viene por GET
{
    $request = \Config\Services::request();
    $id_get = $request->getGet('id'); // Obtiene el 'id' del parámetro GET

    // Prioriza el ID del segmento de la URL si existe, de lo contrario, usa el de GET
    $id = $id_segmento ?? $id_get;

    if (empty($id)) {
        return redirect()->to('/')->with('error', 'Por favor, ingrese un ID de producto para buscar.');
    }

    $productoModel = new ProductosModel();
    $producto = $productoModel->find($id);

    if (!$producto) {
        return view("templates/main_layout", [
            'titulo' => 'Producto no encontrado',
            'prod' => '<h2>Producto no encontrado</h2><p>El producto con el ID ' . esc($id) . ' no existe.</p>'
        ]);
    }

    return view("templates/main_layout", [
        'titulo' => 'Producto en específico',
        'prod' => view('pages/por_producto', ['producto' => $producto]) // Ajustado a 'producto'
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