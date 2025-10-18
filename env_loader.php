<?php
// === CARGADOR MANUAL DE VARIABLES .ENV ===
// Este script lee el archivo .env y carga las variables en $_ENV, $_SERVER y getenv()

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

// Solo para depuración local
// echo "<pre>Cargado correctamente .env</pre>";
