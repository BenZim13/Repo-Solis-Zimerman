<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table = 'consultas';
    protected $primaryKey = 'id';
    // Asegúrate que 'motivo', 'nombre', 'email', 'mensaje', 'estado' estén aquí.
    // 'fecha_creacion' es manejado por useTimestamps = true y createdField.
    protected $allowedFields = ['motivo', 'nombre', 'email', 'mensaje', 'estado'];
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_creacion';
    protected $updatedField  = null; // No usaremos updated_at en este ejemplo
}