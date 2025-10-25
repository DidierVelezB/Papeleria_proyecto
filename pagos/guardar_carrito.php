<?php
session_start();
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!isset($data['carrito'])) {
    echo json_encode(['success' => false, 'msg' => 'Carrito vacío']);
    exit;
}

$_SESSION['carrito_json'] = json_encode($data['carrito']);
echo json_encode(['success' => true]);
?>
