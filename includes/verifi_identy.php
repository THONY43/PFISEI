<?php
session_start();
require '../vendor/autoload.php';  
require 'azure.php';               
$azure = new Azure();

// Si el usuario ha sido redirigido después de iniciar sesión en Azure, obtén el token de acceso
if (isset($_GET['code'])) {
    try {
        // Intercambiar el código por un token de acceso
        $accessToken = $azure->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // Obtener los detalles del usuario con el token de acceso
        $userDetails = $azure->getUserDetails($accessToken);

        // Guardar el nombre y el correo electrónico en variables de sesión
        $_SESSION['user_email'] = $userDetails['mail'];
        $_SESSION['user_name'] = $userDetails['displayName'];

        $email = $_SESSION['user_email'];
        $nombre = $_SESSION['user_name'];

        // Extraer el nombre de usuario antes del @
        $usuario = explode('@', $email)[0];  // Parte del correo antes de @

        // Verificar el rol basado en la estructura del usuario
        if ($usuario === 'apunina1844') {
            // Caso 1: Administrador
            $_SESSION['role'] = 'administrador';
            header('Location: ../Administrador/dashboard.php');
            exit(); 

        } elseif (preg_match('/\d{4}$/', $usuario)) {
            // Caso 2: Estudiante (si el nombre de usuario tiene 4 dígitos al final)
            $_SESSION['role'] = 'estudiante';
            header('Location: ../Estudiantes/dashboard.php');
            exit();
        } else {
            // Caso 3: Docente (sin dígitos al final)
            $_SESSION['role'] = 'docente';
            header('Location: ../Docentes/dashboard.php');
            exit();
        }

    } catch (Exception $e) {
        echo 'Error al obtener el token de acceso: ' . $e->getMessage();
    }
} else {
    echo 'No se recibió ningún código de autorización.';
}
