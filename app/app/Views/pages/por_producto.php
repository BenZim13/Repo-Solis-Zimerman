<?php echo $this->extend('templates/main_layout');?>
<?php echo $this->section('contenido'); ?>

<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <h2>Detalles del producto: <?php echo esc($producto['nombre']) ?></h2>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo esc($producto['nombre']) ?> (ID: <?php echo esc($producto['id_producto']) ?>)</h5>
            <p class="card-text"><strong>Descripción:</strong> <?php echo esc($producto['descripcion']) ?></p>
            <p class="card-text"><strong>Precio:</strong> $<?php echo esc(number_format($producto['precio'], 2, ',', '.')) ?></p>
            <p class="card-text"><strong>Stock Disponible:</strong> <?php echo esc($producto['stock']) ?></p>

            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary mt-3">Volver al Catálogo</a>
            </div>
    </div>
</div>

<?php echo $this->endSection(); ?>