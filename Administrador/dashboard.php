<?php
session_start();
include("../navegacion/topbar-admin.php");
include("../includes/modalserver.php");
include("../Funciones/Funciones.php");
$error = "";
verificarRol('administrador');

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

    <section class="section">

        <div class="containerfluit">
            <div class="columna1">
                <a class="dashboard-stat bg-general" href="manage-students.php">
                    <?php
                    $sql = "SELECT id_estudiante from tbl_estudiantes ";
                    $query = $con->prepare($sql);
                    $query->execute();
                    $totalstudents = $query->rowCount();
                    ?>
                    <span class="number counter"><?php echo htmlentities($totalstudents); ?></span>
                    <span class="name">Estudiantes Registrados</span>
                </a>
            </div>

            <div class="columna2">
                <a class="dashboard-stat bg-general" href="manage-subjects.php">
                    <?php
                    $sql1 = "SELECT id_materia from tbl_materias ";
                    $query1 = $con->prepare($sql1);
                    $query1->execute();
                    $totalsubjects = $query1->rowCount();
                    ?>
                    <span class="number counter"><?php echo htmlentities($totalsubjects); ?></span>
                    <span class="name">Listado de Materias</span>
                </a>
            </div>

            <div class="columna3">
                <a class="dashboard-stat bg-general" href="manage-classes.php">
                    <?php
                    $sql2 = "SELECT id_curso from tbl_cursos ";
                    $query2 = $con->prepare($sql2);
                    $query2->execute();
                    $totalclasses = $query2->rowCount();
                    ?>
                    <span class="number counter"><?php echo htmlentities($totalclasses); ?></span>
                    <span class="name">Total de Carreras</span>
                </a>

            </div>
        </div>



        <div class="container-fluid">
            <div class="col-md-12">
                <div class="mensajeBienvenida">
                    <h4>
                        <?php
                        echo "Bienvenido, $userName, ingreso como Administrador";
                        ?>
                    </h4>
                </div>

                <div class="panel">

                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5>Ver Información de los usuarios</h5>
                        </div>
                    </div>
                    <?php
                    $msg = "";
                    if ($msg) { ?>
                        <div class="alert alert-success left-icon-alert" role="alert">
                            <strong>Proceso Correcto! </strong><?php echo htmlentities($msg); ?>
                        </div>
                    <?php } else if ($error) { ?>
                        <div class="alert alert-danger left-icon-alert" role="alert">
                            <strong>Algo salió mal! </strong> <?php echo htmlentities($error); ?>
                        </div>
                    <?php } ?>
                    <div class="panel-body p-20">
                        <table id="exampl" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Id Usuario</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>C.I</th>
                                    <th>Correo</th>
                                    <th>Tipo de Usuario</th>
                                    <th>Fecha de Creación</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                 $results=buscarUsuario();
                                $cnt = 1;
                               
                                    foreach ($results as $result) { ?>
                                        <tr>
                                            <td><?php echo htmlentities($result->id_usuario); ?></td>
                                            <td><?php echo htmlentities($result->nombre); ?></td>
                                            <td><?php echo htmlentities($result->apellido); ?></td>
                                            <td>
                                            
                                            <?php if (isset($result->cedula_estudiante)) { ?>
                                                <p><?php echo htmlentities($result->cedula_estudiante); ?></p>
                                            <?php } ?>
                                            <?php if (isset($result->cedula_profesor)) { ?>
                                                <p><?php echo htmlentities($result->cedula_profesor); ?></p>
                                            <?php } ?>
                                        </td>
                                            <td><?php echo htmlentities($result->correo); ?></td>
                                            <td><?php echo htmlentities($result->tipo_usuario); ?></td>
                                            <td><?php echo htmlentities($result->created_at); ?></td>
                                            <td>
                                            <a href="setUser.php?stid=<?php echo urlencode($result->id_usuario); ?>&type=<?php echo urlencode( $result->tipo_usuario); ?>"
                                                    class="btn btn-info">
                                                    <i class="fa fa-edit" title="Edit Record"></i>
                                                </a>
                                            </td>

                                        </tr>
                                <?php
                                        $cnt++;
                                    }
                                
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        </div>

    </section>
    <script src="../assets/js/scriptTable.js">

    </script>

</body>


</html>