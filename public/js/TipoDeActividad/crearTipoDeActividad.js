function crearTipoDeActividad() {
    const form = document.getElementById("formularioTipoActividad");
    form.addEventListener("submit", async function (event) {
        event.preventDefault();
        form.classList.add("was-validated");

        if (!form.checkValidity()) {
            event.stopPropagation();
        } else {
            const formData = new FormData(this);
            try {
                const response = await axios.post("/api/tipo-actividad", formData);
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
                form.classList.remove("was-validated");
                form.reset();
                window.location.href = "/admin/tipos-de-actividad";
            } catch (error) {
                mostrarAlerta("Error", "Error al guardar el tipo de actividad", "danger");
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", crearTipoDeActividad);

