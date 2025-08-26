<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promociones</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        
        <header>
            <div class="home-button">
        <a href="../ropa_venta/index.php" class="home-link">
            <i class="fa-solid fa-house-chimney"></i>
            <span class="home">HOME</span>
        </a>
    </div>
                <h1>PROMOCIONES</h1>
        </header>

        <div class="formulario">
            <div class="form-columna">
                <h2>Productos recomendados</h2>
                <div id="recomendaciones" class="recomendaciones-box">
                <!-- Aquí se mostrarán los productos sugeridos -->
                    <p style="color:#777">Aquí aparecerán tus sugerencias personalizadas pronto...</p>
                </div>
                <button onclick="cargarRecomendaciones()">Cargar Recomendaciones</button>
                <button onclick="limpiarHistorial()">Limpiar Historial</button>


            </div>
        </div>
    </div>

    <script src="promocion.js"></script>
</body>