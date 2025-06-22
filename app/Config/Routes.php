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
$routes->get('/',               'Home::cuerpo');
$routes->get('quienessomos',    'Home::quienessomos');
$routes->get('comercializacion','Home::comercializacion');
$routes->get('contacto',        'Home::contacto');
$routes->get('terminos',        'Home::terminos');

// -----------------------------------------------------------------------------
// Catálogo y productos (públicos)
// -----------------------------------------------------------------------------
$routes->group('catalogo', static function (RouteCollection $routes) {
    $routes->get('/',             'Producto::catalogo');
    $routes->get('categoria/(:num)', 'Producto::catalogoPorCategoria/$1');
});

/* --- Detalle / búsqueda de producto (público) --- */
$routes->get('producto/buscar', 'Producto::por_producto');
$routes->get('producto/(:any)', 'Producto::por_producto/$1');

// -----------------------------------------------------------------------------
// Rutas del Carrito de Compras
// -----------------------------------------------------------------------------
$routes->group('carrito', static function (RouteCollection $routes) {
    $routes->get('/',            'CarritoController::index');
    $routes->post('agregar',     'CarritoController::agregar');
    $routes->post('actualizar',  'CarritoController::actualizar');
    $routes->post('eliminar',    'CarritoController::eliminar');
    $routes->post('vaciar',      'CarritoController::vaciar');
});

// -----------------------------------------------------------------------------
// Rutas de Autenticación (Registro, Login, Logout, Perfil) con nombres en español
// -----------------------------------------------------------------------------
$routes->group('/', static function($routes) {
    // Rutas para mostrar el formulario de registro y procesarlo
    $routes->get('registrarse', 'Autenticacion::registrar', ['as' => 'registrarse']);
    $routes->post('registrarse', 'Autenticacion::intentarRegistro');

    // Rutas para mostrar el formulario de login y procesarlo
    $routes->get('ingresar', 'Autenticacion::ingresar', ['as' => 'ingresar']);
    $routes->post('ingresar', 'Autenticacion::intentarIngreso');

    // Ruta para cerrar sesión
    $routes->get('salir', 'Autenticacion::cerrarSesion', ['as' => 'salir']);

    // Ruta para el perfil del usuario (protegida por el filtro 'auth')
    $routes->get('mi-perfil', 'Autenticacion::perfil', ['filter' => 'auth', 'as' => 'mi_perfil']);

    // Rutas de administración (protegidas por el filtro 'admin')
    $routes->group('administracion', ['filter' => 'admin'], function($routes) {
        $routes->get('panel', 'Administracion::panel', ['as' => 'panel_administracion']);
        $routes->get('usuarios', 'Administracion::usuarios', ['as' => 'gestion_usuarios']);
        // Puedes añadir más rutas específicas de la administración aquí, usando el controlador Administracion
    });
});


// -----------------------------------------------------------------------------
// Rutas de Administración de Productos (protegidas por filtro 'admin')
// Nota: Como ya se usa 'admin' como filtro, estas rutas también estarán protegidas.
// Si quieres que solo sean accesibles para administradores, deja el filtro 'admin'.
// Si necesitas un acceso menos restrictivo, podrías cambiarlo a 'auth' o quitar el filtro.
// He puesto el filtro 'admin' aquí también para consistencia con las otras rutas de admin.
// Idealmente, todas las rutas de admin deberían estar dentro del grupo 'administracion'.
// Por ahora, las dejo aquí pero con el filtro explícito.
// -----------------------------------------------------------------------------
$routes->group('productos', static function (RouteCollection $routes) {
    $routes->get('listar',         'Producto::listar', ['filter' => 'admin']);
    $routes->get('agregar',        'Producto::agregar', ['filter' => 'admin']);
    $routes->post('guardar',      'Producto::guardar', ['filter' => 'admin']);
    $routes->get('editar/(:num)',  'Producto::editar/$1', ['filter' => 'admin']);
    $routes->post('actualizar',   'Producto::actualizar', ['filter' => 'admin']);
    $routes->get('eliminar/(:num)', 'Producto::eliminar/$1', ['filter' => 'admin']);
    $routes->post('eliminar_seleccionados', 'Producto::eliminar_seleccionados', ['filter' => 'admin']);
});
$routes->post('administracion/usuarios/eliminar/(:num)', 'Administracion::eliminar/$1');
// También puedes usar una ruta sin el ID si siempre lo pasas por POST
// $routes->post('administracion/usuarios/eliminar', 'Administracion::eliminar');


// -----------------------------------------------------------------------------
// NUEVAS RUTAS DE COMPRA Y FACTURA (MOVIDAS ANTES DEL CATCH-ALL)
// -----------------------------------------------------------------------------
$routes->post('carrito/finalizarCompra', 'CarritoController::finalizarCompra', ['filter' => 'authFilter']);

// Nueva ruta para mostrar la factura (GET)
$routes->get('factura', 'FacturaController::index', ['filter' => 'authFilter']);


// -----------------------------------------------------------------------------
// Catch-all para rutas no definidas (DEBE IR AL FINAL)
// Asegúrate de que tu controlador 'Home' tenga el método 'error404'.
// -----------------------------------------------------------------------------
$routes->get('/(:any)', 'Home::error404');

$routes->setAutoRoute(false); // Asegúrate de que autoRoute esté en false si usas catch-all
