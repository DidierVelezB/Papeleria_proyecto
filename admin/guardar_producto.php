<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conexion_bd.php';

// 1) Datos del form
$nombre        = trim($_POST['nombre'] ?? '');
$descripcion   = trim($_POST['descripcion'] ?? '');
$precio        = (float)($_POST['precio'] ?? 0);
$cantidad      = (int)($_POST['cantidad'] ?? 0);
$categoria     = trim($_POST['categoria'] ?? '');
$subcategoria  = trim($_POST['subcategoria'] ?? '');
$tipo          = trim($_POST['tipo'] ?? '');
$marca         = trim($_POST['marca'] ?? '');
$presentacion  = trim($_POST['presentacion'] ?? '');

// Validaciones básicas
if ($nombre === '' || $precio <= 0 || $categoria === '' || $subcategoria === '' || $tipo === '' || $marca === '' || $presentacion === '') {
  die('Faltan datos obligatorios.');
}
if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
  die('Error al recibir la imagen.');
}

// 2) Normalizar carpetas
function toFolderName($str) {
  return ucfirst(strtolower(trim($str)));
}
$catFolder = toFolderName($categoria);
$subcatFolder = toFolderName($subcategoria);
$tipoFolder   = toFolderName($tipo);

$baseDir = '../img';
$destDir = $baseDir . '/' . $catFolder . '/' . $subcatFolder;
if ($tipoFolder !== '') {
  $destDir .= '/' . $tipoFolder;
}

// 3) Crear carpetas si no existen
if (!is_dir($destDir)) {
  if (!mkdir($destDir, 0775, true)) {
    die('No pude crear la carpeta de destino: ' . htmlspecialchars($destDir));
  }
}

// 4) Validar tipo y tamaño de imagen
$permitidos = ['image/jpeg','image/png','image/webp','image/gif'];
$mime = mime_content_type($_FILES['imagen']['tmp_name']);
if (!in_array($mime, $permitidos, true)) {
  die('Formato de imagen no permitido.');
}
$maxBytes = 5 * 1024 * 1024;
if ($_FILES['imagen']['size'] > $maxBytes) {
  die('La imagen supera los 5 MB.');
}

// 5) Nombre seguro
$origName = basename($_FILES['imagen']['name']);
$seguro   = preg_replace('/[^a-zA-Z0-9\.\-_]/', '_', $origName);
$unico    = time() . '-' . $seguro; 
$destPath = $destDir . '/' . $unico;

// 6) Si no existe → mover el archivo
if (!file_exists($destPath)) {
  if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destPath)) {
    die('No pude mover la imagen al destino.');
  }
}

// 7) Ruta relativa para guardar en BD
$relPath = 'img/' . $catFolder . '/' . $subcatFolder . ($tipoFolder !== '' ? '/'.$tipoFolder : '') . '/' . $unico;

// 8) Insertar en BD
$cantidad = (int)($_POST['cantidad'] ?? 0);

$stmt = $conexion->prepare(
  "INSERT INTO producto (nombre, descripcion, precio, cantidad, categoria, subcategoria, tipo, marca, presentacion, imagen)
   VALUES (?,?,?,?,?,?,?,?,?,?)"
);
$stmt->bind_param("ssdissssss", $nombre, $descripcion, $precio, $cantidad, $categoria, $subcategoria, $tipo, $marca, $presentacion, $relPath);


if ($stmt->execute()) {
  header('Location: listar.php?ok=1');
  exit;
} else {
  die('Error al guardar en BD: ' . $conexion->error);
}