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

    <?php if (!empty($consulta)): ?>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Consulta #<?= esc($consulta['id_consulta']) ?> - Asunto: <?= esc($consulta['asunto']) ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nombre:</strong> <?= esc($consulta['nombre']) ?><br>
                        <strong>Email:</strong> <?= esc($consulta['email']) ?><br>
                        <strong>Teléfono:</strong> <?= esc($consulta['telefono'] ?? 'N/A') ?>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <strong>Fecha de Envío:</strong> <?= esc(date('d/m/Y H:i', strtotime($consulta['fecha_envio']))) ?><br>
                        <strong>Estado:</strong>
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
                    </div>
                </div>

                <hr>

                <p><strong>Usuario Asociado:</strong>
                    <?php if ($consulta['id_usuario']): ?>
                        ID: <?= esc($consulta['id_usuario']) ?> (<?= esc($consulta['nombre_usuario_relacionado'] ?? 'Desconocido') ?>)
                    <?php else: ?>
                        No logueado
                    <?php endif; ?>
                </p>

                <hr>

                <h5>Mensaje:</h5>
                <div class="alert alert-light border p-3">
                    <p class="mb-0"><?= nl2br(esc($consulta['mensaje'])) ?></p>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="<?= base_url('administracion/consultas') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-2"></i>Volver a Consultas
                </a>
                <!-- Puedes añadir aquí botones de acción para la consulta específica si lo deseas -->
                <form action="<?= base_url('administracion/consultas/cambiar_estado') ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_consulta" value="<?= esc($consulta['id_consulta']) ?>">
                    <input type="hidden" name="nuevo_estado" value="respondida">
                    <button type="submit" class="btn btn-success" title="Marcar como Respondida" <?= $consulta['estado'] == 'respondida' ? 'disabled' : '' ?>>
                        <i class="bi bi-check-circle me-2"></i>Marcar como Respondida
                    </button>
                </form>
                <form action="<?= base_url('administracion/consultas/eliminar') ?>" method="post" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta consulta?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_consulta" value="<?= esc($consulta['id_consulta']) ?>">
                    <button type="submit" class="btn btn-danger" title="Eliminar Consulta">
                        <i class="bi bi-trash me-2"></i>Eliminar Consulta
                    </button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            La consulta solicitada no fue encontrada.
        </div>
        <a href="<?= base_url('administracion/consultas') ?>" class="btn btn-secondary">Volver a Consultas</a>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
