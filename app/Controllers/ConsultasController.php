<?php

namespace App\Controllers; 

use App\Controllers\BaseController; // Si tienes un BaseController propio
use App\Models\ConsultaModel;
use CodeIgniter\Controller; // Si no tienes BaseController, usa este

class ConsultasController extends BaseController // O extiende Controller
{
    public function index()
    {
        // La verificación de rol puede estar aquí o en el filtro de ruta
        if (session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Acceso denegado. No tienes permisos para ver esta sección.');
            return redirect()->to('/dashboard'); // O a la página principal de clientes
        }

        $consultaModel = new ConsultaModel();
        $data['consultas'] = $consultaModel->orderBy('fecha_creacion', 'DESC')->findAll();

        echo view('admin/consultas/list_view', $data);
    }

    public function view($id = null)
    {
        if (session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Acceso denegado.');
            return redirect()->to('/dashboard');
        }

        $consultaModel = new ConsultaModel();
        $consulta = $consultaModel->find($id);

        if (!$consulta) {
            session()->setFlashdata('error', 'Consulta no encontrada.');
            return redirect()->to('/admin/consultas');
        }

        $data['consulta'] = $consulta;
        echo view('admin/consultas/detail_view', $data);
    }

    public function updateStatus($id = null)
    {
        if (session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Acceso denegado.');
            return redirect()->to('/dashboard');
        }

        $newStatus = $this->request->getPost('estado');

        $consultaModel = new ConsultaModel();
        if ($consultaModel->update($id, ['estado' => $newStatus])) {
            session()->setFlashdata('success', 'Estado de la consulta actualizado.');
        } else {
            session()->setFlashdata('error', 'Error al actualizar el estado de la consulta.');
        }
        return redirect()->to('/admin/consultas/view/' . $id);
    }
}