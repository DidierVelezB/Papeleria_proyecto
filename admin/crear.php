<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') { die('Acceso denegado'); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo producto</title>
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
  <h1>Crear producto</h1>

  <form action="guardar_producto.php" method="POST" enctype="multipart/form-data">
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Descripción:</label>
    <textarea name="descripcion"></textarea>

    <label>Precio (solo números):</label>
    <input type="number" step="0.01" name="precio" required>

    <!-- Categoría -->
    <label>Categoría:</label>
    <select name="categoria" id="categoria" required>
        <option value="">Seleccione una categoría</option>
        <option value="Escritura y Dibujo">Escritura y Dibujo</option>
        <option value="Material Artístico">Material Artístico</option>
        <option value="Papelería Básica">Papelería Básica</option>
        <option value="Oficina y Organización">Oficina y Organización</option>
        <option value="Manualidades">Manualidades</option>
        <option value="Material Educativo">Material Educativo</option>
        <option value="Juegos y Recreación">Juegos y Recreación</option>
        <option value="Decoración y Eventos">Decoración y Eventos</option>
        <option value="Embalaje">Embalaje</option>
        <option value="Material para Impresión">Material para Impresión</option>
    </select>

    <!-- Subcategoría -->
    <label>Subcategoría:</label>
    <select name="subcategoria" id="subcategoria" required>
        <option value="">Seleccione una subcategoría</option>
    </select>

    <!-- Tipo -->
    <label>Tipo:</label>
    <select name="tipo" id="tipo" required>
        <option value="">Seleccione un tipo</option>
    </select>

    <!-- Marca -->
    <label>Marca:</label>
    <select name="marca" id="marca" required>
        <option value="">Seleccione una marca</option>
    </select>

    <!-- Presentación -->
    <label>Presentación:</label>
    <select name="presentacion" id="presentacion" required>
        <option value="">Seleccione una presentación</option>
    </select>

    <label>Imagen:</label>
    <input type="file" name="imagen" accept="image/*" required>

    <br><br>
    <button type="submit">Guardar</button>
  </form>

  <p><a href="administracion.php">Volver al inicio</a></p>

  <script>
    // Relación entre categorías y sus subcategorías
    const subcategorias = {
      "Escritura y Dibujo": ["Bolígrafos y Esferos", "Lápices", "Portaminas", "Marcadores", "Micropuntas", "Carboncillos y Artísticos"],
      "Material Artístico": ["Temperas", "Acuarelas", "Óleos y Acrílicos", "Pinceles", "Plastilinas", "Vinilos"],
      "Papelería Básica": ["Blocks y Cuadernos", "Cartulinas", "Cartón Paja", "Papeles Especiales"],
      "Oficina y Organización": ["Grapadoras", "Perforadoras", "Clip's y Ganchos", "Cintas", "Carpetas y Organizadores"],
      "Manualidades": ["Tijeras y Cutter", "Pegantes", "Siliconas", "Materiales para Maquetas", "Sellos y Troqueles"],
      "Material Educativo": ["Geometría", "Tajalápices", "Borradores", "Correctores"],
      "Juegos y Recreación": ["Juegos de Mesa", "Rompecabezas", "Material Didáctico"],
      "Decoración y Eventos": ["Escarchas y Brillos", "Moñas y Lazos", "Material para Piñatas", "Elementos para Fiestas"],
      "Embalaje": ["Cintas de Embalaje", "Bolsas y Empaques", "Material de Protección"],
      "Material para Impresión": ["Cintas para Registradoras", "Tintas", "Sellos y Fechadores"]
    };

    // Relación de tipos, marcas y presentaciones según subcategoría
    const detalles = {
      "Lápices": {
        tipos: ["Grafito HB", "2B", "4B", "Colores", "Jumbo", "Bicolor"],
        marcas: ["Faber Castell", "Kores", "Mirado"],
        presentaciones: ["Unidad", "Caja x12", "Caja x24"]
      },
      "Bolígrafos y Esferos": {
        tipos: ["Kilométricos 100", "Kilométricos 300", "Retráctil", "Con tapa", "Gel"],
        marcas: ["BIC", "Papermate", "Pelikan", "Offi-esco"],
        presentaciones: ["Unidad", "Paquete x10", "Caja x50"]
      },
      "Temperas": {
        tipos: ["Escolares", "Profesionales"],
        marcas: ["Payasito", "Parchesitos", "Pelikan"],
        presentaciones: ["Unidad", "Caja x12"]
      }
      // ...puedes seguir llenando para las demás subcategorías
    };

    const categoriaSelect = document.getElementById("categoria");
    const subcatSelect = document.getElementById("subcategoria");
    const tipoSelect = document.getElementById("tipo");
    const marcaSelect = document.getElementById("marca");
    const presSelect = document.getElementById("presentacion");

    // Cuando cambia la categoría -> cargar subcategorías
    categoriaSelect.addEventListener("change", function() {
      const seleccion = this.value;
      subcatSelect.innerHTML = "<option value=''>Seleccione una subcategoría</option>";
      tipoSelect.innerHTML = "<option value=''>Seleccione un tipo</option>";
      marcaSelect.innerHTML = "<option value=''>Seleccione una marca</option>";
      presSelect.innerHTML = "<option value=''>Seleccione una presentación</option>";

      if (subcategorias[seleccion]) {
        subcategorias[seleccion].forEach(sc => {
          let opt = document.createElement("option");
          opt.value = sc;
          opt.textContent = sc;
          subcatSelect.appendChild(opt);
        });
      }
    });

    // Cuando cambia la subcategoría -> cargar tipos, marcas y presentaciones
    subcatSelect.addEventListener("change", function() {
      const seleccion = this.value;
      tipoSelect.innerHTML = "<option value=''>Seleccione un tipo</option>";
      marcaSelect.innerHTML = "<option value=''>Seleccione una marca</option>";
      presSelect.innerHTML = "<option value=''>Seleccione una presentación</option>";

      if (detalles[seleccion]) {
        detalles[seleccion].tipos.forEach(t => {
          let opt = document.createElement("option");
          opt.value = t;
          opt.textContent = t;
          tipoSelect.appendChild(opt);
        });
        detalles[seleccion].marcas.forEach(m => {
          let opt = document.createElement("option");
          opt.value = m;
          opt.textContent = m;
          marcaSelect.appendChild(opt);
        });
        detalles[seleccion].presentaciones.forEach(p => {
          let opt = document.createElement("option");
          opt.value = p;
          opt.textContent = p;
          presSelect.appendChild(opt);
        });
      }
    });
  </script>
</body>
</html>
