<?php namespace App\Controllers;

use App\Models\ConsultaModel;
use App\Models\CategoriasModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Log\Logger; // Necesario para log_message

class ConsultaController extends BaseController
{
    protected $consultaModel;
    protected $categoriaModel;
    protected $session;

    public function __construct()
    {
        $this->consultaModel = new ConsultaModel();
        $this->categoriaModel = new CategoriasModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Muestra el formulario de contacto para que los clientes realicen consultas.
     * Si el usuario está logueado, pre-rellena el nombre y email.
     * @return string
     */
    public function index(): string
    {
        $data = [
            'titulo'          => 'Realizar una Consulta',
            'categorias_menu' => $this->categoriaModel->getAllCategories(),
            'nombre'          => '',
            'email'           => '',
            'telefono'        => '',
            'asunto'          => '',
            'mensaje'         => '',
            'id_usuario'      => null,
        ];

        // Si el usuario está logueado, pre-rellenar los campos
        if ($this->session->get('estaLogueado')) {
            $data['nombre']     = $this->session->get('nombre_usuario');
            $data['email']      = $this->session->get('email_usuario');
            $data['id_usuario'] = $this->session->get('id_usuario');
        }

        return view('pages/formulario_consulta', $data);
    }

    /**
     * Procesa el envío del formulario de consulta.
     * @return RedirectResponse
     */
    public function guardar(): RedirectResponse
    {
        $rules = [
            'nombre'  => 'required|min_length[3]|max_length[255]',
            'email'   => 'required|valid_email',
            'telefono' => 'permit_empty|max_length[50]',
            'asunto'  => 'required|min_length[5]|max_length[255]',
            'mensaje' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre'      => $this->request->getPost('nombre'),
            'email'       => $this->request->getPost('email'),
            'telefono'    => $this->request->getPost('telefono'),
            'asunto'      => $this->request->getPost('asunto'),
            'mensaje'     => $this->request->getPost('mensaje'),
            'estado'      => 'pendiente',
            'id_usuario'  => $this->session->get('id_usuario') ?? null,
        ];

        // --- INICIO DE LÍNEAS DE DEPURACIÓN (se registrarán en writable/logs/) ---
        log_message('debug', 'Datos a insertar en consultas: ' . print_r($data, true));
        // --- FIN DE LÍNEAS DE DEPURACIÓN ---

        if ($this->consultaModel->insert($data)) {
            return redirect()->to(base_url('/'))->with('success', 'Tu consulta ha sido enviada exitosamente. Te responderemos a la brevedad.');
        } else {
            // En caso de error de inserción, intentamos capturar la última consulta para el log.
            try {
                $lastQuery = $this->consultaModel->db()->getLastQuery()->getQuery();
                log_message('error', 'Error al insertar consulta. Última consulta intentada: ' . $lastQuery);
            } catch (\Throwable $th) {
                log_message('error', 'Error al obtener la última consulta: ' . $th->getMessage());
            }
            
            return redirect()->back()->withInput()->with('error', 'Hubo un problema al enviar tu consulta. Intenta de nuevo más tarde.');
        }
    }
}
