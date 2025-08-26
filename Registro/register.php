<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../index.html');
    exit;
}

// Validar campos
if (empty($_POST['usuario']) 
 || empty($_POST['correo']) 
 || empty($_POST['contrasena'])) {
    echo '<div class="alert alert-danger">TODOS LOS CAMPOS SON OBLIGATORIOS</div>';
    exit;
}

// Recoger y sanitizar
$usuario  = trim($_POST['usuario']);
$correo   = trim($_POST['correo']);
$rawPass  = trim($_POST['contrasena']);

// Conectar a la BD
require_once '../conexion_bd.php';


// Comprobar duplicados
$stmt = $conexion->prepare(
    "SELECT 1 
       FROM cliente 
      WHERE nombre = ? 
         OR correoElectronico = ?"
);
if (!$stmt) {
    die('Error en prepare(): ' . $conexion->error);
}
$stmt->bind_param('ss', $usuario, $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo '<div class="alert alert-danger">
            YA EXISTE UN USUARIO O CORREO REGISTRADO
          </div>';
    exit;
}
$stmt->close();

// Hashear y guardar
$hashed = password_hash($rawPass, PASSWORD_DEFAULT);

$stmt = $conexion->prepare("
    INSERT INTO cliente (nombre, correoElectronico, contraseña, rol) 
    VALUES (?, ?, ?, ?)
");
if (!$stmt) {
    die('Error en prepare(): ' . $conexion->error);
}
$rol = 'cliente';
$stmt->bind_param('ssss', $usuario, $correo, $hashed, $rol);

if ($stmt->execute()) {
        header('Location: ../index.php');
            exit;

} else {
    echo '<div class="alert alert-danger">
            ERROR AL REGISTRAR: ' . htmlspecialchars($stmt->error) . '
          </div>';
}

$stmt->close();
$conexion->close();
?>