<?php
include 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Limpiamos el correo (trim quita espacios accidentales)
    $correo_form = mysqli_real_escape_string($conexion, trim($_POST['correo']));
    $password = $_POST['password'];

    // 2. Buscamos en la tabla (asegúrate que la columna sea 'correo')
    $sql = "SELECT * FROM usuarios WHERE correo = '$correo_form'";
    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado) {
        die("Error en la base de datos: " . mysqli_error($conexion));
    }

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // 3. Verificamos la contraseña
        if (password_verify($password, $usuario['password'])) {
            // Guardamos datos en la sesión para usarlos en el panel
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];

            // --- MODIFICACIÓN AQUÍ: Redirección directa a enrollment ---
            header("Location: enrollment.html");
            exit(); // Detenemos el script para que la redirección sea instantánea
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('El correo no está registrado'); window.history.back();</script>";
    }
}
