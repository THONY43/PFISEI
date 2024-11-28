<?php
session_start();
include("../navegacion/topbar-student.php");
include("../Funciones/Funciones.php");

verificarRol('estudiante');
$error = "";

$userEmail = $_SESSION['user_email'];
$userName = $_SESSION['user_name'];




?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/js/DataTables/datatables.min.css" />
    <script src="../assets/js/DataTables/jquery.min.js"></script>
    <script src="../assets/js/DataTables/datatables.min.js"></script>
</head>

<body>
    <div class="content-container">
        <div class="textoFacultad">
            Facultad de Ingeniería en Sistemas, Electrónica e Industrial

        </div>
    </div>
    <div class="fondo-dashboard">
        <div class="contenido">
            <div class="bienvenida">
                <?php
                echo "Bienvenido, $userName";
                ?>
            </div>
            <div class=texto-sub>
                Cursos
                
            </div>
            <div class="carreras">
            <?php
                $result = buscarCarreras();
                if (!empty($result)) {
                    foreach ($result as $carrera) {?>


                      <?php  echo $carrera['nombre_carrera'] . "<br>"; ?>
                  <?php  }?>
              <?php  } else {
                    echo "No se encontraron carreras.";
                }
                ?>
            </div>

            
        </div>
    </div>
</body>

</html>