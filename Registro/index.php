<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="wrapper">
    <div class="card">
      <div class="left-panel">
        <img src="../img/logo.png" alt="Logotipo IA" class="logo-img">
      </div>
      <div class="right-panel">
        <form action="register.php" method="post">
          <div class="field-single">
            <label for="usuario">NOMBRE</label>
            <input type="text" id="usuario" name="usuario" required>
          </div>
          <div class="field-single">
            <label for="correo">CORREO</label>
            <input type="email" id="correo" name="correo" required>
          </div>
          <div class="field-single">
            <label for="contrasena">CONTRASEÑA</label>
            <input type="password" id="contrasena" name="contrasena" required>
          </div>
          <button type="submit" class="btn">REGISTRAR</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
