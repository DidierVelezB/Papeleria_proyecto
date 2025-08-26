<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos en Carrito</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenedor">
        <!-- Encabezado principal -->
        <header>
            <h1>PRODUCTOS EN CARRITO</h1>
            <nav class="navegacion">
                <ul>
                    <li><a href="../ropa_venta/index.php">Inicio</a></li>
                </ul>
            </nav>
        </header>

        <!-- Contenedor principal del carrito -->
       <main class="carrito">
        <section class="lista-productos">
        <h2>Tus Productos (<span id="contador-carrito">0</span>)</h2>
        <div id="contenedor-productos" class="productos-carrito">
            <!-- Los productos se cargarán aquí mediante JavaScript -->
        </div>
    </section>

    <section class="resumen-compra">
        <div class="totales">
        <h3>Resumen de Compra</h3>
        <div class="subtotal">
            <span>Subtotal:</span>
            <span>$<span id="subtotal">0</span></span>
        </div>
        <div class="descuentos">
            <div class="input-descuento">
                <input type="text" id="codigoDescuento" placeholder="Código de descuento">
                <button class="boton-aplicar">APLICAR</button>
            </div>
            <div id="mensajeDescuento" class="mensaje"></div>
        </div>
        <div class="total">
            <span>Total:</span>
            <span>$<span id="total">0</span></span>
        </div>
        <button class="boton-pagar">PAGAR</button>
    </div>
    </section>
</main>
    </div>
        <script>
            const usuarioID = <?php echo isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 'null'; ?>;
        </script>
    <script src="carrito.js"></script>
</body>
</html>