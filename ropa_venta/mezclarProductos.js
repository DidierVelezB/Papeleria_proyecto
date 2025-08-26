// Nuevo contenido para mezclarProductos.js
function mezclarProductos() {
  const contenedor = document.querySelector('.productos-grid');
  const productos = Array.from(contenedor.children);
  
  // Almacenar orden original para paginación
  window.productosOriginales = [...productos];

  // Algoritmo de mezcla (Fisher-Yates)
  for (let i = productos.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [productos[i], productos[j]] = [productos[j], productos[i]];
  }

  // Reordenar DOM
  productos.forEach(producto => contenedor.appendChild(producto));
  contenedor.style.visibility = 'visible';
}