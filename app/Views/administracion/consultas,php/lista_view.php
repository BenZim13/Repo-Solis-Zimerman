<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>
<div class="container mt-4">
    <h2 class="mb-4">Gestión de Consultas</h2>

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

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Motivo</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($consultas) && is_array($consultas)): ?>
                    <?php foreach ($consultas as $consulta) : ?>
                        <tr>
                            <td><?= esc($consulta['id']) ?></td>
                            <td><?= esc($consulta['motivo']) ?></td>
                            <td><?= esc($consulta['nombre']) ?></td>
                            <td><?= esc($consulta['email']) ?></td>
                            <td><?= esc(date('d/m/Y H:i', strtotime($consulta['fecha_creacion']))) ?></td>
                            <td>
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
                            </td>
                            <td>
                                <a href="<?= base_url('admin/consultas/view/' . $consulta['id']) ?>" class="btn btn-info btn-sm">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay consultas pendientes.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>