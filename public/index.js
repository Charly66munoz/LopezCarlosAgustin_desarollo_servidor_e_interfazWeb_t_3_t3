//
let divEdit = document.querySelectorAll(".edit");
let editButtons = document.querySelectorAll(".editButton");

editButtons.forEach(editButton => {
    editButton.addEventListener("click", (event) => {
        const button = event.target;
        const fila = button.closest("tr");
        const isEditing = fila.dataset.editing === "true";

        const allTd = fila.querySelectorAll("td");

        allTd.forEach((element) => {
            const esBoton = element.contains(button);

            if (!esBoton) {
                element.classList.toggle("d-none");
            }
        });

        if (!isEditing) {
            button.textContent = "Cancelar";
            button.classList.replace("btn-outline-danger", "btn-outline-secondary");
            fila.dataset.editing = "true";
        } else {
            button.textContent = "Modificar";
            button.classList.replace("btn-outline-secondary", "btn-outline-danger");
            fila.dataset.editing = "false";
        }
    });
});