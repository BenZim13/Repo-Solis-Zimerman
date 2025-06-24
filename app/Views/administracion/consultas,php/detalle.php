<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>
<div class="container mt-4">
    <h2 class="mb-4">Detalle de Consulta #<?= esc($consulta['id']) ?></h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Información de la Consulta
        </div>
        <div class="card-body">
            <p><strong>Motivo:</strong> <?= esc($consulta['motivo']) ?></p>
            <p><strong>Nombre:</strong> <?= esc($consulta['nombre']) ?></p>
            <p><strong>Email:</strong> <?= esc($consulta['email']) ?></p>
            <p><strong>Fecha:</strong> <?= esc(date('d/m/Y H:i', strtotime($consulta['fecha_creacion']))) ?></p>
            <p>
                <strong>Estado:</strong>
                <?php
                $badgeClass = '';
                switch ($consulta['estado']) {
                    case 'pendiente':
                        $badgeClass = 'bg-warning text-dark';
                        break;
                    case 'respondido':
                        $badgeClass = 'bg-success';
                        break;
                    case 'archivado':
                        $badgeClass = 'bg-secondary';
                        break;
                    default:
                        $badgeClass = 'bg-info';
                        break;
                }
                ?>
                <span class="badge <?= $badgeClass ?>"><?= esc(ucfirst($consulta['estado'])) ?></span>
            </p>
            <hr>
            <p><strong>Mensaje:</strong></p>
            <p class="card-text border p-3 bg-light rounded"><?= nl2br(esc($consulta['mensaje'])) ?></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Actualizar Estado
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/consultas/updateStatus/' . $consulta['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="estado" class="form-label">Nuevo Estado:</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="pendiente" <?= $consulta['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="respondido" <?= $consulta['estado'] == 'respondido' ? 'selected' : '' ?>>Respondido</option>
                        <option value="archivado" <?= $consulta['estado'] == 'archivado' ? 'selected' : '' ?>>Archivado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Estado</button>
            </form>
        </div>
    </div>

    <a href="<?= base_url('admin/consultas') ?>" class="btn btn-outline-secondary">Volver al listado</a>
</div>
<?= $this->endSection() ?>