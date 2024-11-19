<?php
session_start();
include("../navegacion/topbar-admin.php");
include("../Funciones/Funciones.php");
include("../includes/modalserver.php");
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

        <div class="container-fluid">
            <div class="col-md-12">
                <div class="mensajeBienvenida">
                    <h4>
                        Lista de Usuarios
                    </h4>
                </div>

                <div class="panel">

                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5>Ver Información de los usuarios</h5>
                        </div>
                    </div>

                    <div class="panel-body p-20">
                        <table id="exampl" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                $results = buscarUsuario();
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
                                            <a href="setUser.php?stid=<?php echo urlencode($result->id_usuario); ?>&type=<?php echo urlencode($result->tipo_usuario); ?>"
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