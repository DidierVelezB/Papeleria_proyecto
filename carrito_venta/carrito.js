

// Evitar que las imágenes sean arrastrables
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
    
    contenedor.innerHTML = carrito.map((producto) => `
    <div class="item-carrito">
        <img src="${producto.imagen}" alt="${producto.nombre}"/>
        <div class="info-producto">
            <h3>${producto.nombre}</h3>
            <p class="descripcion">${producto.descripcion || "Sin descripción disponible"}</p>
            <p><strong>Tipo:</strong> ${producto.tipo || "-"}</p>
            <p><strong>Marca:</strong> ${producto.marca || "-"}</p>
            <p><strong>Presentación:</strong> ${producto.presentacion || "-"}</p>
            <p class="cantidad-container">
                <button class="btn-cantidad btn-menos" data-id="${producto.id}">−</button>
                <span class="cantidad-num">${producto.cantidad}</span>
                <button class="btn-cantidad btn-mas" data-id="${producto.id}">+</button>
            </p>
            <p class="precio-total">$${(producto.precio * producto.cantidad).toLocaleString()}</p>
            <button class="btn-eliminar" data-id="${producto.id}">Eliminar</button>
        </div>
    </div>
`).join('');
    // Listeners de cantidad
    document.querySelectorAll('.btn-mas').forEach(btn => {
        btn.addEventListener('click', () => cambiarCantidad(btn.dataset.id, +1));
    });

    document.querySelectorAll('.btn-menos').forEach(btn => {
        btn.addEventListener('click', () => cambiarCantidad(btn.dataset.id, -1));
    });

    // Listeners de eliminar
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', eliminarProducto);
    });


    // Listener de eliminar (repetido para asegurar funcionalidad tras recarga)
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
function cambiarCantidad(id, delta) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    carrito = carrito.map(producto => {
        if (producto.id.toString() === id.toString()) {
            producto.cantidad = Math.max(1, (producto.cantidad || 1) + delta);
        }
        return producto;
    });
    localStorage.setItem('carrito', JSON.stringify(carrito));
    cargarCarrito();      
    actualizarTotales(); 
    actualizarContador();
}


function actualizarTotales() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const subtotal = carrito.reduce((sum, producto) => 
        sum + (producto.precio * (producto.cantidad || 1)), 0
    );
    
    document.getElementById('subtotal').textContent = subtotal.toLocaleString();
    document.getElementById('total').textContent = subtotal.toLocaleString();

    // contador = suma de todas las unidades
    const totalUnidades = carrito.reduce((sum, producto) => sum + (producto.cantidad || 0), 0);
    document.getElementById('contador-carrito').textContent = totalUnidades;
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


// Procesar pago con Stripe
async function procesarPago() {
  const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

  if (carrito.length === 0) {
    alert("Tu carrito está vacío.");
    return;
  }

  // Calcular total en COP
  const total = carrito.reduce((sum, producto) =>
    sum + (producto.precio * (producto.cantidad || 1)), 0
  );

  try {
    const response = await fetch("../pagos/create_checkout.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ total }),
    });

    const session = await response.json();

    if (session.id) {
      const stripe = Stripe("pk_test_51SIcarR3GZGsYtdhekumiTFhOoSNAoCwGAUpvVuWOIUr2JOByqqIsancamwpih7c3e2tXZvgqHgJbTif3dAvXFTe000hDq6nd5");
      await stripe.redirectToCheckout({ sessionId: session.id });
    } else {
      alert("Error al crear la sesión de pago: " + (session.error || "Desconocido"));
      console.error(session);
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Hubo un problema al procesar el pago.");
  }
}




function agregarAlCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    const producto = {
        id: Date.now().toString(),
        nombre: document.querySelector(".datos h2")?.textContent.trim() || "Producto sin nombre",
        precio: precioProducto, // Precio fijo
        cantidad: 1,
        imagen: imagenesProducto[indiceActual].imagen
    };

    carrito.push(producto);
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarContador();
    alert(" Producto añadido al carrito");
}

 