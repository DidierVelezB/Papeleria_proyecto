<?php
// === CARGADOR MANUAL DE VARIABLES .ENV ===

$envPath = __DIR__ . '/.env';

// Verificar si el archivo existe
if (!file_exists($envPath)) {
    die("Error: No se encontró el archivo .env en la ruta: $envPath");
}

$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    // Ignorar comentarios
    if (strpos(trim($line), '#') === 0) continue;
    if (!str_contains($line, '=')) continue;

    // Separar clave y valor
    list($name, $value) = array_map('trim', explode('=', $line, 2));

    // Quitar comillas si existen
    $value = trim($value, "\"'");

    // Registrar variable en todos los entornos
    putenv("$name=$value");
    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
}
// === FIN DEL CARGADOR MANUAL DE VARIABLES .ENV ===