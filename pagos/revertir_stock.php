<?php
require_once __DIR__ . '/../conexion_bd.php';
header('Content-Type: application/json');

// Leer datos JSON del carrito
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['productos']) || !is_array($data['productos'])) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

$productos = $data['productos'];

foreach ($productos as $p) {
    $id = intval($p['id']);
    $cantidad = intval($p['cantidad']);

    if ($id > 0 && $cantidad > 0) {
        // 🔹 Sumar cantidad nuevamente
        $stmt = $conexion->prepare("UPDATE producto SET cantidad = cantidad + ? WHERE id = ?");
        $stmt->bind_param("ii", $cantidad, $id);
        $stmt->execute();

        // 🔹 Reactivar producto si estaba inactivo y vuelve a tener stock
        $conexion->query("UPDATE producto SET activo = 1 WHERE id = $id AND cantidad > 0");
    }
}

echo json_encode(['success' => true]);
