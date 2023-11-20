function crearTipoEvento() {
    const form = document.getElementById("formularioTipoEvento");
    form.addEventListener("submit", async function (event) {
        event.preventDefault();
        form.classList.add("was-validated");

        if (!form.checkValidity()) {
            event.stopPropagation();
        } else {
            const formData = new FormData(this);
            try {
                const response = await axios.post("/api/tipo-evento", formData);
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
                if(response.data.mensaje === 'El tipo de evento ya existe'){
                    const inputNombre = document.getElementById("nombreTipoEvento")  
                    inputNombre.classList.remove("is-valid")
                    inputNombre.classList.remove("is-invalid")    
                }else{
                    form.classList.remove("was-validated");
                    form.reset();
                    window.location.href = "/admin/tipos-de-evento";
                }
            } catch (error) {
                mostrarAlerta("Error", "Hubo un error al guardar el tipo de evento", "danger");
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", crearTipoEvento);

