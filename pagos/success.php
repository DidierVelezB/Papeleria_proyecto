<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pago exitoso</title>
  <script>
  document.addEventListener("DOMContentLoaded", async () => {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (carrito.length > 0) {
      try {
        await fetch("../pagos/actualizar_stock.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ productos: carrito })
        });

        // Limpiar carrito
        localStorage.removeItem("carrito");
        alert("Stock actualizado correctamente ✅");
      } catch (error) {
        console.error("Error al actualizar el stock:", error);
      }
    }
  });
  </script>
</head>
<body style="font-family: Arial; text-align: center; padding: 50px;">
  <h1>✅ ¡Pago exitoso!</h1>
  <p>Gracias por tu compra. Nos pondremos en contacto contigo pronto.</p>
  <a href="../ropa_venta/index.php">Volver a la tienda</a>
</body>
</html>
