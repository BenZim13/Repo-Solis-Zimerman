<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h2 class="mb-0"><i class="bi bi-speedometer2 me-2"></i><?= esc($titulo ?? 'Panel de Administración') ?></h2>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('exito')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('exito') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <p class="lead">Bienvenido al panel de administración, <strong><?= esc(session()->get('nombre_usuario') ?? 'Usuario') ?></strong>.</p>

                    <h4 class="mt-4 mb-3">Estadísticas Rápidas:</h4>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="card text-white bg-info shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="bi bi-people-fill me-2"></i>Total Usuarios</h5>
                                    <p class="card-text fs-3"><?= esc($totalUsuarios ?? '0') ?></p>
                                    <a href="<?= base_url('administracion/usuarios') ?>" class="text-white stretched-link">Gestionar Usuarios <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-white bg-warning shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="bi bi-boxes me-2"></i>Total Productos</h5>
                                    <p class="card-text fs-3"><?= esc($totalProductos ?? '0') ?></p>
                                    <a href="<?= base_url('productos/listar') ?>" class="text-white stretched-link">Gestionar Productos <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-4">Opciones de Administración:</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="<?= base_url('administracion/usuarios') ?>" class="text-decoration-none"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Administrar Perfiles de Clientes</a></li>
                        <li class="list-group-item"><a href="<?= base_url('administracion/usuarios/nuevo') ?>" class="text-decoration-none"><i class="bi bi-person-plus-fill me-2 text-success"></i>Crear Nuevo Usuario</a></li>
                        <li class="list-group-item"><a href="<?= base_url('productos/listar') ?>" class="text-decoration-none"><i class="bi bi-box-seam me-2 text-primary"></i>Administrar Productos (Listar/Editar/Baja)</a></li>
                        <li class="list-group-item"><a href="<?= base_url('productos/agregar') ?>" class="text-decoration-none"><i class="bi bi-plus-square-fill me-2 text-success"></i>Agregar Nuevo Producto</a></li>
                        <li class="list-group-item"><a href="<?= base_url('administracion/consultas') ?>" class="text-decoration-none"><i class="bi bi-chat-dots-fill me-2 text-info"></i>Gestionar Consultas</a></li>
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-muted"><i class="bi bi-journal-text me-2"></i>Ver Órdenes (Funcionalidad Futura)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>