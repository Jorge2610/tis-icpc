const fechaInscripcionInicio = document.getElementById("fechaInscripcionInicio");
const fechaInscripcionFin = document.getElementById("fechaInscripcionFin");
const inputGenero = document.getElementById("generoCheck");
const inputEdad = document.getElementById("edadCheck");
const inputCosto = document.getElementById("eventoPagoCheck");
const form = document.getElementById("formularioCrearEvento");
const fechaInicio = document.getElementById("fechaInicio");
const fechaFin = document.getElementById("fechaFin");
const edadMinima = document.getElementById("edadMinima");
const edadMaxima = document.getElementById("edadMaxima");

let tipoForm = 0; //0-> Crear  1->Editar
let datosActualizados = false;
let nombreEvento = document.getElementById("nombreDelEvento").value;

//Validaciones
const setMinDate = (input, target) => {
    if (input.value === "") {
        target.min = input.min;
    } else {
        target.min = input.value;
    }
};

const validarFechas = (fechaInicio, fechaFin) => {
    if (fechaFin.value < fechaInicio.value) {
        fechaFin.value = fechaInicio.value;
    }
    datoCambiado();
};

const copiarEdadMaxima = () => {
    const valor = edadMinima.value;
    edadMaxima.value = valor;
    edadMaxima.min = valor;
};

fechaInicio.addEventListener("change", () => {
    setMinDate(fechaFin, fechaInicio);
    validarFechas(fechaInicio, fechaFin);
});

fechaFin.addEventListener("change", () => {
    validarFechas(fechaInicio, fechaFin);
});

fechaInscripcionInicio.addEventListener("change", () => {
    setMinDate(fechaInscripcionFin, fechaInscripcionInicio);
    validarFechas(fechaInscripcionInicio, fechaInscripcionFin);
});

fechaInscripcionFin.addEventListener("change", () => {
    validarFechas(fechaInscripcionInicio, fechaInscripcionFin);
});

edadMinima.addEventListener("change", () => {
    copiarEdadMaxima();
});

const utilizarInput = (indInput, check) => {
    let input = document.getElementById(indInput);
    input.disabled = !check;
};

const mostrarInput = (indInput, check) => {
    let input = document.getElementById(indInput);
    if (!check) {
        input.style.display = "none";
    } else {
        input.style.display = "flex";
    }
};

//check
inputGenero.addEventListener("change", () => {
    mostrarInput("genero", inputGenero.checked);
});
inputEdad.addEventListener("change", () => {
    mostrarInput("rangosDeEdad", inputEdad.checked);
});
inputCosto.addEventListener("change", () => {
    mostrarInput("eventoPago", inputCosto.checked);
});

/*form.addEventListener("submit", (event) => {
    if (tipoForm === 0 || datosActualizados) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add("was-validated");
    }
});*/

//FUNCIONES


const resetModal = (idModal, idForm) => {
    const output = document.getElementById("sponsorPreview");
    output.style.backgroundImage = "url(" + "../image/uploading.png" + ")";
    const modal = document.getElementById(idModal);
    const inputs = modal.querySelectorAll("input");
    inputs.forEach((element) => (element.value = ""));
    const form = document.getElementById(idForm);
    form.classList.remove("was-validated");
};

//Guardar evento
/*document.addEventListener("DOMContentLoaded", () => {
    mostrarInput("genero", inputGenero.checked);
    mostrarInput("rangosDeEdad", inputEdad.checked);
    mostrarInput("eventoPago", inputCosto.checked);
    const form = document.getElementById("formularioCrearEvento");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        if (!form.checkValidity()) {
            event.stopPropagation();
            $("#modalConfirmacion").modal("hide");
            return;
        }

        const formData = prepararFormData();

        const eventoId = formData.get("evento_id");
        const imagen = document.getElementById("imagen").value;
        formData.set("ruta_afiche", imagen);

        if (eventoId) {
            editarEvento(formData, eventoId);
        } else {
            crearEvento(formData);
        }

        $("#modalConfirmacion").modal("hide");
        form.classList.remove("was-validated");
        form.reset();
    });
});*/
const prepararFormData = () => {
    document.getElementById("select-region").disabled=false;
    const formData = new FormData(form);
    if (!inputEdad.checked) {
        formData.set("edad_minima", "");
        formData.set("edad_maxima", "");
    }
    if (!inputGenero.checked) {
        formData.set("genero", "");
    }
    if (!inputCosto.checked) {
        formData.set("precio_inscripcion", "");
    }
    return formData;
};

