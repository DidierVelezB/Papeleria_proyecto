<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <img src="img/Logo.png" alt="Logo" class="Logo">
            
        <div class="login-container">   
            <form method="post" action="" >
            <h2>Inicio de sesión</h2>
                <?php
                include("conexion_bd.php");
                include("controlador.php");    
                ?>
            <label  for="username">Usuario:</label>
            <input class ="nombre" type="text" id="usuario" name="usuario" placeholder="Ingresa tu usuario" required>

            <label  for="password">Contraseña:</label>
            <input class ="pass" type="password" id="contraseña" name="contraseña" placeholder="Ingresa tu contraseña" required>

            <button name="button" type="submit">INICIAR SESIÓN</button>
            <button name="Registrar" type="button" onclick="window.location.href='../Registro/index.php'">REGISTRAR</button>
        
        </form>
    </div>
</body>