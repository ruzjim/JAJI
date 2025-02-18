document.addEventListener("DOMContentLoaded", function () {
    console.log("Testing JS")
    document.querySelectorAll(".btn-change-state").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            
            let productId = this.getAttribute("data-id");
            let routeTemplate = document.getElementById("stateChangeRoute").getAttribute("data-route");
            let route = routeTemplate.replace(":id", productId);
            
            document.getElementById("confirmChangeButton").setAttribute("href", route);
        });
    });
});
