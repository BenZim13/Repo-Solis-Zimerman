<?php

namespace App\Controllers;

// use CodeIgniter\Controller; // Eliminado: Redundante ya que BaseController ya lo extiende.
use App\Models\UsuarioModelo;
use CodeIgniter\HTTP\ResponseInterface; // Necesario para el tipo RedirectResponse

class Administracion extends BaseController
{
    // No es necesario declarar ni inicializar $session aquí, ya lo hace BaseController.

    /**
     * Muestra el panel principal de administración.
     * @return string|ResponseInterface
     */
    public function panel(): string|ResponseInterface
    {
        $data['titulo'] = 'Panel de Administración';
        return view('administracion/panel', $data);
    }

    /**
     * Muestra la gestión de usuarios (solo para administradores).
     * Carga y pasa los datos de los usuarios a la vista.
     * @return string|ResponseInterface
     */
    public function usuarios(): string|ResponseInterface
    {
        $usuarioModel = new UsuarioModelo();
        $data['usuarios'] = $usuarioModel->findAll();

        $data['titulo'] = 'Gestión de Usuarios';

        return view('administracion/usuarios', $data);
    }

    /**
     * Procesa la eliminación de un usuario.
     * Este método puede ser llamado por POST desde un formulario.
     * Redirige de vuelta a la lista de usuarios con un mensaje de estado.
     * @param int|null $id El ID del usuario a eliminar, si viene en la URL.
     * @return ResponseInterface
     */
    public function eliminar($id = null): ResponseInterface
    {
        // Si el ID no viene en la URL, búscalo en los datos POST
        if ($id === null && $this->request->getPost('id_usuario')) {
            $id = $this->request->getPost('id_usuario');
        }

        // Si después de ambas verificaciones el ID sigue siendo inválido o vacío
        if (empty($id)) {
            return redirect()->to(base_url('administracion/usuarios'))->with('error', 'ID de usuario no válido para eliminar.');
        }

        // Si llegamos aquí, tenemos un $id válido, procedemos con la eliminación
        $usuarioModel = new UsuarioModelo();
        if ($usuarioModel->delete($id)) {
            return redirect()->to(base_url('administracion/usuarios'))->with('success', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->to(base_url('administracion/usuarios'))->with('error', 'No se pudo eliminar el usuario.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * Protegido por el filtro 'admin'.
     * @return string|ResponseInterface
     */
    public function nuevo(): string|ResponseInterface
    {
        $data['titulo'] = 'Crear Nuevo Usuario';
        return view('administracion/nuevo_usuario', $data); // Asumiendo que crearás esta vista
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     * Protegido por el filtro 'admin'.
     * @param int $id El ID del usuario a editar.
     * @return string|ResponseInterface
     */
    public function editar(int $id): string|ResponseInterface
    {
        $usuarioModel = new UsuarioModelo();
        $usuario = $usuarioModel->find($id);

        if ($usuario) {
            $data['titulo'] = 'Editar Usuario';
            $data['usuario'] = $usuario;
            return view('administracion/editar_usuario', $data); // Asumiendo que crearás esta vista
        } else {
            return redirect()->to(base_url('administracion/usuarios'))->with('error', 'Usuario no encontrado.');
        }
    }
}