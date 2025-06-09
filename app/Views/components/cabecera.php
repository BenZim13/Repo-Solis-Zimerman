<nav class="navbar cabec navbar-expand-xl fixed-top">
    <div class="container-fluid d-flex align-content-start flex-wrap">
        <a class="navbar-brand" href="<?= base_url('/') ?>">SuperCarpi</a>

<form class="d-flex" role="search" action="<?= base_url('producto/buscar') ?>" method="get">
    <input class="form-control" type="search" placeholder="Buscar Producto" name="q" required>
    <button class="btn btn-outline-light ms-2" type="submit">
        <i class="bi bi-search"></i>
    </button>
</form>




        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <i class="bi bi-list"></i>
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                    <!-- Contenedor correcto para dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCatalogo" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Catálogo
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownCatalogo">
                            <li><a class="dropdown-item" href="<?= base_url('catalogo') ?>">Ver Todo el Catálogo</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if (isset($categorias_menu) && !empty($categorias_menu)): ?>
                                <?php foreach ($categorias_menu as $categoria): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('catalogo/categoria/' . esc($categoria['id_categoria'])) ?>">
                                            <?= esc($categoria['nombre']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="#">No hay categorías disponibles</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>


                    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Administración
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdmin">
        <li><a class="dropdown-item" href="<?= base_url('productos/listar') ?>">Gestión de Productos</a></li>
        <li><a class="dropdown-item" href="<?= base_url('productos/agregar') ?>">Agregar Producto</a></li>
    </ul>
</li>


                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('comercializacion') ?>">Comercialización</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('quienessomos') ?>">Quiénes Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('contacto') ?>">Información de Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('terminos') ?>">Términos y Usos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
