<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Esta página solo será accesible si el usuario está logueado
        echo view('dashboard_view');
    }
}