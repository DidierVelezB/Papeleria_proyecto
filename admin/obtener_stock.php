<?php
header('Content-Type: application/json');
include '../conexion_bd.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

$result = $conexion->query("SELECT cantidad FROM producto WHERE id = $id");
if ($row = $result->fetch_assoc()) {
    echo json_encode(['cantidad' => (int)$row['cantidad']]);
} else {
    echo json_encode(['cantidad' => 0]);
}
?>
