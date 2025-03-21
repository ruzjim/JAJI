console.log("Hola Mundo");

document.addEventListener("DOMContentLoaded", function () {
    let productosEnCarrito = [];
    let listaProductos = document.getElementById("ListaProductos");
    let escaner = document.getElementById("escaner");
    let limpiarBtn = document.querySelector(".head-text .text-danger"); // Seleccionamos el botón "Limpiar"

    document.querySelectorAll(".producto-card").forEach((card) => {
        card.addEventListener("click", function () {
            let productId = this.getAttribute("data-id"); // Obtiene el ID del producto
            let producto = productos.find((p) => p.Id_Producto == productId); // Busca el producto en la lista

            if (producto) {
                agregarProductoALista(producto); // Agrega el producto a la lista
                actualizarContador(); // Actualiza el contador
            }
        });
    });

    escaner.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Evita que el formulario se envíe si está dentro de uno
            let codigoBarras = escaner.value.trim(); // Obtener el código ingresado

            if (codigoBarras === "") return;

            // Buscar el producto en la variable productos por código de barras
            let producto = productos.find((p) => p.barcode == codigoBarras);

            if (producto) {
                agregarProductoALista(producto);
                actualizarContador();
            } else {
                alert("Producto no encontrado");
            }

            escaner.value = ""; // Limpia input después de ingresar
        }
    });

    $(".cargaElementos").on("click", function () {
        let tbody = document.getElementById("print-receipt-table");
        tbody.innerHTML = ""; // Limpiar el contenido existente

        document.querySelectorAll("#ListaProductos .producto").forEach((productoElemento) => {
            let productId = productoElemento.getAttribute("data-id");
            let producto = productos.find((p) => p.Id_Producto == productId);

            if (producto) {
                let cantidad = parseInt(productoElemento.querySelector(".cantidad").value) || 1;
                let precioDescuento = producto.Precio_Venta - producto.Precio_Venta * (producto.descuento / 100);
                let totalPrecio = precioDescuento * cantidad;

                let filaHTML = `
                    <tr>
                        <td>${producto.Nombre_Producto}</td>
                        <td>₡${producto.Precio_Venta} ${producto.descuento > 0 ? '<span style="color: green;">-' + producto.descuento + '%</span>' : ''} </td>
                        <td>${cantidad}</td>
                        <td class="text-end">₡${totalPrecio.toFixed(2)}</td>
                    </tr>
                `;

                tbody.insertAdjacentHTML("beforeend", filaHTML);
            }
        });
 
        let subtotalCompraRecibo = 0;
        let totalDescuentoRecibo = 0;

        document.querySelectorAll("#ListaProductos .producto").forEach((productoElemento) => {
            let productId = productoElemento.getAttribute("data-id");
            let producto = productos.find((p) => p.Id_Producto == productId);

            if (producto) {
            let cantidad = parseInt(productoElemento.querySelector(".cantidad").value) || 1;
            let totalPrecioSinDescuento = producto.Precio_Venta * cantidad;
            let totalDescuento = (producto.Precio_Venta * (producto.descuento / 100)) * cantidad;
            subtotalCompraRecibo += totalPrecioSinDescuento;
            totalDescuentoRecibo += totalDescuento;
            }
        });

        let subtotalReciboElemento = document.getElementById("subtotalRecibo");
        if (subtotalReciboElemento) {
            subtotalReciboElemento.textContent = "₡ " + subtotalCompraRecibo.toLocaleString();
        }

        let descuentoReciboElemento = document.getElementById("descuentoRecibo");
        if (descuentoReciboElemento) {
            descuentoReciboElemento.textContent = "-₡ " + totalDescuentoRecibo.toLocaleString();
        }

        let totalCompraReciboElemento = document.getElementById("TotalCompraRecibo");
        if (totalCompraReciboElemento) {
            totalCompraReciboElemento.textContent = "₡ " + (subtotalCompraRecibo - totalDescuentoRecibo).toLocaleString();
        }
        // Verificar si hay productos en la lista antes de mostrar el modal
        if (document.querySelectorAll("#ListaProductos .producto").length > 0) {
            let metodoPagoSeleccionado = document.querySelector(".methods .item a.selected");

            if (metodoPagoSeleccionado) {
                $('#print-receipt').modal('show');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Método de pago no seleccionado',
                    text: 'Por favor, seleccione un método de pago antes de imprimir el recibo.',
                });
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No hay productos',
                text: 'No hay productos en la lista para imprimir el recibo.',
            });
        }
    });

    document.getElementById("imprimirRecibo").addEventListener("click", function () {
        let printContents = document.getElementById("reciboaImprimir").outerHTML;
        let originalContents = document.body.innerHTML;

        document.body.innerHTML = `
            <html>
                <head>
                    <title>Recibo</title>
                    <style>
                        /* Aquí puedes agregar estilos personalizados para el PDF */
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            
                            padding: 8px;
                            text-align: left;
                        }
                    </style>
                </head>
                <body>
                    ${printContents}
                </body>
            </html>
        `;

        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Recargar la página para restaurar el contenido original
    });

    document.getElementById("procesarPago").addEventListener("click", function(e) {        
        const metodoPago = document.querySelector('.methods a.selected');
        if (!metodoPago) {
            Swal.fire({
                icon: 'warning',
                title: 'Método de pago no seleccionado',
                text: 'Por favor, seleccione un método de pago antes de imprimir el recibo.',
            });
            return;
        }
        
        const metodoPagoId = parseInt(metodoPago.getAttribute('data-id')) || 0;

    if (metodoPagoId === 0 || metodoPagoId > 3) {
        alert('Método de pago inválido o no seleccionado');
        return;
    }
        
        const productos = Array.from(document.querySelectorAll('#ListaProductos .producto'));
        
        const payload = {
            productos: Array.from(document.querySelectorAll('#ListaProductos .producto')).map(item => ({
                id: parseInt(item.getAttribute('data-id')),
                cantidad: parseInt(item.querySelector('.cantidad').value)
            })),
            metodo_pago_id: parseInt(document.querySelector('.methods a.selected')?.getAttribute('data-id') || 0),
            total: parseFloat(document.getElementById('totalPagar').textContent.replace(/[^\d.]/g, '')),
            cedula: cedulaCliente
        };
        
        console.log('Enviando payload:', payload);
        console.log('Cédula enviada:', payload.cedula);
        
        fetch('/completar-venta', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) { 
                return response.text().then(text => { throw new Error(text) });
            }
            return response.json();
        })
        .then(data => console.log('Respuesta:', data))
        .catch(error => console.error('Error:', error.message));
        
    });


    document.querySelectorAll('.methods a.metodo-pago').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('.methods a.metodo-pago').forEach(el => {
            el.classList.remove('selected');
        });
        this.classList.add('selected');
    });
    });
    

    function agregarProductoALista(producto) {
        // Verificar si el producto ya está en la lista
        let productoExistente = document.querySelector(
            `#ListaProductos .producto[data-id="${producto.Id_Producto}"]`
        );
    
        if (productoExistente) {
            let cantidadInput = productoExistente.querySelector(".cantidad");
            cantidadInput.value = parseInt(cantidadInput.value) + 1; // Sumar cantidad
        } else {
            // Crear nuevo elemento de producto en la lista
            let precioDescuento =
                producto.Precio_Venta -
                producto.Precio_Venta * (producto.descuento / 100);
    
            let productoHTML = `
                <div class="product-list d-flex align-items-center justify-content-between producto" data-id="${producto.Id_Producto}">
                    <div class="d-flex align-items-center product-info">
                        <a href="javascript:void(0);" class="img-bg">
                            <img src="${producto.imagen || 'https://icons.veryicon.com/png/o/miscellaneous/fu-jia-intranet/product-29.png'}" alt="Producto">
                        </a>
                        <div class="info">
                            <span>${producto.barcode}</span>
                            <h6><a href="javascript:void(0);">${producto.Nombre_Producto}</a></h6>
                            ${
                                producto.descuento > 0
                                    ? `<span class="bg-success text-dark bg-opacity-50">₡ ${producto.Precio_Venta} - ${producto.descuento}%</span>`
                                    : ""
                            }
                            <p>₡ ${precioDescuento}</p>
                            <p class="puntos-obtenidos"></p> <!-- Espacio para mostrar puntos obtenidos -->
                        </div>
                    </div>
                    <div class="qty-item text-center">
                        <a href="javascript:void(0);" class="dec"><i data-feather="minus-circle" class="feather-14"></i></a>
                        <input type="text" class="form-control text-center cantidad" value="1">
                        <a href="javascript:void(0);" class="inc"><i data-feather="plus-circle" class="feather-14"></i></a>
                    </div>
                    <div class="d-flex align-items-center action">
                        <a class="btn-icon delete-icon confirm-text" href="javascript:void(0);">
                            <i data-feather="trash-2" class="feather-14"></i>
                        </a>
                    </div>
                </div>
            `;
    
            listaProductos.insertAdjacentHTML("beforeend", productoHTML);
            feather.replace();

            productosEnCarrito.push({
                id: producto.Id_Producto,
                cantidad: 1
            });
        }
    
        fetch(`/producto/${producto.Id_Producto}/puntos`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    puntosProductos.set(producto.Id_Producto, data.puntos_obtenidos);
                    updateTotalPuntos();
                    let productoElement = document.querySelector(
                        `#ListaProductos .producto[data-id="${producto.Id_Producto}"]`
                    );
                    let puntosElement = productoElement.querySelector(".puntos-obtenidos");
                    puntosElement.textContent = `Gana ${data.puntos_obtenidos} puntos`;
                } else {
                    console.log(data.message);
                }
            })
            .catch(error => console.log('Error al obtener puntos:', error));
    
        calcularTotalCompra();
    }

    document.querySelector('#ListaProductos').addEventListener('click', function(e) {
        if (e.target.closest('.delete-icon')) {
            const producto = e.target.closest('.producto');
            const productId = parseInt(producto.getAttribute('data-id'));
            puntosProductos.delete(productId);
            updateTotalPuntos();
        }
    });
    

    // eliminar productos al hacer clic en el basurero
    listaProductos.addEventListener("click", function (event) {
        // Eliminar producto al hacer clic en el basurero
        if (event.target.closest(".delete-icon")) {
            let productoElemento = event.target.closest(".producto"); // Encuentra el contenedor del producto
            if (productoElemento) {
                productoElemento.remove(); // Elimina el producto de la lista
                actualizarContador(); // Actualizar el contador después de eliminar
            }
        }

        // Aumentar cantidad al hacer clic en el botón "+"
        if (event.target.closest(".inc")) {
            let productoElemento = event.target.closest(".producto");
            let cantidadInput = productoElemento.querySelector(".cantidad");
            cantidadInput.value = parseInt(cantidadInput.value) + 1; // Aumentar cantidad
            actualizarContador(); // Actualizar el contador
        }

        // Disminuir cantidad al hacer clic en el botón "-"
        if (event.target.closest(".dec")) {
            let productoElemento = event.target.closest(".producto");
            let cantidadInput = productoElemento.querySelector(".cantidad");
            let nuevaCantidad = parseInt(cantidadInput.value) - 1;
            if (nuevaCantidad >= 1) {
                // Asegurarse de que no baje de 1
                cantidadInput.value = nuevaCantidad; // Disminuir cantidad
            }
            actualizarContador(); // Actualizar el contador
        }
    });

    // Función para limpiar la lista de productos con SweetAlert
    limpiarBtn.addEventListener("click", function () {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡Esto eliminará todos los productos de la lista!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar todo",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Limpiar todos los productos de la lista
                listaProductos.innerHTML = ""; // Eliminar todos los elementos dentro de la lista
                actualizarContador(); // Actualizar el contador después de limpiar
                Swal.fire(
                    "¡Eliminado!",
                    "Todos los productos han sido eliminados.",
                    "success"
                );
            }
        });
    });

    function actualizarContador() {
        let cantidadProductos = 0;

        // Recorremos todos los productos en la lista
        let productosEnLista = listaProductos.querySelectorAll(".producto");

        // Para cada producto, sumamos la cantidad
        productosEnLista.forEach((producto) => {
            let cantidad =
                parseInt(producto.querySelector(".cantidad").value) || 0; // Obtenemos la cantidad
            cantidadProductos += cantidad; // Sumamos la cantidad
        });

        // Actualizamos el contador con el total de artículos
        contadorArticulos.textContent = cantidadProductos;
    }
    // Juan Pa - Código optimizado
    function calcularTotalCompra() {
        let total = 0;
        let totalDescuento = 0; // Juan Pa Aquí: Variable para almacenar el total de descuentos

        // Obtener todos los productos en la lista
        let productosEnLista = document.querySelectorAll(
            "#ListaProductos .producto"
        );

        productosEnLista.forEach((producto) => {
            let cantidad =
                parseInt(producto.querySelector(".cantidad").value) || 1;
            let precioElemento = producto.querySelector("p"); // Tomamos el precio ya calculado
            let precio =
                parseFloat(precioElemento.textContent.replace(/[₡$,]/g, "")) ||
                0;

            // Juan Pa Aquí: Calcular el descuento total
            let precioOriginal =
                parseFloat(
                    producto
                        .querySelector(".bg-success")
                        ?.textContent.split("₡")[1]
                ) || precio;
            let descuentoPorUnidad = precioOriginal - precio;
            totalDescuento += descuentoPorUnidad * cantidad;

            total += precio * cantidad;
        });

        // Actualizar el total en la tabla
        let totalElemento = document.getElementById("totalCompra");
        if (totalElemento) {
            totalElemento.textContent = "₡ " + total.toLocaleString();
        }

        // Juan Pa Aquí: Actualizar el total de descuentos en la tabla
        let descuentoElemento = document.getElementById("totalDescuento");
        if (descuentoElemento) {
            descuentoElemento.textContent =
                "-₡ " + totalDescuento.toLocaleString();
        }
        // Juan Pa Aquí: Actualizar el total a pagar en el botón
        let totalPagarElemento = document.getElementById("totalPagar");
        if (totalPagarElemento) {
            totalPagarElemento.textContent =
                "Total A Pagar: ₡ " + total.toLocaleString();
        }
    }

    // Evento para actualizar total solo cuando cambie la cantidad
    document
        .querySelector("#ListaProductos")
        .addEventListener("input", function (event) {
            if (event.target.classList.contains("cantidad")) {
                calcularTotalCompra();
            }
        });

    // Evento para actualizar total cuando se agregue o elimine un producto
    document
        .querySelector("#ListaProductos")
        .addEventListener("click", function (event) {
            let target = event.target;

            if (
                target.closest(".delete-icon") ||
                target.closest(".inc") ||
                target.closest(".dec")
            ) {
                calcularTotalCompra(); // Se ejecuta inmediatamente sin `setTimeout`
            }
        });

    // Llamar la función al inicio para mostrar el total inicial
    calcularTotalCompra();

    let puntosProductos = new Map();
    let cedulaCliente = null;
    
    // Actualizar puntos al modificar productos
    function updateTotalPuntos() {
        let total = 0;
        document.querySelectorAll('#ListaProductos .producto').forEach(producto => {
            const productId = parseInt(producto.getAttribute('data-id'));
            const cantidad = parseInt(producto.querySelector('.cantidad').value);
            const puntos = puntosProductos.get(productId) || 0;
            total += puntos * cantidad;
        });
        document.getElementById('totalPuntos').textContent = total;
    }
    
    // Manejar modal de puntos
    document.querySelector('.btn-warning').addEventListener('click', () => {
        if (puntosProductos.size > 0) {
            $('#puntosModal').modal('show');
        }
    });
    
    // Validar cédula
    document.getElementById('formPuntos').addEventListener('submit', function(e) {
        e.preventDefault();
        const cedula = document.getElementById('cedula').value.replace(/[^0-9]/g, '');
        
        fetch('/check-user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ cedula })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                cedulaCliente = cedula;
                $('#puntosModal').modal('hide');
            } else {
                Swal.fire('Error', 'Usuario no encontrado', 'error');
            }
        });
    });

    document.getElementById('abrirModalPuntosBtn').addEventListener('click', () => {
        if (puntosProductos.size > 0) {
            $('#puntosModal').modal('show');
        }
    });
});
