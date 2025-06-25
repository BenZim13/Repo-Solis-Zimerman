<?php namespace App\Models;

use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table          = 'consultas'; // Nombre de tu tabla de consultas
    protected $primaryKey     = 'id_consulta';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false; // Las consultas no suelen borrarse suave

    // Campos permitidos para inserción y actualización
    // Son importantes para el método save(), pero usaremos insert() directo por ahora.
    protected $allowedFields = [
        'id_consulta',
        'nombre',
        'email',
        'telefono',
        'asunto',
        'mensaje',
        'fecha_envio', // Aunque el modelo lo gestionará, debe estar permitido
        'estado',
        'id_usuario'
    ];

    // Timestamps
    protected $useTimestamps = true; // Usarás 'fecha_envio' para created_at
    protected $createdField  = 'fecha_envio'; // Mapea fecha_envio a created_at
    protected $updatedField  = null;          // No necesitas un campo de actualización si las consultas no se modifican mucho
    protected $deletedField  = null;          // No hay soft deletes aquí

    // Sobrescribir el método insert para usar el Query Builder directamente
    // Esto asegura que la consulta INSERT se genere correctamente.
    public function insert($data = null, bool $returnID = true)
    {
        // Añadir fecha_envio si el modelo lo gestiona automáticamente y no viene en los datos
        if ($this->useTimestamps && $this->createdField && !isset($data[$this->createdField])) {
            $data[$this->createdField] = date('Y-m-d H:i:s');
        }

        // Utilizar el constructor de consultas de la base de datos para la inserción
        $result = $this->db->table($this->table)->insert($data);

        if ($result && $returnID) {
            return $this->db->insertID(); // Retorna el ID de la última inserción
        }

        return $result; // Retorna true/false si returnID es false
    }


    /**
     * Obtiene consultas con el nombre del usuario si están asociadas.
     * @return list<array>
     */
    public function getConsultasConUsuario(): array
    {
        return $this->select('consultas.*, usuarios.nombre AS nombre_usuario_relacionado, usuarios.email AS email_usuario_relacionado')
                    ->join('usuarios', 'usuarios.id_usuario = consultas.id_usuario', 'left') // LEFT JOIN para permitir consultas sin id_usuario
                    ->orderBy('consultas.fecha_envio', 'DESC')
                    ->findAll();
    }

    /**
     * Obtiene una consulta específica con el nombre del usuario.
     * @param int $idConsulta ID de la consulta.
     * @return array|null
     */
    public function getConsultaConUsuario(int $idConsulta): ?array
    {
        return $this->select('consultas.*, usuarios.nombre AS nombre_usuario_relacionado, usuarios.email AS email_usuario_relacionado')
                    ->join('usuarios', 'usuarios.id_usuario = consultas.id_usuario', 'left')
                    ->where('consultas.id_consulta', $idConsulta)
                    ->first();
    }
}
