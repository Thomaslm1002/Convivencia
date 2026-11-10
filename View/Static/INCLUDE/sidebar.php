<?php
// sidebar.php — inclúyelo en cada página con: include 'sidebar.php';

// Página actual, para marcar la opción activa
$paginaActual = basename($_SERVER['PHP_SELF']);

// Opciones del menú: para agregar una nueva, solo añade una línea
$menu = [
    ['archivo' => 'dashboard.php',     'icono' => 'fa-house',       'texto' => 'Inicio'],
    ['archivo' => 'usuarios.php',      'icono' => 'fa-users',       'texto' => 'Usuarios'],
    ['archivo' => 'sugerencias.php',   'icono' => 'fa-comments',    'texto' => 'Sugerencias'],
    ['archivo' => 'administrador.php', 'icono' => 'fa-user-shield', 'texto' => 'Administradores'],
];
?>
<aside class="sidebar" id="sidebar">

    <div class="logo">
        <i class="fas fa-book-open" aria-hidden="true"></i>
        <span>ManualitOnline</span>
    </div>

    <nav aria-label="Navegación principal">
        <ul>
            <?php foreach ($menu as $item): ?>
                <?php $activo = ($paginaActual === $item['archivo']); ?>
                <li>
                    <a href="<?= $item['archivo'] ?>"
                       class="<?= $activo ? 'active' : '' ?>"
                       <?= $activo ? 'aria-current="page"' : '' ?>
                       title="<?= $item['texto'] ?>">
                        <i class="fas <?= $item['icono'] ?>" aria-hidden="true"></i>
                        <span><?= $item['texto'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Cerrar sesión separado del resto, al final de la barra -->
    <div class="sidebar-footer">
        <a href="cerrar_sesion.php" class="logout">
            <i class="fas fa-right-from-bracket" aria-hidden="true"></i>
            <span>Cerrar sesión</span>
        </a>
    </div>

</aside>