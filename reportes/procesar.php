<?php
session_start();
date_default_timezone_set('America/Bogota');


// Revisa si el usuario está registrado
if (!isset($_SESSION['usuario_id'])) {
    die("No puedes enviar reportes si no estás registrado.");
}

$usuario_id = $_SESSION['usuario_id'];

// Recibimos los datos del formulario
$nombres = $_POST['nombres'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$documento = $_POST['documento'] ?? '';
$fecha = date('Y-m-d');
$reporte = $_POST['reporte'] ?? '';

// Validamos que no estén vacíos  
if ($nombres == '' || $apellidos == '' || $documento == '' || $fecha == '' || $reporte == '') {
    die("Por favor completa todos los campos.");
}

// Conectamos a la base de datos 
$conn = new mysqli("localhost", "root", "", "genia");
if ($conn->connect_error) {
    die("Error conectando a la base de datos: " . $conn->connect_error);
}

// Peparar la consulta para evitar inyecciones SQL
$stmt = $conn->prepare("INSERT INTO reportes (nombres, apellidos, documento, fecha, reporte, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssi", $nombres, $apellidos, $documento, $fecha, $reporte, $usuario_id);

// Ejecutamos y vemos qué pasa
if ($stmt->execute()) {
    echo "Reporte guardado, ¡gracias por avisarnos!";
} else {
    echo "Algo salió mal: " . $stmt->error;
}


$stmt->close();
$conn->close();
?>
