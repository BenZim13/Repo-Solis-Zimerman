<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>
<div class="container mt-4 registro">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h2 class="mb-0"><?= $titulo ?? 'Registrarse' ?></h2>
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

                    <?php if (session()->getFlashdata('errors')): ?> <!-- CAMBIADO A 'errors' -->
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error): ?> <!-- CAMBIADO A 'errors' -->
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('registrarse') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class=" form-floating mb-3">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre') ?>" placeholder="ingrese su nombre" required>
                            <label for="nombre" class="form-label">Nombre</label>
                        </div>

                        <div class=" form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="emailejemplo@gmail.com" required>
                            <label for="email" class="form-label">Email</label>
                        </div>

                        <div class=" form-floating mb-3">
                            <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder=" Contraseña" required>
                            <label for="contraseña" class="form-label">Contraseña</label>
                        </div>

                        <div class=" form-floating mb-3">
                            <input type="password" class="form-control" id="confirmar_contraseña" name="confirmar_contraseña" placeholder=" Confirmar contraseña" required>
                            <label for="confirmar_contraseña" class="form-label">Confirmar Contraseña</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Crea tu cuenta</button>
                        </div>

                    </form>
                    <p class="text-center mt-3">
                        ¿Ya tienes una cuenta? <a href="<?= base_url('ingresar') ?>">Ingresa aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
