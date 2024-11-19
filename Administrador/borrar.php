<?php
session_start();
include("../Funciones/Funciones.php");
verificarRol('administrador');

if (isset($_GET['stid'])) {
    $user_id = $_GET['stid'];
    $result = eliminarUsuario($user_id);

    if ($result) {
        
        header("Location: deleteUser.php?msg=Usuario eliminado con éxito");
    } else {
     
        header("Location: deleteUser.php?msg=Error al eliminar usuario");
    }
} else {
    
    header("Location: deleteUser.php?msg=No se ha proporcionado un id de usuario");
}
?>
