<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>

<div class="container my-4">
    <h2><i class="bi bi-cart-fill me-2"></i>Tu Carrito de Compras</h2>

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

    <?php if (empty($carrito)): ?>
        <div class="alert alert-info" role="alert">
            Tu carrito está vacío. ¡Empieza a agregar productos!
        </div>
        <a href="<?= base_url('catalogo') ?>" class="btn btn-primary">Ir al Catálogo</a>
    <?php else: ?>
        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th class="text-end">Precio Unitario</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-end">Subtotal</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $total_carrito = 0; ?>
                <?php foreach ($carrito as $item): ?>
                    <tr>
                        <td>
                            <?php
                                // Asegúrate de que el nombre_producto siempre esté disponible
                                echo esc($item['nombre_producto'] ?? 'Producto Desconocido');
                            ?>
                        </td>
                        <td class="text-end">$<?= number_format(esc($item['precio_producto']), 2, ',', '.') ?></td>
                        <td class="text-center">
                            <form action="<?= base_url('carrito/actualizar') ?>" method="post" class="d-inline-flex align-items-center">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_carrito" value="<?= esc($item['id_carrito']) ?>">
                                <input type="number" name="cantidad" value="<?= esc($item['cantidad']) ?>" min="1" class="form-control form-control-sm w-auto me-2" style="max-width: 80px;">
                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Actualizar cantidad">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </form>
                        </td>
                        <td class="text-end">$<?= number_format(esc($item['precio_producto'] * $item['cantidad']), 2, ',', '.') ?></td>
                        <td class="text-center">
                            <form action="<?= base_url('carrito/eliminar') ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_carrito" value="<?= esc($item['id_carrito']) ?>">
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar producto">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php $total_carrito += ($item['precio_producto'] * $item['cantidad']); ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total del Carrito:</th>
                    <th class="text-end">$<?= number_format($total_carrito, 2, ',', '.') ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <a href="<?= base_url('catalogo') ?>" class="btn btn-secondary">Seguir Comprando</a>
            <form action="<?= base_url('carrito/vaciar') ?>" method="post" class="d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-warning"><i class="bi bi-trash-fill me-2"></i>Vaciar Carrito</button>
            </form>
            <!-- AÑADIR ESTE FORMULARIO PARA FINALIZAR LA COMPRA -->
            <form action="<?= base_url('carrito/finalizarCompra') ?>" method="post" class="d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-success"><i class="bi bi-bag-check-fill me-2"></i>Finalizar Compra</button>
            </form>
        </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>
