<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>
<div class="container mt-5 ingreso">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h2 class="mb-0"><?= $titulo ?? 'Ingresar' ?></h2>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('exito')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                    <?php if (isset($errores)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errores as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('ingresar') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="ingrese su email" required>
                            <label for="email" class="form-label">Email</label>
                            
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="ingrese su contraseña" required>
                            <label for="contraseña" class="form-label">Contraseña</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>
                    </form>
                    <p class="text-center mt-3">
                        ¿No tienes una cuenta? <a href="<?= base_url('registrarse') ?>">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>