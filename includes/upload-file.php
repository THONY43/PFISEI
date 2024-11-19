<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if ($_SESSION['estudi'] == '') {
    header("Location: ./docente-login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['task_id'];

    // Verificar si se ha seleccionado un archivo
    if ($_FILES['archivo']['name']) {
        $file_name = $_FILES['archivo']['name'];
        $file_size = $_FILES['archivo']['size'];
        $file_tmp = $_FILES['archivo']['tmp_name'];
        $file_type = $_FILES['archivo']['type'];
        $file_ext = strtolower(end(explode('.', $_FILES['archivo']['name'])));

        // Definir extensiones de archivo permitidas
        $extensions = array("doc", "docx", "pdf", "txt");

        if (in_array($file_ext, $extensions) === false) {
            $error = "Extensión de archivo no permitida, elige un archivo válido.";
        }

        // Tamaño máximo del archivo (en este ejemplo, se permite hasta 5 MB)
        $max_file_size = 5 * 1024 * 1024; // 5 MB

        if ($file_size > $max_file_size) {
            $error = "El archivo es demasiado grande. Tamaño máximo permitido: 5 MB.";
        }

        if (empty($error)) {
            // Mover el archivo subido a la ubicación deseada
            move_uploaded_file($file_tmp, "../uploads/" . $file_name);
        
            // Obtener los valores necesarios para los campos de tbltasks_entrega
            $task_id = $task_id; // ID de la tarea obtenido del formulario
            $studentid = $_SESSION['studentid']; // ID del estudiante desde la sesión
            $id_class = $_SESSION['classid']; // ID de la clase desde la sesión
            $fecha = date('Y-m-d H:i:s'); // Fecha actual
            $nombre_archivo = $file_name; // Nombre del archivo adjunto de una tabla        
            // Obtener los valores de la tabla tbltasks
            $sql = "SELECT admin_id, id_subject FROM tbltasks WHERE task_id = :task_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':task_id', $task_id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
        
            if ($result) {
                $profe = $result['admin_id'];
                $materia = $result['id_subject'];
            } 

            // Consulta SQL para insertar los datos en tbltasks_entrega
            $sql_entrega = "INSERT INTO tbltasks_entrega (task_id, StudentId, id_class, fecha_entrega, archivo_entrega, admin_id, subject_id, status) 
                            VALUES (:task_id, :studentid, :id_class, :fecha, :nombre_archivo, :profe, :materia, :statu)";
            $query_entrega = $dbh->prepare($sql_entrega);
            $query_entrega->bindParam(':task_id', $task_id, PDO::PARAM_INT);
            $query_entrega->bindParam(':studentid', $studentid, PDO::PARAM_INT);
            $query_entrega->bindParam(':id_class', $id_class, PDO::PARAM_INT);
            $query_entrega->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $query_entrega->bindParam(':nombre_archivo', $nombre_archivo, PDO::PARAM_STR);
            $query_entrega->bindParam(':profe', $profe, PDO::PARAM_STR);
            $query_entrega->bindParam(':materia', $materia, PDO::PARAM_STR);
            $query_entrega->bindParam(':statu', 0, PDO::PARAM_STR);
            $query_entrega->execute();

            // Actualizar el registro de la tarea en la base de datos con el nombre del archivo adjunto y cambiar el estado a "enviado"
            $sql_update = "UPDATE tbltasks SET archivo_adjun = :archivo_adjun, status = 0 WHERE task_id = :task_id";
            $query_update = $dbh->prepare($sql_update);
            $query_update->bindParam(':archivo_adjun', $file_name, PDO::PARAM_STR);
            $query_update->bindParam(':task_id', $task_id, PDO::PARAM_INT);
            $query_update->execute();

            $msg = "Archivo subido exitosamente.";
        } else {
            $error = "Error al subir el archivo: " . $error;
        }
    } else {
        $error = "Por favor, selecciona un archivo para subir.";
    }
}

// Redirigir de vuelta a la página anterior
header("Location: ".$_SERVER['HTTP_REFERER']);
exit;
?>
