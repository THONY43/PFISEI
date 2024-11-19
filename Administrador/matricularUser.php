<?php
session_start();
include("../navegacion/topbar-admin.php");
include("../Funciones/Funciones.php");
include("../includes/modalserver.php");
verificarRol('administrador');


$userEmail = $_SESSION['user_email'];
$userName = $_SESSION['user_name'];

$error = "";

$lastInsertId = true;
if ($lastInsertId) {
    $msg = "Información del usuario agregada correctamente";
} else {
    $error = "Algo salió mal. Inténtalo de nuevo";
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


    <section class="section">

        <div class="container-fluid">
            <div class="panel">

                <div class="col-md-12">
                    <div class="mensajeBienvenida">
                        <h4>
                            Buscar Usuario
                        </h4>
                    </div>
                    <div class="select-container" style="margin-left:15px;">
                        <form method="GET" action="">
                            <label for="tipo_usuario">Seleccionar Tipo de Usuario:</label>
                            <select name="tipo_usuario" id="tipo_usuario">
                                <option value="docente" <?php if (isset($_GET['tipo_usuario']) && $_GET['tipo_usuario'] == 'docente') echo 'selected'; ?>>Docente</option>
                                <option value="estudiante" <?php if (isset($_GET['tipo_usuario']) && $_GET['tipo_usuario'] == 'estudiante') echo 'selected'; ?>>Estudiante</option>
                            </select>
                            <button class="btn btn-primary" type="submit" style="margin-top: 10px;">Filtrar</button>

                        </form>

                    </div>

                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5>Busque al <?php $tipo_usuario = isset($_GET['tipo_usuario']) ? $_GET['tipo_usuario'] : null;
                            
                            
                            echo $tipo_usuario;
                            ?></h5>
                        </div>
                    </div>

                    <div class="panel-body p-20">
                        <table id="exampl" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id Usuario</th>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                    <th>Cedula</th>
                                    <th>Correo</th>
                                 
                                    <th>Fecha de Creación</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tipo_usuario = isset($_GET['tipo_usuario']) ? $_GET['tipo_usuario'] : null;
                                $results = buscarUsuario1($tipo_usuario);
                                $cnt = 1;
                                foreach ($results as $result) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($result->id_usuario); ?></td>
                                        <td><?php echo htmlentities($result->apellido); ?></td>
                                        <td><?php echo htmlentities($result->nombre); ?></td>
                                        
                                        <td><?php echo htmlentities($result->cedula); ?></td>  
                                        <td><?php echo htmlentities($result->correo); ?></td>
                                      
                                        <td><?php echo htmlentities($result->created_at); ?></td>
                                        <td>
                                            <a href="enrollUser.php?stid=<?php echo urlencode($result->id_usuario);?>&type=<?php echo $tipo_usuario?>"
                                                class="btn btn-primary">
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


    </section>
    <script src="../assets/js/scriptTable.js">

    </script>


</body>

</html>