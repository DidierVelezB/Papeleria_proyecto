<?php
session_start();
date_default_timezone_set('America/Bogota');

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

// Validar
if (!isset($data['carrito']) || !is_array($data['carrito'])) {
    echo json_encode(['success' => false, 'msg' => 'Carrito vacío']);
    exit;
}

// Validar sesión
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'msg' => 'Usuario no logueado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Conectar a BD
$conexion = new mysqli("localhost", "root", "", "genia");
if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'msg' => 'Error DB']);
    exit;
}

foreach ($data['carrito'] as $p) {

    $nombre = $conexion->real_escape_string($p['nombre']);
    $precio = $p['precio'];
    $imagen = $conexion->real_escape_string($p['imagen']);

    // tipo + presentación (si existen)
    $tipo = isset($p['tipo']) ? $conexion->real_escape_string($p['tipo']) : "";
    $presentacion = isset($p['presentacion']) ? $conexion->real_escape_string($p['presentacion']) : "";

    // Crear texto final para campo "producto"
    $productoFinal = $nombre;
    if ($tipo || $presentacion) {
        $productoFinal .= " (" . trim("$presentacion, $tipo", ", ") . ")";
    }

    $fecha = date("Y-m-d H:i:s");

    // Insertar
    $stmt = $conexion->prepare("
        INSERT INTO historial (id_cliente, producto, fecha, precio, imagen)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("issis", $usuario_id, $productoFinal, $fecha, $precio, $imagen);
    $stmt->execute();
    $stmt->close();
}

$conexion->close();

// Guardar carrito en sesión como JSON
$_SESSION['carrito_json'] = json_encode($data['carrito']);

echo json_encode(['success' => true, 'msg' => 'Historial actualizado']);
?>
