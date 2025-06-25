<section id="promos" class="mt-5">
    <div class="container-lg">
        <div id="titulo" class="text-left">
            <h2>Más buscados en la semana</h2>
        </div>
    </div>

    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
            <?php if (!empty($productos_destacados)): ?>
                <?php foreach ($productos_destacados as $producto): ?>
                    <div class="col d-flex justify-content-center">
                        <div class="card h-100" style="width: 18rem;">
                            <!-- Usar la URL de la imagen del producto. Asegúrate de que tus productos en la base de datos tengan una columna 'image_url' con rutas válidas. -->
                            <img src="<?= esc($producto['image_url']) ?>" class="card-img-top" alt="<?= esc($producto['nombre']) ?>">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= esc($producto['nombre']) ?></h5>
                                    <h6>$ <?= number_format(esc($producto['precio']), 2, ',', '.') ?></h6>
                                    
                                    <!-- Visualización del Stock -->
                                    <?php if ($producto['stock'] > 0): ?>
                                        <span class="badge bg-success mb-2"><?= esc($producto['stock']) ?> en stock</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger mb-2">Sin stock</span>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-auto">
                                    <!-- Botón "Ver Detalle" -->
                                    <a href="<?= base_url('producto/' . esc($producto['id_producto'])) ?>" class="btn btn-info mt-2">Ver Detalle</a>

                                    <?php if ($producto['stock'] > 0): ?>
                                        <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-2">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_producto" value="<?= esc($producto['id_producto']) ?>">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                                        </form>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-secondary mt-2" disabled>Agotado</button>
                                    <?php endif; ?>
                                </div>

                                <!-- Fechas (Alta, Modificación, Baja) -->
                                <div class="card-footer bg-transparent border-top-0 pt-3 text-muted" style="font-size: 0.75em;">
                                    <?php if (!empty($producto['fecha_alta'])): ?>
                                        <div>Alta: <?= esc(date('Y-m-d H:i', strtotime($producto['fecha_alta']))) ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($producto['fecha_modifica'])): ?>
                                        <div>Modifica: <?= esc(date('Y-m-d H:i', strtotime($producto['fecha_modifica']))) ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($producto['fecha_elimina'])): ?>
                                        <div>Baja: <?= esc(date('Y-m-d H:i', strtotime($producto['fecha_elimina']))) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="alert alert-info">No hay productos destacados disponibles en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
