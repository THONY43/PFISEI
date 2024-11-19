<?php
session_start();
include("../navegacion/topbar-admin.php");
include("../includes/modalserver.php");
include("../Funciones/Funciones.php");
verificarRol('administrador');

$msg = "";
$stid = isset($_GET['stid']) ? $_GET['stid'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;

// Luego sigue el proceso de validación, similar al anterior


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = actualizarEstudiante(
        $stid,
        $_POST['fullanme'],
        $_POST['rollid'],
        $_POST['emailid'],
        $_POST['gender'],
        $_POST['dob'],
        $_POST['status']
    );
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/js/DataTables/datatables.min.css" />
    <script src="../assets/js/DataTables/jquery.min.js"></script>
    <script src="../assets/js/DataTables/datatables.min.js"></script>
</head>
<div class="content-wrapper">
    <div class="content-container">
        <div class="main-page">

            <div class="container-fluid">
                <div class="row page-title-div">
                    <div class="col-md-6">
                        <h2 class="title">Editar Usuario</h2>

                    </div>

                </div>

            </div>
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h5>Completa la información del Usuario</h5>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php if ($msg) { ?>
                                    <div class="alert alert-success left-icon-alert" role="alert">
                                        <strong>Proceso correcto! </strong><?php echo htmlentities($msg); ?>
                                    </div>
                                    <div class="alert alert-danger left-icon-alert" role="alert">
                                        <strong>Hubo un inconveniete! </strong>
                                    </div>
                                <?php } ?>
                                <?php

                                $results = obtenerEstudiantePorId($stid, $type);

                                if (is_array($results)&& !empty($results)) {
                                    foreach ($results as $result) {

                                        if (strtolower($type) === "estudiante") {
                                ?>
                                            <form class="form-horizontal" method="post">
                                                <div class="form-group">
                                                    <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo htmlentities($result->nombre); ?>" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="apellido" class="col-sm-2 control-label">Apellido</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="apellido" class="form-control" id="apellido" value="<?php echo htmlentities($result->apellido); ?>" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="cedula" class="col-sm-2 control-label">C.I.</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="cedula" class="form-control" id="cedula" value="<?php echo htmlentities($result->cedula); ?>" maxlength="10" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="correo" class="col-sm-2 control-label">Correo</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" name="correo" class="form-control" id="correo" value="<?php echo htmlentities($result->correo); ?>" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="direccion" class="col-sm-2 control-label">Dirección</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="direccion" class="form-control" id="direccion" value="<?php echo htmlentities($result->direccion); ?>" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="telefono" class="col-sm-2 control-label">Teléfono</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="telefono" class="form-control" id="telefono" value="<?php echo htmlentities($result->telefono); ?>" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <!-- Información académica -->
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h5>Información Académica</h5>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="nivel" class="col-sm-2 control-label">Nivel</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nivel" class="form-control" id="nivel" value="<?php echo htmlentities($result->nivel); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="paralelo" class="col-sm-2 control-label">Paralelo</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="paralelo" class="form-control" id="paralelo" value="<?php echo htmlentities($result->paralelo); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="nombre_carrera" class="col-sm-2 control-label">Carrera</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nombre_carrera" class="form-control" id="nombre_carrera" 
                                                        value="<?php echo htmlentities($result->nombre_carrera); ?>" readonly>
                                                    </div>
                                                </div>

                                                <!-- Fecha de registro -->
                                                <div class="form-group">
                                                    <label for="fecha_registro" class="col-sm-2 control-label">Fecha de Registro</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="fecha_registro" class="form-control" id="fecha_registro" 
                                                        value="<?php echo htmlentities($result->fecha_inscripcion); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" name="submit" class="btn btn-primary">Actualizar</button>
                                                    </div>
                                                </div>
                                            </form>
                                    <?php
                                        }
                                    }
                                } else if (isset($results['query_result']) && !empty($results['query_result'])) {
                                    $materias = $results['materias'];
                                    $carreras = $results['carreras'];
                                    $cursos = $results['cursos'];
                                    $result = $results['query_result'][0]; 
                                    echo $result->nombre; 
 
                                ?>
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group">
                                            <label for="nombre_docente" class="col-sm-2 control-label">Nombre Docente</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nombre_docente" class="form-control" id="nombre_docente" 
                                                value="<?php echo htmlentities($result['nombre']); ?>" required="required" autocomplete="off">
                                            </div>
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="apellido_docente" class="col-sm-2 control-label">Apellido Docente</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="apellido_docente" class="form-control" id="apellido_docente"
                                                 value="<?php echo htmlentities($result->apellido); ?>" required="required" autocomplete="off">
                                            </div>
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="materia" class="col-sm-2 control-label">Materia</label>
                                            <div class="col-sm-10">
                                                <select name="materia" class="form-control" id="materia" required="required">
                                                    <?php foreach ($materias as $materia) { ?>
                                                        <option value="<?php echo $materia['id_materia']; ?>" <?php echo $result->id_materia == $materia['id_materia'] ? 'selected' : ''; ?>>
                                                            <?php echo $materia['nombre']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="carrera" class="col-sm-2 control-label">Carrera</label>
                                            <div class="col-sm-10">
                                                <select name="carrera" class="form-control" id="carrera" required="required">
                                                    <?php foreach ($carreras as $carrera) { ?>
                                                        <option value="<?php echo $carrera['id_carrera']; ?>" <?php echo $result->id_carrera == $carrera['id_carrera'] ? 'selected' : ''; ?>>
                                                            <?php echo $carrera['nombre_carrera']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="curso" class="col-sm-2 control-label">Curso</label>
                                            <div class="col-sm-10">
                                                <select name="curso" class="form-control" id="curso" required="required">
                                                    <?php foreach ($cursos as $curso) { ?>
                                                        <option value="<?php echo $curso['id_curso']; ?>" <?php echo $result->id_curso == $curso['id_curso'] ? 'selected' : ''; ?>>
                                                            <?php echo $curso['nivel'] . ' - ' . $curso['paralelo']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="fecha_registro" class="col-sm-2 control-label">Fecha de Registro</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="fecha_registro" class="form-control" id="fecha_registro" value="<?php echo htmlentities($result->fecha_inscripcion); ?>" readonly>
                                            </div>
                                        </div>
                                
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" name="submit" class="btn btn-primary">Actualizar</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php 
                                } 
                                ?>                               

                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
            </div>
        </div>
        <!-- /.content-container -->
    </div>

</html>