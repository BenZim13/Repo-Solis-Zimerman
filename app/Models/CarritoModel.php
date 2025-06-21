<?php namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table        = 'carrito';
    protected $primaryKey   = 'id_carrito';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false; // El carrito no se "elimina suavemente"
protected $allowedFields  = ['id_usuario', 'id_producto', 'cantidad', 'fecha_agregado']; // ¡IMPORTANTE: Asegúrate que 'fecha_agregado' esté aquí!
    protected $useTimestamps = true; // Para las columnas de fecha
    protected $createdField  = 'fecha_agregado';
    protected $updatedField  = false; // No necesitamos un campo 'updated_at' para cada item del carrito
    protected $deletedField  = false; // El soft delete ya está en false

    // Método para obtener todos los ítems del carrito de un usuario, con detalles del producto
    public function getCarritoPorUsuario(int $idUsuario): array
    {
        return $this->select('carrito.*, producto.nombre AS nombre_producto, producto.precio AS precio_producto, producto.image_url')
                     ->join('producto', 'producto.id_producto = carrito.id_producto')
                     ->where('carrito.id_usuario', $idUsuario)
                     ->findAll();
    }

    // Método para añadir un producto al carrito o actualizar su cantidad si ya existe
    public function agregarProducto(int $idUsuario, int $idProducto, int $cantidad = 1): bool
    {
        // Verificar si el producto ya existe en el carrito del usuario
        $existente = $this->where('id_usuario', $idUsuario)
                          ->where('id_producto', $idProducto)
                          ->first();

        if ($existente) {
            // Si existe, actualizar la cantidad
            // Asegura que la cantidad no sea negativa
            $nuevaCantidad = $existente['cantidad'] + $cantidad;
            if ($nuevaCantidad < 1) $nuevaCantidad = 1; // Evita cantidades negativas

            // CORRECCIÓN: Pasa el array asociativo directamente al update del modelo
            return $this->update($existente['id_carrito'], ['cantidad' => $nuevaCantidad]);
        } else {
            // Si no existe, insertar un nuevo registro
            if ($cantidad < 1) $cantidad = 1; // Cantidad mínima al insertar

            // 'fecha_agregado' se autocompleta si useTimestamps es true y está en $allowedFields
            return $this->insert([
                'id_usuario' => $idUsuario,
                'id_producto' => $idProducto,
                'cantidad' => $cantidad,
            ]);
        }
    }

    // Método para actualizar la cantidad de un producto específico en el carrito
    public function actualizarCantidad(int $idCarrito, int $cantidad): bool
    {
        // Asegúrate de que la cantidad no sea menor a 1
        if ($cantidad < 1) {
            $cantidad = 1;
        }
        return $this->update($idCarrito, ['cantidad' => $cantidad]);
    }

    // Método para eliminar un producto específico del carrito
    public function eliminarProducto(int $idCarrito): bool
    {
        return $this->delete($idCarrito);
    }

    // Método para vaciar completamente el carrito de un usuario
    public function vaciarCarrito(int $idUsuario): bool
    {
        return $this->where('id_usuario', $idUsuario)->delete();
    }
}