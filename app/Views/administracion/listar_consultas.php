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
                                <!-- Aquí podrías añadir botones para ver detalle, marcar como respondida, etc. -->
                                <button type="button" class="btn btn-sm btn-primary" title="Ver Detalle" data-bs-toggle="modal" data-bs-target="#consultaModal" data-id="<?= esc($consulta['id_consulta']) ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
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

<!-- Modal para ver el detalle de la consulta -->
<div class="modal fade" id="consultaModal" tabindex="-1" aria-labelledby="consultaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="consultaModalLabel">Detalle de la Consulta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID Consulta:</strong> <span id="modal-id_consulta"></span></p>
                <p><strong>Nombre:</strong> <span id="modal-nombre"></span></p>
                <p><strong>Email:</strong> <span id="modal-email"></span></p>
                <p><strong>Teléfono:</strong> <span id="modal-telefono"></span></p>
                <p><strong>Asunto:</strong> <span id="modal-asunto"></span></p>
                <p><strong>Fecha Envío:</strong> <span id="modal-fecha_envio"></span></p>
                <p><strong>Estado:</strong> <span id="modal-estado"></span></p>
                <p><strong>Usuario Asociado:</strong> <span id="modal-id_usuario"></span></p>
                <hr>
                <p><strong>Mensaje:</strong></p>
                <p id="modal-mensaje" class="alert alert-light border"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var consultaModal = document.getElementById('consultaModal');
    consultaModal.addEventListener('show.bs.modal', function (event) {
        // Botón que activó el modal
        var button = event.relatedTarget;
        var id_consulta = button.getAttribute('data-id');

        // Hacer una solicitud AJAX para obtener los datos de la consulta
        fetch('<?= base_url('administracion/consultas/detalle_ajax/') ?>' + id_consulta)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.consulta) {
                    var consulta = data.consulta;
                    document.getElementById('modal-id_consulta').textContent = consulta.id_consulta;
                    document.getElementById('modal-nombre').textContent = consulta.nombre;
                    document.getElementById('modal-email').textContent = consulta.email;
                    document.getElementById('modal-telefono').textContent = consulta.telefono || 'N/A';
                    document.getElementById('modal-asunto').textContent = consulta.asunto;
                    document.getElementById('modal-fecha_envio').textContent = new Date(consulta.fecha_envio).toLocaleString('es-ES', { dateStyle: 'medium', timeStyle: 'short' });
                    
                    // Actualizar estado con badge
                    var estadoBadge = document.getElementById('modal-estado');
                    estadoBadge.textContent = consulta.estado.charAt(0).toUpperCase() + consulta.estado.slice(1);
                    estadoBadge.className = 'badge'; // Reset classes
                    switch (consulta.estado) {
                        case 'pendiente':
                            estadoBadge.classList.add('bg-warning', 'text-dark');
                            break;
                        case 'respondida':
                            estadoBadge.classList.add('bg-success');
                            break;
                        case 'archivada':
                            estadoBadge.classList.add('bg-secondary');
                            break;
                        default:
                            estadoBadge.classList.add('bg-info');
                            break;
                    }

                    document.getElementById('modal-id_usuario').textContent = consulta.id_usuario ? `ID: ${consulta.id_usuario} (Nombre: ${consulta.nombre_usuario_relacionado || 'Desconocido'})` : 'No logueado';
                    document.getElementById('modal-mensaje').textContent = consulta.mensaje;
                } else {
                    alert('Error al cargar la consulta: ' + (data.message || 'Desconocido'));
                }
            })
            .catch(error => {
                console.error('Error fetching consulta details:', error);
                alert('Error de red o del servidor al cargar la consulta.');
            });
    });
});
</script>

<?= $this->endSection() ?>
