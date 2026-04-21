//
let divEdit = document.querySelectorAll(".edit");
let editButtons = document.querySelectorAll(".editButton");
let saveButton = document.querySelector(".saveButton")
let noChange = document.querySelector(".noChange");

editButtons.forEach(editButton => {
    editButton.addEventListener("click", (event) => {
        event.preventDefault()
        const button = event.target;
        const fila = button.closest("tr");
        //El dataset lo uso para setear la edicion del boton, 
        const isEditing = fila.dataset.editing === "true";

        const allTd = fila.querySelectorAll("td");

        allTd.forEach((element) => {
            const esBoton = element.contains(button);

            if (!esBoton) {
              element.classList.toggle("d-none");
            }
        });

        if (!isEditing) {
            saveButton.classList.toggle("d-none")
            button.textContent = "Cancelar";
            button.classList.replace("btn-outline-warning", "btn-outline-secondary");
            fila.dataset.editing = "true";
        } else {
            saveButton.classList.toggle("d-none");
            button.textContent = "Modificar";
            button.classList.replace("btn-outline-secondary", "btn-outline-warning");
            fila.dataset.editing = "false";
        }
    });
});