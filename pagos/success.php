<?php
session_start();
include '../conexion_bd.php';

// Encabezado HTML
header('Content-Type: text/html; charset=utf-8');

// Verificar que exista el carrito guardado en la sesión
$carritoJSON = $_SESSION['carrito_json'] ?? null;

if ($carritoJSON) {
    $productos = json_decode($carritoJSON, true);

    if (is_array($productos)) {
        foreach ($productos as $p) {
            $id = (int)$p['id'];
            $cantidad = (int)$p['cantidad'];

            // Restar cantidad disponible sin permitir números negativos
            $conexion->query("UPDATE producto SET cantidad = GREATEST(cantidad - $cantidad, 0) WHERE id = $id");
        }

        // Vaciar carrito de la sesión
        unset($_SESSION['carrito_json']);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pago exitoso</title>
</head>
<body style="font-family: Arial; text-align: center; padding: 50px;">
  <h1>✅ ¡Pago exitoso!</h1>
  <p>Gracias por tu compra. El stock ha sido actualizado automáticamente.</p>
  <a href="../ropa_venta/index.php">Volver a la tienda</a>
</body>
</html>
