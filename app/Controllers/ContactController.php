<?php

namespace App\Controllers;

use App\Models\ConsultaModel;
use CodeIgniter\Controller;

class ContactController extends Controller
{
    public function index()
    {
        echo view('contacto');
    }

    public function submit()
    {
        helper(['form', 'url']);

        $rules = [
            'motivo'  => 'required|in_list[consulta,reclamo,sugerencia,otro]', // Asegúrate que estos coincidan con los 'value' de tu select en contacto.php
            'nombre'  => 'required|min_length[3]|max_length[100]',
            'email'   => 'required|valid_email|max_length[255]',
            'mensaje' => 'required|min_length[10]|max_length[1000]',
        ];

        if ($this->validate($rules)) {
            $consultaModel = new ConsultaModel();

            $data = [
                'motivo'  => $this->request->getPost('motivo'),
                'nombre'  => $this->request->getPost('nombre'),
                'email'   => $this->request->getPost('email'),
                'mensaje' => $this->request->getPost('mensaje'),
                'estado'  => 'pendiente'
            ];
            $consultaModel->save($data);
            if ($consultaModel->save($data)) {
                session()->setFlashdata('success', '¡Tu consulta ha sido enviada con éxito! Nos pondremos en contacto contigo pronto.');
                return redirect()->to('/contact');
            } else {
                session()->setFlashdata('error', 'Hubo un error al enviar tu consulta. Por favor, inténtalo de nuevo más tarde.');
                return redirect()->to('contact')->withInput();
            }
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to('/contact')->withInput();
        }
    }
}