<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    // ... (otras funciones)

    public function login()
    {
        helper(['form', 'url']);

        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[8]',
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $ses_data = [
                    'id_usuario'        => $user['id_usuario'],
                    'username'  => $user['username'],
                    'email'     => $user['email'],
                    'isLoggedIn' => TRUE,
                    'role'      => $user['role'] // Almacena el rol en la sesión
                ];
                session()->set($ses_data);

                // Redirigir según el rol del usuario
                if ($user['role'] === 'admin') {
                    return redirect()->to('/dashboard'); // Redirige al dashboard de administración
                } else {
                    return redirect()->to('/home'); // Redirige al home para clientes
                }

            } else {
                session()->setFlashdata('error', 'Usuario o contraseña incorrectos.');
                return redirect()->to('/login')->withInput();
            }
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to('/login')->withInput();
        }
    }

    // ... (otras funciones)
}