<?php
session_start();
if ($_FILES['foto']['error'] === 0) {
    $directorio = "uploads/";

    // Crear el directorio si no existe
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Obtener nombre original y construir ruta
    $nombreArchivoOriginal = basename($_FILES["foto"]["name"]);
    $rutaDestino = $directorio . $nombreArchivoOriginal;

    // Si ya existe una imagen con ese nombre, la reemplaza
    if (file_exists($rutaDestino)) {
        unlink($rutaDestino);
    }

    // Mover la nueva imagen al destino
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
        // Guardar la ruta en una cookie por 30 días
        setcookie("foto_usuario", $rutaDestino, time() + (86400 * 30), "/");
        // Redirigir para actualizar la vista
        header("Location: index.php");
        exit;
    } else {
        echo "Hubo un error al mover el archivo.";
    }
} else {
    echo "Hubo un error al subir la imagen.";
}
