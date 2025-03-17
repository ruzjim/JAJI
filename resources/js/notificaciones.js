document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".btn-edit-notification");
    const updateRoute = document.getElementById("updateMessageRoute").getAttribute("data-route");
    const saveButton = document.getElementById("saveNotificationBtn");
    let selectedId = null;

    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            selectedId = this.getAttribute("data-id");
            const mensaje = this.getAttribute("data-mensaje");

            document.getElementById("editNotificationId").value = selectedId;
            document.getElementById("editMensaje").value = mensaje;
        });
    });

    saveButton.addEventListener("click", function () {
        const id = document.getElementById("editNotificationId").value;
        const mensaje = document.getElementById("editMensaje").value;

        fetch(updateRoute.replace(":id", id), {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ Mensaje: mensaje })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert("Error al actualizar el mensaje.");
            }
        })
        .catch(error => console.error("Error:", error));
    });
});
