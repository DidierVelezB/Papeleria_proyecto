<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conexion_bd.php';

$id            = (int)($_POST['id'] ?? 0);
$nombre        = trim($_POST['nombre'] ?? '');
$descripcion   = trim($_POST['descripcion'] ?? '');
$precio        = (float)($_POST['precio'] ?? 0);
$categoria     = trim($_POST['categoria'] ?? '');
$subcategoria  = trim($_POST['subcategoria'] ?? '');
$tipo          = trim($_POST['tipo'] ?? '');
$marca         = trim($_POST['marca'] ?? '');
$presentacion  = trim($_POST['presentacion'] ?? '');

if ($id <= 0 || $nombre === '' || $precio <= 0 || $categoria === '' || $subcategoria === '' || $tipo === '' || $marca === '' || $presentacion === '') { 
    die('Datos inválidos'); 
}

// 1) Obtener producto actual (para saber su imagen)
$stmt = $conexion->prepare("SELECT imagen FROM producto WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($imagenActual);
$stmt->fetch();
$stmt->close();

$nuevaRuta = $imagenActual;

// 2) Si suben imagen nueva, la procesamos
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
  function toFolderName($s){ return mb_convert_case(trim($s), MB_CASE_TITLE, 'UTF-8'); }
  $catFolder = toFolderName($categoria);
  $subcatFolder = toFolderName($subcategoria);
  $tipoFolder = toFolderName($tipo);

  $baseDir = '../img';
  $destDir = $baseDir . '/' . $catFolder . '/' . $subcatFolder . ($tipoFolder ? '/'.$tipoFolder : '');

  if (!is_dir($destDir)) { mkdir($destDir, 0775, true); }

  $permitidos = ['image/jpeg','image/png','image/webp','image/gif'];
  $mime = mime_content_type($_FILES['imagen']['tmp_name']);
  if (!in_array($mime, $permitidos, true)) { die('Formato no permitido'); }

  $seguro = preg_replace('/[^a-zA-Z0-9\.\-_]/', '_', basename($_FILES['imagen']['name']));
  $unico  = time().'_'.$seguro;
  $dest   = $destDir.'/'.$unico;

  if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $dest)) { die('No pude mover la imagen'); }

  // borrar la anterior si existe
  if ($imagenActual && file_exists('../'.$imagenActual)) { @unlink('../'.$imagenActual); }

  $nuevaRuta = 'img/' . $catFolder . '/' . $subcatFolder . ($tipoFolder ? '/'.$tipoFolder : '') . '/' . $unico;
}

// 3) Actualizar BD
$stmt = $conexion->prepare(
  "UPDATE producto SET nombre=?, descripcion=?, precio=?, categoria=?, subcategoria=?, tipo=?, marca=?, presentacion=?, imagen=? WHERE id=?"
);
$stmt->bind_param("ssdssssssi", $nombre, $descripcion, $precio, $categoria, $subcategoria, $tipo, $marca, $presentacion, $nuevaRuta, $id);
if ($stmt->execute()) {
  header('Location: listar.php?ok=1');
  exit;
}
die('No pude actualizar el producto: ' . $conexion->error);