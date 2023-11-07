function crearTipoEvento() {
    const form = document.getElementById("formularioTipoEvento");
    form.addEventListener("submit", async function (event) {
        event.preventDefault();
        form.classList.add("was-validated");

        if (!form.checkValidity()) {
            event.stopPropagation();
        } else {
            const formData = new FormData(this);
            console.log("Se esta creando algo");
            try {
                const response = await axios.post("/api/tipo-evento", formData);
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
                form.classList.remove("was-validated");
                form.reset();
            } catch (error) {
                mostrarAlerta("Error", "Hubo un error al guardar el tipo de evento", "danger");
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", crearTipoEvento);

