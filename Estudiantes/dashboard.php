<?php
session_start();
include("../navegacion/topbar-student.php") ;
include("../Funciones/Funciones.php");

verificarRol('estudiante');
$error = "";

$userEmail = $_SESSION['user_email'];
$userName = $_SESSION['user_name'];


echo "Bienvenido, $userName";

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
    
</body>
</html>

