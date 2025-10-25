<?php
require_once __DIR__ . '/../conexion_bd.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['productos']) || !is_array($data['productos'])) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

$productos = $data['productos'];

foreach ($productos as $p) {
    $id = intval($p['id']);
    $cantidadComprada = intval($p['cantidad']);

    // Restar stock
    $stmt = $conexion->prepare("UPDATE producto SET cantidad = GREATEST(cantidad - ?, 0) WHERE id = ?");
    $stmt->bind_param("ii", $cantidadComprada, $id);
    $stmt->execute();

    // Si llega a 0, marcar como inactivo (opcional)
    $conexion->query("UPDATE producto SET activo = 0 WHERE id = $id AND cantidad = 0");
}

echo json_encode(['success' => true]);
