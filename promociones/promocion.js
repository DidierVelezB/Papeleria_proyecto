// === LIMPIAR HISTORIAL ===
function limpiarHistorial() {
  localStorage.removeItem('productosClickeados');
  const contenedor = document.getElementById('recomendaciones');
  contenedor.innerHTML = '<p style="color:#777">Historial limpiado. No hay productos recomendados aún.</p>';
  alert('Historial de productos limpiado.');
}

// LISTA DE PRODUCTOS CARGADOS AUTOMÁTICAMENTE
let todosLosProductos = [];

async function cargarProductos() {
  try {
    const response = await fetch('cargar_productos.php');
    if (!response.ok) throw new Error('Error al cargar el catálogo');
    todosLosProductos = await response.json();
    console.log('Productos cargados:', todosLosProductos.length);
  } catch (error) {
    console.error('Error cargando productos:', error);
  }
}

// === RECOMENDACIONES BASADAS EN HISTORIAL ===
function cargarRecomendaciones() {
  const historial = JSON.parse(localStorage.getItem('productosClickeados')) || [];
  const contenedor = document.getElementById('recomendaciones');
  contenedor.innerHTML = '';

  if (historial.length === 0) {
    contenedor.innerHTML = '<p style="color:#777">No hay productos recomendados aún.</p>';
    return;
  }

  // 1. Contar frecuencias de categorías (categoria-subcategoria)
  const categoriaContador = {};
  historial.forEach(p => {
    const categoria = `${p.categoria}-${p.subcategoria}`;
    categoriaContador[categoria] = (categoriaContador[categoria] || 0) + 1;
  });

  // 2. Ordenar categorías más vistas
  const categoriasOrdenadas = Object.entries(categoriaContador)
    .sort((a, b) => b[1] - a[1])
    .map(item => item[0]);

  // 3. Obtener IDs de productos ya vistos
  const idsVistos = historial.map(p => p.id.toString());

  // 4. Generar recomendaciones por prioridad
  const sugerencias = [];
  const maxRecomendaciones = 4;
  let recomendacionesRestantes = maxRecomendaciones;

  for (const categoria of categoriasOrdenadas) {
    if (recomendacionesRestantes <= 0) break;

    const [cat, subcat] = categoria.split('-');
    const productosFiltrados = todosLosProductos.filter(p =>
      p.categoria === cat &&
      p.subcategoria === subcat &&
      !idsVistos.includes(p.id.toString())
    );

    const proporcion = categoriaContador[categoria] / historial.length;
    const cantidad = Math.max(1, Math.floor(proporcion * maxRecomendaciones));

    sugerencias.push(...productosFiltrados.slice(0, Math.min(cantidad, recomendacionesRestantes)));
    recomendacionesRestantes = maxRecomendaciones - sugerencias.length;
  }

  // 5. Completar con otros productos si faltan
  if (sugerencias.length < maxRecomendaciones) {
    const disponibles = todosLosProductos.filter(p =>
      !idsVistos.includes(p.id.toString()) &&
      !sugerencias.some(s => s.id === p.id)
    );

    sugerencias.push(...disponibles.slice(0, maxRecomendaciones - sugerencias.length));
  }

  // 6. Mostrar recomendaciones
  if (sugerencias.length === 0) {
    contenedor.innerHTML = '<p style="color:#777">No se encontraron productos recomendados.</p>';
    return;
  }

  sugerencias.slice(0, maxRecomendaciones).forEach(producto => {
    const item = document.createElement('div');
    item.className = 'producto-sugerido';
    item.innerHTML = `
      <h3>${producto.nombre}</h3>
      <img src="../${producto.imagen}" alt="${producto.nombre}" />
      <p><strong>Categoría:</strong> ${producto.categoria}</p>
      <p><strong></strong> ${producto.subcategoria}</p>
      <p><strong></strong> ${producto.marca}</p>
      <p class="precio">$${producto.precio.toLocaleString()}</p>
    `;
    contenedor.appendChild(item);
  });
}

// === INICIALIZAR ===
document.addEventListener('DOMContentLoaded', async () => {
  await cargarProductos();
  cargarRecomendaciones();
});
