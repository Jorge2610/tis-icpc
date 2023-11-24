const form = document.getElementById("formularioActividad");
const inputNombre = document.getElementById('nombreActividad')
const mensajeNombre = document.getElementById('mensajeNombre')
const fechaEventoInicio = document.getElementById("fechaEventoInicio");
const fechaEventoFin = document.getElementById("fechaEventoFin");
const fechaInicio = document.getElementById("fechaInicio");
const fechaFin = document.getElementById("fechaFin");
const mensajeFechaInicio = document.getElementById("mensajeFechaInicio");
const mensajeFechaFin = document.getElementById("mensajeFechaFin");

/**PETICIONES a AXIOS**/
/**CREAR ACTIVIDAD**/
const editarActividad = (formData) => {

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
            inputNombre.classList.remove('is-valid')
            inputNombre.classList.add('is-invalid')
            mensajeNombre.innerHTML = 'La actividad ya existe'
        }else{
            if(response.data.error != "danger"){
                window.location.href = "/admin/actividad/editar-actividad";
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
});

const validar = () => {
    return form.querySelector(".is-invalid") === null;
};

/**EDITAR ACTIVIDAD**/


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

/**Validaciones para fecha INICIO**/
fechaInicio.addEventListener("change", () => {
    const fechaInicioSeleccionada = new Date(fechaInicio.value);
    const fechaMin = new Date(fechaInicio.min);
    const fechaMax = new Date(fechaInicio.max);

    // Verificar si la fecha está dentro del rango permitido
    if ( fechaInicioSeleccionada < fechaMin) {
        fechaInicio.classList.add("is-invalid");
        fechaInicio.classList.remove("is-valid");
        mensajeFechaInicio.innerHTML = "La hora es menor al inicio de evento";
    } else if(fechaInicioSeleccionada > fechaMax){
        fechaInicio.classList.add("is-invalid");
        fechaInicio.classList.remove("is-valid");
        mensajeFechaInicio.innerHTML = "La hora es mayor al fin de evento";
    }else if(fechaInicio.value == ""){
        fechaInicio.classList.add("is-invalid");
        fechaInicio.classList.remove("is-valid");
        mensajeFechaInicio.innerHTML = "Seleccione una fecha y hora";
    }else if(fechaInicio.value > fechaFin.value){
        fechaFin.classList.add("is-invalid");
        fechaFin.classList.remove("is-valid");
        mensajeFechaFin.innerHTML = "Seleccione una fecha correcta";
    }else {
        //Quitamos todos los mensajes y validamos
        mensajeFechaInicio.innerHTML = "";
        fechaInicio.classList.remove("is-invalid");
        fechaInicio.classList.add("is-valid");
        //Ponemos como valor mínimo la fecha inicio de la actividad
        fechaFin.min = fechaInicio.value;
        fechaFin.dispatchEvent(new Event("change"));
    }
});

/**Validaciones para fecha FIN**/
fechaFin.addEventListener("change", () => {
    // Obtener las fechas como objetos Date
    const fechaFinSeleccionada = new Date(fechaFin.value);
    const fechaMin = new Date(fechaFin.min);
    const fechaMax = new Date(fechaFin.max);

    // Verificar si la fecha está dentro del rango permitido
    if (fechaFinSeleccionada < fechaMin) {
        fechaFin.classList.add("is-invalid");
        fechaFin.classList.remove("is-valid");
        mensajeFechaFin.innerHTML = "La hora es menor al inicio de evento";
    } else if(fechaFinSeleccionada > fechaMax){
        fechaFin.classList.add("is-invalid");
        fechaFin.classList.remove("is-valid");
        mensajeFechaFin.innerHTML = "La hora es mayor al fin de evento";
    }else if(fechaFin.value == ""){
        fechaFin.classList.add("is-invalid");
        fechaFin.classList.remove("is-valid");
        mensajeFechaFin.innerHTML = "Seleccione una fecha y hora";
    }else if(fechaFin.value < fechaInicio.value){
        fechaInicio.classList.add("is-invalid");
        fechaInicio.classList.remove("is-valid");
        mensajeFechaInicio.innerHTML = "Seleccione una fecha correcta";
    }else {
        //Quitamos todos los mensajes y validamos
        mensajeFechaFin.innerHTML = "";
        fechaFin.classList.remove("is-invalid");
        fechaFin.classList.add("is-valid");
    }
});
