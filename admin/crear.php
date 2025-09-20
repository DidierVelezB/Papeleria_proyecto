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
      "Escritura y Dibujo": ["Bolígrafos", "Esferos", "Lápices", "Portaminas", "Marcadores", "Micropuntas", "Carboncillos", "Artísticos"],
      "Material Artístico": ["Temperas", "Acuarelas", "Óleos y Acrílicos", "Pinceles", "Plastilinas", "Vinilos"],
      "Papelería Básica": ["Blocks", "Cuadernos", "Cartulinas", "Cartón Paja", "Papeles Especiales"],
      "Oficina y Organización": ["Grapadoras", "Perforadoras", "Clip's", "Ganchos", "Cintas", "Carpetas y Organizadores"],
      "Manualidades": ["Tijeras", "Cutter", "Pegantes", "Siliconas", "Materiales para Maquetas", "Sellos y Troqueles"],
      "Material Educativo": ["Geometría", "Tajalápices", "Borradores", "Correctores"],
      "Juegos y Recreación": ["Juegos de Mesa", "Rompecabezas", "Material Didáctico"],
      "Decoración y Eventos": ["Escarchas y Brillos", "Moñas y Lazos", "Material para Piñatas", "Elementos para Fiestas"],
      "Embalaje": ["Cintas de Embalaje", "Bolsas", "Empaques", "Material de Protección"],
      "Material para Impresión": ["Cintas para Registradoras", "Tintas", "Sellos y Fechadores"]
    };

    // Relación de tipos, marcas y presentaciones según subcategoría
    const detalles = {
      "Bolígrafos": {
        tipos: ["Kilométricos 100", "Kilométricos 300", "Retráctil", "Con tapa", "Gel"],
        marcas: ["BIC", "Papermate", "Pelikan", "Offi-esco"],
        presentaciones: ["Unidad", "Paquete x10", "Caja x50"]
      },
      "Lápices": {
        tipos: ["Grafito HB", "2B", "4B", "Colores", "Jumbo", "Bicolor"],
        marcas: ["Faber Castell", "Kores", "Mirado"],
        presentaciones: ["Unidad", "Caja x12", "Caja x24"]
      },
      "Portaminas": {
        tipos: ["0.5 mm", "0.7 mm", "1.0 mm"],
        marcas: ["Faber Castell", "Kores", "Staedtler"],
        presentaciones: ["Unidad", "Paquete x2", "Paquete x5", "Paquete x10", "Caja x12"]
      },
      "Marcadores": {
        tipos: ["Punta Fina", "Punta Gruesa", "Resaltadores", "Pizarrón Blanco"],
        marcas: ["Sharpie", "Pilot", "BIC"],
        presentaciones: ["Unidad", "Paquete x4", "Paquete x8"]
      },
      "Micropuntas": {
        tipos: ["0.3 mm", "0.5 mm", "0.7 mm", "1.0 mm"],
        marcas: ["Staedtler", "Faber Castell", "Pentel"],
        presentaciones: ["Unidad", "Paquete x2", "Paquete x5", "Paquete x10"]
      },
      "Carboncillos": {
        tipos: ["Duro", "Medio", "Blandos"],
        marcas: ["Generico", "Conte"],
        presentaciones: ["Unidad", "Set x6", "Set x12"]
      },
      "Artísticos": {
        tipos: ["Grafito", "Carbón", "Pastel", "Acuarela"],
        marcas: ["Generico", "Faber Castell", "Conte"],
        presentaciones: ["Unidad", "Set x6", "Set x12"]
      },
      "Temperas": {
        tipos: ["Escolares", "Profesionales"],
        marcas: ["Payasito", "Parchesitos", "Pelikan"],
        presentaciones: ["Unidad", "Caja x12"]
      },
      "Acuarelas": {
        tipos: ["Pastillas", "Tubos"],
        marcas: ["Pelikan", "Faber Castell", "Kores"],
        presentaciones: ["Set x12", "Set x24"]
      },
      "Oleos y Acrílicos": {
        tipos: ["Óleos", "Acrílicos"],
        marcas: ["Generico", "Faber Castell", "Kores"],
        presentaciones: ["Unidad", "Set x6", "Set x12"]
      },
      "Pinceles": {
        tipos: ["Redondos", "Planos", "Abanico", "Angular"],
        marcas: ["Generico", "Faber Castell", "Kores"],
        presentaciones: ["Unidad", "Set x6", "Set x12"]
      },
      "Plastilinas": {
        tipos: ["Tradicional", "Modelado", "Masa Flexible"],
        marcas: ["Play-Doh", "Genios", "Crayola"],
        presentaciones: ["Unidad", "Set x6", "Set x12"]
      },
      "Vinilos": {
        tipos: ["Adhesivos", "Textiles", "Decorativos"],
        marcas: ["Generico", "3M", "Avery"],
        presentaciones: ["Unidad", "Rollo x5m", "Rollo x10m"]
      },
      "Blocks": {
        tipos: ["Dibujo", "Acuarela", "Esbozo"],
        marcas: ["Canson", "Faber Castell", "Generico"],
        presentaciones: ["Unidad", "Pack x3"]
      },
      "Cuadernos": {
        tipos: ["Rayados", "Cuadriculados", "Lisios", "Mixtos"],
        marcas: ["Scribe", "Norma", "Generico"],
        presentaciones: ["Unidad", "Pack x3", "Pack x5"]
      },
      "Cartulinas": {
        tipos: ["Colores", "Blancas", "Negra"],
        marcas: ["Generico", "Canson"],
        presentaciones: ["Unidad", "Pack x10", "Pack x50"]
      },
      "Cartón Paja": {
        tipos: ["Blanco", "Marrón", "Colores"],
        marcas: ["Generico", "Canson"],
        presentaciones: ["Unidad", "Pack x5", "Pack x10"]
      },
      "Papeles Especiales": {
        tipos: ["Metalizados", "Texturados", "Fotográficos"],
        marcas: ["Generico", "Canson", "HP"],
        presentaciones: ["Unidad", "Pack x10", "Pack x50"]
      },
      "Grapadoras": {
        tipos: ["Manual", "Eléctrica"],
        marcas: ["Generico", "Rapid", "Swingline"],
        presentaciones: ["Unidad"]
      },
      "Perforadoras": {
        tipos: ["2 orificios", "4 orificios", "Multi-orificios"],
        marcas: ["Generico", "Rapid", "Fellowes"],
        presentaciones: ["Unidad"]
      },
      "Clip's": {
        tipos: ["Metálicos", "Plásticos", "Decorativos"],
        marcas: ["Generico", "Offi-esco"],
        presentaciones: ["Pack x100", "Pack x200"]
      },
      "Ganchos": {
        tipos: ["Metálicos", "Plásticos"],
        marcas: ["Generico", "Offi-esco"],
        presentaciones: ["Pack x100", "Pack x200"]
      },
      "Cintas": {
        tipos: ["Transparente", "Embalaje", "Doble Faz", "Masking"],
        marcas: ["Generico", "Scotch", "3M"],
        presentaciones: ["Unidad", "Rollo x50m", "Rollo x100m"]
      },
      "Carpetas y Organizadores": {
        tipos: ["Carpetas Plásticas", "Carpetas de Cartón", "Archivadores"],
        marcas: ["Generico", "Offi-esco", "Scribe"],
        presentaciones: ["Unidad"]
      },
      "Tijeras": {
        tipos: ["Escolares", "Oficina", "Profesionales"],
        marcas: ["Fiskars", "Generico", "Westcott"],
        presentaciones: ["Unidad"]
      },
      "Cutter": {
        tipos: ["Retráctil", "Con Seguro"],
        marcas: ["Generico", "Olfa", "Fiskars"],
        presentaciones: ["Unidad"]
      },
      "Pegantes": {
        tipos: ["En Barra", "Líquido", "Spray", "Silicona"],
        marcas: ["Generico", "Pritt", "3M"],
        presentaciones: ["Unidad"]
      },
      "Siliconas": {
        tipos: ["Fría", "Caliente"],
        marcas: ["Generico", "Bosch", "Black & Decker"],
        presentaciones: ["Unidad"]
      },
      "Materiales para Maquetas": {
        tipos: ["Madera Balsa", "Cartón Pluma", "Espuma"],
        marcas: ["Generico", "Faber Castell"],
        presentaciones: ["Unidad", "Pack x5"]
      },
      "Sellos y Troqueles": {
        tipos: ["Personalizados", "Pre-diseñados"],
        marcas: ["Generico", "Trodat"],
        presentaciones: ["Unidad"]
      },
      "Geometría": {
        tipos: ["Reglas", "Compases", "Escuadras", "Transportadores"],
        marcas: ["Faber Castell", "Staedtler", "Generico"],
        presentaciones: ["Unidad"]
      },
      "Tajalápices": {
        tipos: ["Manual", "Eléctrico"],
        marcas: ["Faber Castell", "Staedtler", "Generico"],
        presentaciones: ["Unidad"]
      },
      "Borradores": {
        tipos: ["Goma Blanca", "Goma de Lápiz", "Goma de Tinta"],
        marcas: ["Faber Castell", "Staedtler", "Generico"],
        presentaciones: ["Unidad", "Pack x3"]
      },
      "Correctores": {
        tipos: ["Líquido", "Cinta"],
        marcas: ["BIC", "Tipp-Ex", "Generico"],
        presentaciones: ["Unidad"]
      },
      "Juegos de Mesa": {
        tipos: ["Estrategia", "Familiares", "Cartas"],
        marcas: ["Hasbro", "Mattel", "Generico"],
        presentaciones: ["Unidad"]
      },
      "Rompecabezas": {
        tipos: ["500 piezas", "1000 piezas", "2000 piezas"],
        marcas: ["Ravensburger", "Generico"],
        presentaciones: ["Unidad"]
      },
      "Material Didáctico": {
        tipos: ["Letras y Números", "Figuras Geométricas", "Mapas"],
        marcas: ["Generico", "Faber Castell"],
        presentaciones: ["Unidad", "Set x6"]
      },
      "Escarchas y Brillos": {
        tipos: ["Finas", "Gruesas", "En Gel"],
        marcas: ["Generico", "Crafter's"],
        presentaciones: ["Unidad", "Pack x3"]
      },
      "Moñas y Lazos": {
        tipos: ["Pre-hechas", "Cintas"],
        marcas: ["Generico", "Offi-esco"],
        presentaciones: ["Unidad", "Pack x5"]
      },
      "Material para Piñatas": {
        tipos: ["Papel Crepé", "Papel China", "Cintas"],
        marcas: ["Generico", "Offi-esco"],
        presentaciones: ["Unidad", "Pack x5"]
      },
      "Cintas de Embalaje": {
        tipos: ["Transparente", "Embalaje", "Doble Faz"],
        marcas: ["Generico", "Scotch", "3M"],
        presentaciones: ["Unidad", "Rollo x50m", "Rollo x100m"]
      },
      "Bolsas": {
        tipos: ["Plásticas", "Papel", "Tela"],
        marcas: ["Generico", "Offi-esco"],
        presentaciones: ["Unidad", "Pack x10", "Pack x50"]
      },
      "Empaques": {
        tipos: ["Cajas", "Sobres", "Tubos"],
        marcas: ["Generico", "Offi-esco"],
        presentaciones: ["Unidad", "Pack x5", "Pack x10"]
      },
      "Material de Protección": {
        tipos: ["Burbuja", "Manila", "Espuma"],
        marcas: ["Generico", "3M"],
        presentaciones: ["Unidad", "Rollo x5m", "Rollo x10m"]
      },
      "Cintas para Registradoras": {
        tipos: ["Térmicas", "No Térmicas"],
        marcas: ["Generico", "Epson", "Casio"],
        presentaciones: ["Unidad", "Pack x5"]
      },
      "Tintas": {
        tipos: ["Tinta para Sellos", "Tinta para Fechadores"],
        marcas: ["Generico", "Trodat"],
        presentaciones: ["Unidad"]
      },
      "Sellos y Fechadores": {
        tipos: ["Personalizados", "Pre-diseñados"],
        marcas: ["Generico", "Trodat"],
        presentaciones: ["Unidad"]
      }
    };
    // Duplicar detalles para "Esferos" igual que "Bolígrafos"
    detalles["Esferos"] = JSON.parse(JSON.stringify(detalles["Bolígrafos"]));
    // detalles["esferos"].marcas.push("Paper Mate");



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
