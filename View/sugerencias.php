<?php
session_start();

if (($_SESSION['tipo'] ?? '') !== 'administrador') {
    header('Location: Iniciar.php');
    exit();
}

require_once '../Controler/contactoctrl.php';

$contactos = (new Contactoctrl())->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#2867eb">
  <title>Sugerencias | ManualitOnline</title>
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
          <h1>Sugerencias</h1>
        </div>
        <div class="gestion-user">
          <span class="gestion-user__icon" aria-hidden="true">
            <i class="fa-solid fa-user"></i>
          </span>
          <span>Administrador</span>
        </div>
      </header>

      <section class="gestion-content" aria-labelledby="suggestions-title">
        <div class="gestion-heading">
          <div>
            <p class="gestion-heading__eyebrow">Mensajes recibidos</p>
            <h2 id="suggestions-title">Administración de sugerencias</h2>
            <p class="gestion-heading__description">Revisa los mensajes y datos de contacto enviados por los usuarios.</p>
          </div>
          <div class="gestion-count" aria-label="<?php echo count($contactos); ?> mensajes recibidos">
            <span class="gestion-count__number"><?php echo count($contactos); ?></span>
            <span class="gestion-count__label">Mensajes</span>
          </div>
        </div>

        <div class="gestion-table-card">
          <div class="gestion-table-card__header">
            <div>
              <h3>Bandeja de sugerencias</h3>
              <p>Mensajes enviados desde el formulario de contacto</p>
            </div>
            <span class="gestion-table-card__icon" aria-hidden="true">
              <i class="fa-solid fa-comments"></i>
            </span>
          </div>

          <div class="gestion-table-scroll" role="region" aria-label="Lista de sugerencias" tabindex="0">
            <table class="gestion-table gestion-table--suggestions">
              <thead>
                <tr>
                  <th scope="col" class="gestion-table__id">ID</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Correo electrónico</th>
                  <th scope="col">Teléfono</th>
                  <th scope="col">Asunto</th>
                  <th scope="col">Mensaje</th>
                  <th scope="col" class="gestion-table__actions-heading">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($contactos)): ?>
                  <tr>
                    <td colspan="7" class="gestion-table__empty">
                      <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
                      <span>No hay sugerencias recibidas.</span>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($contactos as $contacto): ?>
                    <?php
                    $id = (int) $contacto->getId();
                    $nombre = htmlspecialchars($contacto->getNombre(), ENT_QUOTES, 'UTF-8');
                    $correo = htmlspecialchars($contacto->getCorreo(), ENT_QUOTES, 'UTF-8');
                    $telefono = htmlspecialchars($contacto->getTelefono(), ENT_QUOTES, 'UTF-8');
                    $asunto = htmlspecialchars($contacto->getAsunto(), ENT_QUOTES, 'UTF-8');
                    $mensaje = htmlspecialchars($contacto->getMensaje(), ENT_QUOTES, 'UTF-8');
                    $inicial = htmlspecialchars(
                        mb_strtoupper(mb_substr($contacto->getNombre(), 0, 1, 'UTF-8'), 'UTF-8'),
                        ENT_QUOTES,
                        'UTF-8'
                    );
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
                      <td><?php echo $telefono; ?></td>
                      <td class="gestion-subject"><?php echo $asunto; ?></td>
                      <td class="gestion-message" title="<?php echo $mensaje; ?>"><?php echo $mensaje; ?></td>
                      <td class="gestion-actions">
                        <a class="gestion-action gestion-action--edit"
                           href="editar_contacto.php?id=<?php echo $id; ?>"
                           aria-label="Editar sugerencia de <?php echo $nombre; ?>"
                           title="Editar sugerencia">
                          <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        </a>
                        <a class="gestion-action gestion-action--delete"
                           href="eliminar_contacto.php?id=<?php echo $id; ?>"
                           aria-label="Eliminar sugerencia de <?php echo $nombre; ?>"
                           title="Eliminar sugerencia"
                           onclick="return confirm('¿Eliminar sugerencia?')">
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
            Total: <strong><?php echo count($contactos); ?></strong>
            <?php echo count($contactos) === 1 ? 'mensaje' : 'mensajes'; ?>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
