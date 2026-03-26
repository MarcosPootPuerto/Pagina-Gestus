<?php
// Esto sucede cuando se registran con google o manualmente
include 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- CASO A: REGISTRO CON GOOGLE ---
    if (isset($_POST['google_id']) && !empty($_POST['google_id'])) {
        $google_id = mysqli_real_escape_string($conexion, $_POST['google_id']);
        $nombre    = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $correo    = mysqli_real_escape_string($conexion, $_POST['correo']);

        // Revisar si ya existe
        $check = mysqli_query($conexion, "SELECT * FROM usuarios WHERE google_id = '$google_id' OR correo = '$correo'");

        if (mysqli_num_rows($check) > 0) {
            echo "<script>window.location.href='panel.html';</script>";
        } else {
            // PASSWORD se llena con un texto fijo porque la autenticación la lleva Google
            $sql = "INSERT INTO usuarios (nombre, correo, google_id, PASSWORD) VALUES ('$nombre', '$correo', '$google_id', 'GOOGLE_ACCOUNT')";

            if (mysqli_query($conexion, $sql)) {
                echo "<script>
                        alert('¡Bienvenido! Registro con Google exitoso.');
                        window.location.href='enrollment.html';
                      </script>";
            } else {
                echo "Error al guardar: " . mysqli_error($conexion);
            }
        }
    }

    // --- CASO B: REGISTRO MANUAL ---
    else if (isset($_POST['nombre'])) {
        $nombre   = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $correo   = mysqli_real_escape_string($conexion, $_POST['correo']);
        $password = $_POST['password'];

        if (!empty($nombre) && !empty($correo) && !empty($password)) {
            
            // IMPORTANTE: Verificar si el correo ya existe en registro manual
            $checkEmail = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo'");
            if (mysqli_num_rows($checkEmail) > 0) {
                echo "<script>alert('El correo ya está registrado.'); window.history.back();</script>";
            } else {
                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO usuarios (nombre, correo, PASSWORD) VALUES ('$nombre', '$correo', '$password_hash')";

                if (mysqli_query($conexion, $sql)) {
                    echo "<script>
                            alert('¡Estudiante registrado con éxito!');
                            window.location.href='enrollment.html';
                          </script>";
                } else {
                    echo "Error en el servidor. Inténtalo más tarde.";
                }
            }
        } else {
            echo "<script>alert('Por favor, rellena todos los campos'); window.history.back();</script>";
        }
    }
}

// Cerrar conexión para optimizar RDS
mysqli_close($conexion);
?>