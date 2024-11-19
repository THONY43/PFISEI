<?php
include("includes/azure.php");
$azure = new Azure();

$basePath = dirname($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FISEI - Plataforma</title>
    <link rel="shortcut icon" href="assets/images/LogoFisei.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include("includes/modalserver.php"); ?>
    
    <div class="inicio">
            <div class="content-container1">
                <div class="imagen">
                    <img src="assets/images/sistemas.png" alt="Imagen de la facultad" class="imagen1">
                    <div class="texto">
                        <h4 class="suave-texto">Facultad de Ingeniería en Sistemas, Electrónica e Industrial</h4>
                    </div>
                </div>

                <div class="boton">
                    <div class="texto2">
                        <h4 class="suave-texto">Ingresar con:</h4>
                    </div>
                    <a href="<?php echo $azure->getAuthorizationUrl(); ?>" class="btn btn-primary enlace-inicio">
                        <img src="https://www.microsoft.com/favicon.ico" alt="Microsoft Icon" class="icono-microsoft">
                        Microsoft Office 365
                    </a>
                </div>
            </div>
        
    </div>

</body>

</html>
