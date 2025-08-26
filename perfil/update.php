<?php
// archivo: actualizar_perfil.php

// Iniciar sesión solo si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ajusta esta ruta según dónde esté tu perfil.php
include __DIR__ . '/index.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    die("Acceso no autorizado.");
}

$conn = new mysqli("localhost", "root", "", "genia");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recuperar los datos del formulario
$usuario_id = $_SESSION['usuario_id'];
$tipo_documento = $_POST['tipo_documento'] ?? null; 
$cedula = $_POST['cedula'] ?? null;
$nombres = $_POST['nombre'] ?? null;
$apellidos = $_POST['apellidos'] ?? null;
$email = $_POST['correoElectronico'] ?? null;

// Inicializar la consulta con la parte básica
$sql = "UPDATE cliente SET ";

// Arreglo para almacenar los valores de los campos que se van a actualizar
$params = [];
$types = "";

// Agregar campos que han sido enviados
if (!empty($tipo_documento)) {
    $sql .= "tipo_documento = ?, ";
    $params[] = $tipo_documento;
    $types .= "s";
}

if (!empty($cedula)) {
    $sql .= "cedula = ?, ";
    $params[] = $cedula;
    $types .= "s";
}

if (!empty($nombres)) {
    $sql .= "nombre = ?, ";
    $params[] = $nombres;
    $types .= "s";
}

if (!empty($apellidos)) {
    $sql .= "apellidos = ?, ";
    $params[] = $apellidos;
    $types .= "s";
}

if (!empty($email)) {
    $sql .= "correoElectronico = ?, ";
    $params[] = $email;
    $types .= "s";
}

// Eliminar la última coma y espacio
$sql = rtrim($sql, ", ");

// Verificar si hay campos para actualizar
if ($sql === "UPDATE cliente SET") {
    die("No hay datos para actualizar.");
}

// Agregar la condición WHERE para actualizar solo el usuario correspondiente
$sql .= " WHERE idCliente = ?";

// Agregar el id del usuario como parámetro
$params[] = $usuario_id;
$types .= "i";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo "Perfil actualizado correctamente.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
