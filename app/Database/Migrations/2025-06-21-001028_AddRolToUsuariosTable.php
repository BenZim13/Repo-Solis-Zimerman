<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRolToUsuariosTable extends Migration // ¡IMPORTANTE! Asegúrate que el nombre de la clase aquí sea exactamente el mismo que tiene tu archivo de migración (sin la fecha y .php)
{
    public function up()
    {
        // Define los campos que vas a añadir a la tabla
        $fields = [
            'rol' => [
                'type'       => 'INT',        // Tipo de dato: entero
                'constraint' => 5,            // Longitud máxima (5 dígitos, suficiente para 1, 2, etc.)
                'default'    => 2,            // Valor por defecto: 2 (para clientes)
                'null'       => false,        // La columna NO puede ser nula
                'after'      => 'password',   // (Opcional) La columna se añadirá después de la columna 'password' en tu tabla de usuarios
            ],
        ];

        // Añade la nueva columna 'rol' a tu tabla llamada 'usuarios'
        // ¡MUY IMPORTANTE! Si tu tabla de usuarios no se llama 'usuarios', cambia ese nombre aquí.
        $this->forge->addColumn('usuarios', $fields);
    }

    public function down()
    {
        // Este método se usa para revertir la migración (borrar la columna 'rol')
        // Es útil si necesitas deshacer los cambios en la base de datos
        $this->forge->dropColumn('usuarios', 'rol');
    }
}