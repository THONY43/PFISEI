<?php
include("../includes/config.php");
$con = Database::getConnection();

// Funciones.php
function actualizarEstudiante($stid, $studentname, $roolid, $studentemail, $gender, $dob, $status)
{
    global $con;
    try {
        $sql = "UPDATE tbl_profesores SET 
                StudentName = :studentname,
                RollId = :roolid,
                StudentEmail = :studentemail,
                Gender = :gender,
                DOB = :dob,
                Status = :status 
                WHERE StudentId = :stid";

        $query = $con->prepare($sql);
        $query->execute([
            ':studentname' => $studentname,
            ':roolid' => $roolid,
            ':studentemail' => $studentemail,
            ':gender' => $gender,
            ':dob' => $dob,
            ':status' => $status,
            ':stid' => $stid
        ]);

        return "Información de Estudiante Actualizada Correctamente";
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}



// Funciones.php
function verificarRol($rolRequerido)
{

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $rolRequerido) {
        header('Location: ../index.php');
        exit();
    }
}

function buscarUsuario()
{
    global $con;
    $sql = "SELECT tbl_usuarios.nombre, tbl_usuarios.apellido, tbl_usuarios.id_usuario,
                   tbl_usuarios.correo, tbl_usuarios.tipo_usuario, tbl_usuarios.created_at,
                   tbl_estudiantes.id_estudiante, tbl_estudiantes.cedula AS cedula_estudiante,
                   tbl_profesores.id_profesor, tbl_profesores.cedula AS cedula_profesor
            FROM tbl_usuarios
            LEFT JOIN tbl_estudiantes ON tbl_usuarios.id_usuario = tbl_estudiantes.id_estudiante
            LEFT JOIN tbl_profesores ON tbl_usuarios.id_usuario = tbl_profesores.id_profesor";

    $query = $con->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    return $results ?: [];
}

function buscarUsuario1($typeUser)
{
    global $con;

    if (isset($typeUser) && $typeUser === "docente") {
        $sql = "SELECT tbl_usuarios.nombre, tbl_usuarios.apellido, tbl_usuarios.id_usuario,
                       tbl_usuarios.correo, tbl_usuarios.tipo_usuario, tbl_usuarios.created_at,
                       tbl_profesores.cedula, tbl_profesores.id_profesor
                FROM tbl_usuarios
                JOIN tbl_profesores ON tbl_usuarios.id_usuario = tbl_profesores.id_profesor";

        $query = $con->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results ?: [];
    } else if (isset($typeUser) && $typeUser === "estudiante") {
        $sql = "SELECT tbl_usuarios.nombre, tbl_usuarios.apellido, tbl_usuarios.id_usuario,
                       tbl_usuarios.correo, tbl_usuarios.tipo_usuario, tbl_usuarios.created_at,
                       tbl_estudiantes.cedula, tbl_estudiantes.id_estudiante
                FROM tbl_usuarios
                JOIN tbl_estudiantes ON tbl_usuarios.id_usuario = tbl_estudiantes.id_estudiante";

        $query = $con->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results ?: [];
    }


    return [];
}

