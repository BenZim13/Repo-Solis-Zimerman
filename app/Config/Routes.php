<?php

namespace Config;

use CodeIgniter\Config\Services;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

// -----------------------------------------------------------------------------
// Rutas del sistema (NO BORRAR)
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Ajustes por defecto
// -----------------------------------------------------------------------------
$routes->setDefaultNamespace('App\Controllers');

// -----------------------------------------------------------------------------
// Páginas estáticas
// -----------------------------------------------------------------------------
$routes->get('/',              'Home::cuerpo');
$routes->get('quienessomos',   'Home::quienessomos');
$routes->get('comercializacion','Home::comercializacion');
$routes->get('inicio',         'Home::inicio');
$routes->get('contacto',       'Home::contacto');
$routes->get('terminos',       'Home::terminos');

// -----------------------------------------------------------------------------
// Catálogo y productos (públicos)
// -----------------------------------------------------------------------------
$routes->group('catalogo', static function (RouteCollection $routes) {
    $routes->get('/',              'Producto::catalogo');               // /catalogo
    $routes->get('categoria/(:num)', 'Producto::catalogoPorCategoria/$1'); // /catalogo/categoria/5 (si tienes este método)
});

/* --- Detalle / búsqueda de producto (público) --- */
$routes->get('producto/buscar', 'Producto::por_producto');   // Para el formulario GET en la cabecera
$routes->get('producto/(:any)', 'Producto::por_producto/$1'); // Para /producto/123 o /producto/nombre

// -----------------------------------------------------------------------------
// Rutas de Administración de Productos (¡NUEVAS!)
// -----------------------------------------------------------------------------
$routes->group('productos', static function (RouteCollection $routes) {
    $routes->get('listar',       'Producto::listar');       // GET /productos/listar -> Muestra la lista de productos
    $routes->get('agregar',      'Producto::agregar');      // GET /productos/agregar -> Muestra el formulario para agregar
    $routes->post('guardar',     'Producto::guardar');      // POST /productos/guardar -> Procesa el formulario de agregar/editar
    $routes->get('editar/(:num)', 'Producto::editar/$1');    // GET /productos/editar/ID -> Muestra el formulario de edición
    $routes->post('actualizar',  'Producto::actualizar');   // POST /productos/actualizar -> Procesa la actualización (usa el mismo método guardar o uno separado)
    $routes->get('eliminar/(:num)', 'Producto::eliminar/$1'); // GET /productos/eliminar/ID -> Elimina (soft delete) un producto
        $routes->post('eliminar_seleccionados', 'Producto::eliminar_seleccionados'); // POST /productos/eliminar_seleccionados

});

// Nota: Las rutas de POST para 'guardar' y 'actualizar' podrían unificarse si tu formulario
// siempre envía el 'id_producto' (para actualizar) o no lo envía (para agregar).
// Por simplicidad y claridad, las he separado aquí.

// -----------------------------------------------------------------------------
// Finalización de rutas (NO BORRAR)
// -----------------------------------------------------------------------------
$routes->get('/(:any)', 'Home::error404'); // Catch-all for undefined routes
$routes->setAutoRoute(false); // Asegúrate de que esto esté en 'false' en producción