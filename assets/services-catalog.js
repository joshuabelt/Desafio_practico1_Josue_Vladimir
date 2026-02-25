let carrito = [];

    function agregarAlCarrito(id, nombre, precio) {
        const index = carrito.findIndex(item => item.id === id);
        if (index > -1) {
            carrito[index].cantidad++;
        } else {
            carrito.push({ id, nombre, precio, cantidad: 1 });
        }
        actualizarUI();
    }

    function actualizarUI() {
        const lista = document.getElementById('carrito-lista');
        const inputJson = document.getElementById('items_json');
        
        if (carrito.length === 0) {
            lista.innerHTML = '<p>No hay servicios</p>';
            return;
        }

        lista.innerHTML = carrito.map((item, i) => `
            <div style="font-size: 0.9em; margin-bottom: 5px; display: flex; justify-content: space-between;">
                <span>${item.nombre} x ${item.cantidad}</span>
                <span>$${(item.precio * item.cantidad).toFixed(2)}</span>
            </div>
        `).join('');

        inputJson.value = JSON.stringify(carrito);
    }



    
    
    function agregarAlCarrito(id, nombre, precio) {
    const index = carrito.findIndex(item => item.id === id);
    
    if (index > -1) {
        carrito[index].cantidad++;
    } else {
        carrito.push({ id, nombre, precio, cantidad: 1 });
    }
    
    // Llamamos a la actualización de la UI
    actualizarUI();
    
    // Opcional: Pequeña animación de scroll hacia el formulario
    document.getElementById('datos-cliente').scrollIntoView({ behavior: 'smooth' });
}

function actualizarUI() {
    const lista = document.getElementById('servicios-seleccionados'); // El div de la derecha
    const inputJson = document.getElementById('items_json');
    let total = 0;

    if (carrito.length === 0) {
        lista.innerHTML = '<p class="text-muted">No hay servicios seleccionados</p>';
        return;
    }

    // Generamos el HTML 
    lista.innerHTML = carrito.map((item) => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        return `
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>${item.nombre} x ${item.cantidad}</span>
                <span>$${subtotal.toFixed(2)}</span>
            </div>
        `;
    }).join('');

    // Actualizamos el campo oculto para PHP
    inputJson.value = JSON.stringify(carrito);
    
   
}

// Función para mostrar el modal
function verCarrito() {
    const modal = document.getElementById('miModalCarrito');
    const detalle = document.getElementById('detalle-carrito-modal');
    
    if (carrito.length === 0) {
        detalle.innerHTML = "<p style='text-align:center; padding:20px;'>Tu carrito está vacío.</p>";
    } else {
        let totalGeneral = 0; // Variable para acumular el total
        
        let tabla = `
            <table style='width:100%; border-collapse: collapse;'>
                <thead>
                    <tr style='border-bottom: 2px solid #ddd;'>
                        <th style='text-align:left; padding: 8px;'>Servicio</th>
                        <th style='text-align:center; padding: 8px;'>Cant.</th>
                        <th style='text-align:right; padding: 8px;'>Subtotal</th>
                    </tr>
                </thead>
                <tbody>`;
        
        // El bucle SOLO genera las filas de los productos
        carrito.forEach(item => {
            const subtotal = item.precio * item.cantidad;
            totalGeneral += subtotal; // Sumamos al total general
            
            tabla += `
                <tr style='border-bottom: 1px solid #eee;'>
                    <td style='padding: 8px;'>${item.nombre}</td>
                    <td style='text-align:center; padding: 8px;'>${item.cantidad}</td>
                    <td style='text-align:right; padding: 8px;'>$${subtotal.toFixed(2)}</td>
                </tr>`;
        });
        
        // Cerramos el cuerpo y agregamos UNA SOLA FILA para el total al final
        tabla += `
                </tbody>
                <tfoot>
                    <tr style='font-weight: bold; background-color: #f9f9f9;'>
                        <td colspan='2' style='text-align:right; padding: 12px;'>TOTAL:</td>
                        <td style='text-align:right; padding: 12px;'>$${totalGeneral.toFixed(2)}</td>
                    </tr>
                </tfoot>
            </table>`;
        
        detalle.innerHTML = tabla;
    }
    
    modal.style.display = "block";
}
function cerrarModal() {
    document.getElementById('miModalCarrito').style.display = "none";
}

