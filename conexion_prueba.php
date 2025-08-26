<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conexion_bd.php';

$sql = "SELECT * FROM producto";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - Nombre: " . $row['nombre'] . " - Precio: " . $row['precio'] . "<br>";
    }
} else {
    echo "⚠️ No hay productos en la tabla.";
}
