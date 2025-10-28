<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pago cancelado</title>
  <script>
  document.addEventListener("DOMContentLoaded", async () => {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (carrito.length > 0) {
      try {
        // Reintegrar stock al cancelar pago
        await fetch("revertir_stock.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ productos: carrito })
        });

        alert("El pago fue cancelado.");

        // Vaciar carrito local
        localStorage.removeItem("carrito");
      } catch (error) {
        console.error("Error al revertir el stock:", error);
      }
    }
  });
  </script>
</head>
<body style="font-family: Arial; text-align: center; padding: 50px;">
  <h1>❌ Pago cancelado</h1>
  <p>Tu pago no se completó. Puedes intentarlo nuevamente.</p>
  <a href="../ropa_venta/index.php">Volver a la tienda</a>
</body>
</html>
