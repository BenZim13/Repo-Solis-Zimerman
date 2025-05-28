<h2>Productos</h2>
<table class="table">
    <thead>
        <th>ID</th>
        <th>NOMBRE</th>
        <th>DESCRIPCION</th>
        <th>PRECIO $</th>
        <th>STOCK</th>
    </thead>
    <tbody>
        <?php foreach($productos as $producto) : ?>
            <tr>
                <td><?= esc($producto->id_producto) ?></td>
                <td><?= esc($producto->nombre) ?></td>
                <td><?= esc($producto->descripcion) ?></td>
                <td><?= esc($producto->precio) ?></td>
                <td><?= esc($producto->stock) ?></td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>