<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Verificar si está logueado
        if (! session()->get('estaLogueado')) {
            return redirect()->to(base_url('ingresar'))->with('error', 'Debes ingresar para acceder a esta sección.');
        }

        // 2. Verificar si el rol del usuario es 1 (administrador)
        if (session()->get('rol') != 1) {
            return redirect()->to(base_url('/'))->with('error', 'No tienes los permisos necesarios para acceder a esta sección.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hace nada
    }
}