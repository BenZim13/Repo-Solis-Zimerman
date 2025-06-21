<?php

namespace App\Controllers;

use App\Models\UsuarioModelo; // ✅ Correcto, usas el nombre de tu modelo
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;

class Autenticacion extends BaseController // O 'extends Controller'
{
    protected $usuarioModelo;
    protected $session;

    public function __construct()
    {
        $this->usuarioModelo = new UsuarioModelo(); // ✅ Instancia correcta del modelo
        $this->session = \Config\Services::session(); // ✅ Inicialización de sesión correcta
    }

    /**
     * Muestra el formulario de registro.
     * Puede retornar una vista (string) o una redirección (RedirectResponse).
     */
    public function registrar(): string|RedirectResponse // ✅ ¡SOLUCIÓN APLICADA AQUÍ!
    {
        if ($this->session->get('estaLogueado')) {
            return redirect()->to(base_url('mi-perfil')); // Esto es un RedirectResponse
        }
        $data['titulo'] = 'Registrarse en SuperCarpi';
        return view('autenticacion/registro', $data); // Esto es un string
    }

    /**
     * Procesa el formulario de registro.
     */
    public function intentarRegistro(): RedirectResponse // ✅ Correcto, siempre devuelve una redirección
    {
        $rules = [
            'nombre'               => 'required|min_length[3]|max_length[255]',
            'email'                => 'required|valid_email|is_unique[usuarios.email]', // Asegúrate que 'usuarios' sea el nombre de tu tabla
            'contraseña'           => 'required|min_length[6]|max_length[255]',
            'confirmar_contraseña' => 'required_with[contraseña]|matches[contraseña]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('contraseña'), PASSWORD_DEFAULT),
            'rol'      => 2, // Rol por defecto, asegúrate que 2 sea el ID de rol de usuario normal
            'activo'   => 1, // ✅ 'activo' es el campo correcto según tu modelo
        ];

        if ($this->usuarioModelo->insert($data)) {
            return redirect()->to(base_url('ingresar'))->with('exito', '¡Registro exitoso! Ahora puedes ingresar.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo completar el registro. Intenta de nuevo.');
        }
    }

    /**
     * Muestra el formulario de inicio de sesión.
     * Puede retornar una vista (string) o una redirección (RedirectResponse).
     */
    public function ingresar(): string|RedirectResponse // ✅ ¡SOLUCIÓN APLICADA AQUÍ!
    {
        if ($this->session->get('estaLogueado')) {
            return redirect()->to(base_url('mi-perfil')); // Esto es un RedirectResponse
        }
        $data['titulo'] = 'Ingresar a SuperCarpi';
        return view('autenticacion/ingreso', $data); // Esto es un string
    }

    /**
     * Procesa el intento de inicio de sesión.
     */
    public function intentarIngreso(): RedirectResponse // ✅ Correcto, siempre devuelve una redirección
    {
        $rules = [
            'email'        => 'required|valid_email',
            'contraseña'   => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('contraseña');

        // Busca por email en la tabla 'usuarios' usando el modelo
        $usuario = $this->usuarioModelo->where('email', $email)->first();

        if ($usuario && password_verify($password, $usuario['password'])) {
            if ($usuario['activo'] == 0) { // ✅ 'activo' es el campo correcto
                return redirect()->back()->withInput()->with('error', 'Tu cuenta está inactiva. Contacta al administrador.');
            }

            $datosUsuario = [
                'id_usuario'   => $usuario['id_usuario'], // ✅ 'id_usuario' es el campo correcto
                'nombre'       => $usuario['nombre'],
                'email'        => $usuario['email'],
                'rol'          => $usuario['rol'],
                'estaLogueado' => true,
            ];
            $this->session->set($datosUsuario);

            if ($usuario['rol'] == 1) { // 1 para administrador
                return redirect()->to(base_url('administracion/panel'))->with('exito', '¡Bienvenido Administrador, ' . esc($usuario['nombre']) . '!');
            } else { // Otros roles
                return redirect()->to(base_url('mi-perfil'))->with('exito', '¡Bienvenido, ' . esc($usuario['nombre']) . '!');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas. Verifica tu email y contraseña.');
        }
    }

    /**
     * Cierra la sesión.
     */
    public function cerrarSesion(): RedirectResponse // ✅ Correcto
    {
        $this->session->destroy();
        return redirect()->to(base_url('ingresar'))->with('exito', 'Has cerrado sesión exitosamente.');
    }

    /**
     * Muestra la página de perfil del usuario.
     * Protegida por filtro 'auth'.
     */
    public function perfil(): string // ✅ Correcto, solo retorna vista
    {
        $data['titulo'] = 'Mi Perfil';
        $data['usuario'] = $this->session->get(); // Obtiene todos los datos de la sesión
        return view('usuario/perfil', $data);
    }
}