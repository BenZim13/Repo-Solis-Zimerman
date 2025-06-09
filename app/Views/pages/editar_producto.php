<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>

<div class="container my-5">
    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h2><?= esc($titulo) ?></h2>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?= form_open(base_url('productos/actualizar')) ?>
                <input type="hidden" name="id_producto" value="<?= esc($producto['id_producto']) ?>">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre', $producto['nombre']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= old('descripcion', $producto['descripcion']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label">Precio:</label>
                    <input type="number" class="form-control" id="precio" name="precio" step="0.01" value="<?= old('precio', $producto['precio']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock', $producto['stock']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="image_url" class="form-label">URL de la Imagen:</label>
                    <input type="url" class="form-control" id="image_url" name="image_url" value="<?= old('image_url', $producto['image_url']) ?>">
                    <small class="form-text text-muted">Opcional. Introduce una URL de imagen para el producto.</small>
                </div>

                <div class="mb-3">
                    <label for="id_categoria" class="form-label">Categoría:</label>
                    <select class="form-select" id="id_categoria" name="id_categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= esc($categoria['id_categoria']) ?>" <?= old('id_categoria', $producto['id_categoria']) == $categoria['id_categoria'] ? 'selected' : '' ?>>
                                <?= esc($categoria['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" <?= old('activo', $producto['activo']) == 1 ? 'checked' : '' ?>>
                    <label class="form-check-label" for="activo">Producto Activo</label>
                </div>

                <button type="submit" class="btn btn-warning">Actualizar Producto</button>
                <a href="<?= base_url('productos/listar') ?>" class="btn btn-secondary">Cancelar</a>
            <?= form_close() ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>