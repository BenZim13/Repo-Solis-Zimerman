<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content_for_layout') ?>

<div class="container my-4">
    <div class="card p-4 shadow-sm" style="max-width: 800px; margin: auto;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4"><i class="bi bi-receipt me-2"></i>Factura de Compra</h2>
            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Factura No.:</strong> <?= uniqid('INV-') ?> <br>
                    <strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($invoice['fecha'])) ?>
                </div>
                <div class="col-md-6 text-md-end">
                    <strong>Tienda Ejemplo</strong><br>
                    Dirección: Calle Falsa 123<br>
                    Ciudad: Buenos Aires<br>
                    Email: info@tienda.com
                </div>
            </div>

            <h5 class="mb-3 mt-4">Datos del Cliente:</h5>
            <p>
                <strong>Nombre:</strong> <?= esc($invoice['cliente_nombre']) ?><br>
                <strong>Email:</strong> <?= esc($invoice['cliente_email']) ?><br>
                <!-- Puedes añadir más datos del cliente si los tienes en tu modelo de usuario -->
            </p>

            <h5 class="mb-3 mt-4">Detalles de los Productos:</h5>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio Unitario</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoice['productos'] as $producto): ?>
                        <tr>
                            <td><?= esc($producto['nombre']) ?></td>
                            <td class="text-center"><?= esc($producto['cantidad']) ?></td>
                            <td class="text-end">$<?= number_format(esc($producto['precio_unitario']), 2, ',', '.') ?></td>
                            <td class="text-end">$<?= number_format(esc($producto['subtotal']), 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Pagado:</th>
                        <th class="text-end">$<?= number_format(esc($invoice['total']), 2, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>

            <div class="text-center mt-4">
                <p class="text-muted">¡Gracias por tu compra!</p>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-primary mt-3">Volver al Catálogo</a>
                <button type="button" class="btn btn-info mt-3" onclick="window.print()">Imprimir Factura</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
