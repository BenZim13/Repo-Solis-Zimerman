<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>

<div class="container my-4">
    <h2><i class="bi bi-people-fill me-2"></i><?= esc($titulo) ?></h2>
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

    <div class="d-flex justify-content-end mb-3">
        <a href="<?= base_url('administracion/usuarios/nuevo') ?>" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-2"></i>Crear Nuevo Usuario
        </a>
    </div>

    <?php if (empty($usuarios)): ?>
        <div class="alert alert-info" role="alert">
            No hay usuarios registrados en el sistema.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= esc($usuario['id_usuario']) ?></td>
                            <td><?= esc($usuario['nombre']) ?></td>
                            <td><?= esc($usuario['email']) ?></td>
                            <td><?= esc($usuario['rol']) ?></td>
                            <td>
                                <?= $usuario['activo'] ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>' ?>
                            </td>
                            <td>
                                <!-- Botón Editar -->
                                <a href="<?= base_url('administracion/usuarios/editar/' . esc($usuario['id_usuario'])) ?>" class="btn btn-info btn-sm me-1" title="Editar Usuario">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Botón Eliminar (con Modal) - Lógica para deshabilitar eliminación de sí mismo/otros admins -->
                                <?php
                                    $currentUserId = session()->get('id_usuario');
                                    $isCurrentUser = (int)$usuario['id_usuario'] === (int)$currentUserId;
                                    $isOtherAdmin = ($usuario['rol'] === 'admin' && !$isCurrentUser);
                                ?>
                                <?php if ($isCurrentUser || $isOtherAdmin): ?>
                                    <button type="button" class="btn btn-danger btn-sm" disabled title="No puedes eliminar esta cuenta">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-danger btn-sm" title="Eliminar Usuario" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="<?= esc($usuario['id_usuario']) ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a href="<?= base_url('administracion/panel') ?>" class="btn btn-secondary mt-3">Volver al Panel</a>
</div>

<!-- Modal de Confirmación de Eliminación (asegúrate de que este modal esté en tu main_layout.php o al final de tu vista) -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.
                <br>
                <strong id="userIdToDelete"></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteUserForm" action="" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_usuario" id="deleteUserIdInput">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        if (confirmDeleteModal) {
            confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Botón que activó el modal
                const userId = button.getAttribute('data-id'); // Extraer ID del usuario

                // Actualizar el texto en el modal para mostrar el ID del usuario
                const userIdText = confirmDeleteModal.querySelector('#userIdToDelete');
                userIdText.textContent = 'Usuario ID: ' + userId;

                // Actualizar el action del formulario de eliminación y el input oculto
                const deleteUserForm = confirmDeleteModal.querySelector('#deleteUserForm');
                deleteUserForm.action = '<?= base_url('administracion/usuarios/eliminar/') ?>' + userId;
                const deleteUserIdInput = confirmDeleteModal.querySelector('#deleteUserIdInput');
                deleteUserIdInput.value = userId;
            });
        }
    });
</script>

<?= $this->endSection() ?>
