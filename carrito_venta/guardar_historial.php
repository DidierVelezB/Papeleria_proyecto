<?php
session_start();
header('Content-Type: application/json');

$conexion = new mysqli("localhost", "root", "", "genia");
if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id_cliente']) || !isset($data['productos']) || !is_array($data['productos'])) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
}

$id_cliente = $data['id_cliente'];
$productos = $data['productos'];
$fecha = date("Y-m-d H:i:s");

$stmt = $conexion->prepare("INSERT INTO historial (id_cliente, producto, talla, precio, fecha, imagen) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta']);
    exit;
}

foreach ($productos as $producto) {
    $nombre = isset($producto['nombre']) ? $producto['nombre'] : 'Producto desconocido';
    $talla = isset($producto['talla']) ? $producto['talla'] : 'Única';
    $precio = isset($producto['precio']) ? floatval($producto['precio']) : 0;
    $imagen = isset($producto['imagen']) ? $producto['imagen'] : '';

    $stmt->bind_param("issdss", $id_cliente, $nombre, $talla, $precio, $fecha, $imagen);
    $stmt->execute();
}

$stmt->close();
$conexion->close();

echo json_encode(['success' => true]);
?>
