<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    /** Campos que se pueden insertar / actualizar  */
    protected $allowedFields = ['username', 'password', 'email', `nombre`, `apellido`, `dni`, `direccion`];
    protected $useTimestamps = true; // Si tienes created_at y updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_mod';


    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}