<nav class="navbar cabec fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <a class="navbar-brand text-white" href="<?= base_url('/') ?>">SuperCarpi</a>

        <form class="d-flex mx-auto" role="search" action="<?= base_url('producto/buscar') ?>" method="get">
            <input class="form-control" type="search" placeholder="Buscar Producto" name="q" required>
            <button class="btn btn-outline-light ms-2" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <div class="d-flex align-items-center">

            <div class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownCatalogo" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            </div>

            <a class="nav-link text-white me-3" href="<?= base_url('carrito') ?>">
                <i class="bi bi-cart-fill fs-5"></i>
            </a>

            <div class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle text-white" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-5"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
                    <?php if (session()->get('estaLogueado')): ?>
                        <li><span class="dropdown-item-text">¡Hola, <?= esc(session()->get('nombre') ?? 'Usuario') ?>!</span></li>
                        <?php if (session()->get('rol') == 1): // Rol 1 es Administrador ?>
                            <li><span class="dropdown-item-text small text-muted">(Administrador)</span></li>
                            <li><a class="dropdown-item" href="<?= base_url('administracion/panel') ?>">Panel Admin</a></li> <?php else: ?>
                            <li><span class="dropdown-item-text small text-muted">(Cliente)</span></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="<?= base_url('mi-perfil') ?>">Mi Perfil</a></li> <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('salir') ?>">Cerrar Sesión</a></li> <?php else: ?>
                        <li><a class="dropdown-item" href="<?= base_url('ingresar') ?>">Ingresar</a></li> <li><a class="dropdown-item" href="<?= base_url('registrarse') ?>">Registrarse</a></li> <?php endif; ?>
                </ul>
            </div>

            <button class="navbar-toggler text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <i class="bi bi-list fs-3"></i>
            </button>
        </div>

        <div class="offcanvas offcanvas-end bg-light text-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header bg-dark text-white">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">

                    <?php if (session()->get('estaLogueado') && session()->get('rol') == 1): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Administración
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdmin">
                                <li><a class="dropdown-item" href="<?= base_url('administracion/panel') ?>">Panel Principal Admin</a></li> <li><a class="dropdown-item" href="<?= base_url('productos/listar') ?>">Gestión de Productos</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('productos/agregar') ?>">Agregar Producto</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('administracion/usuarios') ?>">Gestión de Usuarios</a></li> </ul>
                        </li>
                    <?php endif; ?>

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