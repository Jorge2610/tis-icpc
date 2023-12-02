const fechaEventoInicio = document.getElementById("fechaEventoInicio");
const fechaEventoFin = document.getElementById("fechaEventoFin");
const fechaInicio = document.getElementById("fechaInicio");
const fechaFin = document.getElementById("fechaFin");
const mensajeFechaInicio = document.getElementById("mensajeFechaInicio");
const mensajeFechaFin = document.getElementById("mensajeFechaFin");

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

