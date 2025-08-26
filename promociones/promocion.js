function cargarRecomendaciones() {
    const historial = JSON.parse(localStorage.getItem('productosClickeados')) || [];
    const contenedor = document.getElementById('recomendaciones');
    contenedor.innerHTML = '';

    if (historial.length === 0) {
        contenedor.innerHTML = '<p style="color:#777">No hay productos recomendados aún.</p>';
        return;
    }

    // 1. Contar frecuencias de categorías (tipo-género)
    const categoriaContador = {};
    
    historial.forEach(p => {
        const categoria = `${p.tipo}-${p.genero}`;
        categoriaContador[categoria] = (categoriaContador[categoria] || 0) + 1;
    });

    // 2. Ordenar categorías por frecuencia (de mayor a menor)
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
        
        const [tipo, genero] = categoria.split('-');
        const productosFiltrados = todosLosProductos.filter(p => 
            p.tipo === tipo && 
            p.genero === genero &&
            !idsVistos.includes(p.id.toString())
        );

        // Calcular cuántas recomendaciones tomar de esta categoría (proporcional)
        const proporcion = categoriaContador[categoria] / historial.length;
        const cantidad = Math.max(1, Math.floor(proporcion * maxRecomendaciones));
        
        sugerencias.push(...productosFiltrados.slice(0, Math.min(cantidad, recomendacionesRestantes)));
        recomendacionesRestantes = maxRecomendaciones - sugerencias.length;
    }

    // 5. Completar con otras categorías si faltan recomendaciones
    if (sugerencias.length < maxRecomendaciones) {
        const productosDisponibles = todosLosProductos.filter(p => 
            !idsVistos.includes(p.id.toString()) &&
            !sugerencias.some(s => s.id === p.id)
        );
        
        sugerencias.push(...productosDisponibles.slice(0, maxRecomendaciones - sugerencias.length));
    }

    // 6. Mostrar las recomendaciones
    if (sugerencias.length === 0) {
        contenedor.innerHTML = '<p style="color:#777">No se encontraron productos recomendados.</p>';
        return;
    }

    sugerencias.slice(0, maxRecomendaciones).forEach(producto => {
        const item = document.createElement('div');
        item.className = 'producto-sugerido';
        item.innerHTML = `
            <h3>${producto.nombre}</h3>
            <img src="${producto.imagen}" alt="${producto.nombre}" />
            <p>${producto.tipo} - ${producto.genero}</p>
            <p class="precio">$${producto.precio.toLocaleString()}</p>
        `;
        contenedor.appendChild(item);
    });
}
function limpiarHistorial() {
    localStorage.removeItem('productosClickeados');
    const contenedor = document.getElementById('recomendaciones');
    contenedor.innerHTML = '<p style="color:#777">Historial limpiado. No hay productos recomendados aún.</p>';
    alert('Historial de productos limpiado.');
}


