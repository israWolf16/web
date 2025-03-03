<?php
$host = "localhost";
$dbname = "refugio";
$user = "tu_usuario";
$password = "tu_contraseña";

// Crear conexión
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . pg_last_error());
}

// Obtener datos del formulario
$id = htmlspecialchars($_POST['id']);

// Eliminar datos de la base de datos
$query = "DELETE FROM dogs WHERE id='$id'";
$result = pg_query($conn, $query);

if ($result) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error: " . pg_last_error($conn);
}

pg_close($conn);
?>
