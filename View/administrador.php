<?php
session_start();

if (($_SESSION['tipo'] ?? '') !== 'administrador') {
    header('Location: Iniciar.php');
    exit();
}

require_once '../Controler/administradoresctrl.php';

$administradores = (new Administradoresctrl())->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#2867eb">
  <title>Administradores | ManualitOnline</title>
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="Static/CSS/administrador.css?v=20261021-4">
</head>
<body class="admin-page">
  <div class="admin-layout">
    <?php include 'Static/INCLUDE/sidebar.php'; ?>

    <main class="admin-main">
      <header class="admin-topbar">
        <div>
          <p class="admin-topbar__eyebrow">Panel de control</p>
          <h1>Administradores</h1>
        </div>
        <div class="admin-user">
          <span class="admin-user__icon" aria-hidden="true">
            <i class="fa-solid fa-user"></i>
          </span>
          <span>Administrador</span>
        </div>
      </header>

      <section class="admin-content" aria-labelledby="admin-list-title">
        <div class="admin-heading">
          <div>
            <p class="admin-heading__eyebrow">Gestión de accesos</p>
            <h2 id="admin-list-title">Administración de administradores</h2>
            <p class="admin-heading__description">Consulta y administra las cuentas con acceso al panel.</p>
          </div>
          <div class="admin-count" aria-label="<?php echo count($administradores); ?> administradores registrados">
            <span class="admin-count__number"><?php echo count($administradores); ?></span>
            <span class="admin-count__label">Registrados</span>
          </div>
        </div>

        <div class="admin-table-card">
          <div class="admin-table-card__header">
            <div>
              <h3>Lista de administradores</h3>
              <p>Información de las cuentas registradas</p>
            </div>
            <span class="admin-table-card__icon" aria-hidden="true">
              <i class="fa-solid fa-user-shield"></i>
            </span>
          </div>

          <div class="admin-table-scroll" role="region" aria-label="Lista de administradores" tabindex="0">
            <table class="admin-table">
              <thead>
                <tr>
                  <th scope="col" class="admin-table__id">ID</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Correo electrónico</th>
                  <th scope="col" class="admin-table__actions-heading">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($administradores)): ?>
                  <tr>
                    <td colspan="4" class="admin-table__empty">
                      <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
                      <span>No hay administradores registrados.</span>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($administradores as $administrador): ?>
                    <?php
                    $id = (int) $administrador->getId();
                    $nombre = htmlspecialchars($administrador->getNombre(), ENT_QUOTES, 'UTF-8');
                    $correo = htmlspecialchars($administrador->getCorreo(), ENT_QUOTES, 'UTF-8');
                    ?>
                    <tr>
                      <td class="admin-table__id"><?php echo $id; ?></td>
                      <td>
                        <div class="admin-person">
                          <span class="admin-person__avatar" aria-hidden="true">
                            <?php echo htmlspecialchars(mb_strtoupper(mb_substr($administrador->getNombre(), 0, 1, 'UTF-8'), 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>
                          </span>
                          <span class="admin-person__name"><?php echo $nombre; ?></span>
                        </div>
                      </td>
                      <td class="admin-email"><?php echo $correo; ?></td>
                      <td class="admin-actions">
                        <a class="admin-action admin-action--edit"
                           href="editar_administrador.php?id=<?php echo $id; ?>"
                           aria-label="Editar administrador <?php echo $nombre; ?>"
                           title="Editar administrador">
                          <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        </a>
                        <a class="admin-action admin-action--delete"
                           href="eliminar_administrador.php?id=<?php echo $id; ?>"
                           aria-label="Eliminar administrador <?php echo $nombre; ?>"
                           title="Eliminar administrador"
                           onclick="return confirm('¿Eliminar administrador?')">
                          <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <div class="admin-table-card__footer">
            Total: <strong><?php echo count($administradores); ?></strong>
            <?php echo count($administradores) === 1 ? 'administrador' : 'administradores'; ?>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
