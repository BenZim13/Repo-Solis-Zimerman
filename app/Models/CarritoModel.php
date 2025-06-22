<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\API\ResponseTrait;

class CarritoModel extends Model
{
    protected $table          = 'carrito';
    protected $primaryKey     = 'id_carrito';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Asegúrate de incluir 'id_carrito' en allowedFields para permitir actualizaciones
    protected $allowedFields = ['id_carrito', 'id_usuario', 'id_producto', 'cantidad', 'fecha_agregado'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_agregado';
    protected $updatedField  = false; // No necesitamos un campo 'updated_at' para cada item del carrito
    protected $deletedField  = false;

    public function getCarritoPorUsuario(int $idUsuario): array
    {
        return $this->select('carrito.*, producto.nombre AS nombre_producto, producto.precio AS precio_producto, producto.image_url')
                    ->join('producto', 'producto.id_producto = carrito.id_producto')
                    ->where('carrito.id_usuario', $idUsuario)
                    ->findAll();
    }

    public function agregarProducto(int $idUsuario, int $idProducto, int $cantidad = 1): bool
    {
        log_message('debug', '*** INICIO agregarProducto (Solución definitiva) ***');
        log_message('debug', 'idUsuario: {idUsuario}, idProducto: {idProducto}, cantidad: {cantidad}', [
            'idUsuario' => $idUsuario,
            'idProducto' => $idProducto,
            'cantidad' => $cantidad
        ]);

        if ($cantidad < 1) {
            $cantidad = 1;
            log_message('debug', 'Cantidad ajustada a 1.');
        }

        $itemExistente = $this->where('id_usuario', $idUsuario)
                              ->where('id_producto', $idProducto)
                              ->first();

        if ($itemExistente) {
            log_message('debug', 'Producto existente encontrado: {itemExistente}', ['itemExistente' => json_encode($itemExistente)]);
            $nuevaCantidad = $itemExistente['cantidad'] + $cantidad;
            if ($nuevaCantidad < 1) {
                $nuevaCantidad = 1;
                log_message('debug', 'Nueva cantidad ajustada a 1 (negativa/cero).');
            }

            $dataToUpdate = [
                'cantidad'   => $nuevaCantidad,
                // No necesitamos 'fecha_agregado' aquí a menos que quieras actualizarla en cada cambio.
                // Si tu DB tiene ON UPDATE CURRENT_TIMESTAMP para fecha_agregado, se actualizará sola.
            ];

            log_message('debug', 'Datos para ACTUALIZAR (Direct DB Query): {data}', ['data' => json_encode($dataToUpdate)]);
            log_message('debug', 'Tipo de clave de cantidad en dataToUpdate: {type}', ['type' => gettype(key($dataToUpdate))]);
            log_message('debug', 'Tipo de valor de cantidad en dataToUpdate: {type}', ['type' => gettype($dataToUpdate['cantidad'])]);

            // CAMBIO CLAVE: Usar update directamente del Query Builder, no $this->save()
            $result = $this->db->table($this->table)
                               ->where('id_carrito', $itemExistente['id_carrito'])
                               ->update($dataToUpdate);

            log_message('debug', 'Resultado de update (Direct DB Query): {result}', ['result' => $result ? 'true' : 'false']);
            return $result;
        } else {
            log_message('debug', 'Producto NO existente, insertando nuevo (Direct DB Query).');
            $dataToInsert = [
                'id_usuario'  => $idUsuario,
                'id_producto' => $idProducto,
                'cantidad'    => $cantidad,
                'fecha_agregado' => date('Y-m-d H:i:s'), // Añadir la fecha explícitamente
            ];

            log_message('debug', 'Datos para INSERTAR (Direct DB Query): {data}', ['data' => json_encode($dataToInsert)]);
            log_message('debug', 'Tipo de clave de id_usuario en dataToInsert: {type}', ['type' => gettype(key($dataToInsert))]);
            log_message('debug', 'Tipo de valor de id_usuario en dataToInsert: {type}', ['type' => gettype($dataToInsert['id_usuario'])]);

            // CAMBIO CLAVE: Usar insert directamente del Query Builder, no $this->save()
            $result = $this->db->table($this->table)->insert($dataToInsert);

            log_message('debug', 'Resultado de insert (Direct DB Query): {result}', ['result' => $result ? 'true' : 'false']);
            return $result;
        }
    }

    public function actualizarCantidad(int $idCarrito, int $cantidad): bool
    {
        log_message('debug', '*** INICIO actualizarCantidad (Solución definitiva) ***');
        log_message('debug', 'idCarrito: {idCarrito}, cantidad: {cantidad}', [
            'idCarrito' => $idCarrito,
            'cantidad' => $cantidad
        ]);

        if ($cantidad < 1) {
            $cantidad = 1;
            log_message('debug', 'Cantidad ajustada a 1.');
        }

        $dataToUpdate = [
            'cantidad'   => $cantidad
        ];

        log_message('debug', 'Datos para ACTUALIZAR (Direct DB Query): {data}', ['data' => json_encode($dataToUpdate)]);
        log_message('debug', 'Tipo de clave de cantidad en dataToUpdate: {type}', ['type' => gettype(key($dataToUpdate))]);
        log_message('debug', 'Tipo de valor de cantidad en dataToUpdate: {type}', ['type' => gettype($dataToUpdate['cantidad'])]);

        // CAMBIO CLAVE: Usar update directamente del Query Builder, no $this->save()
        $result = $this->db->table($this->table)
                           ->where('id_carrito', $idCarrito)
                           ->update($dataToUpdate);

        log_message('debug', 'Resultado de update (Direct DB Query - actualizarCantidad): {result}', ['result' => $result ? 'true' : 'false']);
        return $result;
    }

    public function eliminarProducto(int $idCarrito): bool
    {
        log_message('debug', 'Eliminando producto del carrito: {idCarrito}', ['idCarrito' => $idCarrito]);
        // Para delete, el método del modelo sigue siendo seguro, ya que no pasa por set()
        return $this->delete($idCarrito);
    }

    public function vaciarCarrito(int $idUsuario): bool
    {
        log_message('debug', 'Vaciando carrito para usuario: {idUsuario}', ['idUsuario' => $idUsuario]);
        // Para delete, el método del modelo sigue siendo seguro
        return $this->where('id_usuario', $idUsuario)->delete();
    }
}
