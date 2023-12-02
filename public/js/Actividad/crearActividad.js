const form = document.getElementById("formularioActividad");
const inputNombre = document.getElementById('nombreActividad')
const mensajeNombre = document.getElementById('mensajeNombre')
let nombreAnterior = ''

/**PETICIONES a AXIOS**/
/**CREAR ACTIVIDAD**/
const crearActividad = (formData) => {
    nombreAnterior = inputNombre.value
    axios.post("/api/actividad", formData)
    .then(function(response){
        const mensaje = response.data.mensaje
        const nombreIgual = 'La actividad ya existe'
        mostrarAlerta(
            "Éxito",
            mensaje,
            response.data.error ? "danger" : "success"
        );
        if(mensaje === nombreIgual){
            inputNombre.classList.remove('is-valid')
            inputNombre.classList.add('is-invalid')
            mensajeNombre.textContent = 'La actividad ya existe'
        }else{
            form.querySelectorAll(".form-control, .form-select").forEach(
                (Element) => {
                    Element.classList.remove("is-valid");
                }
            );
            form.reset();
            if(response.data.error != "danger"){
                setTimeout(()=>{
                    window.location.href = "/admin/actividad";
               },1800);
            }
        }
    })
    .catch (function(error) {
        mostrarAlerta("Error", "Hubo un error al guardar la actividad", "danger");
    });
}

form.addEventListener("submit", (event) => {
    event.preventDefault();
    form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
        Element.dispatchEvent(new Event("change"));
    });
    if(validar()){
        const formData = new FormData(form);
        crearActividad(formData);
    }
    $("#modalConfirmacion").modal("hide");
});

const validar = () => {
    return form.querySelector(".is-invalid") === null;
};

/**Validacion para el input nombre**/
inputNombre.addEventListener("input", validarNombreRepetido);
inputNombre.addEventListener("change", validarNombreRepetido);

function validarNombreRepetido() {
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
         if (inputNombre.value !== nombreAnterior && inputNombre.value !== '') {
             inputNombre.classList.remove("is-invalid");
             inputNombre.classList.add("is-valid");
         }else if(inputNombre.value == ''){
             inputNombre.classList.remove("is-valid");
             inputNombre.classList.add("is-invalid");
             mensajeNombre.textContent = 'El nombre no puede estar vacío.'
         }else{
             inputNombre.classList.remove("is-valid");
             inputNombre.classList.add("is-invalid");
             mensajeNombre.textContent = 'La actividad ya existe.'
         }
    }
 }

function quitarValidacion(){
    form.querySelectorAll(".form-control, .form-select").forEach(
        (Element) => {
            Element.classList.remove("is-valid");
            Element.classList.remove("is-invalid");
        }
    );
    window.location.href = "/admin/actividad";
}

