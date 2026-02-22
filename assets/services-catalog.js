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