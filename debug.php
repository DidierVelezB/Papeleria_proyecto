<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'conexion_bd.php';

$sql = "SELECT * FROM producto";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Debug Productos</title>
</head>
<body>
<h1>Debug productos</h1>

<?php
if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }
} else {
    echo "⚠️ No hay productos en la tabla.";
}
?>

</body>
</html>