function obtenerEstudiantePorId($stid, $type)
{
    global $con; 
    try {
        if (strtolower($type) === "estudiante") { 
            $sql = "SELECT e.id_estudiante, e.cedula, e.direccion, e.telefono, 
                    i.id_usuario, i.id_curso, i.fecha_inscripcion, 
                    u.id_usuario, u.nombre, u.apellido, u.correo, 
                    c.id_curso, c.nivel, c.paralelo, c.id_carrera, 
                    ca.id_carrera, ca.nombre_carrera 
                    FROM tbl_estudiantes e
                    left JOIN tbl_usuarios u ON u.id_usuario = e.id_estudiante
                    left JOIN tbl_inscripciones i ON i.id_usuario = e.id_estudiante
                    left JOIN tbl_cursos c ON c.id_curso = i.id_curso
                    left JOIN tbl_carreras ca ON ca.id_carrera = c.id_carrera
                    WHERE e.id_estudiante = :stid";

            $query = $con->prepare($sql);
            $query->bindParam(':stid', $stid, PDO::PARAM_STR);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_OBJ);
        } else if (strtolower($type) === "profesor") {
            $sql = "SELECT 
                    p.cedula,  p.telefono, p.id_profesor, 
                    u.id_usuario, u.nombre, u.apellido, u.correo, 
                    rm.id_curso, rm.id_materia, rm.id_profesor, 
                    c.id_curso, c.nivel, c.paralelo, c.id_carrera, 
                    ca.id_carrera, ca.nombre_carrera, 
                    m.id_materia, m.nombre
                FROM tbl_profesores p
                 JOIN tbl_usuarios u ON p.id_profesor = u.id_usuario
                JOIN tbl_relacionmaterias rm ON p.id_profesor = rm.id_profesor
                 JOIN tbl_cursos c ON rm.id_curso = c.id_curso
                JOIN tbl_carreras ca ON c.id_carrera = ca.id_carrera
                JOIN tbl_materias m ON rm.id_materia = m.id_materia
                WHERE tbl_profesores.id_profesor = :stid";

            $query = $con->prepare($sql);
            $query->bindParam(':stid', $stid, PDO::PARAM_STR);
            $query->execute();

            $materias = $con->query("SELECT * FROM tbl_materias")->fetchAll(PDO::FETCH_ASSOC);
            $carreras = $con->query("SELECT * FROM tbl_carreras")->fetchAll(PDO::FETCH_ASSOC);
            $cursos = $con->query("SELECT * FROM tbl_cursos")->fetchAll(PDO::FETCH_ASSOC);

            return [
                'query_result' => $query->fetchAll(PDO::FETCH_OBJ),
                'materias' => $materias,
                'carreras' => $carreras,
                'cursos' => $cursos
            ];
        }
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}


function obtenerUsuarioPorId($stid, $type)
{
    global $con;

    try {
        if (strtolower($type) === "estudiante") {
            $sql = "SELECT e.id_estudiante, e.cedula, u.id_usuario, u.nombre, u.apellido
                    FROM tbl_estudiantes e
                    JOIN tbl_usuarios u ON u.id_usuario = e.id_estudiante
                    WHERE e.id_estudiante = :stid";

            $carreras = $con->query("SELECT * FROM tbl_carreras")->fetchAll(PDO::FETCH_ASSOC);
            $cursos = $con->query("SELECT * FROM tbl_cursos")->fetchAll(PDO::FETCH_ASSOC);

            $query = $con->prepare($sql);
            $query->bindParam(':stid', $stid, PDO::PARAM_STR);
            $query->execute();
            return [
                'query_result' => $query->fetchAll(PDO::FETCH_ASSOC),
                'carreras' => $carreras,
                'cursos' => $cursos
            ];
        } else if (strtolower($type) === "docente") {
            $sql = "SELECT 
                        p.cedula, p.telefono, p.id_profesor, 
                        u.id_usuario, u.nombre, u.apellido, u.correo, u.created_at,
                        rm.id_curso, rm.id_materia, rm.id_profesor, 
                        c.id_curso, c.nivel, c.paralelo, c.id_carrera, 
                        ca.id_carrera, ca.nombre_carrera, 
                        m.id_materia, m.nombre AS nombre_materia
                    FROM tbl_profesores p
                    LEFT JOIN tbl_usuarios u ON p.id_profesor = u.id_usuario
                    LEFT JOIN tbl_relacionmaterias rm ON p.id_profesor = rm.id_profesor
                    LEFT JOIN tbl_cursos c ON rm.id_curso = c.id_curso
                    LEFT JOIN tbl_carreras ca ON c.id_carrera = ca.id_carrera
                    LEFT JOIN tbl_materias m ON rm.id_materia = m.id_materia
                    WHERE p.id_profesor = :stid";

            $query = $con->prepare($sql);
            $query->bindParam(':stid', $stid, PDO::PARAM_STR);
            $query->execute();

            $materias = $con->query("SELECT * FROM tbl_materias")->fetchAll(PDO::FETCH_ASSOC);
            $carreras2 = $con->query("SELECT * FROM tbl_carreras")->fetchAll(PDO::FETCH_ASSOC);
            $cursos2 = $con->query("SELECT * FROM tbl_cursos")->fetchAll(PDO::FETCH_ASSOC);

            return [
                'query_result2' => $query->fetchAll(PDO::FETCH_ASSOC),
                'materias2' => $materias,
                'carreras2' => $carreras2,
                'cursos2' => $cursos2
            ];
        }
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}


function eliminarUsuario($user_id)
{

    $con = Database::getConnection();

    try {

        $con->beginTransaction();


        $sqlEstudiante = "DELETE FROM estudiantes WHERE id_usuario = :id_usuario";
        $sqlDocente = "DELETE FROM docentes WHERE id_usuario = :id_usuario";

        $stmtEstudiante = $con->prepare($sqlEstudiante);
        $stmtDocente = $con->prepare($sqlDocente);

        $stmtEstudiante->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);
        $stmtDocente->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);

        $stmtEstudiante->execute();
        $stmtDocente->execute();

        $sqlUsuario = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmtUsuario = $con->prepare($sqlUsuario);
        $stmtUsuario->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);
        $stmtUsuario->execute();


        $con->commit();

        return true;
    } catch (Exception $e) {
        $con->rollBack();
        return false;
    }
}

