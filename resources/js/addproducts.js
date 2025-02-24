document.addEventListener("DOMContentLoaded", function () {
    let listaProductos = document.getElementById("ListaProductos");
    let escaner = document.getElementById("escaner");
    let limpiarBtn = document.querySelector(".head-text .text-danger"); // Seleccionamos el botón "Limpiar"
    
    escaner.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Evita que el formulario se envíe si está dentro de uno
            let codigoBarras = escaner.value.trim(); // Obtener el código ingresado

            if (codigoBarras === "") return;

            // Buscar el producto en la variable productos por código de barras
            let producto = productos.find(p => p.barcode == codigoBarras);

            if (producto) {
                agregarProductoALista(producto);
                actualizarContador();
            } else {
                alert("Producto no encontrado");
            }

            escaner.value = ""; // Limpiar input después de ingresar
        }
    });

    function agregarProductoALista(producto) {
        // Verificar si el producto ya está en la lista
        let productoExistente = document.querySelector(`#ListaProductos .producto[data-id="${producto.Id_Producto}"]`);

        if (productoExistente) {
            let cantidadInput = productoExistente.querySelector(".cantidad");
            cantidadInput.value = parseInt(cantidadInput.value) + 1; // Sumar cantidad
        } else {
            // Crear nuevo elemento de producto en la lista
            let productoHTML = `
                <div class="product-list d-flex align-items-center justify-content-between producto" data-id="${producto.Id_Producto}">
                    <div class="d-flex align-items-center product-info">
                        <a href="javascript:void(0);" class="img-bg">
                            <img src="${producto.imagen || 'https://icons.veryicon.com/png/o/miscellaneous/fu-jia-intranet/product-29.png'}" alt="Producto">
                        </a>
                        <div class="info">
                            <span>${producto.barcode}</span>
                            <h6><a href="javascript:void(0);">${producto.Nombre_Producto}</a></h6>
                            <p>₡ ${producto.Precio_Venta}</p>
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
            feather.replace(); // Refrescar los iconos de Feather
        }
    }

    // Agregar event listener para eliminar productos al hacer clic en el basurero
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
            if (nuevaCantidad >= 1) { // Asegurarse de que no baje de 1
                cantidadInput.value = nuevaCantidad; // Disminuir cantidad
            }
            actualizarContador(); // Actualizar el contador
        }
    });

    // Función para limpiar la lista de productos con SweetAlert
    limpiarBtn.addEventListener("click", function () {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esto eliminará todos los productos de la lista!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar todo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Limpiar todos los productos de la lista
                listaProductos.innerHTML = ''; // Eliminar todos los elementos dentro de la lista
                actualizarContador(); // Actualizar el contador después de limpiar
                Swal.fire(
                    '¡Eliminado!',
                    'Todos los productos han sido eliminados.',
                    'success'
                );
            }
        });
    });

    function actualizarContador() {
        let cantidadProductos = 0;
    
        // Recorremos todos los productos en la lista
        let productosEnLista = listaProductos.querySelectorAll(".producto");
    
        // Para cada producto, sumamos la cantidad
        productosEnLista.forEach(producto => {
            let cantidad = parseInt(producto.querySelector(".cantidad").value) || 0; // Obtenemos la cantidad
            cantidadProductos += cantidad; // Sumamos la cantidad
        });
    
        // Actualizamos el contador con el total de artículos
        contadorArticulos.textContent = cantidadProductos;
    }
});
