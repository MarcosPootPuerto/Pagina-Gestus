<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Perfil - Gestus</title>
    <style>
        :root {
            --primary-orange: #FF5722;
            --deep-blue: #2C5697;
            --bg-neutral: #F4F7F6;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg-neutral);
            margin: 0;
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .crud-container {
            background: var(--white);
            width: 100%;
            max-width: 800px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .close-x {
            position: absolute;
            top: 15px;
            right: 20px;
            text-decoration: none;
            color: #ccc;
            font-size: 1.8rem;
            font-weight: 300;
            line-height: 1;
            transition: color 0.2s;
        }

        .close-x:hover {
            color: var(--primary-orange);
        }

        h2 {
            color: var(--deep-blue);
            border-bottom: 2px solid var(--bg-neutral);
            padding-bottom: 10px;
        }

        .form-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .input-box label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #fff;
            box-sizing: border-box;
        }

        .btn-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-update {
            background: var(--primary-orange);
            color: white;
        }

        .btn-delete {
            background: #d32f2f;
            color: white;
        }

        .btn-back {
            background: #666;
            color: white;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            line-height: 1.5;
        }

        .btn-logout {
            background: transparent;
            color: #d32f2f;
            border: 1px solid #d32f2f;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: #d32f2f;
            color: white;
        }
    </style>
</head>

<body>

    <div class="crud-container">
        <a href="enrollment.html" class="close-x" title="Cerrar">&times;</a>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-right: 30px;">
            <a href="perfil.html" class="btn btn-back">← Volver al Perfil</a>
            <a href="index.html" class="btn btn-logout">Cerrar Sesión</a>
        </div>

        <h2>Modificar Datos de Usuario</h2>

        <form action="actualizar.php" method="POST">
            <div class="form-section">
                <div class="input-box">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre" placeholder="Tu nombre" required>
                </div>
                <div class="input-box">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="input-box">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="new_pass" placeholder="Dejar en blanco para no cambiar">
                </div>
                <div class="input-box">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="confirm_pass" placeholder="Repita la nueva contraseña">
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-update">Guardar Cambios</button>
                <button type="button" class="btn btn-delete" onclick="confirmDelete()">Eliminar Cuenta</button>
            </div>
        </form>

        <hr style="margin: 40px 0; border: 0; border-top: 1px solid #eee;">

        <h3>Estado de Seguridad</h3>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
            <p style="margin: 5px 0; font-size: 0.9rem;"><strong>Estado de cuenta:</strong> <span style="color: green;">✓ Verificada</span></p>
            <p style="margin: 5px 0; font-size: 0.9rem;"><strong>Última sincronización de señas:</strong> 24/03/2026</p>
        </div>
    </div>

    <script>
        // Función para confirmar eliminación (puedes redirigir a un eliminar.php)
        function confirmDelete() {
            if (confirm("¿Estás seguro de que deseas eliminar tu perfil de Gestus? Esta acción borrará permanentemente tu progreso.")) {
                window.location.href = "eliminar_cuenta.php";
            }
        }
    </script>

</body>

</html>