// Lista de todos los productos disponibles 
const todosLosProductos = [
  {
    "id": "1",
    "nombre": "Camiseta Básica",
    "precio": 35000,
    "tipo": "camisa",
    "genero": "hombre",
    "imagen": "/img/Camisas/hombre/Camisa1.jpg"
  },
  {
    "id": "2",
    "nombre": "Camiseta Premium",
    "precio": 45000,
    "tipo": "camisa",
    "genero": "hombre",
    "imagen": "/img/Camisas/hombre/Camisa2.jpg"
  },
  {
    "id": "3",
    "nombre": "Camiseta Deportiva",
    "precio": 55000,
    "tipo": "camisa",
    "genero": "hombre",
    "imagen": "/img/Camisas/hombre/Camisa3.jpg"
  },
  {
    "id": "4",
    "nombre": "Camiseta Gato",
    "precio": 39000,
    "tipo": "camisa",
    "genero": "hombre",
    "imagen": "/img/Camisas/hombre/Camisa4.jpg"
  },
  {
    "id": "5",
    "nombre": "Camiseta Clasic",
    "precio": 40000,
    "tipo": "camisa",
    "genero": "hombre",
    "imagen": "/img/Camisas/hombre/Camisa5.jpg"
  },
  {
    "id": "6",
    "nombre": "Camiseta Happy",
    "precio": 41000,
    "tipo": "camisa",
    "genero": "mujer",
    "imagen": "/img/Camisas/mujer/Camisa1.jpg"
  },
  {
    "id": "7",
    "nombre": "Camiseta Roja",
    "precio": 42000,
    "tipo": "camisa",
    "genero": "mujer",
    "imagen": "/img/Camisas/mujer/Camisa2.jpg"
  },
  {
    "id": "8",
    "nombre": "Camiseta Soft",
    "precio": 43000,
    "tipo": "camisa",
    "genero": "mujer",
    "imagen": "/img/Camisas/mujer/Camisa3.jpg"
  },
  {
    "id": "9",
    "nombre": "Camiseta Vogue",
    "precio": 44000,
    "tipo": "camisa",
    "genero": "mujer",
    "imagen": "/img/Camisas/mujer/Camisa4.jpg"
  },
  {
    "id": "10",
    "nombre": "Camiseta Palma",
    "precio": 45000,
    "tipo": "camisa",
    "genero": "mujer",
    "imagen": "/img/Camisas/mujer/Camisa5.jpg"
  },
  {
    "id": "11",
    "nombre": "Pantalón Elegante",
    "precio": 60000,
    "tipo": "pantalon",
    "genero": "hombre",
    "imagen": "/img/Pantalones/hombre/pantalon1.jpg"
  },
  {
    "id": "12",
    "nombre": "Pantalón White",
    "precio": 61000,
    "tipo": "pantalon",
    "genero": "hombre",
    "imagen": "/img/Pantalones/hombre/pantalon2.jpg"
  },
  {
    "id": "13",
    "nombre": "Jean",
    "precio": 62000,
    "tipo": "pantalon",
    "genero": "hombre",
    "imagen": "/img/Pantalones/hombre/pantalon3.jpg"
  },
  {
    "id": "14",
    "nombre": "Pantalon Jogger",
    "precio": 63000,
    "tipo": "pantalon",
    "genero": "hombre",
    "imagen": "/img/Pantalones/hombre/pantalon4.jpg"
  },
  {
    "id": "15",
    "nombre": "Pantalón Safari",
    "precio": 64000,
    "tipo": "pantalon",
    "genero": "hombre",
    "imagen": "/img/Pantalones/hombre/pantalon5.jpg"
  },
  {
    "id": "16",
    "nombre": "Pantalón Jogger",
    "precio": 65000,
    "tipo": "pantalon",
    "genero": "mujer",
    "imagen": "/img/Pantalones/mujer/pantalon1.jpg"
  },
  {
    "id": "17",
    "nombre": "Pantalón negro",
    "precio": 66000,
    "tipo": "pantalon",
    "genero": "mujer",
    "imagen": "/img/Pantalones/mujer/pantalon2.jpg"
  },
  {
    "id": "18",
    "nombre": "Pantalón Jogger Gris",
    "precio": 67000,
    "tipo": "pantalon",
    "genero": "mujer",
    "imagen": "/img/Pantalones/mujer/pantalon3.jpg"
  },
  {
    "id": "19",
    "nombre": "Jean Overzise",
    "precio": 68000,
    "tipo": "pantalon",
    "genero": "mujer",
    "imagen": "/img/Pantalones/mujer/pantalon4.jpg"
  },
  {
    "id": "20",
    "nombre": "Pantalón A rallas",
    "precio": 69000,
    "tipo": "pantalon",
    "genero": "mujer",
    "imagen": "/img/Pantalones/mujer/pantalon5.jpg"
  },
  {
    "id": "21",
    "nombre": "Chaqueta Cuero",
    "precio": 80000,
    "tipo": "chaqueta",
    "genero": "hombre",
    "imagen": "/img/Chaquetas/hombre/chaqueta1.jpg"
  },
  {
    "id": "22",
    "nombre": "Chaqueta Biker",
    "precio": 81000,
    "tipo": "chaqueta",
    "genero": "hombre",
    "imagen": "/img/Chaquetas/hombre/chaqueta2.jpg"
  },
  {
    "id": "23",
    "nombre": "Chaqueta Elegante",
    "precio": 82000,
    "tipo": "chaqueta",
    "genero": "hombre",
    "imagen": "/img/Chaquetas/hombre/chaqueta3.jpg"
  },
  {
    "id": "24",
    "nombre": "Chaqueta overzise",
    "precio": 83000,
    "tipo": "chaqueta",
    "genero": "hombre",
    "imagen": "/img/Chaquetas/hombre/chaqueta4.jpg"
  },
  {
    "id": "25",
    "nombre": "Chaqueta Modelo 5",
    "precio": 84000,
    "tipo": "chaqueta",
    "genero": "hombre",
    "imagen": "/img/Chaquetas/hombre/chaqueta5.jpg"
  },
  {
    "id": "26",
    "nombre": "Chaqueta Modelo 6",
    "precio": 85000,
    "tipo": "chaqueta",
    "genero": "mujer",
    "imagen": "/img/Chaquetas/mujer/chaqueta1.jpg"
  },
  {
    "id": "27",
    "nombre": "Chaqueta Modelo 7",
    "precio": 86000,
    "tipo": "chaqueta",
    "genero": "mujer",
    "imagen": "/img/Chaquetas/mujer/chaqueta2.jpg"
  },
  {
    "id": "28",
    "nombre": "Chaqueta Modelo 8",
    "precio": 87000,
    "tipo": "chaqueta",
    "genero": "mujer",
    "imagen": "/img/Chaquetas/mujer/chaqueta3.jpg"
  },
  {
    "id": "29",
    "nombre": "Chaqueta Modelo 9",
    "precio": 88000,
    "tipo": "chaqueta",
    "genero": "mujer",
    "imagen": "/img/Chaquetas/mujer/chaqueta4.jpg"
  },
  {
    "id": "30",
    "nombre": "Chaqueta Modelo 10",
    "precio": 89000,
    "tipo": "chaqueta",
    "genero": "mujer",
    "imagen": "/img/Chaquetas/mujer/chaqueta5.jpg"
  },
  {
    "id": "31",
    "nombre": "Falda Modelo 1",
    "precio": 45000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda1.jpg"
  },
  {
    "id": "32",
    "nombre": "Falda Modelo 2",
    "precio": 46000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda2.jpg"
  },
  {
    "id": "33",
    "nombre": "Falda Modelo 3",
    "precio": 47000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda3.jpg"
  },
  {
    "id": "34",
    "nombre": "Falda Modelo 4",
    "precio": 48000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda4.jpg"
  },
  {
    "id": "35",
    "nombre": "Falda Modelo 5",
    "precio": 49000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda5.jpg"
  },
  {
    "id": "36",
    "nombre": "Falda Modelo 6",
    "precio": 50000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda6.jpg"
  },
  {
    "id": "37",
    "nombre": "Falda Modelo 7",
    "precio": 51000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda7.jpg"
  },
  {
    "id": "38",
    "nombre": "Falda Modelo 8",
    "precio": 52000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda8.jpg"
  },
  {
    "id": "39",
    "nombre": "Falda Modelo 9",
    "precio": 53000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda9.jpg"
  },
  {
    "id": "40",
    "nombre": "Falda Modelo 10",
    "precio": 54000,
    "tipo": "falda",
    "genero": "mujer",
    "imagen": "/img/faldas/falda10.jpg"
  },
  {
    "id": "41",
    "nombre": "Blusa Elegante",
    "precio": 52000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa1.jpg"
  },
  {
    "id": "42",
    "nombre": "Blusa Casual",
    "precio": 48000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa2.jpg"
  },
  {
    "id": "43",
    "nombre": "Blusa Estampada",
    "precio": 50000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa3.jpg"
  },
  {
    "id": "44",
    "nombre": "Blusa Formal",
    "precio": 55000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa4.jpg"
  },
  {
    "id": "45",
    "nombre": "Blusa de Seda",
    "precio": 65000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa5.jpg"
  },
  {
    "id": "46",
    "nombre": "Blusa Casual Verano",
    "precio": 40000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa6.jpg"
  },
  {
    "id": "47",
    "nombre": "Blusa con Encaje",
    "precio": 53000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa7.jpg"
  },
  {
    "id": "48",
    "nombre": "Blusa de Algodón",
    "precio": 42000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa8.jpg"
  },
  {
    "id": "49",
    "nombre": "Blusa Floral",
    "precio": 47000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa9.jpg"
  },
  {
    "id": "50",
    "nombre": "Blusa de Manga Larga",
    "precio": 50000,
    "tipo": "blusa",
    "genero": "mujer",
    "imagen": "/img/Blusas/blusa10.jpg"
  }
]