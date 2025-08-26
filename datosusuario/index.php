<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Datos de Usuario</title>
  <link rel="stylesheet" href="estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <div class="container">
    <header>
      <div class="home-icon">
        <a href="../ropa_venta/index.php">    
          <i class="fa-solid fa-house-chimney"></i>
          <span class="home-text">HOME</span>
        </a>
      </div>
      <h1>DATOS DE USUARIO</h1>
    </header>

    <main>
      <section class="usuario-info">
        <div class="avatar">
          <form action="subir_foto.php" method="POST" enctype="multipart/form-data">
            <label for="fotoInput">
              <img src="<?php echo isset($_COOKIE['foto_usuario']) ? $_COOKIE['foto_usuario'] . '?ts=' . time() : 'https://via.placeholder.com/100x100?text=?'; ?>" alt="Usuario" id="avatarImg">

            </label>
            <input type="file" name="foto" id="fotoInput" accept="image/*" onchange="this.form.submit()">
          </form>
        </div>
        <div class="red-social">
          <p>RED SOCIAL DE ORIGEN</p>
        </div>
        <div class="descripcion">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.</p>
        </div>
      </section>

      <section class="mensaje">
        <h2>MENSAJE GENERADO</h2>
        <div class="mensaje-box">
          <?php echo "<p>Este es el mensaje generado dinámicamente.</p>"; ?>
        </div>
      </section>
    </main>

    <footer class="botones">
      <button>ATRÁS</button>
      <button>EDITAR</button>
      <button>SIGUIENTE</button>
    </footer>
  </div>
</body>
</html>