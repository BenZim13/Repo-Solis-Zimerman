<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>
<h2 class="my-4">Productos Disponibles</h2>

<?php if (!empty($productos) && is_array($productos)): ?>
  <div class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
      <?php foreach($productos as $producto): ?>
        <div class="col d-flex justify-content-center">
          <div class="card h-100" style="width: 18rem;">
            <?php if (!empty($producto['image_url'])): ?>
              <img src="<?= esc($producto['image_url']) ?>" class="card-img-top" alt="<?= esc($producto['nombre']) ?>">
            <?php else: ?>
              <div class="d-flex align-items-center justify-content-center" style="height: 180px; background-color: #f8f9fa;">
                <i class="bi bi-image-alt" style="font-size: 4rem; color: #ccc;"></i>
              </div>
            <?php endif; ?>
            <div class="card-body text-center">
              <h5 class="card-title"><?= esc($producto['nombre']) ?></h5>
              <p class="card-text"><?= esc($producto['descripcion']) ?></p>
              <p class="card-text"><small class="text-muted"><?= esc($producto['nombre_categoria'] ?? 'Sin categoría') ?></small></p>
              <h6>$<?= number_format(esc($producto['precio']), 2, ',', '.') ?></h6>
              <?php if (esc($producto['stock']) > 0): ?>
                <span class="badge bg-success mb-2"><?= esc($producto['stock']) ?> en stock</span>
              <?php else: ?>
                <span class="badge bg-danger mb-2">Agotado</span>
              <?php endif; ?>
              <div class="d-grid gap-2">
                <a href="<?= base_url('producto/' . $producto['id_producto']) ?>" class="btn btn-info  mb-2">
                  <i class="bi bi-eye"></i> Ver Detalle
                </a>
                <?php if ($producto['stock'] > 0): ?>
                  <form action="<?= base_url('carrito/agregar') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_producto" value="<?= esc($producto['id_producto']) ?>">
                    <input type="hidden" name="cantidad" value="1">
                    <button type="submit" class="btn btn-success btn-sm">
                      <i class="bi bi-cart-plus"></i> Añadir al Carrito
                    </button>
                  </form>
                <?php else: ?>
                  <button type="button" class="btn btn-secondary btn-sm" disabled>
                    <i class="bi bi-x-circle"></i> Sin Stock
                  </button>
                <?php endif; ?>
              </div>
              <small class="d-block mt-3 text-muted">
                Alta: <?= esc($producto['fecha_alta']) ?><br>
                Modifica: <?= esc($producto['fecha_modifica']) ?><br>
                Baja: <?= esc($producto['fecha_elimina']) ?>
              </small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php else: ?>
  <p class="text-center">No hay productos disponibles en el catálogo.</p>
<?php endif; ?>

<?= $this->endSection() ?>
