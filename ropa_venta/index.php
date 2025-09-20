<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tienda Principal</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
  <div id="mensaje"></div>
  <div class="nav-left">
    <div class="dropdown">
      <a href="../perfil/index.php">Mi Perfil</a>
      <div class="dropdown-content">
        <a href="../reportes/index.php">Reportes</a>
        <a href="../soporte_tecnico/index.php">Soporte Técnico</a>
      </div>
    </div>
    <a href="../promociones/index.php">Promociones</a>
    <span class="saludo-usuario">
    <?php echo "¡Hola, " . $_SESSION['usuario'] . '!'; ?>
    </span>
  </div>

  <div class="nav-right">
    <a href="../carrito_venta/index.php" class="btn-carrito" title="Carrito">
    🛒 <span id="contador-carrito">0</span>
    </a>
    <button class="logout-btn" onclick="window.location.href='../logout.php'">Cerrar Sesión</button>
  </div>
</header>

<main>
  <aside class="filtros-dropdown">
    <div class="filtros-dropdown-content">
      <button class="filtro-btn">Filtros</button>
      <div class="filtros-menu">
        <button data-filtro="todos">Todos</button>


        <div class="submenu">
          <span>ESCRITURA Y DIBUJO</span>
          <button data-filtro="Bolígrafos y Esferos">Bolígrafos y Esferos</button>
          <button data-filtro="Lápices">Lápices</button>
          <button data-filtro="Portaminas">Portaminas</button>
          <button data-filtro="Marcadores">Marcadores</button>
          <button data-filtro="Micropuntas">Micropuntas</button>
        </div>

        <div class="submenu">
          <span>MATERIAL ARTÍSTICO</span>
          <button data-filtro="Temperas">Temperas</button>
          <button data-filtro="Acuarelas">Acuarelas</button>
          <button data-filtro="Óleos y Acrílicos">Óleos y Acrílicos</button>
          <button data-filtro="Pinceles">Pinceles</button>
          <button data-filtro="Plastilinas">Plastilinas</button>
        </div>

        <div class="submenu">
          <span>PAPELERÍA BÁSICA</span>
          <button data-filtro="Blocks y Cuadernos">Blocks y Cuadernos</button>
          <button data-filtro="Cartulinas">Cartulinas</button>
          <button data-filtro="Cartón Paja">Cartón Paja</button>
          <button data-filtro="Papeles Especiales">Papeles Especiales</button>
        </div>



      </div>
    </div>
  </aside>

  <section class="productos-grid">
     <?php
        include '../conexion_bd.php';
        $sql = "SELECT * FROM producto";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $imgPath = $row['imagen'];
                if (strpos($imgPath, '/') === 0) {
                    $imgPath = ltrim($imgPath, '/');
                }
                $imgPath = '../' . $imgPath;
                
                if (!file_exists($imgPath)) {
                    $imgPath = '../img/placeholder.jpg';
                }

                echo '
                  <div class="producto" data-categoria="'.$row['categoria'].'" data-subcategoria="'.$row['subcategoria'].'">
                    <div class="img-placeholder">
                      <img src="'.$imgPath.'" 
                          alt="'.htmlspecialchars($row['nombre']).'" 
                          style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                      <div class="info">
                        <h3>'.htmlspecialchars($row['nombre']).'</h3>
                        <p>'.htmlspecialchars($row['descripcion']).'</p>
                        <p>Tipo: '.htmlspecialchars($row['tipo']).'</p>
                        <p>Marca: '.htmlspecialchars($row['marca']).'</p>
                        <p>Cantidad: '.htmlspecialchars($row['presentacion']).'</p>
                        <p class="precio">$'.number_format($row['precio'], 0, ",", ".").'</p>
                        <button class="btn-add"
                            data-id="'.$row['id'].'"
                            data-nombre="'.htmlspecialchars($row['nombre'], ENT_QUOTES).'"
                            data-descripcion="'.htmlspecialchars($row['descripcion'], ENT_QUOTES).'"
                            data-precio="'.$row['precio'].'"
                            data-tipo="'.htmlspecialchars($row['tipo'], ENT_QUOTES).'"
                            data-marca="'.htmlspecialchars($row['marca'], ENT_QUOTES).'"
                            data-presentacion="'.htmlspecialchars($row['presentacion'], ENT_QUOTES).'"
                            data-imagen="'.$imgPath.'">Añadir al carrito</button>
                      </div>
                    </div>
                  ';
            }
        } else {
            echo "<p>No hay productos disponibles.</p>";
        }
        $conexion->close();
     ?>
  </section>

  <div class="paginacion">
    <button class="pagina-btn" data-pagina="1">1</button>
    <button class="pagina-btn" data-pagina="2">2</button>
    <button class="pagina-btn" data-pagina="3">3</button>
    <button class="pagina-btn" data-pagina="4">4</button>
    <button class="pagina-btn" data-pagina="5">5</button>
  </div>
</main>

<script>
document.querySelectorAll('img').forEach(img => {
  img.setAttribute('loading', 'lazy');
});
</script>
<script src="filtro.js"></script>
<script src="script.js"></script>
<script src="n_paginas.js"></script>
<script src="mezclarProductos.js"></script>
</body>
</html>