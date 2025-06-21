<?= $this->extend('templates/main_layout') ?>

<?php $this->section('content_for_layout') ?>
<h2 class="my-4">Productos Disponibles</h2>

<table class="table table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>IMAGEN</th>
            <th>NOMBRE</th>
            <th>DESCRIPCION</th>
            <th>PRECIO $</th>
            <th>STOCK</th>
            <th>CATEGORIA</th>
            <th>ALTA</th>
            <th>MODIFICA</th>
            <th>BAJA</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($productos) && is_array($productos)): ?>
            <?php foreach($productos as $producto) : ?>
                <tr>
                    <td><?= esc($producto['id_producto']) ?></td>
                    <td>
                        <?php if (!empty($producto['image_url'])): ?>
                            <img src="<?= esc($producto['image_url']) ?>" alt="<?= esc($producto['nombre']) ?>" style="width: 80px; height: auto; border-radius: 4px;">
                        <?php else: ?>
                            <i class="bi bi-image-alt" style="font-size: 2rem; color: #ccc;"></i>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($producto['nombre']) ?></td>
                    <td><?= esc($producto['descripcion']) ?></td>
                    <td>$<?= number_format(esc($producto['precio']), 2, ',', '.') ?></td>
                    <td>
                        <?php if (esc($producto['stock']) > 0): ?>
                            <span class="badge bg-success"><?= esc($producto['stock']) ?></span>
                        <?php else: ?>
                            <span class="badge bg-danger">Agotado</span>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($producto['nombre_categoria'] ?? 'Sin categoría') ?></td>
                    <td><?= esc($producto['fecha_alta']) ?></td>
                    <td><?= esc($producto['fecha_modifica']) ?></td>
                    <td><?= esc($producto['fecha_elimina']) ?></td>
                    <td>
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('producto/' . $producto['id_producto']) ?>" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> Ver Detalle
                            </a>
                            <?php if ($producto['stock'] > 0): ?>
                                <form action="<?= base_url('carrito/agregar') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_producto" value="<?= esc($producto['id_producto']) ?>">
                                    <input type="hidden" name="cantidad" value="1"> <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-cart-plus"></i> Añadir al Carrito
                                    </button>
                                </form>
                            <?php else: ?>
                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-x-circle"></i> Sin Stock
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach;?>
        <?php else: ?>
            <tr>
                <td colspan="11" class="text-center">No hay productos disponibles en el catálogo.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php $this->endSection() ?>