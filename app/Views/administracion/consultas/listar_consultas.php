<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>

<div class="container my-4">
    <h2><i class="bi bi-question-circle-fill me-2"></i><?= esc($titulo) ?></h2>
    <hr>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($consultas)): ?>
        <div class="alert alert-info" role="alert">
            No hay consultas registradas en el sistema.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Asunto</th>
                        <th>Fecha Envío</th>
                        <th>Estado</th>
                        <th>Usuario (si logueado)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $consulta): ?>
                        <tr>
                            <td><?= esc($consulta['id_consulta']) ?></td>
                            <td><?= esc($consulta['nombre']) ?></td>
                            <td><?= esc($consulta['email']) ?></td>
                            <td><?= esc($consulta['telefono'] ?? 'N/A') ?></td>
                            <td><?= esc($consulta['asunto']) ?></td>
                            <td><?= esc(date('d/m/Y H:i', strtotime($consulta['fecha_envio']))) ?></td>
                            <td>
                                <?php
                                    $estado_badge = '';
                                    switch ($consulta['estado']) {
                                        case 'pendiente':
                                            $estado_badge = 'bg-warning text-dark';
                                            break;
                                        case 'respondida':
                                            $estado_badge = 'bg-success';
                                            break;
                                        case 'archivada':
                                            $estado_badge = 'bg-secondary';
                                            break;
                                        default:
                                            $estado_badge = 'bg-info';
                                            break;
                                    }
                                ?>
                                <span class="badge <?= $estado_badge ?>"><?= esc(ucfirst($consulta['estado'])) ?></span>
                            </td>
                            <td>
                                <?php if ($consulta['id_usuario']): ?>
                                    ID: <?= esc($consulta['id_usuario']) ?><br>
                                    Nombre: <?= esc($consulta['nombre_usuario_relacionado'] ?? 'Desconocido') ?>
                                <?php else: ?>
                                    No logueado
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- ENLACE DIRECTO PARA VER DETALLE (sin modal AJAX) -->
                                <a href="<?= base_url('administracion/consultas/ver/' . esc($consulta['id_consulta'])) ?>" class="btn btn-sm btn-primary" title="Ver Detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <!-- Formulario para cambiar estado (ej. a 'respondida') -->
                                <form action="<?= base_url('administracion/consultas/cambiar_estado') ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_consulta" value="<?= esc($consulta['id_consulta']) ?>">
                                    <input type="hidden" name="nuevo_estado" value="respondida">
                                    <button type="submit" class="btn btn-sm btn-success" title="Marcar como Respondida" <?= $consulta['estado'] == 'respondida' ? 'disabled' : '' ?>>
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                                <form action="<?= base_url('administracion/consultas/eliminar') ?>" method="post" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta consulta?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_consulta" value="<?= esc($consulta['id_consulta']) ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar Consulta">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a href="<?= base_url('administracion/panel') ?>" class="btn btn-secondary mt-3">Volver al Panel</a>
</div>

<?= $this->endSection() ?>
