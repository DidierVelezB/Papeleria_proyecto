<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="register-container">
    <div class="register-card">
      <h2>Registro de Usuario</h2>
      <form action="register.php" method="post">
        <div class="form-group">
          <label for="usuario">Nombre:</label>
          <input type="text" id="usuario" name="usuario" placeholder="Ingresa tu nombre" required>
        </div>

        <div class="form-group">
          <label for="correo">Correo:</label>
          <input type="email" id="correo" name="correo" placeholder="Ingresa tu correo" required>
        </div>

        <div class="form-group">
          <label for="contrasena">Contraseña:</label>
          <input type="password" id="contrasena" name="contrasena" placeholder="Crea una contraseña" required>
        </div>

        <button type="submit" class="btn">REGISTRAR</button>
        <button type="button" class="btn volver" onclick="window.location.href='../index.php'">VOLVER</button>
      </form>
    </div>
  </div>
</body>
</html>
