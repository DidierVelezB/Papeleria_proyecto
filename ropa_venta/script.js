document.querySelectorAll('.btn-add').forEach(btn => {
    btn.addEventListener('click', () => {
        const contenedorProducto = btn.closest('.producto');
        const producto = {
            id: btn.dataset.id,
            nombre: btn.dataset.nombre,
            precio: parseInt(btn.dataset.precio),
            marca: contenedorProducto.querySelector('p:nth-child(5)').innerText.split(': ')[1],
            imagen: contenedorProducto.querySelector('.img-placeholder img').getAttribute('src'),
            categoria: contenedorProducto.dataset.categoria,
            subcategoria: contenedorProducto.dataset.subcategoria,
            cantidad: 1 //campo cantidad
        };

        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        // Guardar historial de clics
        let historial = JSON.parse(localStorage.getItem('productosClickeados')) || [];
        if (!historial.some(item => item.id.toString() === producto.id.toString())) {
            historial.push(producto);
            localStorage.setItem('productosClickeados', JSON.stringify(historial));
        }

        // Verificar si el producto ya está en el carrito
        const existe = carrito.some(item => item.id.toString() === producto.id.toString());
        
        // Función para mostrar mensajes
        function mostrarMensaje(texto) {
            const mensaje = document.getElementById('mensaje');
            mensaje.textContent = texto;
            mensaje.classList.add('mostrar');
            setTimeout(() => mensaje.classList.remove('mostrar'), 2000);
        }
        
        const index = carrito.findIndex(item => item.id.toString() === producto.id.toString());

        if (index === -1) {
            carrito.push(producto);
        } else {
            carrito[index].cantidad += 1;
        }
        localStorage.setItem('carrito', JSON.stringify(carrito));
        actualizarContador();
        mostrarMensaje('Producto añadido al carrito exitosamente');
    });
});

function actualizarContador() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const totalUnidades = carrito.reduce((sum, item) => sum + (item.cantidad || 0), 0);
    document.querySelectorAll('#contador-carrito').forEach(element => {
        element.textContent = totalUnidades;
    });
}

// Inicializar contador al cargar la página
document.addEventListener('DOMContentLoaded', actualizarContador);
