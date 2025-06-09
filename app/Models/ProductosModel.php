<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model
{
    /**  Tabla y PK  */
    protected $table      = 'producto';
    protected $primaryKey = 'id_producto';

    /**  Retorno  */
    protected $returnType     = 'array';
    protected $useAutoIncrement = true;

    /**  Soft-delete  */
    protected $useSoftDeletes = true;
    protected $deletedField   = 'fecha_elimina';

    /**  Campos que se pueden insertar / actualizar  */
    protected $allowedFields = [
        'id_producto',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'image_url',
        'activo',
        'id_categoria',
        'fecha_alta',
        'fecha_modifica',
        'fecha_elimina',   // imprescindible para soft-delete
    ];

    /**  Timestamps  */
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_modifica';

    /* ---------------------------------------------------------------------- */
    /*  Métodos propios                                                       */
    /* ---------------------------------------------------------------------- */

    /**  Devuelve todos los productos activos con el nombre de su categoría */
    public function getProductosConCategoria(): array
    {
        return $this->select('producto.*, categoria.nombre AS nombre_categoria')
                    ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                    ->where('producto.fecha_elimina', null)
                    ->findAll();
    }

    /**
     * Devuelve **un** producto (activo) buscando por ID exacto
     * o por coincidencia parcial de nombre, ignorando mayúsculas.
     */
    public function buscarProducto(string $valor): ?array
    {
        if (is_numeric($valor)) {
            return $this->where('id_producto', (int) $valor)
                        ->where('fecha_elimina', null)
                        ->first();
        }

        return $this->where('fecha_elimina', null)
                    ->where('LOWER(nombre) LIKE', '%' . strtolower($valor) . '%')
                    ->first();
    }
}
