">
```php
<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h2 class="mb-0"><i class="bi bi-question-circle-fill me-2"></i><?= esc($titulo) ?></h2>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

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

                    <!-- INICIO: Usando la etiqueta <form> HTML explícita -->
                    <form action="<?= base_url('consultas/guardar') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Tu Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="<?= old('nombre', $nombre ?? '') ?>" required
                                placeholder="Ingresa tu nombre completo">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Tu Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= old('email', $email ?? '') ?>" required
                                placeholder="ejemplo@dominio.com">
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono (Opcional):</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                value="<?= old('telefono', $telefono ?? '') ?>"
                                placeholder="Tu número de teléfono">
                        </div>

                        <div class="mb-3">
                            <label for="asunto" class="form-label">Asunto:</label>
                            <input type="text" class="form-control" id="asunto" name="asunto"
                                value="<?= old('asunto', $asunto ?? '') ?>" required
                                placeholder="Breve descripción de tu consulta">
                        </div>

                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje:</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="6" required
                                placeholder="Detalla tu consulta aquí..."><?= old('mensaje', $mensaje ?? '') ?></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Enviar Consulta</button>
                            <a href="<?= base_url('/') ?>" class="btn btn-secondary btn-lg">Cancelar</a>
                        </div>
                    </form>
                    <!-- FIN: Usando la etiqueta <form> HTML explícita -->
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>