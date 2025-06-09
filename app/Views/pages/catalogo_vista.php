<?= $this->extend('templates/main_layout') ?>

<?php $this->section('content_for_layout') ?>
<h2>Productos</h2>
<table class="table">
    <thead>
        <tr>
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
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($productos) && is_array($productos)): ?>
            <?php foreach($productos as $producto) : ?>
                <tr>
                    <td><?= esc($producto['id_producto']) ?></td>
                    <td><?= esc($producto['nombre']) ?></td>
                    <td><?= esc($producto['descripcion']) ?></td>
                    <td><?= esc($producto['precio']) ?></td>
                    <td><?= esc($producto['stock']) ?></td>
                    <td><?= esc($producto['fecha_alta']) ?></td>
                    <td><?= esc($producto['fecha_modifica']) ?></td>
                    <td><?= esc($producto['fecha_elimina']) ?></td>
                    <td><?= esc($producto['image_url']) ?></td>
<td><?= esc($producto['nombre_categoria'] ?? 'Sin categoría') ?></td>
<td>
                        ID: <?= esc($producto['id_producto']) ?> <br>
<a href="<?= base_url('producto/' . $producto['id_producto']) ?>" class="btn btn-info btn-sm">Ver</a>
                    </td>
                </tr>
            <?php endforeach;?>
        <?php else: ?>
            <tr>
                <td colspan="11">No hay productos disponibles en el catálogo.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php $this->endSection() ?>