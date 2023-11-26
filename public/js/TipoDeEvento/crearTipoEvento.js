const form = document.getElementById("formularioTipoEvento");
const botonCancelar = document.getElementById("cancelarBoton")
const inputNombre = document.getElementById("nombreTipoEvento")  
const mensajeNombre = document.getElementById("mensajeNombre")
const inputDescripcion = document.getElementById("detalleTipoEvento")
let nombreAnterior = ''

const crearTipoEvento = (formData) => {
    //Si el tipo de evento existe entonces se guarda este valor y servirá para la validación
    nombreAnterior = inputNombre.value
    axios.post("/api/tipo-evento", formData)
    .then(function(response){
        const mensaje = response.data.mensaje
        const nombreIgual = 'El tipo de evento ya existe'
        mostrarAlerta(
            "Éxito",
            mensaje,
            response.data.error ? "danger" : "success"
        );
        /**Si existe un tipo de evento con el mismo nombre, se mantiene los datos del formulario**/
        if(mensaje === nombreIgual){
            inputNombre.classList.remove("is-valid")
            inputNombre.classList.add("is-invalid")    
            inputDescripcion.classList.add("is-valid")
            mensajeNombre.textContent = 'El tipo de evento ya existe'
        }else{
            form.querySelectorAll(".form-control, .form-select").forEach(
                (Element) => {
                    Element.classList.remove("is-valid");
                }
            );
            form.reset();
            setTimeout(()=>{
                window.location.href = "/admin/tipos-de-evento";
            },1800);
        }   
    }).catch(function(error){
        mostrarAlerta("Error", "Hubo un error al guardar el tipo de evento", "danger");
    })
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

function validarNombreRepetido(){
    //Validaciones antes de que se guarde el nombre repetido
    if(nombreAnterior === ''){
        if(inputNombre.value === ''){
            inputNombre.classList.remove("is-valid");
            inputNombre.classList.add("is-invalid");
            mensajeNombre.textContent = "El nombre no puede estar vacío.";
        }else{
            inputNombre.classList.remove("is-invalid");
            inputNombre.classList.add("is-valid");
        }
    }else{
        if(inputNombre.value !== nombreAnterior && inputNombre.value !== '') {
            inputNombre.classList.remove("is-invalid");
            inputNombre.classList.add("is-valid");
            mensajeNombre.textContent = "";
        }else {
            if (inputNombre.value === "") {
                inputNombre.classList.remove("is-valid");
                inputNombre.classList.add("is-invalid");
                mensajeNombre.textContent = "El nombre no puede estar vacío.";
            } else {
                inputNombre.classList.remove("is-valid");
                inputNombre.classList.add("is-invalid");
                mensajeNombre.textContent = "El tipo de evento ya existe";
            }
        }
    }
}

inputNombre.addEventListener("input",validarNombreRepetido );
inputNombre.addEventListener("change",validarNombreRepetido );

function quitarValidacion(){
    form.querySelectorAll(".form-control, .form-select").forEach(
        (Element) => {
            Element.classList.remove("is-valid");
            Element.classList.remove("is-invalid");
        }
    );
}

