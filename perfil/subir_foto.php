<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    die("No hay sesión iniciada.");
}

if ($_FILES['foto']['error'] === 0) {
    $usuario_id = $_SESSION['usuario_id'];
    $directorio = "uploads/";

    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Aseguramos que sea imagen válida
    $info = pathinfo($_FILES['foto']['name']);
    $extension = strtolower($info['extension']);
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($extension, $extensionesPermitidas)) {
        die("Extensión de imagen no permitida.");
    }

    $nombreArchivo = $usuario_id . '.' . $extension;
    $rutaDestino = $directorio . $nombreArchivo;

    // Elimina otras versiones del mismo usuario
    foreach ($extensionesPermitidas as $ext) {
        $viejo = $directorio . $usuario_id . '.' . $ext;
        if (file_exists($viejo)) {
            unlink($viejo);
        }
    }

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Hubo un error al mover el archivo.";
    }
} else {
    echo "Hubo un error al subir la imagen.";
}
