<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>

<div class="container my-4">
    <h2><i class="bi bi-person-gear me-2"></i><?= esc($titulo) ?>: <?= esc($usuario['nombre']) ?></h2>
    <hr>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <form action="<?= base_url('administracion/usuarios/actualizarUsuario') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_usuario" value="<?= esc($usuario['id_usuario']) ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre', $usuario['nombre']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $usuario['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña (dejar vacío para no cambiar):</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="form-text text-muted">Deja este campo vacío si no deseas cambiar la contraseña.</small>
            </div>

            <div class="mb-3">
                <label for="password_confirm" class="form-label">Confirmar Nueva Contraseña:</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm">
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol:</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="cliente" <?= old('rol', $usuario['rol']) === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                    <option value="admin" <?= old('rol', $usuario['rol']) === 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
                <?php if ((int)session()->get('id_usuario') === (int)$usuario['id_usuario'] && $usuario['rol'] === 'admin'): ?>
                    <small class="form-text text-danger">No puedes cambiar tu propio rol de administrador.</small>
                <?php endif; ?>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" <?= old('activo', $usuario['activo']) == 1 ? 'checked' : '' ?>
                    <?php if ((int)session()->get('id_usuario') === (int)$usuario['id_usuario'] && (int)$usuario['activo'] == 1): ?>
                        disabled title="No puedes desactivar tu propia cuenta de administrador"
                    <?php endif; ?>
                >
                <label class="form-check-label" for="activo">Activo</label>
                <?php if ((int)session()->get('id_usuario') === (int)$usuario['id_usuario'] && (int)$usuario['activo'] == 1): ?>
                    <small class="form-text text-danger">No puedes desactivar tu propia cuenta de administrador.</small>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success me-2"><i class="bi bi-arrow-repeat me-2"></i>Actualizar Usuario</button>
            <a href="<?= base_url('administracion/usuarios') ?>" class="btn btn-secondary"><i class="bi bi-x-circle me-2"></i>Cancelar</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
