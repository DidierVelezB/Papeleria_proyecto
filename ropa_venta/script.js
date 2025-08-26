document.querySelectorAll('.btn-add').forEach(btn => {
    btn.addEventListener('click', () => {
        const contenedorProducto = btn.closest('.producto');
        const producto = {
            id: btn.dataset.id,
            nombre: btn.dataset.nombre,
            precio: parseInt(btn.dataset.precio),
            // Nota: Ya no existe el campo "talla", se reemplaza por "marca"
            marca: contenedorProducto.querySelector('p:nth-child(5)').innerText.split(': ')[1],
            imagen: contenedorProducto.querySelector('.img-placeholder img').getAttribute('src'),
            categoria: contenedorProducto.dataset.categoria,
            subcategoria: contenedorProducto.dataset.subcategoria
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
        
        if (!existe) {
            carrito.push(producto);
            localStorage.setItem('carrito', JSON.stringify(carrito));
            actualizarContador();
            mostrarMensaje('✅ Producto añadido al carrito');
        } else {
            mostrarMensaje('⚠️ Este producto ya está en el carrito');
        }
    });
});

function actualizarContador() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    document.querySelectorAll('#contador-carrito').forEach(element => {
        element.textContent = carrito.length;
    });
}

// Inicializar contador al cargar la página
document.addEventListener('DOMContentLoaded', actualizarContador);
