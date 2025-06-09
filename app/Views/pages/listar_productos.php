<?= $this->extend('templates/main_layout') ?>
<?= $this->section('content_for_layout') ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><?= esc($titulo) ?></h2>
        <a href="<?= base_url('productos/agregar') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </a>
    </div>

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

    <?php if (empty($productos)): ?>
        <div class="alert alert-info" role="alert">
            No hay productos registrados.
        </div>
    <?php else: ?>
        <?= form_open(base_url('productos/eliminar_seleccionados'), ['id' => 'form-eliminar-multiples']) ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 30px;">
                            <input type="checkbox" id="seleccionar-todos">
                        </th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="ids_eliminar[]" value="<?= esc($producto['id_producto']) ?>">
                            </td>
                            <td><?= esc($producto['id_producto']) ?></td>
                            <td><?= esc($producto['nombre']) ?></td>
                            <td><?= esc(mb_strimwidth($producto['descripcion'], 0, 50, '...')) ?></td> <td>$<?= esc(number_format($producto['precio'], 2, ',', '.')) ?></td>
                            <td><?= esc($producto['stock']) ?></td>
                            <td><?= esc($producto['nombre_categoria']) ?></td>
                            <td>
                                <?php if ($producto['activo']): ?>
                                    <span class="badge bg-success">Sí</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">No</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('productos/editar/' . esc($producto['id_producto'])) ?>" class="btn btn-sm btn-warning mb-1" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="<?= base_url('productos/eliminar/' . esc($producto['id_producto'])) ?>" class="btn btn-sm btn-danger mb-1" title="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto? (Se ocultará, no se borrará permanentemente)')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-danger" id="btn-eliminar-seleccionados" disabled onclick="return confirm('¿Estás seguro de que quieres eliminar los productos seleccionados? (Se ocultarán, no se borrarán permanentemente)')">
                <i class="bi bi-trash"></i> Eliminar Seleccionados
            </button>
        </div>
        <?= form_close() ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const seleccionarTodosCheckbox = document.getElementById('seleccionar-todos');
    const checkboxesProductos = document.querySelectorAll('input[name="ids_eliminar[]"]');
    const btnEliminarSeleccionados = document.getElementById('btn-eliminar-seleccionados');

    function toggleEliminarButton() {
        const anyChecked = Array.from(checkboxesProductos).some(checkbox => checkbox.checked);
        btnEliminarSeleccionados.disabled = !anyChecked;
    }

    seleccionarTodosCheckbox.addEventListener('change', function() {
        checkboxesProductos.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleEliminarButton();
    });

    checkboxesProductos.forEach(checkbox => {
        checkbox.addEventListener('change', toggleEliminarButton);
    });

    // Estado inicial del botón al cargar la página
    toggleEliminarButton();
});
</script>

<?= $this->endSection() ?>