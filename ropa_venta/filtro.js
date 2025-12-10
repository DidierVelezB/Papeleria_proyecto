document.querySelectorAll('.filtros-menu button').forEach(boton => {
  boton.addEventListener('click', function() {
    // Remover clase activa de todos los botones
    document.querySelectorAll('.filtros-menu button').forEach(btn => {
      btn.classList.remove('filtro-activo');
    });
    // Agregar clase activa al botón clickeado
    this.classList.add('filtro-activo');
    
    const categoria = this.getAttribute('data-filtro');
    const productos = document.querySelectorAll('.producto');

    productos.forEach(producto => {
      const cat = producto.getAttribute('data-categoria');
      const subcat = producto.getAttribute('data-subcategoria');

      if (categoria === 'todos' || cat.includes(categoria) || subcat.includes(categoria)) {
        producto.style.display = 'block';
        producto.style.animation = 'aparecer 0.5s ease forwards';
      } else {
        producto.style.animation = 'desaparecer 0.3s ease forwards';
        setTimeout(() => {
          producto.style.display = 'none';
        }, 300);
      }
    });
  });
});


const style = document.createElement('style');
style.textContent = `
  @keyframes aparecer {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  @keyframes desaparecer {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(20px); }
  }
  
  .filtro-activo {
    background-color: #002d2b !important;
    color: white !important;
  }
`;
document.head.appendChild(style);