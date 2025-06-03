<?php
    namespace App\Models;
    use CodeIgniter\Model;//clase que contiene funciones para trabajar modelo
//hereda de la clase model
    class ProductosModel extends Model{ 
        
    protected $table      = 'producto';//nombre de tabla
    protected $primaryKey = 'id_producto';//clave priamria

    protected $useAutoIncrement = true;//ya se asigno en BD

    protected $returnType     = 'array';//puede ser object dependiendo del tipo
    protected $useSoftDeletes = true;//elimina registro luego se configura campo

    protected $allowedFields = ['id_producto', 'nombre', 'descripcion', 'precio', 'stock', 'image_url', 'activo', 'id_categoria'];//para insertar y actalizar

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;//fechas cuando actualicemos o eliminemos uq abajo se define, sino se elimina lo de abajo y se pone false este campo
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_modifica';
    protected $deletedField  = 'fecha_elimina';
        
    }





