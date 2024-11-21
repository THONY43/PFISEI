<?php
session_start();
include("../navegacion/topbar-admin.php");
include("../Funciones/Funciones.php");
include("../includes/modalserver.php");
verificarRol('administrador');

$stid = isset($_GET['stid']) ? $_GET['stid'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;
$msg = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['user_type'])) {
        $user_type = $_POST['user_type'];

        if ($user_type === 'estudiante') {
            $msg = inscribirEstudiante(
                $stid,
                $carrera = $_POST['carrera'],
                $nivel = $_POST['nivel'],
                $paralelo = $_POST['paralelo']
            );
        } elseif ($user_type === 'docente') {
            $msg = inscribirDocente(
                $stid,
                $carrera = $_POST['carrera'],
                $materia = $_POST['materia'],
                $curso = $_POST['curso']
            );
        } else {
            $msg = "Tipo de usuario no reconocido.";
        }
    } else {
        $msg = "No se ha enviado el tipo de usuario.";
    }
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

<body>

    <div class="content-wrapper">
        <div class="content-container">
            <div class="main-page">

                <div class="container-fluid">
                    <div class="row page-title-div">
                        <div class="col-md-6">
                            <h2 class="title">Matricular <?php echo $type ?></h2>

                        </div>

                    </div>

                </div>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h5>Verificar la información del <?php echo $type ?></h5>
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

                                    $results = obtenerUsuarioPorId($stid, $type);

                                    if (isset($results['query_result']) && !empty($results['query_result'])) {
                                        $carreras = $results['carreras'];
                                        $cursos = $results['cursos'];
                                        foreach ($results['query_result'] as $result) {

                                            if (strtolower($type) === "estudiante") {
                                    ?>
                                                <form class="form-horizontal" method="post">

                                                    <input type="hidden" name="user_type" value="estudiante">
                                                    <div class="form-group">
                                                        <label for="nombre" class="col-sm-2 control-label">Nombres</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="nombre" class="form-control" id="nombre"
                                                                value="<?php echo htmlentities($result['nombre']); ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="apellido" class="col-sm-2 control-label">Apellidos</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="apellido" class="form-control" id="apellido"
                                                                value="<?php echo htmlentities($result['apellido']); ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="cedula" class="col-sm-2 control-label">C.I.</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="cedula" class="form-control" id="cedula"
                                                                value="<?php echo htmlentities($result['cedula']); ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <!-- Información académica -->
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            <h5>Información Académica</h5>
                                                        </div>
                                                    </div>



                                                    <div class="form-group">
                                                        <label for="carrera" class="col-sm-2 control-label">Carrera</label>
                                                        <div class="col-sm-4">
                                                            <select name="carrera" class="form-control" id="carrera" required="required">
                                                                <?php
                                                                foreach ($carreras as $carrera) {
                                                                    $id_carrera = $carrera['id_carrera'];
                                                                    $nombre_carrera = $carrera['nombre_carrera'];
                                                                    $duracion_carrera = $carrera['duracion_carrera']; // Duración de la carrera

                                                                    // Añadimos el atributo 'data-duracion' en cada opción
                                                                    echo "<option value='$id_carrera' data-duracion='$duracion_carrera'>$nombre_carrera</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nivel" class="col-sm-2 control-label">Nivel</label>
                                                        <div class="col-sm-4">
                                                            <select name="nivel" class="form-control" id="nivel" required="required">
                                                                <!-- Las opciones de 'Nivel' se llenarán dinámicamente -->
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="paralelo" class="col-sm-2 control-label">Paralelo</label>
                                                        <div class="col-sm-4">
                                                            <select name="paralelo" class="form-control" id="paralelo" required="required">
                                                                <option value="A">Paralelo A</option>
                                                                <option value="B">Paralelo B</option>
                                                            </select>
                                                        </div>


                                                    </div>



                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" class="btn btn-primary">Inscribir</button>
                                                        </div>
                                                    </div>
                                                </form>
                                        <?php
                                            }
                                        }
                                    } elseif (isset($results['query_result2']) && !empty($results['query_result2'])) {
                                        $materias = $results['materias2'];
                                        $carreras = $results['carreras2'];
                                        $cursos = $results['cursos2'];

                                        $result = $results['query_result2'][0];
                                        ?>
                                        <form class="form-horizontal" method="post">
                                            <input type="hidden" name="user_type" value="docente">

                                            <div class="form-group">
                                                <label for="nombre_docente" class="col-sm-2 control-label">Nombre Docente</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nombre_docente" class="form-control" id="nombre_docente"
                                                        value="<?php echo htmlentities($result['nombre']); ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="apellido_docente" class="col-sm-2 control-label">Apellido Docente</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="apellido_docente" class="form-control" id="apellido_docente"
                                                        value="<?php echo htmlentities($result['apellido']); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="apellido_docente" class="col-sm-2 control-label">Cedula Docente</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="apellido_docente" class="form-control" id="apellido_docente"
                                                        value="<?php echo htmlentities($result['cedula']); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Información Académica</h5>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="carrera" class="col-sm-2 control-label">Carrera</label>
                                                <div class="col-sm-10">
                                                    <select name="carrera" class="form-control" id="carrera" required="required">
                                                        <?php foreach ($carreras as $carrera) { ?>
                                                            <option value="<?php echo $carrera['id_carrera']; ?>" <?php echo $result['id_carrera'] == $carrera['id_carrera'] ? 'selected' : ''; ?>>
                                                                <?php echo $carrera['nombre_carrera']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="materia" class="col-sm-2 control-label">Materia</label>
                                                <div class="col-sm-10">
                                                    <select name="materia" class="form-control" id="materia">
                                                        <?php foreach ($materias as $materia) { ?>
                                                            <option value="<?php echo $materia['id_materia']; ?>" <?php echo $result['id_materia'] == $materia['id_materia'] ? 'selected' : ''; ?>>
                                                                <?php echo $materia['nombre']; ?>

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
                                                            <option value="<?php echo $curso['id_curso']; ?>"
                                                                <?php echo $result['id_curso'] == $curso['id_curso'] ? 'selected' : ''; ?>>
                                                                <?php echo $curso['nivel'] . ' - ' . $curso['paralelo']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
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
                    </div>
                </div>

            </div>
            <script src="../includes/verificar_cupos.js"></script>
            <script src="../assets/js/scriptParalelo.js"></script>

</body>

</html>