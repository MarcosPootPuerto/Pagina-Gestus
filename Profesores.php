<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistema_gestus";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- LÓGICA PARA REGISTRO MANUAL ADAPTADO ---
    if (isset($_POST['nombre']) && !isset($_POST['google_id'])) {
        $nombre   = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
        $pais     = mysqli_real_escape_string($conexion, $_POST['pais']);
        $materia  = mysqli_real_escape_string($conexion, $_POST['materia']);
        $idioma   = mysqli_real_escape_string($conexion, $_POST['idioma']); // Recibe "ESPAÑOL"
        $nivel    = mysqli_real_escape_string($conexion, $_POST['nivel']);  // Recibe "SECUNDARIA"
        
        // Asumo que el correo y password vienen de otros campos o los agregas aquí
        $correo   = isset($_POST['correo']) ? mysqli_real_escape_string($conexion, $_POST['correo']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (!empty($nombre) && !empty($apellido)) {
            $password_hash = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : '';
            
            // Insertar todos los campos nuevos
            $sql = "INSERT INTO estudiantes (nombre, apellido, pais, materia, idioma, nivel, correo, PASSWORD) 
                    VALUES ('$nombre', '$apellido', '$pais', '$materia', '$idioma', '$nivel', '$correo', '$password_hash')";
            
            if (mysqli_query($conexion, $sql)) {
                echo "<script>alert('¡Registro exitoso!'); window.location.href='index.html';</script>";
            } else {
                echo "Error en el registro: " . mysqli_error($conexion);
            }
        }
    }

    // --- LÓGICA PARA GOOGLE (Se mantiene igual) ---
    if (isset($_POST['google_id'])) {
        $google_id = mysqli_real_escape_string($conexion, $_POST['google_id']);
        $nombre    = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $correo    = mysqli_real_escape_string($conexion, $_POST['correo']);

        $checkUser = mysqli_query($conexion, "SELECT * FROM estudiantes WHERE google_id = '$google_id' OR correo = '$correo'");

        if (mysqli_num_rows($checkUser) > 0) {
            echo "Login con Google exitoso";
        } else {
            $sql = "INSERT INTO estudiantes (nombre, correo, google_id) VALUES ('$nombre', '$correo', '$google_id')";
            mysqli_query($conexion, $sql);
            echo "Registro con Google exitoso";
        }
    }
}
?>