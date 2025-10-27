<?php
include '../conexion_bd.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $conexion->prepare("SELECT * FROM producto WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$prod = $stmt->get_result()->fetch_assoc();
if (!$prod) { die('Producto no encontrado'); }

// Definir las opciones para los dropdowns (mismas que en crear.php)
$categorias = [
    'ESCRITURA Y DIBUJO', 'MATERIAL ARTÍSTICO', 'PAPELERÍA BÁSICA', 
    'OFICINA Y ORGANIZACIÓN', 'MANUALIDADES', 'MATERIAL EDUCATIVO',
    'JUEGOS Y RECREACIÓN', 'DECORACIÓN Y EVENTOS', 'EMBALAJE', 
    'MATERIAL PARA IMPRESIÓN'
];

$subcategorias = [
    'Bolígrafos y Esferos', 'Lápices', 'Portaminas', 'Marcadores', 'Micropuntas',
    'Carboncillos y Artísticos', 'Temperas', 'Acuarelas', 'Óleos y Acrílicos', 'Pinceles',
    'Plastilinas', 'Vinilos', 'Blocks y Cuadernos', 'Cartulinas', 'Cartón Paja',
    'Papeles Especiales', 'Grapadoras', 'Perforadoras', 'Clip\'s y Ganchos', 'Cintas',
    'Carpetas y Organizadores', 'Tijeras y Cutter', 'Pegantes', 'Siliconas',
    'Materiales para Maquetas', 'Sellos y Troqueles', 'Geometría', 'Tajalápices',
    'Borradores', 'Correctores', 'Juegos de Mesa', 'Rompecabezas', 'Material Didáctico',
    'Escarchas y Brillos', 'Moñas y Lazos', 'Material para Piñatas', 'Elementos para Fiestas',
    'Cintas de Embalaje', 'Bolsas y Empaques', 'Material de Protección',
    'Cintas para Registradoras', 'Tintas', 'Sellos y Fechadores'
];

$tipos = [
    'Kilométricos', 'Retráctiles', 'Con tapa', 'Gel', 'Tinta normal', 'Grafito',
    'Colores', 'Jumbo', 'Bicolor', 'Permanentes', 'Borrables', 'Grafiti', 'Escolares',
    'Profesionales', 'Económicas', 'Perlados', 'Neón', 'Rayados', 'Cuadriculados',
    'Bristol', 'Durex', 'Acuarela', 'Crepé', 'Foamy', 'Vinilo', 'Mariposa', 'Legajadores',
    'Embalaje', 'Enmascarar', 'Doble faz', 'Sipega', 'Colbón', 'UHU', 'Líquida',
    'En barra', 'Delgada', 'Miga de pan', 'Líquido', 'Cinta', 'Esfero'
];

$marcas = [
    'BIC', 'Papermate', 'Pelikan', 'Faber Castell', 'Kilométricos', 'Payasito',
    'Parchesitos', 'Macao', 'Trensito', 'Offi-esco', 'Studmark', 'Sipega', 'Colbón',
    'UHU', 'Kores', 'Mirado'
];

$presentaciones = [
    'Unidad', 'Paquete x5', 'Paquete x10', 'Paquete x12', 'Caja x24', 'Caja x50',
    'Caja x100', 'Blister', 'Display', 'Granel'
];
function normalizar($texto) {
    $texto = trim(mb_strtolower($texto, 'UTF-8'));
    $texto = str_replace(
        ['á','é','í','ó','ú','ü','ñ'],
        ['a','e','i','o','u','u','n'],
        $texto
    );
    return $texto;
}

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar</title>
  <style>
    a {
        color: inherit;       
        text-decoration: none; 
    }
    select, input, textarea {
        margin-bottom: 10px;
        padding: 8px;
        width: 300px;
    }
    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }
  </style>
</head>
<body>
  <h1>Editar producto #<?= (int)$prod['id'] ?></h1>
  <form action="actualizar_producto.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= (int)$prod['id'] ?>">

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($prod['nombre']) ?>" required>

    <label>Descripción:</label>
    <textarea name="descripcion"><?= htmlspecialchars($prod['descripcion']) ?></textarea>

    <label>Precio:</label>
    <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($prod['precio']) ?>" required>

    <label>Cantidad en Stock:</label>
    <input type="number" name="cantidad" min="0" value="<?= (int)$prod['cantidad'] ?>" required>

    <label>Categoría:</label>
    <select name="categoria" required>
        <option value="">Seleccione una categoría</option>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" 
                <?= (normalizar($prod['categoria']) === normalizar($cat)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Subcategoría:</label>
    <select name="subcategoria" required>
        <option value="">Seleccione una subcategoría</option>
        <?php foreach ($subcategorias as $sc): ?>
            <option value="<?= htmlspecialchars($sc) ?>" 
                <?= (normalizar($prod['subcategoria']) === normalizar($sc)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($sc) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Tipo:</label>
    <select name="tipo" required>
        <option value="">Seleccione un tipo</option>
        <?php foreach ($tipos as $t): ?>
            <option value="<?= htmlspecialchars($t) ?>" 
                <?= (normalizar($prod['tipo']) === normalizar($t)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($t) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Marca:</label>
    <select name="marca" required>
        <option value="">Seleccione una marca</option>
        <?php foreach ($marcas as $m): ?>
            <option value="<?= htmlspecialchars($m) ?>" 
                <?= (normalizar($prod['marca']) === normalizar($m)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($m) ?>
            </option>
        <?php endforeach; ?>
    </select>

   <label>Presentación:</label>
    <select name="presentacion" required>
        <option value="">Seleccione una presentación</option>
        <?php foreach ($presentaciones as $p): ?>
            <option value="<?= htmlspecialchars($p) ?>" 
                <?= (normalizar($prod['presentacion']) === normalizar($p)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($p) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <p>Imagen actual: <?php if ($prod['imagen']) { ?><img src="../<?= htmlspecialchars($prod['imagen']) ?>" width="80"><?php } ?></p>
    <label>Nueva imagen (opcional):</label>
    <input type="file" name="imagen" accept="image/*">

    <br><br>
    <button type="submit">Actualizar</button>
  </form>

  <p><a href="listar.php">Volver</a></p>
</body>
</html>