<h2>Productos</h2>
<table class="table">
    <thead>
        <th>ID</th>
        <th>NOMBRE</th>
        <th>DESCRIPCION</th>
        <th>PRECIO $</th>
        <th>STOCK</th>
        <th>ALTA</th>
        <th>MODIFICA</th>
        <th>BAJA</th>
        <th>IMAGEN</th>
        <th>CATEGORIA</th>
    </thead>
    <tbody>
        <?php foreach($productos as $producto) : ?>
            <tr>
                <td><?php echo $producto['id_producto'] ?></td>
                <td><?php echo $producto['nombre'] ?></td>
                <td><?php echo $producto['descripcion'] ?></td>
                <td><?php echo $producto['precio'] ?></td>
                <td><?php echo $producto['stock'] ?></td>
                <td><?php echo $producto['fecha_alta'] ?></td>
                <td><?php echo $producto['fecha_modifica'] ?></td>
                <td><?php echo $producto['fecha_elimina'] ?></td>
                <td><?php echo $producto['image_url'] ?></td>
                <td><?php echo $producto['id_categoria'] ?></td> 
                //ARREGLAR PARA QUE APAREZCA NOMRBE DE LA CATEGORIA

                
            </tr>
        <?php endforeach;?>
    </tbody>
</table>