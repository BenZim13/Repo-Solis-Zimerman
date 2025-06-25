<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>



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