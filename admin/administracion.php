<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') { die('Acceso denegado'); }
$host = 'localhost';
$dbname = 'genia';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Procesar TOGGLE ESTADO (corregido)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_estado'])) {
        $id = (int)$_POST['id'];
        $stmt = $conn->prepare("
            UPDATE codigos_descuento 
            SET activo = IF(activo = 1, 0, 1) 
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    // 2. Procesar ELIMINAR CÓDIGO
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_codigo'])) {
        $id = (int)$_POST['id'];
        $stmt = $conn->prepare("DELETE FROM codigos_descuento WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $_SESSION['exito'] = "Código borrado correctamente";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // 2. Procesar NUEVO CÓDIGO 
    if (isset($_POST['nuevo_codigo'])) {
        $errores = [];
        
        // Validaciones
        if (empty($_POST['codigo'])) $errores[] = "El código es requerido";
        if (!is_numeric($_POST['porcentaje']) || $_POST['porcentaje'] <= 0 || $_POST['porcentaje'] > 100) {
            $errores[] = "Porcentaje debe ser entre 1 y 100";
        }

        if (empty($errores)) {
            try {
                $stmt = $conn->prepare("INSERT INTO codigos_descuento (codigo, porcentaje, valido_hasta, usos_maximos) 
                                      VALUES (:codigo, :porcentaje, :valido_hasta, :usos_maximos)");
                $stmt->bindParam(':codigo', $_POST['codigo']);
                $stmt->bindParam(':porcentaje', $_POST['porcentaje']);
                $stmt->bindParam(':valido_hasta', $_POST['valido_hasta']);
                $stmt->bindParam(':usos_maximos', $_POST['usos_maximos']);
                $stmt->execute();

                $_SESSION['exito'] = "Código agregado correctamente";
                header("Location: ".$_SERVER['PHP_SELF']);
                exit;
            } catch(PDOException $e) {
                $errores[] = "Error al guardar: ".$e->getMessage();
            }
        }
    }

    // Obtener códigos ACTUALIZADOS
    $stmt = $conn->query("SELECT * FROM codigos_descuento ORDER BY valido_hasta DESC");
    $codigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Descuentos</title>
    <style>
table { width: 100%; border-collapse: collapse; }
th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
.activo { color: green; }
.inactivo { color: red; }
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.form-group input {
    padding: 8px;
    width: 100%;
    max-width: 300px;
}
.alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
}
.alert-success {
    background-color: #dff0d8;
    color: #3c763d;
}
.alert-error {
    background-color: #f2dede;
    color: #a94442;
}
td button {
    width: 10px; 
    min-width: 150px;
    white-space: nowrap;
}
td.estado {
    width: 100px; 
    text-align: center;
    white-space: nowrap;
    font-weight: bold;
}

a {
    color: inherit;       
    text-decoration: none;
    background-color: bisque;
    border: 2px solid #333;
    padding: 3px;
    transition: 1s;
}
a:hover {
    background-color: #79e475ff;
}
.logout-btn {
  padding: 6.2px 20px;
  margin-right: 70px;
  font-size: 14px;
  align-items: center;
  background-color: #e74c3c;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}
    </style>
</head>
<body>
    <h1>Administrar Códigos de Descuento</h1>
    <button class="logout-btn" onclick="window.location.href='../logout.php'">Cerrar Sesión</button>
    
    <div class="form-group">
        <a href="../admin/crear.php">Crear nuevo producto</a>
    </div>
    <div class="form-group">
        <a href="../admin/listar.php">Ver listado de productos</a>
    </div>

    
    <h2>Agregar Nuevo Código</h2>
            <?php if (!empty($errores)): ?>
                <div class="alert alert-error">
            <?php foreach($errores as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success">
            <p><?= $_SESSION['exito'] ?></p>
        </div>
        <?php unset($_SESSION['exito']); ?>
        <?php endif; ?>    
    <form method="POST">
        <input type="text" name="codigo" placeholder="Código" required>
        <input type="number" name="porcentaje" min="1" max="100" placeholder="Porcentaje" required>
        <input type="date" name="valido_hasta" placeholder="Válido hasta">
        <input type="number" name="usos_maximos" min="1" placeholder="Usos máximos (opcional)">
        <button type="submit" name="nuevo_codigo">Agregar</button>
    </form>
    
    <h2>Códigos Existentes</h2>
        <?php if (!empty($errores)): ?>
            <div class="alert alert-error">
                <?php foreach($errores as $error): ?>
                    <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success">
            <p><?= $_SESSION['exito'] ?></p>
        </div>
        <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>
    
    <table>
        <tr>
            <th>Código</th>
            <th>Descuento</th>
            <th>Válido hasta</th>
            <th>Usos</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($codigos as $codigo): ?>
        <tr>
            <td><?= htmlspecialchars($codigo['codigo']) ?></td>
            <td><?= $codigo['porcentaje'] ?>%</td>
            <td><?= $codigo['valido_hasta'] ?: 'Indefinido' ?></td>
            <td><?= $codigo['usos_actuales'] ?>/<?= $codigo['usos_maximos'] ?: '∞' ?></td>
            <td class="estado <?= $codigo['activo'] ? 'activo' : 'inactivo' ?>">
                <?= $codigo['activo'] ? 'Activo' : 'Inactivo' ?>
            </td>
            <td>
            <!-- Toggle Estado -->
            <form method="POST" style="display: inline;">
                <input type="hidden" name="id" value="<?= $codigo['id'] ?>">
                <button type="submit" name="toggle_estado"><?= $codigo['activo'] ? 'Desactivar' : 'Activar' ?></button>
            </form> 

            <!-- Botón Borrar -->
            <form method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de borrar este código?');">
                <input type="hidden" name="id" value="<?= $codigo['id'] ?>">
                <button type="submit" name="borrar_codigo" style="background: #ff4444; color: white;">Borrar</button>
            </form>
        </td>
        <?php endforeach; ?>
    </table>
</body>
</html>