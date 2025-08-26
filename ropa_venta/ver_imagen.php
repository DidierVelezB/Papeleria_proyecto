<?php
$conexion = new mysqli("localhost", "root", "", "genia");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT imagen FROM historial LIMIT 10"; // Trae solo 10 para no saturar
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo htmlspecialchars($fila['imagen']) . "<br>";
    }
} else {
    echo "No hay datos en la tabla.";
}

$conexion->close();
?>
