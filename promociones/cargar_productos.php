<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/../conexion_bd.php';


$productos = [];
$sql = "SELECT id, nombre, descripcion, precio, cantidad, categoria, subcategoria, tipo, marca, presentacion, imagen 
        FROM producto";

$result = $conexion->query($sql);

while ($row = $result->fetch_assoc()) {
    $productos[] = [
        'id' => (int)$row['id'],
        'nombre' => $row['nombre'],
        'descripcion' => $row['descripcion'],
        'precio' => (float)$row['precio'],
        'cantidad' => (int)$row['cantidad'],
        'categoria' => $row['categoria'],
        'subcategoria' => $row['subcategoria'],
        'tipo' => $row['tipo'],
        'marca' => $row['marca'],
        'presentacion' => $row['presentacion'],
        'imagen' => $row['imagen']
        
    ];
}

header('Content-Type: application/json');
echo json_encode($productos);
