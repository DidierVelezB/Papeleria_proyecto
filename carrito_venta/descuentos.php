<?php
session_start();
header('Content-Type: application/json');

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'genia';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $codigo = $data['codigo'] ?? '';

        // Consulta para verificar el código de descuento
        $stmt = $conn->prepare("SELECT * FROM codigos_descuento WHERE codigo = :codigo AND (valido_hasta >= CURDATE() OR valido_hasta IS NULL) AND (usos_maximos IS NULL OR usos_actuales < usos_maximos) AND activo = TRUE");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        
        $descuento = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($descuento) {
            // Actualizar contador de usos
            $stmt = $conn->prepare("UPDATE codigos_descuento SET usos_actuales = usos_actuales + 1 WHERE id = :id");
            $stmt->bindParam(':id', $descuento['id']);
            $stmt->execute();
            
            echo json_encode([
                'success' => true,
                'porcentaje' => $descuento['porcentaje'],
                'mensaje' => 'Descuento aplicado correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Código no válido o ha expirado'
            ]);
        }
    }
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Error en la base de datos'
    ]);
}
?>