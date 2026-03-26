<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $pass = $_POST['new_pass'];

    // Suponiendo que el ID del usuario es 1 (luego lo harás dinámico con SESIONES)
    $id_usuario = 1;

    if (!empty($pass)) {
        // Si el usuario puso una nueva contraseña
        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email', password='$pass' WHERE id=$id_usuario";
    } else {
        // Si no quiso cambiar la contraseña
        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email' WHERE id=$id_usuario";
    }

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('Datos actualizados'); window.location='perfil.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
