<?php
include '../conexion_bd.php';
$res = $conexion->query("SELECT * FROM producto ORDER BY id DESC");
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Productos</title>
  <style>
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
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    img {
        max-width: 60px;
        height: auto;
    }
  </style>
</head>
<body>
  <h1>Productos</h1>
  <?php if (isset($_GET['ok'])) echo '<p>Operación exitosa.</p>'; ?>
  <p><a href="administracion.php"> Volver al inicio</a></p>
  <p><a href="crear.php"> Nuevo producto</a></p>
  <table>
    <tr>
      <th>ID</th>
      <th>Imagen</th>
      <th>Nombre</th>
      <th>Categoría</th>
      <th>Subcategoría</th>
      <th>Tipo</th>
      <th>Marca</th>
      <th>Presentación</th>
      <th>Precio</th>
      <th>Cantidad</th>
      <th>Estado</th>
      <th>Acciones</th>
      
    </tr>
    <?php while ($p = $res->fetch_assoc()): ?>
      <tr>
        <td><?= (int)$p['id'] ?></td>
        <td><?php if ($p['imagen']) { ?><img src="../<?= htmlspecialchars($p['imagen']) ?>" alt=""><?php } ?></td>
        <td><?= htmlspecialchars($p['nombre']) ?></td>
        <td><?= htmlspecialchars($p['categoria']) ?></td>
        <td><?= htmlspecialchars($p['subcategoria']) ?></td>
        <td><?= htmlspecialchars($p['tipo']) ?></td>
        <td><?= htmlspecialchars($p['marca']) ?></td>
        <td><?= htmlspecialchars($p['presentacion']) ?></td>
        <td>$<?= number_format($p['precio'], 0, ',', '.') ?></td>
        
        <td><?= (int)$p['cantidad'] ?></td>
        <td>
        <?php
          if (isset($p['activo']) && (int)$p['activo'] === 0) {
            echo '<span style="color:red;font-weight:bold;">Agotado</span>';
          } else {
            echo '<span style="color:green;font-weight:bold;">Disponible</span>';
          }
        ?>
      </td>

        <td>
          
          <a href="editar.php?id=<?= (int)$p['id'] ?>">Editar</a> |
          <a href="eliminar_producto.php?id=<?= (int)$p['id'] ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>