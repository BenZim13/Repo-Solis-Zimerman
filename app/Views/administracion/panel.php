<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0"><?= $titulo ?? 'Panel de Administración' ?></h2>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('exito')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <p class="lead">Bienvenido al panel de administración, <strong><?= esc(session()->get('nombre') ?? 'Usuario') ?></strong>.</p>

                    <h4 class="mt-4">Opciones de Administración:</h4>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="<?= base_url('productos/listar') ?>">Gestión de Productos</a></li>
                        <li class="list-group-item"><a href="<?= base_url('productos/agregar') ?>">Agregar Nuevo Producto</a></li>
                        <li class="list-group-item"><a href="<?= base_url('administracion/usuarios') ?>">Gestión de Usuarios</a></li>
                        <li class="list-group-item"><a href="#">Ver Órdenes</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>