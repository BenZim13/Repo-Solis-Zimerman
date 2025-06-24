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
// Rutas de Autenticación (Registro, Login, Logout, Perfil)
// Son importantes que estén arriba ya que muchos filtros dependen de la sesión.
// -----------------------------------------------------------------------------
$routes->group('/', static function(RouteCollection $routes) {
    // Rutas para mostrar el formulario de registro y procesarlo (sin filtro)
    $routes->get('registrarse', 'Autenticacion::registrar', ['as' => 'registrarse']);
    $routes->post('registrarse', 'Autenticacion::intentarRegistro');

    // Rutas para mostrar el formulario de login y procesarlo (sin filtro)
    $routes->get('ingresar', 'Autenticacion::ingresar', ['as' => 'ingresar']);
    $routes->post('ingresar', 'Autenticacion::intentarIngreso');

    // Ruta para cerrar sesión (sin filtro)
    $routes->get('salir', 'Autenticacion::cerrarSesion', ['as' => 'salir']);

    // Ruta para el perfil del usuario (protegida por el filtro 'auth')
    $routes->get('mi-perfil', 'Autenticacion::perfil', ['filter' => 'auth', 'as' => 'mi_perfil']);
});

// -----------------------------------------------------------------------------
// Rutas de ADMINISTRACIÓN (DEBEN IR ANTES DE RUTAS MÁS GENÉRICAS COMO CATÁLOGO O CATCH-ALL)
// -----------------------------------------------------------------------------

// Rutas de Administración (protegidas por el filtro 'admin')
$routes->group('administracion', ['filter' => 'admin'], static function(RouteCollection $routes) {
    $routes->get('panel', 'Administracion::panel', ['as' => 'panel_administracion']);
    $routes->get('usuarios', 'Administracion::usuarios', ['as' => 'gestion_usuarios']);
    $routes->post('usuarios/eliminar/(:num)', 'Administracion::eliminar/$1');
    $routes->get('usuarios/nuevo', 'Administracion::nuevo');
    $routes->post('usuarios/guardarUsuario', 'Administracion::guardarUsuario');
    $routes->get('usuarios/editar/(:num)', 'Administracion::editar/$1');
    $routes->post('usuarios/actualizarUsuario', 'Administracion::actualizarUsuario');
});

// Rutas de Administración de Productos (protegidas por filtro 'admin')
$routes->group('productos', ['filter' => 'admin'], static function (RouteCollection $routes) {
    $routes->get('listar',          'Producto::listar');
    $routes->get('agregar',         'Producto::agregar');
    $routes->post('guardar',       'Producto::guardar');
    $routes->get('editar/(:num)',   'Producto::editar/$1');
    $routes->post('actualizar',    'Producto::actualizar');
    $routes->get('eliminar/(:num)', 'Producto::eliminar/$1'); // Soft delete para productos
    $routes->post('eliminar_seleccionados', 'Producto::eliminar_seleccionados');
    $routes->get('toggleActivo/(:num)', 'Producto::toggleActivo/$1'); // Cambiar estado activo/inactivo
});


// -----------------------------------------------------------------------------
// Rutas del Carrito de Compras y Factura (también deben ir antes del catch-all)
// -----------------------------------------------------------------------------
$routes->group('carrito', ['filter' => 'auth'], static function (RouteCollection $routes) {
    $routes->get('/',            'CarritoController::index');
    $routes->post('agregar',     'CarritoController::agregar');
    $routes->post('actualizar',  'CarritoController::actualizar');
    $routes->post('eliminar',    'CarritoController::eliminar');
    $routes->post('vaciar',      'CarritoController::vaciar');
    $routes->post('finalizarCompra', 'CarritoController::finalizarCompra');
});

$routes->post('test-agregar', static function () {
    return 'Test agregar route reached successfully.';
});

// Ruta para mostrar la factura (protegida por 'auth')
$routes->get('factura', 'FacturaController::index', ['filter' => 'auth']);


// -----------------------------------------------------------------------------
// Páginas estáticas (sin filtros de autenticación)
// -----------------------------------------------------------------------------
$routes->get('/',               'Home::cuerpo');
$routes->get('quienessomos',    'Home::quienessomos');
$routes->get('comercializacion','Home::comercializacion');
$routes->get('contacto',        'Home::contacto');
$routes->get('terminos',        'Home::terminos');

// -----------------------------------------------------------------------------
// Catálogo y productos (públicos) - Estas rutas son más genéricas, van antes del catch-all
// -----------------------------------------------------------------------------
$routes->group('catalogo', static function (RouteCollection $routes) {
    $routes->get('/',             'Producto::catalogo');
    $routes->get('categoria/(:num)', 'Producto::catalogoPorCategoria/$1');
});

/* --- Detalle / búsqueda de producto (público) --- */
$routes->get('producto/buscar', 'Producto::por_producto');
$routes->get('producto/(:any)', 'Producto::por_producto/$1');


$routes->group('carrito', ['filter' => 'auth'], static function (RouteCollection $routes) {
    $routes->get('/',            'CarritoController::index');
    $routes->post('agregar',     'CarritoController::agregar');
    $routes->post('actualizar',  'CarritoController::actualizar');
    $routes->post('eliminar',    'CarritoController::eliminar');
    $routes->post('vaciar',      'CarritoController::vaciar');
    $routes->post('finalizarCompra', 'CarritoController::finalizarCompra');
});

// -----------------------------------------------------------------------------
// Catch-all para rutas no definidas (DEBE IR SIEMPRE AL FINAL)
// -----------------------------------------------------------------------------
$routes->get('/(:any)', 'Home::error404'); // Asegúrate de que tu controlador 'Home' tenga el método 'error404'.

$routes->setAutoRoute(true); // Habilitado temporalmente para pruebas
