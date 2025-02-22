<?php
$host = "localhost";
$dbname = "refugio";
$user = "programador"; // Usuario de PostgreSQL
$password = "12345"; // Nueva contraseña

// Habilitar informes de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Crear conexión
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . pg_last_error());
}

// Obtener datos del formulario de búsqueda
$breed = htmlspecialchars($_GET['breed']);
$age = htmlspecialchars($_GET['age']);
$sex = htmlspecialchars($_GET['sex']);
$size = htmlspecialchars($_GET['size']);

// Construir la consulta SQL con filtros
$query = "SELECT id, name, age, breed, description, sex, size, image_url FROM dogs WHERE 1=1";
if (!empty($breed)) {
    $query .= " AND breed ILIKE '%$breed%'";
}
if (!empty($age)) {
    $query .= " AND age = $age";
}
if (!empty($sex)) {
    $query .= " AND sex = '$sex'";
}
if (!empty($size)) {
    $query .= " AND size = '$size'";
}

$result = pg_query($conn, $query);

if (!$result) {
    echo "Error en la consulta: " . pg_last_error($conn);
    exit;
}

if (pg_num_rows($result) > 0) {
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
