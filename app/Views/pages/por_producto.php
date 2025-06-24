<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>

<div class="container my-5">
<div class="card">
    <div class="card-header align text-center">
        <h2><?= esc($titulo) ?></h2>
    </div>
    <div class="d-flex">
        <?php if (!empty($producto['image_url'])): ?>
            <img src="<?= esc($producto['image_url']) ?>" alt="<?= esc($producto['nombre']) ?>" class="img-fluid" style="max-width: 250px; object-fit: contain;"/>
        <?php else: ?>
            <div style="width: 250px; height: 250px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-image-alt" style="font-size: 4rem; color: #ccc;"></i>
            </div>
        <?php endif; ?>
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

<a href="<?= base_url('catalogo') ?>" class="btn btn-primary por-producto-btn-volver mt-3">Volver al Catálogo</a>
        </div>
    </div>
</div>
</div>

<?= $this->endSection() ?>

