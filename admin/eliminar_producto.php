<?php
include '../conexion_bd.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { die('ID inválido'); }

// 1) Obtén la ruta actual para borrar el archivo
$stmt = $conexion->prepare("SELECT imagen FROM producto WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($imagen);
if (!$stmt->fetch()) { die('Producto no encontrado'); }
$stmt->close();

// 2) Borra en BD
$stmt = $conexion->prepare("DELETE FROM producto WHERE id=?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
  // 3) Borra el archivo físico si existe
  $filePath = '../' . $imagen; // porque estamos en /admin/
  if ($imagen && file_exists($filePath)) { @unlink($filePath); }
  header('Location: listar.php?ok=1');
  exit;
}
die('No pude eliminar el producto.');