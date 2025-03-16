// totalCompra.js - Calcula el total de la compra en el carrito de compras

document.addEventListener("DOMContentLoaded", function () {
    actualizarTotal(); // Inicializa el total cuando carga la página

    // Escucha eventos de cambio en la cantidad o eliminación de productos
    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-product")) {
            eliminarProducto(event.target);
        }
    });
    
    document.body.addEventListener("input", function (event) {
        if (event.target.classList.contains("product-quantity")) {
            actualizarTotal();
        }
    });
});

function actualizarTotal() {
    let total = 0;
    document.querySelectorAll(".product-row").forEach(row => {
        const price = parseFloat(row.querySelector(".product-price").textContent);
        const quantity = parseInt(row.querySelector(".product-quantity").value, 10);
        total += price * quantity;
    });
    document.getElementById("totalCompra").textContent = `$${total.toFixed(2)}`;
}

function eliminarProducto(button) {
    const row = button.closest(".product-row");
    row.remove();
    actualizarTotal();
}
