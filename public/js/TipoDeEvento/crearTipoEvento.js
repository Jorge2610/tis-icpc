const form = document.getElementById("formularioTipoEvento");
const botonCancelar = document.getElementById("cancelarBoton")
const inputNombre = document.getElementById("nombreTipoEvento")  
const mensaje = document.getElementById("mensajeNombre")
const inputDescripcion = document.getElementById("detalleTipoEvento")

const crearTipoEvento = (formData) => {
    const nombreAnterior = inputNombre.value
    axios.post("/api/tipo-evento", formData)
    .then(function(response){
        const mensaje = response.data.mensaje
        const nombreIgual = 'El tipo de evento ya existe'
        mostrarAlerta(
            "Éxito",
            mensaje,
            response.data.error ? "danger" : "success"
        );
        if(mensaje === nombreIgual){
            inputNombre.classList.remove("is-valid")
            inputNombre.classList.add("is-invalid")    
            mensaje.innerHTML = "El tipo de evento ya existe"
            inputDescripcion.classList.add("is-valid")
        }else{
            form.querySelectorAll(".form-control, .form-select").forEach(
                (Element) => {
                    Element.classList.remove("is-valid");
                }
            );
            form.reset();
            window.location.href = "/admin/tipos-de-evento";
        }   
    }).catch(function(error){
        mostrarAlerta("Error", "Hubo un error al guardar el tipo de evento", "danger");
    })

    inputNombre.addEventListener("input", function () {
        if (inputNombre.value !== nombreAnterior) {
            inputNombre.classList.remove("is-invalid");
            inputNombre.classList.add("is-valid");
        }else{
            inputNombre.classList.remove("is-valid");
            inputNombre.classList.add("is-invalid");
        }
    });
}

form.addEventListener("submit",(event) =>{
    event.preventDefault()
    form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
        Element.dispatchEvent(new Event("change"));
    });
    if(validar()){
        const formData = new FormData(form);
        crearTipoEvento(formData);
    }
})

const validar = () => {
    return form.querySelector(".is-invalid") === null;
};

//Agregar validación a los inputs
form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
    Element.addEventListener("change", () => {
        if (Element.hasAttribute("required") && Element.value === "") {
            Element.classList.remove("is-valid");
            Element.classList.add("is-invalid");
        } else {
            Element.classList.remove("is-invalid");
            Element.classList.add("is-valid");
        }
    });
});

function quitarValidacion(){
    form.querySelectorAll(".form-control, .form-select").forEach(
        (Element) => {
            Element.classList.remove("is-valid");
            Element.classList.remove("is-invalid");
        }
    );
}

