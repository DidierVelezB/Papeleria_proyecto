<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Promociones</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
    <header>
        <a href="../Inicio_principal/index.php" class="home-button">
            <div class="logo">
                <i class="fa-solid fa-house-chimney"></i>
                <span>HOME</span>
            </div>
        </a>
        <h1>ANÁLISIS DE PROMOCIONES</h1>
    </header>
    <main>
        <section class="promociones">
            <h2>PRODUCTOS EN PROMOCIÓN</h2>
            <?php
                $productos = ["camiseta1.png", "camiseta2.png", "camiseta3.png", "camiseta4.png","camiseta5.png","camiseta6.png","camiseta7.png","camiseta8.png","camiseta9.png","camiseta10.png",];
                foreach ($productos as $producto) {
                    echo '<div class="producto">
                            <i class="fa-solid fa-shirt"></i>
                            <button class="btn">READ MORE</button>
                          </div>';
                }
            ?>
        </section>

        <section class="coincidencias">
            <h2>COINCIDENCIAS DE GUSTOS</h2>
            <?php
                for ($i = 0; $i < 5; $i++) {
                    echo '<div class="coincidencia">
                            <div class="avatar">?</div>
                            <div class="info"></div>
                          </div>';
                }
            ?>
            <button class="siguiente">SIGUIENTE</button>
        </section>
    </main>
</body>
</html>
