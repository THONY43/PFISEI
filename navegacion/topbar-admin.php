<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FISEI - Gestión Administrador</title>
  <link rel="shortcut icon" href="../assets/images/LogoFisei.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body class="top-navbar-fixed">
  <!-- Navbar principal -->
  <nav class="navbar navbar-top bg-white">
    <div class="container-fluid">
      <div class="navbar-header no-padding">
        <a class="navbar-brand" target="_blank" href="index.php">
          <img src="../assets/images/sistemas.png" class="navbar-logo">
        </a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <!-- Navegación Izquierda (Menús principales) -->
        <ul class="nav navbar-nav navbar-left">
          <li class="nav-item activo">
            <a href="../Administrador/dashboard.php">
              Página Principal
            </a>
          </li>
          <li class="nav-item" onclick="showSubmenu(this, 'usuarios')">
            <a href="#">Usuarios</a>
          </li>
          <li class="nav-item" onclick="showSubmenu(this, 'carreras')">
            <a href="#">Carreras</a>
          </li>
          <li class="nav-item" onclick="showSubmenu(this, 'materias')">
            <a href="#">Materias</a>
          </li>
        </ul>
        <!-- Navegación Derecha (Iconos) -->
        <ul class="nav navbar-nav navbar-right">
          <li class="nav-item2">
            <a href="#" class="icon-link">
              <i class="fa-regular fa-bell"></i>
            </a>
          </li>
          <li class="nav-item2">
            <a href="#" class="icon-link">
              <i class="fa-regular fa-envelope"></i>
            </a>
          </li>
          <li class="nav-item2">
            <a href="#" class="icon-link">
              <i class="fa fa-user-circle"></i>
            </a>
          </li>
          <li class="nav-item2">
            <a href="../includes/cerrarsesion.php" class="icon-link">
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <script src="../assets/js/scriptnav.js"></script>

  <nav class="sub-navbar" id="sub-navbar">
    <div class="container-fluid">
      <ul class="nav navbar-nav navbar-left" id="submenu-items">
        <!-- Los elementos de submenú se generarán aquí -->
      </ul>
    </div>
  </nav>
  <script src="../assets/js/scriptsubnav.js"> </script>
</body>

</html>