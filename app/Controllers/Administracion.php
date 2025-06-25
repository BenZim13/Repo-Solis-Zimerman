<?php namespace App\Controllers;

use App\Models\UsuarioModelo;
use App\Models\ProductosModel;
use App\Models\ConsultaModel;
use CodeIgniter\HTTP\RedirectResponse;
// Eliminamos: use CodeIgniter\API\ResponseTrait;

class Administracion extends BaseController
{
    // Eliminamos: use ResponseTrait;

    protected UsuarioModelo $usuarioModel;
    protected ProductosModel $productosModel;
    protected ConsultaModel $consultaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModelo();
        $this->productosModel = new ProductosModel();
        $this->consultaModel = new ConsultaModel();
    }

    /**
     * Muestra el panel principal de administración.
     * @return string
     */
    public function panel(): string
    {
        $data = [
            'titulo' => 'Panel de Administración',
            'totalUsuarios' => $this->usuarioModel->countAllResults(),
            'totalProductos' => $this->productosModel->countAllResults(),
            'totalConsultasPendientes' => $this->consultaModel->where('estado', 'pendiente')->countAllResults(),
        ];
        return view('administracion/panel', $data); // Ruta corregida a 'administracion/panel'
    }

    /**
     * Muestra la lista de usuarios para administración.
     * @return string
     */
    public function usuarios(): string
    {
        $usuarios = $this->usuarioModel->findAll();
        $data = [
            'titulo' => 'Administración de Usuarios',
            'usuarios' => $usuarios,
        ];
        // Asumo que tu vista de listar usuarios está directamente en 'administracion/usuarios.php'
        // Si tienes una subcarpeta como 'administracion/usuarios/listar.php', ajusta aquí:
        // return view('administracion/usuarios/listar', $data);
        return view('administracion/usuarios', $data);
    }

    /**
     * Procesa la eliminación de un usuario (soft delete).
     * @param int|null $id ID del usuario a eliminar.
     * @return RedirectResponse
     */
    public function eliminar($id = null): RedirectResponse
    {
        if ($id === null && $this->request->getPost('id_usuario')) {
            $id = (int) $this->request->getPost('id_usuario');
        }

        if (empty($id)) {
            return redirect()->to(base_url('administracion/usuarios'))->with('error', 'ID de usuario no válido para eliminar.');
        }

        // Validaciones de seguridad:
        if ((int)session()->get('id_usuario') === $id) {
             return redirect()->to(base_url('administracion/usuarios'))->with('error', 'No puedes eliminar tu propia cuenta de usuario.');
        }

        $usuarioAEliminar = $this->usuarioModel->find($id);
        if ($usuarioAEliminar && $usuarioAEliminar['rol'] === 'admin') {
             return redirect()->to(base_url('administracion/usuarios'))->with('error', 'No puedes eliminar una cuenta de administrador directamente desde aquí.');
        }

        if ($this->usuarioModel->delete($id)) {
            return redirect()->to(base_url('administracion/usuarios'))->with('success', 'Usuario eliminado correctamente (soft delete).');
        } else {
            return redirect()->to(base_url('administracion/usuarios'))->with('error', 'No se pudo eliminar el usuario.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * @return string
     */
    public function nuevo(): string
    {
        $data['titulo'] = 'Crear Nuevo Usuario';
        // Asumo que tu vista de nuevo usuario está directamente en 'administracion/nuevo_usuario.php'
        // Si tienes una subcarpeta como 'administracion/usuarios/nuevo.php', ajusta aquí:
        // return view('administracion/usuarios/nuevo', $data);
        return view('administracion/nuevo_usuario', $data);
    }

    /**
     * Procesa la creación de un nuevo usuario desde el panel de administración.
     * @return RedirectResponse
     */
    public function guardarUsuario(): RedirectResponse
    {
        $rules = [
            'nombre'           => 'required|min_length[3]|max_length[255]',
            'email'            => 'required|valid_email|is_unique[usuarios.email]',
            'password'         => 'required|min_length[6]|max_length[255]',
            'rol'              => 'required|in_list[admin,cliente]',
            'activo'           => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'      => $this->request->getPost('rol'),
            'activo'   => (int)$this->request->getPost('activo'),
        ];

        if ($this->usuarioModel->insert($data)) {
            return redirect()->to(base_url('administracion/usuarios'))->with('success', 'Usuario creado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo crear el usuario.');
        }
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     * @param int $id El ID del usuario a editar.
     * @return string|RedirectResponse
     */
    public function editar(int $id): string|RedirectResponse
    {
        $usuario = $this->usuarioModel->find($id);

        if ($usuario) {
            $data['titulo'] = 'Editar Usuario';
            $data['usuario'] = $usuario;
            // Asumo que tu vista de editar usuario está directamente en 'administracion/editar_usuario.php'
            // Si tienes una subcarpeta como 'administracion/usuarios/editar.php', ajusta aquí:
            // return view('administracion/usuarios/editar', $data);
            return view('administracion/editar_usuario', $data);
        } else {
            return redirect()->to(base_url('administracion/usuarios'))->with('error', 'Usuario no encontrado.');
        }
    }

    /**
     * Procesa la actualización de un usuario desde el panel de administración.
     * @return RedirectResponse
     */
    public function actualizarUsuario(): RedirectResponse
    {
        $id = (int)$this->request->getPost('id_usuario');

        $rules = [
            'id_usuario'       => 'required|is_natural_no_zero',
            'nombre'           => 'required|min_length[3]|max_length[255]',
            'email'            => 'required|valid_email|is_unique[usuarios.email,id_usuario,{id_usuario}]',
            'rol'              => 'required|in_list[admin,cliente]',
            'activo'           => 'required|in_list[0,1]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]|max_length[255]';
            $rules['password_confirm'] = 'required_with[password]|matches[password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'rol'      => $this->request->getPost('rol'),
            'activo'   => (int)$this->request->getPost('activo'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ((int)session()->get('id_usuario') === $id && $this->request->getPost('rol') !== 'admin') {
             return redirect()->back()->withInput()->with('error', 'No puedes cambiar tu propio rol de administrador.');
        }
        if ((int)session()->get('id_usuario') === $id && (int)$this->request->getPost('activo') === 0) {
            return redirect()->back()->withInput()->with('error', 'No puedes desactivar tu propia cuenta de administrador.');
        }

        if ($this->usuarioModel->update($id, $data)) {
            if ((int)session()->get('id_usuario') === $id) {
                 session()->set('nombre_usuario', $data['nombre']);
                 session()->set('email_usuario', $data['email']);
                 session()->set('rol_usuario', $data['rol']);
            }
            return redirect()->to(base_url('administracion/usuarios'))->with('success', 'Usuario actualizado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar el usuario.');
        }
    }

    /**
     * Muestra la lista de consultas enviadas por los usuarios.
     * Protegido por el filtro 'admin'.
     * @return string
     */
    public function consultas(): string
    {
        $consultas = $this->consultaModel->getConsultasConUsuario();

        $data = [
            'titulo' => 'Gestión de Consultas',
            'consultas' => $consultas,
        ];
        return view('administracion/consultas/listar_consultas', $data);
    }

    /**
     * Muestra el detalle de una consulta específica de forma convencional.
     * Protegido por el filtro 'admin'.
     * @param int $idConsulta ID de la consulta a ver.
     * @return string|RedirectResponse
     */
    public function ver_detalle(int $idConsulta): string|RedirectResponse
    {
        $consulta = $this->consultaModel->getConsultaConUsuario($idConsulta);

        if (!$consulta) {
            session()->setFlashdata('error', 'Consulta no encontrada.');
            return redirect()->to(base_url('administracion/consultas'));
        }

        $data = [
            'titulo' => 'Detalle de Consulta',
            'consulta' => $consulta,
        ];
        return view('administracion/consultas/ver_detalle', $data);
    }

    /**
     * Cambia el estado de una consulta (ej. de 'pendiente' a 'respondida').
     * @return RedirectResponse
     */
    public function cambiar_estado(): RedirectResponse
    {
        $idConsulta = (int) $this->request->getPost('id_consulta');
        $nuevoEstado = $this->request->getPost('nuevo_estado'); // Ej: 'respondida', 'archivada'

        // Validar que el ID y el estado son válidos
        if (empty($idConsulta) || !in_array($nuevoEstado, ['pendiente', 'respondida', 'archivada'])) {
            return redirect()->back()->with('error', 'Datos de estado de consulta inválidos.');
        }

        // --- INICIO DE LA CORRECCIÓN ---
        // Usar update directamente con where para evitar problemas con timestamps/tipos de datos en el modelo
        $updateResult = $this->consultaModel->builder()
                                            ->where('id_consulta', $idConsulta)
                                            ->set('estado', $nuevoEstado)
                                            ->update();

        if ($updateResult) {
            session()->setFlashdata('success', 'Estado de la consulta actualizado a ' . ucfirst($nuevoEstado) . '.');
        } else {
            session()->setFlashdata('error', 'No se pudo actualizar el estado de la consulta.');
        }
        // --- FIN DE LA CORRECCIÓN ---

        return redirect()->to(base_url('administracion/consultas'));
    }

    /**
     * Elimina una consulta de la base de datos.
     * @return RedirectResponse
     */
    public function eliminarConsulta(): RedirectResponse
    {
        $idConsulta = (int) $this->request->getPost('id_consulta');

        if (empty($idConsulta)) {
            return redirect()->back()->with('error', 'ID de consulta no válido.');
        }

        if ($this->consultaModel->delete($idConsulta)) {
            session()->setFlashdata('success', 'Consulta eliminada exitosamente.');
        } else {
            session()->setFlashdata('error', 'No se pudo eliminar la consulta.');
        }

        return redirect()->to(base_url('administracion/consultas'));
    }
}
