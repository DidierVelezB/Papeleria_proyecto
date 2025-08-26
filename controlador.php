<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["usuario"]) || empty($_POST["contraseña"])) {
        echo '<div class="alert alert-danger">LOS CAMPOS ESTÁN VACÍOS</div>';
    } else {
        include("conexion_bd.php"); 
        
        $nombre = trim($_POST["usuario"]);
        $contraseña = trim($_POST["contraseña"]);

        $stmt = $conexion->prepare("SELECT idCliente, nombre, contraseña, rol FROM cliente WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($datos = $resultado->fetch_object()) {
            if (password_verify($contraseña, $datos->contraseña)) {
                $_SESSION['usuario_id'] = $datos->idCliente;
                $_SESSION['usuario'] = $datos->nombre;
                $_SESSION['rol'] = $datos->rol;
                
                if ($datos->rol === 'administrador') {
                    header("Location: ../admin/administracion.php"); // Redirige al admin
                } else {
                    header("Location: ../ropa_venta/index.php"); // Redirige a usuario normal
                }
                exit;
            } else {
                echo '<div class="alert alert-danger">ACCESO DENEGADO</div>';
            }
        } else {
            echo '<div class="alert alert-danger">USUARIO NO ENCONTRADO</div>';
        }

        $stmt->close();
        $conexion->close();
    }
}
?>
