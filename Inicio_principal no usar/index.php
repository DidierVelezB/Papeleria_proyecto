<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <div class="logo">🔗</div>
            <a href="../logout.php">
                <button class="logout">CERRAR SESIÓN</button>
            </a>
        </div>
        <div class="buttons">
            <?php
                $buttons = [
                    "MI PERFIL" => "../datosusuario/index.php", 
                    "PROMOCIONES" =>'#', 
                    "HISTORIAL" =>'#', 
                    "REPORTES" => "../reportes/index.php", 
                    "FILTROS" => "../analisisprom/index.php", 
                    "SOPORTE TÉCNICO" =>'#'
                ];
                foreach ($buttons as $label => $link) {
                    echo "<a class='btn' href='$link'>$label</a>";
                }
            ?>
        </div>
    </div>
</body>
</html>