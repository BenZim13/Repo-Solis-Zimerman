<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Verificar si el usuario está logueado
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('redirect_url', current_url());
            return redirect()->to('/login');
        }

        // 2. Si hay argumentos, verificar el rol
        // Los argumentos del filtro se pasan como un array.
        // Ejemplo de uso en Routes: ['filter' => 'auth:admin']
        if (is_array($arguments) && !empty($arguments)) {
            $requiredRole = $arguments[0]; // Asume que el primer argumento es el rol requerido

            if (session()->get('role') !== $requiredRole) {
                // Si el rol del usuario no coincide con el rol requerido para esta ruta
                session()->setFlashdata('error', 'Acceso denegado. No tienes los permisos necesarios para acceder a esta sección.');

                // Redirige al usuario a un lugar apropiado según su rol actual o al home.
                if (session()->get('role') === 'cliente') {
                    return redirect()->to('/'); // Redirige al home de clientes
                } else {
                    return redirect()->to('/dashboard'); // Si fuera un rol intermedio, redirige al dashboard (o una página de error)
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No necesitamos lógica aquí para la autenticación en este ejemplo.
    }
}