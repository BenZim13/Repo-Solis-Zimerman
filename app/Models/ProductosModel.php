<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model
{
    /** Tabla y PK  */
    protected $table        = 'producto';
    protected $primaryKey = 'id_producto';

    /** Retorno  */
    protected $returnType     = 'array';
    protected $useAutoIncrement = true;

    /** Soft-delete  */
    protected $useSoftDeletes = true;
    protected $deletedField   = 'fecha_elimina';

    /** Campos que se pueden insertar / actualizar  */
    // Asegúrate de que 'id_producto' NO esté en allowedFields si es AUTO_INCREMENT
    // Si 'id_producto' se auto-incrementa y se genera en la DB, no debe estar aquí.
    // Solo si lo vas a proporcionar manualmente (lo cual es raro para PK).
    protected $allowedFields = [
        // 'id_producto', // Generalmente, la PK no se permite en `allowedFields` si es AUTO_INCREMENT
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'image_url',
        'activo',
        'id_categoria',
        // 'fecha_alta',    // Timestamps los maneja el modelo automáticamente
        // 'fecha_modifica',// Timestamps los maneja el modelo automáticamente
        // 'fecha_elimina', // Soft deletes los maneja el modelo automáticamente
    ];

    /** Timestamps  */
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_modifica';

    /* ---------------------------------------------------------------------- */
    /* Métodos propios                                                       */
    /* ---------------------------------------------------------------------- */

    /** Devuelve todos los productos activos con el nombre de su categoría */
    public function getProductosConCategoria(): array
    {
        return $this->select('producto.*, categoria.nombre AS nombre_categoria')
                     ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                     ->where('producto.fecha_elimina', null) // Solo productos NO eliminados
                     ->where('producto.activo', 1) // Solo productos activos
                     ->findAll();
    }

    /**
     * Devuelve **un** producto (activo) buscando por ID exacto
     * o por coincidencia parcial de nombre, ignorando mayúsculas.
     */
    public function buscarProducto(string $valor): ?array
    {
        $builder = $this->builder();
        $builder->where('fecha_elimina', null); // Siempre buscamos productos no eliminados
        $builder->where('activo', 1); // Siempre buscamos productos activos

        if (is_numeric($valor)) {
            $builder->where('id_producto', (int) $valor);
            return $builder->get()->getRowArray();
        }

        // Si no es numérico, o si la búsqueda por ID no se realizó, buscar por nombre
        $builder->where('LOWER(nombre) LIKE', '%' . strtolower(trim($valor)) . '%');
        return $builder->get()->getRowArray();
    }

    /**
     * Devuelve todos los productos (activos e inactivos, pero no eliminados) con el nombre de su categoría,
     * útil para el listado de administración.
     */
    public function getAllAdminProductsConCategoria(): array
    {
        return $this->select('producto.*, categoria.nombre AS nombre_categoria')
                    ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                    ->where('producto.fecha_elimina', null) // NO mostrar productos soft-deleted
                    ->findAll();
    }
}