function irAFormulario() {
    cerrarModal();
    // Hace scroll suave hasta el input de Nombre para que el usuario empiece a llenar
    document.getElementsByName('Nombre completo')[0].focus();
    document.getElementById('datos-cliente').scrollIntoView({ behavior: 'smooth' });
}


function agregarAlCarrito(id, nombre, precio) {
    const index = carrito.findIndex(item => item.id === id);
    
    if (index > -1) {
        if (carrito[index].cantidad < 10) {
            carrito[index].cantidad++;
        } else {
            alert("Máximo 10 unidades por servicio");
        }
    } else {
        carrito.push({ id, nombre, precio, cantidad: 1 });
    }
    actualizarUI();
}

function cambiarCantidad(id, delta) {
    const index = carrito.findIndex(item => item.id === id);
    if (index !== -1) {
        const nuevaCantidad = carrito[index].cantidad + delta;
        if (nuevaCantidad >= 1 && nuevaCantidad <= 10) {
            carrito[index].cantidad = nuevaCantidad;
        }
        actualizarUI();
    }
}

function eliminarItem(id) {
    carrito = carrito.filter(item => item.id !== id);
    actualizarUI();
}

function vaciarCarrito() {
    if(confirm("¿Estás seguro de vaciar el carrito?")) {
        carrito = [];
        actualizarUI();
    }
}

function actualizarUI() {
    const lista = document.getElementById('servicios-seleccionados');
    const contador = document.getElementById('carrito-count');
    const inputJson = document.getElementById('items_json');
    const btnVaciar = document.getElementById('btn-vaciar');
    
    let totalGeneral = 0;
    let totalItems = 0;

    if (carrito.length === 0) {
        lista.innerHTML = '<p class="text-muted">No hay servicios</p>';
        contador.innerText = "0";
        btnVaciar.style.display = "none";
        return;
    }

    lista.innerHTML = carrito.map(item => {
        const subtotal = item.precio * item.cantidad;
        totalGeneral += subtotal;
        totalItems += item.cantidad;
        
        return `
            <div class="item-carrito" style="border-bottom: 1px solid #eee; padding: 10px 0;">
                <div style="display:flex; justify-content: space-between; align-items:center;">
                    <span style="font-weight:bold;">${item.nombre}</span>
                    <button class="btn-del" onclick="eliminarItem(${item.id})">×</button>
                </div>
                <div style="display:flex; justify-content: space-between; align-items:center; margin-top:5px;">
                    <div class="controles-cantidad">
                        <button onclick="cambiarCantidad(${item.id}, -1)">-</button>
                        <span style="margin: 0 10px;">${item.cantidad}</span>
                        <button onclick="cambiarCantidad(${item.id}, 1)">+</button>
                    </div>
                    <span>$${subtotal.toFixed(2)}</span>
                </div>
            </div>
        `;
    }).join('');

    contador.innerText = totalItems;
    inputJson.value = JSON.stringify(carrito);
    btnVaciar.style.display = "block";
    
    
}

async function generarCotización() {
    if (carrito.length === 0) return alert("El carrito está vacío");

    // Calculamos el total antes de enviar
    const totalGeneral = carrito.reduce((acc, item) => acc + (item.precio * item.cantidad), 0);

    const payload = {
        cliente: {
            nombre: document.querySelector('[placeholder="Nombre completo"]').value,
            empresa: document.querySelector('[placeholder="Empresa"]').value,
            email: document.querySelector('[placeholder="Email"]').value,
            telefono: document.querySelector('[placeholder="Teléfono"]').value
        },
        items: carrito,
        total: totalGeneral
    };

    try {
        const response = await fetch('process-quote.php', {
            method: 'POST',
            body: JSON.stringify(payload)
        });

        const res = await response.json();
        
        if (res.success) {
            alert("Cotización generada: " + res.codigo);
            // Limpiamos carrito y vamos al historial
            carrito = [];
            window.location.href = 'lista-cotizaciones.php'; 
        }
    } catch (e) {
        console.error("Error al guardar:", e);
    }
}
