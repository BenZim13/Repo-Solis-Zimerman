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
// Catálogo y productos
// -----------------------------------------------------------------------------
$routes->group('catalogo', static function (RouteCollection $routes) {
    $routes->get('/',                 'Producto::catalogo');                // /catalogo
    $routes->get('categoria/(:num)',  'Producto::catalogoPorCategoria/$1'); // /catalogo/categoria/5
});

/*
 |------------------------------------------------------------------------
 | Detalle de producto unificado
 |------------------------------------------------------------------------
 |  Acepta:
 |   • /producto/123          (ID numérico)
 |   • /producto/Costilla%20Swift  (Nombre)
 |   • /producto/costilla swift    (el nombre no distingue mayúsculas)
/* --- Detalle / búsqueda de producto --- */
$routes->get('producto/buscar', 'Producto::por_producto'); // formulario GET
$routes->get('producto/(:any)', 'Producto::por_producto/$1'); // /producto/123  o  /producto/nombre