const editarEvento = (formData, eventoId) => {
    if (!datosActualizados) {
        window.location.href =
            "/eventos/" + document.getElementById("nombreDelEvento").value;
    }
    for (let [campo, valor] of formData) {
        console.log(`${campo}: ${valor}`);
    }
    nombreEvento = document.getElementById("nombreDelEvento").value;
    
    axios
        .post("/api/evento/actualizar/" + eventoId, formData)
        .then(function (response) {
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.data.error ? "danger" : "success"
            );
        })
        .catch(function (error) {
            mostrarAlerta(
                "Error",
                "Hubo un error al guardar el tipo de evento",
                "danger"
            );
        });
};

const crearEvento = (formData) => {
    axios
        .post("/api/evento", formData)
        .then(function (response) {
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.data.error ? "danger" : "success"
            );
        })
        .catch(function (error) {
            mostrarAlerta(
                "Error",
                "Hubo un error al guardar el tipo de evento",
                "danger"
            );
        });
};
const datoCambiado = () => {
    if (tipoForm === 1) {
        datosActualizados = true;
    }
};

//Recuperar tipos de eventos necesario para el form

window.addEventListener("load", () => {
    if (document.getElementById("nombreDelEvento").value != "") {
        tipoForm = 1;
        document.getElementById("select-region").disabled=true;

    }
    axios
        .get("/api/tipo-evento")
        .then(function (response) {
            const select = document.getElementById("tipoDelEvento");
            const tiposDeEvento = response.data;
            tiposDeEvento.forEach(function (tipo) {
                const option = document.createElement("option");
                option.value = tipo.id;
                option.text = tipo.nombre;
                select.appendChild(option);
            });
            const idTipoEvento = document
                .getElementById("tipoDelEvento")
                .getAttribute("data-id");
            if (idTipoEvento != "") {
                select.value = idTipoEvento;
            }
        })
        .catch(function (error) {
            console.error(error);
        });
});

const cerrar = (edicion) => {
    if (edicion) {
        window.location.href = "/eventos/" + nombreEvento;
    }
    document
        .getElementById("formularioCrearEvento")
        .classList.remove("was-validated");
};

//agragar validacion a los inputs
form.querySelectorAll(".form-control, .form-select").forEach(Element=>{
    Element.addEventListener("change",()=>{
        if(Element.hasAttribute("required") && Element.value===""){
            Element.classList.remove("is-valid");
            Element.classList.add("is-invalid");
        }
        else{
            Element.classList.remove("is-invalid");
            Element.classList.add("is-valid");
        }
    })
});
form.addEventListener("submit",(event)=>{
    event.preventDefault();
    form.querySelectorAll(".form-control, .form-select").forEach(Element=>{
        Element.dispatchEvent(new Event("change"));
    })
    let aux="";
    form.querySelectorAll(".institucion").forEach(Element=>{
        if(Element.checked){
            aux= Element.value+", "+aux;
        }
    })
    console.log(aux);
    if(!validar()){
        $("#modalConfirmacion").modal("hide");
    }
    else{
        const formData = prepararFormData();

        const eventoId = formData.get("evento_id");
        const imagen = document.getElementById("imagen").value;
        formData.set("ruta_afiche", imagen);
        formData.set("institucion", aux);
        if (eventoId) {
            editarEvento(formData, eventoId);
        } else {
            crearEvento(formData);
        }

        $("#modalConfirmacion").modal("hide");
        form.classList.remove("was-validated");
        form.reset();
    }

})

const validar=()=>{
    console.log(form.querySelector(".is-invalid"));
    if(form.querySelector(".is-invalid")===null){
        return true;
    }
    else{
        return false;
    }
};