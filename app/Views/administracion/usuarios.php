<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="display-4 text-primary">Gestión de Usuarios</h2>
        <p class="lead">Aquí puedes administrar los usuarios de tu plataforma.</p>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de Usuarios</h5>
            <a href="<?= base_url('administracion/usuarios/nuevo') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
            </a>
        </div>
        <div class="card-body">
            <?php if (empty($usuarios)): ?>
                <div class="alert alert-info text-center" role="alert">
                    <h4 class="alert-heading">¡Lista de Usuarios Vacía!</h4>
                    <p>No hay usuarios registrados en el sistema por el momento.</p>
                    <hr>
                    <p class="mb-0">Haz clic en "Nuevo Usuario" para agregar el primero.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Estado</th> <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <th scope="row"><?= esc($usuario['id_usuario']) ?></th> <td><?= esc($usuario['nombre']) ?></td>
                                    <td><?= esc($usuario['email']) ?></td>
                                    <td><?= esc($usuario['rol']) ?></td>
                                    <td>
                                        <?php if ($usuario['activo'] == 1): ?> <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('administracion/usuarios/editar/' . esc($usuario['id_usuario'])) ?>" class="btn btn-info btn-sm me-1" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" title="Eliminar" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="<?= esc($usuario['id_usuario']) ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

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
                        <input type="hidden" name="id_usuario" id="deleteUserIdInput">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
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