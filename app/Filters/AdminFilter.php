<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        log_message('debug', '--- INICIO AdminFilter ---');
        // CORRECCIÓN APLICADA AQUÍ: Se usa getUri()->getPath()
        log_message('debug', 'Ruta solicitada: ' . $request->getUri()->getPath());
        log_message('debug', 'EstaLogueado en sesión: ' . (session()->get('estaLogueado') ? 'true' : 'false'));
        log_message('debug', 'Rol de usuario en sesión: ' . (session()->get('rol_usuario') ?? 'NULO'));

        // 1. Verificar si está logueado
        if (! session()->get('estaLogueado')) {
            log_message('debug', 'AdminFilter: Usuario no logueado. Redirigiendo a ingreso.');
            return redirect()->to(base_url('ingresar'))->with('error', 'Debes ingresar para acceder a esta sección.');
        }

        // 2. Verificar si el rol del usuario es 1 (administrador)
        if (session()->get('rol_usuario') != 1) { // ¡Importante! El rol se almacena como entero 1
            log_message('debug', 'AdminFilter: Rol no es administrador (' . session()->get('rol_usuario') . '). Redirigiendo a catálogo.');
            return redirect()->to(base_url('catalogo'))->with('error', 'No tienes los permisos necesarios para acceder a esta sección.');
        }

        log_message('debug', 'AdminFilter: Acceso permitido.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hace nada
    }
}
