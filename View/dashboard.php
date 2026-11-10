<?php
/**
 * dashboard.php
 * Panel de administración de ManualitOnline.
 * Solo accesible para usuarios de tipo "administrador". Muestra una barra
 * lateral, tarjetas con estadísticas (usuarios, manual, noticias y
 * sugerencias) y las gráficas del sistema.
 *
 * Secciones del archivo:
 *   1. Lógica PHP (sesión, control de acceso, dependencias, estadísticas)
 *   2. Cabecera del documento (<head>)
 *   3. Barra lateral (sidebar)
 *   4. Contenido principal (barra superior, bienvenida, tarjetas y gráficas)
 *   5. Scripts
 */

/*  1. LÓGICA PHP  */

// Inicia o reanuda la sesión del usuario (antes de cualquier salida HTML).
session_start();

//  Control de acceso: solo pueden entrar los administradores
// Si el usuario no tiene sesión o su tipo no es "administrador", se le
// redirige a la página de inicio de sesión y se detiene la ejecución.
if (($_SESSION['tipo'] ?? '') !== 'administrador') {
    header("Location: Iniciar.php");
    exit();
}

// Dependencias 
// Modelo y controlador de usuarios (Registrar / Registrarctrl)
require_once "../Model/registrar.php";
require_once "../Controler/registrarctrl.php";
// Modelo y controlador de contactos o sugerencias (Contacto / Contactoctrl)
require_once "../Model/contacto.php";
require_once "../Controler/contactoctrl.php";
// Estadísticas para las tarjetas 
// Total de usuarios registrados
$totalUsuarios = (new Registrarctrl())->contar();
// Total de sugerencias o contactos
$totalSugerencias = (new Contactoctrl())->contar();

$conexion = ConexionBD::getConn();

$consulta = $conexion->query(
    "SELECT COUNT(*) FROM administradores"
);

$totalAdministradores = (int) $consulta->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<!--  2. CABECERA DEL DOCUMENTO  -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard -- ManualitOnline</title>
  <!-- Estilos del dashboard y de las gráficas -->
  <link rel="stylesheet" href="Static/CSS/Dashboard.css">
  <link rel="stylesheet" href="Static/CSS/grafica.css">
  <link rel="stylesheet" href="Static/CSS/sidebar.css?v=20261021-5">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome (íconos) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <!-- Ícono de la pestaña -->
  <link rel="icon" href="Static/IMG/LogoSF.png" type="image/jpeg">
</head>
<body class="dashboard-page">
  <div class="container">
    <!--  3. BARRA LATERAL: Incluye el menú lateral compartido por las páginas del panel. -->
    <?php include("Static/INCLUDE/sidebar.php"); ?>

    <!--  4. CONTENIDO PRINCIPAL: Contiene la barra superior, el mensaje de bienvenida, las tarjetas de estadísticas y las gráficas. -->
    <div class="main">
      <!-- Barra superior: título de la página y usuario actual -->
      <div class="navbar">
        <h2>Dashboard</h2>
        <div class="user">
          <i class="fas fa-user-circle"></i>
          Administrador
        </div>
      </div>
      <div class="content">
        <!-- Bienvenida -->
        <h1>¡Bienvenido!</h1>
        <p>Panel de administración de ManualitOnline.</p>
        <!-- Tarjetas de estadísticas."Usuarios" y "Sugerencias" son dinámicas (vienen de la base de datos); "Manual" y "Noticias" están escritas a mano (1 y 12). -->
        <div class="cards">
          <div class="card">
            <i class="fas fa-users"></i>
            <h2><?php echo $totalUsuarios; ?></h2>
            <p>Usuarios</p>
          </div>
          <div class="card">
            <i class="fas fa-book"></i>
            <h2>1</h2>
            <p>Manual</p>
          </div>
          <div class="card">
            <i class="fas fa-newspaper"></i>
            <h2><?php echo  $totalAdministradores; ?></h2>
            <p>Administradores</p>
          </div>
          <div class="card">
            <i class="fas fa-comments"></i>
            <h2><?php echo $totalSugerencias; ?></h2>
            <p>Sugerencias</p>
          </div>
        </div>
        <!-- Gráficas: se cargan desde un archivo reutilizable -->
        <?php include("Static/INCLUDE/graficas.php"); ?>
      </div>
    </div>
  </div>

  <!--  5. SCRIPTS: Lógica de las gráficas. -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="Static/JS/Grafica.js"></script>
</body>
</html>