<?php namespace App\Models;

use CodeIgniter\Model;

class UsuarioModelo extends Model
{
    protected $table = 'usuarios'; // Nombre de tu tabla de usuarios
    protected $primaryKey = 'id_usuario'; // Clave primaria
    protected $allowedFields = ['nombre', 'email', 'password', 'rol', 'activo']; // Campos permitidos
}
