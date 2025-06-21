<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActivoToUsuariosTable extends Migration
{
    public function up()
    {
        $fields = [
            'activo' => [
                'type'       => 'TINYINT',      // Usamos TINYINT para valores booleanos (0 o 1)
                'constraint' => 1,              // Longitud de 1 dígito
                'default'    => 1,              // Asigna 1 (activo) por defecto para nuevos usuarios
                'null'       => false,
                'after'      => 'rol',          // Puedes especificar después de 'rol' o de otro campo
            ],
        ];
        $this->forge->addColumn('usuarios', $fields); // Asume que tu tabla de usuarios se llama 'usuarios'
    }

    public function down()
    {
        // Esto es para revertir la migración si es necesario
        $this->forge->dropColumn('usuarios', 'activo');
    }
}