const productosPorPagina = 5;
let productosFiltrados = [];
let paginaActual = 1;

// Función para mostrar productos paginados
function mostrarPagina(pagina) {
  const inicio = (pagina - 1) * productosPorPagina;
  const fin = inicio + productosPorPagina;

  productosFiltrados.forEach((producto, index) => {
    producto.style.display = (index >= inicio && index < fin) ? 'block' : 'none';
  });

  // Actualizar botones de paginación
  document.querySelectorAll('.pagina-btn').forEach(btn => btn.classList.remove('active'));
  const btnActiva = document.querySelector(`.pagina-btn[data-pagina="${pagina}"]`);
  if (btnActiva) btnActiva.classList.add('active');

  paginaActual = pagina;
}

// Función para aplicar filtro
function aplicarFiltro(categoria) {
  const productos = document.querySelectorAll('.producto');
  productosFiltrados = [];

  productos.forEach(producto => {
    const cat = producto.getAttribute('data-categoria');
    const subcat = producto.getAttribute('data-subcategoria');
    const visible = (categoria === 'todos' || cat.includes(categoria) || subcat.includes(categoria));
    producto.style.display = 'none';

    if (visible) productosFiltrados.push(producto);
  });

  generarBotonesPaginacion();
  mostrarPagina(1);
}

// Generar botones según cantidad de productos filtrados
function generarBotonesPaginacion() {
  const contenedor = document.querySelector('.paginacion');
  contenedor.innerHTML = '';

  const totalPaginas = Math.ceil(productosFiltrados.length / productosPorPagina);

  for (let i = 1; i <= totalPaginas; i++) {
    const boton = document.createElement('button');
    boton.classList.add('pagina-btn');
    boton.textContent = i;
    boton.setAttribute('data-pagina', i);

    if (i === 1) boton.classList.add('active');

    boton.addEventListener('click', () => {
      mostrarPagina(i);
    });

    contenedor.appendChild(boton);
  }
}

// Asignar eventos a los filtros
document.querySelectorAll('.filtros-menu button').forEach(boton => {
  boton.addEventListener('click', () => {
    const categoria = boton.getAttribute('data-filtro');
    aplicarFiltro(categoria);
  });
});

// Inicializar con todos
aplicarFiltro('todos');