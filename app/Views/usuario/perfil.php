<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white text-center">
                    <h2 class="mb-0"><?= $titulo ?? 'Mi Perfil' ?></h2>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('exito')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <p><strong>ID de Usuario:</strong> <?= esc($usuario['id_usuario'] ?? 'N/A') ?></p>
                    <p><strong>Nombre:</strong> <?= esc($usuario['nombre'] ?? 'N/A') ?></p>
                    <p><strong>Email:</strong> <?= esc($usuario['email'] ?? 'N/A') ?></p>
                    <p><strong>Rol:</strong> <?= ($usuario['rol'] ?? null) == 1 ? 'Administrador' : 'Cliente' ?></p>

                    <h4 class="mt-4">Opciones:</h4>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="#">Editar Perfil</a></li>
                        <li class="list-group-item"><a href="#">Ver Historial de Pedidos</a></li>
                        <?php if (($usuario['rol'] ?? null) == 1): ?>
                            <li class="list-group-item bg-info text-white"><a class="text-white" href="<?= base_url('administracion/panel') ?>">Ir al Panel de Administración</a></li>
                        <?php endif; ?>
                        <li class="list-group-item"><a href="<?= base_url('salir') ?>">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>