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

$sql = "SELECT id, name, age, breed, description, sex, size, image_url FROM dogs";
$result = pg_query($conn, $sql);

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        echo "<div class='dog'>";
        echo "<h3>" . $row["name"] . "</h3>";
        echo "<p>ID: " . $row["id"] . "</p>";
        echo "<p>Edad: " . $row["age"] . "</p>";
        echo "<p>Raza: " . $row["breed"] . "</p>";
        echo "<p>Sexo: " . $row["sex"] . "</p>";
        echo "<p>Tamaño: " . $row["size"] . "</p>";
        echo "<p>Descripción: " . $row["description"] . "</p>";
        echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "' style='width:200px; height:auto;'>";
        echo "</div>";
    }
} else {
    echo "0 resultados.";
}

pg_close($conn);
?>
