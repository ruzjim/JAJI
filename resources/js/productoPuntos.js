document.addEventListener("DOMContentLoaded", function () {
    console.log("ProductoPuntos JS Loaded");

    document.querySelectorAll(".btn-change-state").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            let idProductoPunto = this.getAttribute("data-id");
            let routeTemplate = document.getElementById("stateChangeRoute").getAttribute("data-route");
            let route = routeTemplate.replace(":id", idProductoPunto);

            // Actualizar el enlace del botón "Confirmar"
            document.getElementById("confirmChangeButton").setAttribute("href", route);
        });
    });
});
