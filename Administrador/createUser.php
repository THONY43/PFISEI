<?php
session_start();
include("../navegacion/topbar-admin.php");
include("../includes/modalserver.php");
include("../Funciones/Funciones.php");

verificarRol('administrador');
$error = "";
$msg = "";
if (isset($_POST['submitDocente'])) {
    $nombres = $_POST['nameDocente'];
    $apellidos = $_POST['apellidoDocente'];
    $cedula = $_POST['cedulaDocente'];
    $email = $_POST['emailDocente'];
    $telefono = $_POST['telefonoDocente'];

    $resultado = insertarUsuario('profesor', $nombres, $apellidos, $cedula, $email, $telefono, 'direccion');

    if ($resultado) {
        $msg = "Información del docente agregada correctamente";
    } else {
        $error = "Algo salió mal. Inténtalo de nuevo";
    }
}

if (isset($_POST['submitEstudiante'])) {
    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $cedula = $_POST['cedulaEstudiante'];
    $email = $_POST['emailEstudiante'];
    $telefono = $_POST['telefonoEstudiante'];
    $direccion = $_POST['direccionEstudiante'];

    $resultado = insertarUsuario('estudiante', $nombres, $apellidos, $cedula, $email, $telefono, $direccion);


    if ($resultado) {
        $msg = "Información del estudiante agregada correctamente";
    } else {
        $error = "Algo salió mal. Inténtalo de nuevo";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/js/DataTables/datatables.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="content-container">
        <div class="main-page">
            <div class="container-fluid1">
                <div class="row page-title-div">
                    <div class="col-md-6">
                        <h4 class="title">Agregar Usuario</h4>
                    </div>
                </div>
            </div>

            <!-- Selección del tipo de usuario -->
            <div class="select-container">
                <label for="userType" class="labeluser">Seleccionar tipo de usuario:</label>
                <select id="userType" name="userType">
                    <option value="">Seleccione una opción</option>
                    <option value="docente">Docente</option>
                    <option value="estudiante">Estudiante</option>
                </select>
            </div>
        </div>
        <?php if ($msg) { ?>
            <div class="alert alert-success" role="alert">
                <strong>Bien hecho! </strong><?php echo htmlentities($msg); ?>
            </div>
        <?php } else if ($error) { ?>
            <div class="alert alert-danger" role="alert">
                <strong>Algo salió mal!</strong> <?php echo htmlentities($error); ?>
            </div>
        <?php } ?>

        <!-- Formulario de Docente -->
        <div id="docenteForm" style="display:none;">
            <section class="section1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4>Completa la información del docente</h4>

                                    <div class="panel-body">

                                        <form class="row" method="post">
                                            <!-- Campos para Docente -->
                                            <div class="form-group col-md-4">
                                                <label for="nameDocente" class="control-label">Nombres</label>
                                                <input type="text" name="nameDocente" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="apellidoDocente" class="control-label">Apellidos</label>
                                                <input type="text" name="apellidoDocente" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="cedulaDocente" class="control-label">C.I.</label>
                                                <input type="text" name="cedulaDocente" class="form-control" maxlength="10" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="emailDocente" class="control-label">Correo Personal</label>
                                                <input type="email" name="emailDocente" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="telefonoDocente" class="control-label">Teléfono</label>
                                                <input type="text" name="telefonoDocente" class="form-control" required>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <button type="submit" name="submitDocente" class="btn btn-primary">Agregar Docente</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>

        <!-- Formulario de Estudiante -->
        <div id="estudianteForm" style="display:none;">
            <section class="section1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4>Completa la información del estudiante</h4>

                                    <div class="panel-body">

                                        <form class="row" method="post">
                                            <!-- Campos para Estudiante -->
                                            <div class="form-group col-md-4">
                                                <label for="nombreEstudiante" class="control-label">Nombres</label>
                                                <input type="text" name="nombre" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="apellidoEstudiante" class="control-label">Apellidos</label>
                                                <input type="text" name="apellido" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="cedulaEstudiante" class="control-label">C.I.</label>
                                                <input type="text" name="cedulaEstudiante" class="form-control" maxlength="10" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="emailEstudiante" class="control-label">Correo</label>
                                                <input type="email" name="emailEstudiante" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="direccionEstudiante" class="control-label">Dirección</label>
                                                <input type="text" name="direccionEstudiante" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="telefonoEstudiante" class="control-label">Teléfono</label>
                                                <input type="text" name="telefonoEstudiante" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <button type="submit" name="submitEstudiante" class="btn btn-primary">Agregar Estudiante</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>

    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#userType').on('change', function() {
                var userType = $(this).val();
                if (userType === 'docente') {
                    $('#docenteForm').show();
                    $('#estudianteForm').hide();
                } else if (userType === 'estudiante') {
                    $('#estudianteForm').show();
                    $('#docenteForm').hide();
                } else {
                    $('#docenteForm, #estudianteForm').hide();
                }
            });
        });
    </script>
</body>

</html>