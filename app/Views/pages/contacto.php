<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>

<div id="contacto-form-section" class="container-fluid py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card border-0 card-form-contacto shadow-sm"> <div class="card-header bg-primary text-white"> <h2 class="mb-0 text-center"> Formulario de Contacto</h2>
                    </div>
                    <div class="card-body">
                        <form class="mt-4" action="#" method="post"> <div class="mb-3"> <label for="motivo" class="form-label">Motivo de Consulta</label>
                                <select class="form-select" id="motivo" name="motivo" aria-label="Motivo de consulta">
                                    <option selected>Selecciona un motivo</option>
                                    <option value="1">Consulta</option>
                                    <option value="2">Reclamo</option>
                                    <option value="3">Sugerencia</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Tu correo electrónico" required>
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje aquí" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
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
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3539.0605963073356!2d-58.8354922849202!3d-27.464670282898124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456ca010b98a13%3A0xc4a1b0b7e4f9b09!2sCorrientes!5e0!3m2!1ses-419!2sar!4v1625000000000!5m2!1ses-419!2sar"
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