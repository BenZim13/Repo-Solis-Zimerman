<?php
        namespace App\Models;
        use CodeIgniter\Model;

        class CategoriasModel extends Model{
protected $table = 'categoria'; //nombre tabla
protected $primaryKey = 'id_categoria';

protected $useAutoIncrement = true;

protected $returnType = 'array';
protected $useSoftDeletes = false;

protected $allowedFields = ['id_categoria', 'nombre'];

protected bool $allowEmptyInserts = false;
protected bool $updateOnlyChanged = true;

public function getCategoria($id){
    return $this->find($id);
}

public function getAllCategories()
    {
        return $this->findAll(); // Esto recuperará todos los registros de la tabla 'categoria'
    }

}