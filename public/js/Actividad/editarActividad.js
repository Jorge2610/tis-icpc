const form = document.getElementById("formularioActividad");
const inputNombre = document.getElementById('nombreActividad')
const mensajeNombre = document.getElementById('mensajeNombre')
const fechaEventoInicio = document.getElementById("fechaEventoInicio");
const fechaEventoFin = document.getElementById("fechaEventoFin");
const fechaInicio = document.getElementById("fechaInicio");
const fechaFin = document.getElementById("fechaFin");
const mensajeFechaInicio = document.getElementById("mensajeFechaInicio");
const mensajeFechaFin = document.getElementById("mensajeFechaFin");
const switchMensaje = document.getElementById("notificacion")
let nombreAnterior = ''
let valorCheckbox = ""

/**PETICIONES a AXIOS**/
/**EDITAR   ACTIVIDAD**/
const editarActividad = (formData) => {
    const estaActivado = switchMensaje.checked
    valorCheckbox = estaActivado ? "on":
    formData.append("notificacion",valorCheckbox)

    axios.post("/api/actividad/"+formData.get("id"),formData)
    .then(function(response){
        const mensaje = response.data.mensaje
        const nombreIgual = 'La actividad ya existe'
        mostrarAlerta(
            "Éxito",
            mensaje,
            response.data.error ? "danger" : "success"
        );
        if(mensaje === nombreIgual){
            nombreAnterior = inputNombre.value
            inputNombre.classList.remove('is-valid')
            inputNombre.classList.add('is-invalid')
            mensajeNombre.innerHTML = 'La actividad ya existe'
        }else{
            if(response.data.error != "danger"){
                setTimeout(()=>{
                    window.location.href = "/admin/actividad/editar-actividad";
               },1800);
            }
        }
    })
    .catch (function(error) {
        mostrarAlerta("Error", "Hubo un error al editar la actividad", "danger");
    });
    }

form.addEventListener("submit", (event) => {
    event.preventDefault();
    form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
        Element.dispatchEvent(new Event("change"));
    });
    if(validar()){
        form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
            if(Element.disabled)
                Element.disabled=false;            
        });
        const formData = new FormData(form);
        editarActividad(formData); 
    }
    $("#modalConfirmacion").modal("hide");
});

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

/**Validacion para el input nombre**/
inputNombre.addEventListener("input", validarNombreRepetido);
inputNombre.addEventListener("change", validarNombreRepetido);


/**Validaciones para fecha INICIO**/
fechaInicio.addEventListener("change", () => {
    const fechaInicioSeleccionada = new Date(fechaInicio.value);
    const fechaMin = new Date(fechaInicio.min);
    const fechaMax = new Date(fechaInicio.max);
    if(fechaInicio.disabled == false){
        // Verificar si la fecha está dentro del rango permitido
        if(fechaInicioSeleccionada < fechaMin || fechaInicioSeleccionada > fechaMax || (fechaInicio.value > fechaFin.value && fechaFin.value !== '') ) {
            isValid(fechaInicio,false)
            mensajeFechaInicio.innerHTML = "Rango de fechas no válido.";
            deshabilitar()
        }else if(fechaInicio.value == ""){
            isValid(fechaInicio,false)
            mensajeFechaInicio.innerHTML = "Seleccione una fecha y hora.";
            deshabilitar()
        }else {
            //Quitamos todos los mensajes y validamos
            mensajeFechaInicio.innerHTML = "";
            isValid(fechaInicio,true)
            //Ponemos como valor mínimo la fecha inicio de la actividad
            fechaFin.disabled = false
            fechaFin.min = fechaInicio.value;
            fechaFin.dispatchEvent(new Event("change"));
        }
    }else{
        isValid(fechaInicio,true)
    }
});

/**Validaciones para fecha FIN**/
fechaFin.addEventListener("change", () => {
    // Obtener las fechas como objetos Date
    const fechaFinSeleccionada = new Date(fechaFin.value);
    const fechaMin = new Date(fechaFin.min);
    const fechaMax = new Date(fechaFin.max);

    // Verificar si la fecha está dentro del rango permitido
    if(fechaFin.value == ""){
     isValid(fechaFin,false)
     mensajeFechaFin.innerHTML = "Seleccione una fecha y hora.";
    }else if (fechaFinSeleccionada < fechaMin || fechaFinSeleccionada > fechaMax || (fechaFin.value < fechaInicio.value && fechaInicio.value !== '')) {
        isValid(fechaFin,false)
        mensajeFechaFin.innerHTML = "Rango de fechas no válido.";
    }else {
        //Quitamos todos los mensajes y validamos
        mensajeFechaFin.innerHTML = "";
        isValid(fechaFin,true)
    }
});

const isValid = (componente, bandera) => {
     if (bandera) {
         componente.classList.remove("is-invalid");
         componente.classList.add("is-valid");
     }
     else {
         componente.classList.remove("is-valid");
         componente.classList.add("is-invalid");
     }
 }

const deshabilitar = () =>{
     fechaFin.disabled = true;
     fechaFin.value=""
     fechaFin.classList.remove('is-valid')
     fechaFin.classList.remove('is-invalid')
}

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
}
