/**PETICIONES a AXIOS**/
/**CREAR ACTIVIDAD**/
const crearActividad = () => {
    const form = document.getElementById("formularioActividad");
    form.addEventListener("submit", async function (event) {
        event.preventDefault();
        form.classList.add("was-validated");

        if (!form.checkValidity()) {
            event.stopPropagation();
        } else {
            const formData = new FormData(this);
            try {
                const response = await axios.post("/api/actividad", formData);
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
                form.classList.remove("was-validated");
                form.reset();
                if(response.data.error != "danger"){
                    window.location.href = "/admin/actividad";
                }
            } catch (error) {
                mostrarAlerta("Error", "Hubo un error al guardar la actividad", "danger");
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", crearActividad);

/**EDITAR ACTIVIDAD**/

/**OBTENER TIPOS DE ACTIVIDAD**/
window.addEventListener("load", () => {
    axios
        .get("/api/tipo-evento")
        .then(function (response) {
            const select = document.getElementById("tipoDeActividad");
            const tiposDeActividad = response.data;
            tiposDeActividad.forEach(function (tipo) {
                const option = document.createElement("option");
                option.value = tipo.id;
                option.text = tipo.nombre;
                select.appendChild(option);
            });
            /*
            const idTipoActividad = document
                .getElementById("tipoDeActividad")
                .getAttribute("data-id");
            if (idTipoActividad != "") {
                select.value = idTipoActividad;
            }*/
        })
        .catch(function (error) {
            console.error(error);
        });
});

/**VALIDACIONES**/
const fechaEventoInicio = document.getElementById("fechaEventoInicio");
const fechaEventoFin = document.getElementById("fechaEventoFin");
const fechaInicio = document.getElementById("fechaInicio");
const fechaFin = document.getElementById("fechaFin");
const form = document.getElementById("formularioActividad");
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
        fechaInicio.classList.remove("is-invalid");
        fechaInicio.classList.add("is-valid");
    }
});

