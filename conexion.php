<?php
// Datos de tu instancia de AWS RDS
$host = "gestusdatabase.c90gcggym77t.us-east-2.rds.amazonaws.com"; 
$user = "admin";
$pass = "Gato4532-.";
$db   = "gestus_db";

// Crear la conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar si funcionó
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
echo "¡Conexión exitosa a AWS RDS!";
?>