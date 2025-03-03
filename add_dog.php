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
$name = htmlspecialchars($_POST['name']);
$age = htmlspecialchars($_POST['age']);
$breed = htmlspecialchars($_POST['breed']);
$description = htmlspecialchars($_POST['description']);
$sex = htmlspecialchars($_POST['sex']);
$size = htmlspecialchars($_POST['size']);

// Procesar la imagen
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $image_url = $target_file;

    // Insertar datos en la base de datos
    $query = "INSERT INTO dogs (name, age, breed, description, sex, size, image_url) VALUES ('$name', $age, '$breed', '$description', '$sex', '$size', '$image_url')";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "Nuevo registro creado exitosamente";
    } else {
        echo "Error: " . pg_last_error($conn);
    }
} else {
    echo "Error al cargar la imagen.";
}

pg_close($conn);
?>
