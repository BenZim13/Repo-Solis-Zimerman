<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>

<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <h2><?= esc($titulo) ?></h2>
        </div>
        <div class="card-body">
            <?php if ($producto): ?>
                <h5 class="card-title"><?= esc($producto['nombre']) ?> (ID: <?= esc($producto['id_producto']) ?>)</h5>
                <p class="card-text"><strong>Descripción:</strong> <?= esc($producto['descripcion']) ?></p>
                <p class="card-text"><strong>Precio:</strong> $<?= esc(number_format($producto['precio'], 2, ',', '.')) ?></p>
                <p class="card-text"><strong>Stock Disponible:</strong> <?= esc($producto['stock']) ?></p>
                <p class="card-text"><strong>Categoría:</strong> <?= esc($producto['nombre_categoria']) ?></p>
            <?php else: ?>
                <p class="text-danger">No se encuentra el producto, revise el catálogo.</p>
            <?php endif; ?>

            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary mt-3">Volver al Catálogo</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
