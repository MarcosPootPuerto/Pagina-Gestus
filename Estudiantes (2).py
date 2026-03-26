<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "gestusdatabase.c90gcggym77t.us-east-2.rds.amazonaws.com";
$user = "admin";
$pass = "Gato4532-.";
$db   = "gestus_db";

// Mantengo el puerto 3307 que pusiste
$conexion = mysqli_connect($host, $user, $pass, $db, 3307);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- CASO A: REGISTRO CON GOOGLE (Si viene google_id) ---
    if (isset($_POST['google_id'])) {
        $google_id = mysqli_real_escape_string($conexion, $_POST['google_id']);
        $nombre    = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $correo    = mysqli_real_escape_string($conexion, $_POST['correo']);

        // Revisar si ya existe para no duplicar
        $check = mysqli_query($conexion, "SELECT * FROM estudiantes WHERE google_id = '$google_id' OR correo = '$correo'");

        if (mysqli_num_rows($check) > 0) {
            // Si ya existe, solo lo mandamos al panel
            echo "<script>window.location.href='panel.html';</script>";
        } else {
            // Si es nuevo, lo guardamos (PASSWORD se llena con un texto fijo porque es cuenta de Google)
            $sql = "INSERT INTO estudiantes (nombre, correo, google_id, PASSWORD) VALUES ('$nombre', '$correo', '$google_id', 'GOOGLE_ACCOUNT')";
            
            if (mysqli_query($conexion, $sql)) {
                echo "<script>
                        alert('¡Bienvenido! Registro con Google exitoso.');
                        window.location.href='panel.html';
                      </script>";
            } else {
                echo "Error al guardar Google: " . mysqli_error($conexion);
            }
        }
    } 

    // --- CASO B: REGISTRO MANUAL (El que ya tenías) ---
    else if (isset($_POST['nombre'])) {
        $nombre   = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $correo   = mysqli_real_escape_string($conexion, $_POST['correo']);
        $password = $_POST['password'];

        if (!empty($nombre) && !empty($correo) && !empty($password)) {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO estudiantes (nombre, correo, PASSWORD) VALUES ('$nombre', '$correo', '$password_hash')";

            if (mysqli_query($conexion, $sql)) {
                echo "<script>
                        alert('¡Estudiante registrado con éxito!');
                        window.location.href='panel.html';
                      </script>";
            } else {
                echo "Error en la base de datos: " . mysqli_error($conexion);
            }
        } else {
            echo "<script>alert('Por favor, rellena todos los campos'); window.history.back();</script>";
        }
    }
}
?>
