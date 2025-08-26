<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('America/Bogota');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil e Historial</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="home-button">
        <a href="../ropa_venta/index.php" class="home-link">
            <i class="fa-solid fa-house-chimney"></i>
            <span class="home">HOME</span>
        </a>
    </div>

    <h1>PERFIL</h1>
    <div class="container">
        <div class="perfil">
            <div class="avatar">
                <?php
                $avatar = 'https://via.placeholder.com/100x100?text=?';

                if (isset($_SESSION['usuario_id'])) {
                    $usuario_id = $_SESSION['usuario_id'];
                    $carpeta = "uploads/";
                    $exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                    foreach ($exts as $ext) {
                        $ruta = $carpeta . $usuario_id . '.' . $ext;
                        if (file_exists($ruta)) {
                            $avatar = $ruta . '?t=' . time(); // fuerza actualización de caché
                            break;
                        }
                    }
                }
                ?>
                <form action="subir_foto.php" method="POST" enctype="multipart/form-data">
                    <label for="fotoInput">
                        <img src="<?php echo $avatar; ?>" alt="Usuario" id="avatarImg">
                    </label>
                    <input type="file" name="foto" id="fotoInput" accept="image/*" onchange="this.form.submit()">
                </form>
            </div>
            <br>
            <form action="update.php" method="POST">
                <select name="tipo_documento" class="documento">
                    <option value="">TIPO DE DOCUMENTO</option>
                    <option value="cedula">Cédula de ciudadanía</option>
                    <option value="tarjeta_identidad">Tarjeta de identidad</option>
                    <option value="pasaporte">Pasaporte</option>
                    <option value="cedula_ext">Cédula de extranjería</option>
                </select>

                <input type="text" name="cedula" placeholder="N° DOCUMENTO" class="input-cedula">
                <br>
                <input type="text" name="nombre" placeholder="NOMBRES" class="input-nombre">
                <input type="text" name="apellidos" placeholder="APELLIDOS" class="input-apellidos">
                <br>
                <input type="email" name="correoElectronico" class="full-width" placeholder="EMAIL">
                <br>
                <button type="submit" class="editar">EDITAR</button>
            </form>
        </div>

        <div class="historial">
            <div class="titulo-historial">HISTORIAL</div>

            <?php
            if (isset($_SESSION['usuario_id'])) {
                $usuario_id = $_SESSION['usuario_id'];
                $conexion = new mysqli("localhost", "root", "", "genia");

                if ($conexion->connect_error) {
                    echo "<p>Error de conexión: " . $conexion->connect_error . "</p>";
                } else {
                    $stmt = $conexion->prepare("SELECT producto, fecha, precio, talla, imagen FROM historial WHERE id_cliente = ? ORDER BY fecha DESC");
                    $stmt->bind_param("i", $usuario_id);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    if ($resultado->num_rows > 0) {
                        echo "<ul class='lista-historial'>";
                        while ($fila = $resultado->fetch_assoc()) {
                            echo "<li style='margin-bottom:15px; display:flex; align-items:center; gap:10px;'>";

                            
                            $urlFinalConCache = 'http://localhost:3000/' . $fila['imagen'] . '?v=' . time();

                            echo "<img src='" . htmlspecialchars($urlFinalConCache) . "' alt='Imagen producto' style='width:60px; height:auto; border-radius:5px;'>";



                            echo "<div>";
                            echo "<strong>Producto:</strong> " . htmlspecialchars($fila['producto']) . "<br>";
                            echo "<strong>Talla:</strong> " . htmlspecialchars($fila['talla']) . "<br>";
                            echo "<strong>Precio:</strong> $" . number_format($fila['precio'], 0, ',', '.') . "<br>";
                            echo "<strong>Fecha:</strong> <span class='hora-usuario' data-utc='" . htmlspecialchars($fila['fecha']) . "'></span>";
                            echo "</div>";
                            echo "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No hay historial de compras.</p>";
                    }

                    $stmt->close();
                    $conexion->close();
                }
            } else {
                echo "<p>Debes iniciar sesión para ver el historial.</p>";
            }
            ?>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const elementos = document.querySelectorAll(".hora-usuario");

            elementos.forEach(el => {
                const utc = el.dataset.utc; // Fecha en UTC
                const fecha = new Date(utc + " UTC"); // Forzar interpretación en UTC
                fecha.setHours(fecha.getHours() - 2); // Ajustar a la zona horaria de Bogotá (UTC-5)

                // Ajustar la fecha a la zona horaria local
                const opciones = {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                    hour: "2-digit",
                    minute: "2-digit",
                    second: "2-digit",
                };

                el.textContent = fecha.toLocaleString(undefined, opciones); // Formato local
            });
        });
</script>
</body>
</html>
