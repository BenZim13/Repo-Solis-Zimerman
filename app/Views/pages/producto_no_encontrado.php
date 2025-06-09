<div class="container my-5">
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading"><?= esc($titulo ?? 'Producto No Encontrado') ?></h4>
        <p><?= esc($mensaje ?? 'El producto solicitado no fue encontrado en nuestra base de datos.') ?></p>
        <hr>
        <p class="mb-0">Puedes <a href="<?= base_url('catalogo') ?>" class="alert-link">volver al catálogo principal</a> para explorar otros productos.</p>
    </div>
</div>