function insertarUsuario($tipo, $nombres, $apellidos, $cedula, $email, $telefono, $direccion)
{
    global $con;

    $ultimosCuatroDigitos = substr($cedula, -4);
    $facultad = 22;
    $id_usuario = $facultad.$ultimosCuatroDigitos;

    try {
        $con->beginTransaction();


        $sql1 = "INSERT INTO tbl_usuarios(id_usuario, correo, nombre, apellido, tipo_usuario, created_at)
                 VALUES (:id_usuario, :email, :nombres, :apellidos, :tipo, NOW())";
        $stmt1 = $con->prepare($sql1);
        $stmt1->bindParam(':id_usuario', $id_usuario);
        $stmt1->bindParam(':email', $email);
        $stmt1->bindParam(':nombres', $nombres);
        $stmt1->bindParam(':apellidos', $apellidos);
        $stmt1->bindParam(':tipo', $tipo);
        if (!$stmt1->execute()) {
           
            throw new Exception('Error al insertar en la tabla de usuarios: ');
        }

        if ($tipo == 'profesor') {
            $sql = "INSERT INTO tbl_profesores (id_profesor, cedula, telefono) 
                    VALUES (:id_usuario, :cedula, :telefono)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':telefono', $telefono);
            if (!$stmt->execute()) {
               
                throw new Exception('Error al insertar en la tabla de profesores: ');
            }
        } else {
            $sql = "INSERT INTO tbl_estudiantes (id_estudiante, cedula, direccion, telefono) 
                    VALUES (:id_usuario, :cedula, :direccion, :telefono)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            if (!$stmt->execute()) {
                
                throw new Exception('Error al insertar en la tabla de estudiantes: ');
            }
        }

        $con->commit();
        return true;

    } catch (Exception $e) {
        $con->rollBack();
        echo 'Error: ' . $e->getMessage(); 
        return false;
    }
}


//INSCRIBIR DOCENTE 

function inscribirDocente($stid,$carrera,$idmateria,$idcurso){
global $con;
$facultad=22;
$id_profesor = substr($stid, -2);
$id_curso = substr($idcurso, -2);
$id_materia = substr($idmateria, -2);
$id_cursoMateria=$facultad.$id_profesor.$id_curso.$id_materia;
try {
    $sql = "INSERT INTO tbl_relacionmaterias(id_curso_materia,id_curso,id_materia,id_profesor)
    Values ($id_cursoMateria,$idcurso,$idmateria,$stid)";
     $stmt = $con->prepare($sql);
     
     if (!$stmt->execute()) {
        return "Inscripcion de Docente Agregada Correctamente";
    }
} catch (PDOException $e) {
    return "Error: " . $e->getMessage();
}
}



function inscribirEstudiante($stid,$carrera,$nivel,$paralelo){
global $con;
$facultad=22;
try {

    
   $sql="INSERT INTO tbl_inscripciones";
    return "Inscripcion de Docente Agregada Correctamente";
} catch (PDOException $e) {
    return "Error: " . $e->getMessage();
}
}


function buscarCarreras (){
    global $con;
    try{
        $sql="SELECT *  FROM tbl_carreras";
        $query = $con->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $e) {

    }
}

