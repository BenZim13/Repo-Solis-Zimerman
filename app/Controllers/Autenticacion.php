<?php namespace App\Controllers;

use App\Models\UsuarioModelo;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;

class Autenticacion extends BaseController // O 'extends Controller' si no usas BaseController
{
    protected $usuarioModelo;
    protected $session;

    public function __construct()
    {
        $this->usuarioModelo = new UsuarioModelo();
        $this->session = \Config\Services::session();
    }

    /**
     * Muestra el formulario de registro.
     * Puede retornar una vista (string) o una redirección (RedirectResponse).
     */
    public function registrar(): string|RedirectResponse
    {
        if ($this->session->get('estaLogueado')) {
            // Si ya está logueado, redirigir según el rol
            if ($this->session->get('rol_usuario') == 1) { // Usar == 1 para admin
                return redirect()->to(base_url('administracion/panel'));
            }
            return redirect()->to(base_url('mi-perfil'));
        }
        $data['titulo'] = 'Registrarse en SuperCarpi';
        return view('autenticacion/registro', $data);
    }

    /**
     * Procesa el formulario de registro.
     */
    public function intentarRegistro(): RedirectResponse
    {
        $rules = [
            'nombre'           => 'required|min_length[3]|max_length[255]',
            'email'            => 'required|valid_email|is_unique[usuarios.email]',
            'contraseña'       => 'required|min_length[6]|max_length[255]',
            'confirmar_contraseña' => 'required_with[contraseña]|matches[contraseña]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('contraseña'), PASSWORD_DEFAULT),
            'rol'      => 2, // CLAVE: Asignar 2 (cliente) por defecto
            'activo'   => 1, // Por defecto, activo
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
    public function ingresar(): string|RedirectResponse
    {
        if ($this->session->get('estaLogueado')) {
            // Si ya está logueado, redirigir según el rol
            if ($this->session->get('rol_usuario') == 1) { // Usar == 1 para admin
                return redirect()->to(base_url('administracion/panel'));
            }
            return redirect()->to(base_url('mi-perfil'));
        }
        $data['titulo'] = 'Ingresar a SuperCarpi';
        return view('autenticacion/ingreso', $data);
    }

    /**
     * Procesa el intento de inicio de sesión.
     */
    public function intentarIngreso(): RedirectResponse
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

        $usuario = $this->usuarioModelo->where('email', $email)->first();

        if ($usuario && password_verify($password, $usuario['password'])) {
            if ($usuario['activo'] == 0) {
                return redirect()->back()->withInput()->with('error', 'Tu cuenta está inactiva. Contacta al administrador.');
            }

            // INICIO: Asegurarse de guardar el ID y el ROL numérico en la sesión
            $this->session->set([
                'id_usuario'     => (int)$usuario['id_usuario'], // Asegurar que sea int
                'nombre_usuario' => $usuario['nombre'],
                'email_usuario'  => $usuario['email'],
                'rol_usuario'    => (int)$usuario['rol'],    // CLAVE: Guardar el rol como entero
                'estaLogueado'   => true,
            ]);
            // FIN: Modificaciones

            session()->setFlashdata('exito', '¡Bienvenido, ' . esc($usuario['nombre']) . '!');

            // Redirigir según el rol numérico almacenado en la sesión
            if ($this->session->get('rol_usuario') == 1) { // Comparar con el entero 1 para admin
                return redirect()->to(base_url('administracion/panel'));
            } else {
                return redirect()->to(base_url('catalogo')); // Para clientes, redirigir al catálogo
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas. Verifica tu email y contraseña.');
        }
    }

    /**
     * Cierra la sesión.
     */
    public function cerrarSesion(): RedirectResponse
    {
        $this->session->destroy();
        return redirect()->to(base_url('ingresar'))->with('exito', 'Has cerrado sesión exitosamente.');
    }

    /**
     * Muestra la página de perfil del usuario.
     * Protegida por filtro 'auth'.
     */
    public function perfil(): string
    {
        $data['titulo'] = 'Mi Perfil';
        // Acceder a los datos de la sesión con los nuevos nombres
        $data['usuario'] = [
            'id_usuario' => $this->session->get('id_usuario'),
            'nombre'     => $this->session->get('nombre_usuario'),
            'email'      => $this->session->get('email_usuario'),
            'rol'        => $this->session->get('rol_usuario'), // El rol es numérico
        ];
        // Para mostrar un texto legible en la vista del perfil
        $data['usuario']['rol_display'] = ($data['usuario']['rol'] == 1) ? 'Administrador' : 'Cliente';

        return view('usuario/perfil', $data);
    }
}
