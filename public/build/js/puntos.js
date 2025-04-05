document.addEventListener("DOMContentLoaded", function () {
    console.log("Testing JS")
    document.querySelectorAll(".btn-change-state").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            
            let Id_Puntos = this.getAttribute("data-id");
            let routeTemplate = document.getElementById("stateChangeRoute").getAttribute("data-route");
            let route = routeTemplate.replace(":id", Id_Puntos);
            
            document.getElementById("confirmChangeButton").setAttribute("href", route);
        });
    });
});