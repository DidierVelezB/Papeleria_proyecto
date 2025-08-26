<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DEBUG - Diagnóstico Completo</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .debug-section { background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .product-box { border: 2px solid #333; padding: 10px; margin: 10px; display: inline-block; }
    img { max-width: 150px; max-height: 150px; }
  </style>
</head>
<body>

<h1>🔍 DIAGNÓSTICO COMPLETO - ¿Por qué no se ven las imágenes?</h1>

<div class="debug-section">
  <h2>1. Información del Servidor</h2>
  PHP Version: <?php echo phpversion(); ?><br>
  Sistema: <?php echo PHP_OS; ?><br>
  Directorio actual: <?php echo getcwd(); ?>
</div>

<div class="debug-section">
  <h2>2. Prueba de Ruta de Imagen MANUAL</h2>
  <?php
  // Prueba manual con una ruta conocida
  $ruta_prueba = '../img/Camisas/hombre/1755726290-sg-11134201-22110-r3icnaitwnjv5c.jpg';
  echo "Ruta de prueba: " . $ruta_prueba . "<br>";
  echo "¿Existe?: " . (file_exists($ruta_prueba) ? '<span class="success">SÍ</span>' : '<span class="error">NO</span>') . "<br>";
  
  if (file_exists($ruta_prueba)) {
      echo "Tamaño: " . filesize($ruta_prueba) . " bytes<br>";
      echo "Imagen: <br><img src='" . $ruta_prueba . "' alt='Prueba'>";
  } else {
      echo "<span class='error'>❌ EL PROBLEMA ES DE RUTAS O PERMISOS</span>";
  }
  ?>
</div>

<div class="debug-section">
  <h2>3. Productos desde Base de Datos</h2>
  <?php
  include '../conexion_bd.php';
  
  if ($conexion->connect_error) {
      die("Error de conexión: " . $conexion->connect_error);
  }
  
  $sql = "SELECT * FROM producto";
  $resultado = $conexion->query($sql);
  
  echo "Número de productos: " . $resultado->num_rows . "<br><br>";
  
  if ($resultado->num_rows > 0) {
      while ($row = $resultado->fetch_assoc()) {
          echo "<div class='product-box'>";
          echo "<h3>" . htmlspecialchars($row['nombre']) . "</h3>";
          
          // Procesamiento de ruta
          $imgPath = $row['imagen'];
          if (strpos($imgPath, '/') === 0) {
              $imgPath = ltrim($imgPath, '/');
          }
          $imgPath = '../' . $imgPath;
          
          echo "Ruta BD: " . $row['imagen'] . "<br>";
          echo "Ruta construida: " . $imgPath . "<br>";
          echo "¿Existe?: " . (file_exists($imgPath) ? '<span class="success">SÍ</span>' : '<span class="error">NO</span>') . "<br>";
          
          if (file_exists($imgPath)) {
              echo "<img src='" . $imgPath . "' alt='" . htmlspecialchars($row['nombre']) . "'>";
          } else {
              echo "<span class='error'>No se puede mostrar - archivo no encontrado</span>";
          }
          
          echo "</div>";
      }
  } else {
      echo "No hay productos en la base de datos";
  }
  
  $conexion->close();
  ?>
</div>

<div class="debug-section">
  <h2>4. Prueba de Permisos de Archivos</h2>
  <?php
  $test_file = '../img/Camisas/hombre/1755726290-sg-11134201-22110-r3icnaitwnjv5c.jpg';
  if (file_exists($test_file)) {
      echo "Permisos del archivo: " . substr(sprintf('%o', fileperms($test_file)), -4) . "<br>";
      echo "¿Es legible?: " . (is_readable($test_file) ? '<span class="success">SÍ</span>' : '<span class="error">NO</span>') . "<br>";
      
      // Intentar leer el archivo
      $content = @file_get_contents($test_file);
      echo "¿Se puede leer?: " . ($content !== false ? '<span class="success">SÍ</span>' : '<span class="error">NO - Error: ' . error_get_last()['message'] . '</span>');
  }
  ?>
</div>

<div class="debug-section">
  <h2>5. Prueba de URL Directa</h2>
  <?php
  $direct_url = 'http://' . $_SERVER['HTTP_HOST'] . '/img/Camisas/hombre/1755726290-sg-11134201-22110-r3icnaitwnjv5c.jpg';
  echo "URL directa: <a href='" . $direct_url . "' target='_blank'>" . $direct_url . "</a><br>";
  echo "Abre este enlace en una nueva pestaña. ¿Se ve la imagen?";
  ?>
</div>

</body>
</html>