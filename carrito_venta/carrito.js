// Lista de imágenes del mismo producto (diferentes ángulos)
const imagenesProducto = [
    { imagen: "../img/Camisa1.webp" },
    { imagen: "../img/Camisa2.jpg" },
    { imagen: "../img/Camisa3.jpg" }
];
// Esto es para evitar que el usuario arrastre las imágenes y las suelte en otro lugar
document.querySelectorAll('img').forEach(img => {
  img.addEventListener('dragstart', event => {
    event.preventDefault();
  });
});
function inicializar() {
    cargarCarrito(); // Solo funciones del carrito
    actualizarTotales();
    actualizarContador();

    const btnAplicar = document.querySelector(".boton-aplicar");
    const btnPagar = document.querySelector(".boton-pagar");

    if (btnAplicar) btnAplicar.addEventListener("click", aplicarDescuento);
    if (btnPagar) btnPagar.addEventListener("click", procesarPago);
}

document.addEventListener("DOMContentLoaded", inicializar);



// Precio único del producto
const precioProducto = 200000;

// Variables globales
let indiceActual = 0;

function cargarCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const contenedor = document.getElementById('contenedor-productos');
    
    contenedor.innerHTML = carrito.map((producto, index) => `
        <div class="item-carrito">
            <img src="${producto.imagen}" alt="${producto.nombre}"/>
            <div class="info-producto">
                <h3>${producto.nombre}</h3>
                <p>Talla: ${producto.talla}</p>
                <p class="precio">$${producto.precio.toLocaleString()}</p>
                <button class="btn-eliminar" data-id="${producto.id}">Eliminar</button>
            </div>
        </div>
    `).join(''); 

    // Añade los listeners para los botones de eliminar
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', eliminarProducto);
    });
}

function eliminarProducto(e) {
    const id = e.target.dataset.id;
    let carrito = JSON.parse(localStorage.getItem('carrito'));
    
    carrito = carrito.filter(producto => producto.id !== id);
    localStorage.setItem('carrito', JSON.stringify(carrito));
    
    cargarCarrito();
    actualizarTotales();
    actualizarContador();
}

function actualizarTotales() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const subtotal = carrito.reduce((sum, producto) => sum + producto.precio, 0);
    
    document.getElementById('subtotal').textContent = subtotal.toLocaleString();
    document.getElementById('total').textContent = subtotal.toLocaleString();
    document.getElementById('contador-carrito').textContent = carrito.length;
}

// Modificar función aplicarDescuento para trabajar con el total
async function aplicarDescuento() {
    const codigo = document.getElementById('codigoDescuento').value.trim();
    const mensaje = document.getElementById('mensajeDescuento');
    const subtotal = parseFloat(document.getElementById('subtotal').textContent.replace(/\./g, ''));

    if (!codigo) {
        mensaje.textContent = "Ingrese un código válido";
        return;
    }

    try {
        const response = await fetch('descuentos.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ codigo })
        });
        
        const data = await response.json();
        
        if (data.success) {
            const descuento = subtotal * (data.porcentaje / 100);
            const total = subtotal - descuento;
            
            document.getElementById('total').textContent = total.toLocaleString();
            mensaje.textContent = `Descuento del ${data.porcentaje}% aplicado (-$${descuento.toLocaleString()})`;
            mensaje.style.color = '#00b5b5';
            
            sessionStorage.setItem('descuentoAplicado', JSON.stringify({
                codigo,
                porcentaje: data.porcentaje,
                descuentoAplicado: descuento
            }));
        } else {
            mensaje.textContent = data.mensaje;
            mensaje.style.color = 'red';
            sessionStorage.removeItem('descuentoAplicado');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Actualizar el contador en todas las páginas
function actualizarContador() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    document.querySelectorAll('#contador-carrito').forEach(element => {
        element.textContent = carrito.length;
    });
}


// Procesar pago
async function procesarPago() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    if (carrito.length === 0) {
        alert("Tu carrito está vacío.");
        return;
    }
    if (!usuarioID) {
        alert("Debes iniciar sesión para procesar el pago.");
        return;
    }

    try {
        const response = await fetch('guardar_historial.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id_cliente: usuarioID, 
                productos: carrito
            })
        });

        const data = await response.json();
        if (data.success) {
            alert("Compra guardada en historial correctamente.");
            localStorage.removeItem('carrito');
            actualizarContador();
            window.location.reload();
        } else {
            alert("Error al guardar el historial: " + data.error);
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Error al procesar el pago.");
    }
}

function agregarAlCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    const producto = {
        id: Date.now().toString(),
        nombre: document.querySelector(".datos h2")?.textContent.trim() || "Producto sin nombre",
        talla: document.querySelector("select[name='talla']")?.value || "Única",
        precio: precioProducto,
        imagen: imagenesProducto[indiceActual].imagen
    };

    carrito.push(producto);
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarContador();
    alert(" Producto añadido al carrito");
}

 