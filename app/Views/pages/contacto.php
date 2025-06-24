<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>

<div id="contacto-form-section" class="container-fluid py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card border-0 card-form-contacto shadow-sm">
                    <div class="card-header text-white" style="background-color:#ff5722;"> <h2 class="mb-0 text-center"> Formulario de Contacto</h2>
                    </div>
                    <div class="card-body">
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

                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0 text-start">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form class="mt-4" action="<?= base_url('contact/submit') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="motivo" class="form-label">Motivo de Consulta</label>
                                <select class="form-select" id="motivo" name="motivo" aria-label="Motivo de consulta" required>
                                    <option value="">Selecciona un motivo</option> <option value="consulta" <?= old('motivo') == 'consulta' ? 'selected' : '' ?>>Consulta</option>
                                    <option value="reclamo" <?= old('motivo') == 'reclamo' ? 'selected' : '' ?>>Reclamo</option>
                                    <option value="sugerencia" <?= old('motivo') == 'sugerencia' ? 'selected' : '' ?>>Sugerencia</option>
                                    <option value="otro" <?= old('motivo') == 'otro' ? 'selected' : '' ?>>Otro</option> </select>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" value="<?= old('nombre') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Tu correo electrónico" value="<?= old('email') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje aquí" required><?= old('mensaje') ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color:#ff5722; border-color:#ff5722;">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="medios_de_contacto" class="container-fluid py-5 bg-light"> <div class="container-lg text-center mb-4"> <h2>Contacto</h2>
    </div>
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-4">
                <div class="card mb-3 h-100 border-0"> <div class="row g-0 align-items-center">
                        <div class="col-md-4">
                            <img src="<?=base_url('public/assets/img/10.png')?>" class="img-fluid rounded-start" alt="Instagram">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-primary" style="color:#ff5722;">Instagram</h5>
                                <p class="card-text">@SuperCarpiOk</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card mb-3 h-100 border-0"> <div class="row g-0 align-items-center">
                        <div class="col-md-4">
                            <img src="<?=base_url('public/assets/img/9.png')?>" class="img-fluid rounded-start" alt="Correo">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-primary" style="color:#ff5722;">Correo</h5>
                                <p class="card-text">SupermercadosSuperCarpi@gmail.com </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card mb-3 h-100 border-0"> <div class="row g-0 align-items-center">
                        <div class="col-md-4">
                            <img src="<?=base_url('public/assets/img/telefono.png')?>" class="img-fluid rounded-start" alt="Teléfono">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title text-primary" style="color:#ff5722;">Teléfono</h5>
                                <p class="card-text">+54 9 379 4369875 </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="mapa-ubicacion" class="container-fluid py-5"> <div class="container">
        <h2 class="text-center mb-4" style="color:#ff5722;">Ubicación</h2>
        <div class="ratio ratio-16x9"> <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3539.110595089307!2d-58.8319694!3d-27.4697966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456ca123456789%3A0x123456789abcdef!2sCorrientes%2C%20Corrientes%20Province%2C%20Argentina!5e0!3m2!1sen!2sus!4v1678901234567!5m2!1sen!2sus"
                width="100%"
                height="400"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Mapa de ubicación de SuperCarpi">
            </iframe>
        </div>
    </div>
</section>

<section id="razon_titular" class="container-fluid py-5 bg-light"> <div class="container-lg text-center mb-4"> </div>
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm"> <div class="card-body">
                        <h5 class="card-title text-primary" style="color:#ff5722;">Titular de la Empresa</h5>
                        <p class="card-text">Juan Gomez</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm"> <div class="card-body">
                        <h5 class="card-title text-primary" style="color:#ff5722;">Razón Social</h5> <p class="card-text"> Corporación Iberá S.A</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>