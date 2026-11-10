<?php
session_start();

if (($_SESSION['tipo'] ?? '') !== 'administrador') {
    header('Location: Iniciar.php');
    exit();
}

require_once '../Controler/registrarctrl.php';

$usuarios = (new Registrarctrl())->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#2867eb">
  <title>Usuarios | ManualitOnline</title>
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="Static/CSS/gestion.css?v=20261021-2">
</head>
<body class="gestion-page">
  <div class="gestion-layout">
    <?php include 'Static/INCLUDE/sidebar.php'; ?>

    <main class="gestion-main">
      <header class="gestion-topbar">
        <div>
          <p class="gestion-topbar__eyebrow">Panel de control</p>
          <h1>Usuarios</h1>
        </div>
        <div class="gestion-user">
          <span class="gestion-user__icon" aria-hidden="true">
            <i class="fa-solid fa-user"></i>
          </span>
          <span>Administrador</span>
        </div>
      </header>

      <section class="gestion-content" aria-labelledby="users-title">
        <div class="gestion-heading">
          <div>
            <p class="gestion-heading__eyebrow">Gestión de cuentas</p>
            <h2 id="users-title">Administración de usuarios</h2>
            <p class="gestion-heading__description">Consulta las cuentas registradas y su tipo de acceso.</p>
          </div>
          <div class="gestion-count" aria-label="<?php echo count($usuarios); ?> usuarios registrados">
            <span class="gestion-count__number"><?php echo count($usuarios); ?></span>
            <span class="gestion-count__label">Registrados</span>
          </div>
        </div>

        <div class="gestion-table-card">
          <div class="gestion-table-card__header">
            <div>
              <h3>Lista de usuarios</h3>
              <p>Cuentas registradas en ManualitOnline</p>
            </div>
            <span class="gestion-table-card__icon" aria-hidden="true">
              <i class="fa-solid fa-users"></i>
            </span>
          </div>

          <div class="gestion-table-scroll" role="region" aria-label="Lista de usuarios" tabindex="0">
            <table class="gestion-table">
              <thead>
                <tr>
                  <th scope="col" class="gestion-table__id">ID</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Correo electrónico</th>
                  <th scope="col">Tipo de cuenta</th>
                  <th scope="col" class="gestion-table__actions-heading">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($usuarios)): ?>
                  <tr>
                    <td colspan="5" class="gestion-table__empty">
                      <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
                      <span>No hay usuarios registrados.</span>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($usuarios as $usuario): ?>
                    <?php
                    $id = (int) $usuario->getId();
                    $nombre = htmlspecialchars($usuario->getNombre(), ENT_QUOTES, 'UTF-8');
                    $correo = htmlspecialchars($usuario->getCorreo(), ENT_QUOTES, 'UTF-8');
                    $tipoCuenta = htmlspecialchars($usuario->getTipoCuenta(), ENT_QUOTES, 'UTF-8');
                    $inicial = htmlspecialchars(mb_strtoupper(mb_substr($usuario->getNombre(), 0, 1, 'UTF-8'), 'UTF-8'), ENT_QUOTES, 'UTF-8');
                    ?>
                    <tr>
                      <td class="gestion-table__id"><?php echo $id; ?></td>
                      <td>
                        <div class="gestion-person">
                          <span class="gestion-person__avatar" aria-hidden="true"><?php echo $inicial; ?></span>
                          <span class="gestion-person__name"><?php echo $nombre; ?></span>
                        </div>
                      </td>
                      <td class="gestion-email"><?php echo $correo; ?></td>
                      <td><span class="gestion-badge"><?php echo $tipoCuenta; ?></span></td>
                      <td class="gestion-actions">
                        <a class="gestion-action gestion-action--edit"
                           href="editar_usuarios.php?id=<?php echo $id; ?>"
                           aria-label="Editar usuario <?php echo $nombre; ?>"
                           title="Editar usuario">
                          <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        </a>
                        <a class="gestion-action gestion-action--delete"
                           href="eliminar_usuarios.php?id=<?php echo $id; ?>"
                           aria-label="Eliminar usuario <?php echo $nombre; ?>"
                           title="Eliminar usuario"
                           onclick="return confirm('¿Eliminar usuario?')">
                          <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <div class="gestion-table-card__footer">
            Total: <strong><?php echo count($usuarios); ?></strong>
            <?php echo count($usuarios) === 1 ? 'usuario' : 'usuarios'; ?>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
