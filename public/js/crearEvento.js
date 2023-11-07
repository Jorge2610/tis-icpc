const fechaInscripcionInicio = document.getElementById(
    "fechaInscripcionInicio"
);
const fechaInscripcionFin = document.getElementById("fechaInscripcionFin");
const inputGenero = document.getElementById("generoCheck");
const inputEdad = document.getElementById("edadCheck");
const inputCosto = document.getElementById("eventoPagoCheck");
const form = document.getElementById("formularioCrearEvento");
const fechaInicio = document.getElementById("fechaInicio");
const fechaFin = document.getElementById("fechaFin");
const edadMinima = document.getElementById("edadMinima");
const edadMaxima = document.getElementById("edadMaxima");
const chekcTodas = document.getElementById("check-institucion-TODAS");
const costo = document.getElementById("costoEvento");
const checkTodasRango = document.getElementById("input-grado-Todas");

let boolCosto = true;
let boolMinEdad = true;
let boolcheckEdad = true;
let boolMaxEdad = true;
let tipoForm = 0; //0-> Crear  1->Editar
let datosActualizados = false;
let nombreEvento = document.getElementById("nombreDelEvento").value;

//Validaciones
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
const prepararFormData = () => {
    if(tipoForm=="1"){
        document.querySelectorAll(".fecha-editar").forEach(Element=>{
            Element.disabled=false;
        })
    }
    document.getElementById("select-region").disabled = false;
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
    window.location.href ="/eventos/"
};

const crearEvento = (formData) => {
    axios
        .post("/api/evento/", formData)
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
    window.location.href ="/eventos/"+ document.getElementById("nombreDelEvento").value;
};
const datoCambiado = () => {
    if (tipoForm === 1) {
        datosActualizados = true;
    }
};

//Recuperar tipos de eventos necesario para el form

window.addEventListener("load", () => {
    checkTodasRango.classList.remove("grado-requerido");
    chekcTodas.classList.remove("institucion");
    if (document.getElementById("nombreDelEvento").value != "") {
        tipoForm = 1;
        iniciarEditar();
    }else{
        fechasMin();
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
    window.location.href = "/eventos/" 
};

//agragar validacion a los inputs
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
form.addEventListener("submit", (event) => {
    event.preventDefault();
    form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
        Element.dispatchEvent(new Event("change"));
    });
    if (!validar()) {
        $("#modalConfirmacion").modal("hide");
    } else {
        let aux = "";
        form.querySelectorAll(".institucion").forEach((Element) => {
            if (Element.checked) {
                aux = Element.value + "-" + aux;
            }
        });
        let insti = "";
        form.querySelectorAll(".grado-requerido").forEach((Element) => {
            if (Element.checked) {
                insti = Element.value + "-" + insti;
            }
        });
        const formData = prepararFormData();

        const eventoId = formData.get("evento_id");
        const imagen = document.getElementById("imagen").value;
        formData.set("ruta_afiche", imagen);
        formData.set("institucion", aux.slice(0, -1));
        formData.set("grado_academico", insti.slice(0, -1));
        if (eventoId) {
            editarEvento(formData, eventoId);
        } else {
            crearEvento(formData);
        }

        $("#modalConfirmacion").modal("hide");
        form.classList.remove("was-validated");
        form.reset();
    }
});

const validar = () => {
    if (form.querySelector(".is-invalid") === null) {
        return true;
    } else {
        return false;
    }
};

chekcTodas.addEventListener("change", () => {
    document.querySelectorAll(".institucion").forEach((Element) => {
        if(!Element.disabled){
            if (chekcTodas.checked) {
                Element.checked = true;
            } else {
                Element.checked = false;
            }
        }       
    });
});

document.querySelectorAll(".institucion").forEach((Element) => {
    Element.addEventListener("change", () => {
        let bandera = true;
        document.querySelectorAll(".institucion").forEach((Element) => {
            if(!Element.disabled){
                if (!Element.checked) {
                    bandera = false;
                }
            }
           
        });
        chekcTodas.checked = bandera;
    });
});

const validarEdad = () => {
    if (boolMaxEdad && boolMinEdad && boolcheckEdad) {
        boolMaxEdad = false;
        boolMinEdad = false;
        edadMaxima.dispatchEvent(new Event("change"));
        edadMinima.dispatchEvent(new Event("change"));
    } else {
        boolcheckEdad = true;
    }

    if (
        edadMaxima.classList.contains("is-invalid") ||
        edadMaxima.classList.contains("is-invalid")
    ) {
        inputEdad.classList.remove("is-valid");
        inputEdad.classList.add("is-invalid");
    } else {
        inputEdad.classList.add("is-valid");
        inputEdad.classList.remove("is-invalid");
    }
};

const fechasMin = () => {
    let fechaLocal = new Date();
    fechaLocal.setHours(fechaLocal.getHours() - 4);
    let laFecha = fechaLocal.toISOString().substring(0, 16);
    fechaInicio.min = laFecha;
    fechaFin.min = laFecha;
    fechaInscripcionInicio.min = laFecha.split("T")[0];
    fechaInscripcionFin.min = laFecha.split("T")[0];
};

validarCosto = () => {
    if (boolCosto) {
        boolCosto = false;
        costo.dispatchEvent(new Event("change"));
    } else {
        boolCosto = true;
    }
    if (costo.classList.contains("is-invalid")) {
        inputCosto.classList.add("is-invalid");
        inputCosto.classList.remove("is-valid");
    } else {
        inputCosto.classList.remove("is-invalid");
        inputCosto.classList.add("is-valid");
    }
};

fechaInscripcionInicio.addEventListener("change", () => {
    let validarMax =
        fechaInscripcionInicio.value > fechaInscripcionInicio.max &&
        fechaInscripcionInicio.max !== "";
    if (fechaInscripcionInicio.value == "" && fechaInscripcionFin.value != "") {
        fechaInscripcionInicio.classList.remove("is-valid");
        fechaInscripcionInicio.classList.add("is-invalid");
    }
    if (
        (fechaInscripcionInicio.value < fechaInscripcionInicio.min ||
            validarMax) &&
        fechaInscripcionInicio.value !== ""
    ) {
        fechaInscripcionInicio.classList.remove("is-valid");
        fechaInscripcionInicio.classList.add("is-invalid");
    } else {
        fechaInscripcionFin.min = fechaInscripcionInicio.value;
        fechaInscripcionFin.dispatchEvent(new Event("change"));
    }
});

fechaInscripcionFin.addEventListener("change", () => {
    if (
        fechaInscripcionInicio.value !== "" &&
        fechaInscripcionFin.value === ""
    ) {
        fechaInscripcionFin.classList.remove("is-valid");
        fechaInscripcionFin.classList.add("is-invalid");
    }
    if (
        fechaInscripcionFin.value > fechaInscripcionFin.max &&
        fechaInscripcionFin.max !== ""
    ) {
        fechaInscripcionFin.classList.remove("is-valid");
        fechaInscripcionFin.classList.add("is-invalid");
    }
    if (
        fechaInscripcionFin.value < fechaInscripcionFin.min &&
        fechaInscripcionFin.value !== ""
    ) {
        fechaInscripcionFin.classList.remove("is-valid");
        fechaInscripcionFin.classList.add("is-invalid");
    }
});

costo.addEventListener("change", () => {
    if ((costo.value < costo.min || costo.value == "") && inputCosto.checked) {
        costo.classList.remove("is-valid");
        costo.classList.add("is-invalid");
    }
    if (boolCosto) {
        boolCosto = false;
        validarCosto();
    } else {
        boolCosto = true;
    }
});

fechaInicio.addEventListener("change", () => {
    if (
        fechaInicio.value < fechaInicio.min &&
        fechaInicio.value !== "" &&
        fechaInicio.value != ""
    ) {
        fechaInicio.classList.add("is-invalid");
        fechaInicio.classList.remove("is-valid");
    } else {
        fechaFin.min = fechaInicio.value;
        fechaFin.dispatchEvent(new Event("change"));
        fechaInscripcionInicio.max = fechaInicio.value.split("T")[0];
        fechaInscripcionInicio.dispatchEvent(new Event("change"));
    }
});

fechaFin.addEventListener("change", () => {
    if (fechaFin.value < fechaFin.min && fechaFin.value !== "") {
        fechaFin.classList.remove("is-valid");
        fechaFin.classList.add("is-invalid");
    } else {
        fechaInscripcionFin.max = fechaFin.value.split("T")[0];
    }
});

edadMaxima.addEventListener("change", () => {
    let ambos = edadMaxima.value === "" && edadMinima.value === "";
    if (parseInt(edadMaxima.value) < parseInt(edadMaxima.min) && edadMaxima.value !== "") {
        edadMaxima.classList.add("is-invalid");
        edadMaxima.classList.remove("is-valid");
    } else {
        if (ambos && inputEdad.checked) {
            edadMaxima.classList.add("is-invalid");
            edadMaxima.classList.remove("is-valid");
        } else {
            edadMaxima.classList.remove("is-invalid");
            edadMaxima.classList.add("is-valid");
        }
    }
    if (boolMinEdad && boolMaxEdad && boolcheckEdad) {
        boolMinEdad = false;
        boolcheckEdad = false;
        edadMinima.dispatchEvent(new Event("change"));
        validarEdad();
    } else {
        boolMaxEdad = true;
    }
});
edadMinima.addEventListener("change", () => {
    let ambos = edadMaxima.value === "" && edadMinima.value === "";

    if (parseInt(edadMinima.value) < parseInt(edadMinima.min) && edadMinima.value !== "") {
        edadMinima.classList.add("is-invalid");
        edadMinima.classList.remove("is-valid");
    } else {
        if(edadMinima.value !== ""){}
            edadMaxima.min = edadMinima.value;
    }
    
    if (ambos && inputEdad.checked) {
        edadMinima.classList.add("is-invalid");
        edadMinima.classList.remove("is-valid");
    }

    if (boolMinEdad && boolMaxEdad && boolcheckEdad) {
        boolMaxEdad = false;
        boolcheckEdad = false;
        edadMaxima.dispatchEvent(new Event("change"));
        validarEdad();
    } else {
        boolMinEdad = true;
    }
});
inputCosto.addEventListener("change", () => {
    validarCosto();
});
inputEdad.addEventListener("change", () => {
    validarEdad();
});

checkTodasRango.addEventListener("change", () => {
    document.querySelectorAll(".grado-requerido").forEach((Element) => {
        if(!Element.disabled){
            if (checkTodasRango.checked) {
                Element.checked = true;
            } else {
                Element.checked = false;
            }
        }
    });
});

document.querySelectorAll(".grado-requerido").forEach((Element) => {
    Element.addEventListener("change", () => {
        let bandera = true;
        document.querySelectorAll(".grado-requerido").forEach((Element) => {
            if(!Element.disabled){
                if (!Element.checked) {
                    bandera = false;
                }
            }
        });
        checkTodasRango.checked = bandera;
    });
});

//iniciar editar un evento

const iniciarEditar=()=>{

    mostrarInput("genero", inputGenero.checked);
    mostrarInput("rangosDeEdad", inputEdad.checked);
    mostrarInput("eventoPago", inputCosto.checked);
    let fechaLocal = new Date();
    fechaLocal.setHours(fechaLocal.getHours() - 4);
    let laFecha = fechaLocal.toISOString().substring(0, 16);
    let f1=new Date(fechaInicio.value);
    let fl1=new Date(laFecha);
    let fl2=new Date(laFecha.split("T")[0]);
    let f2=new Date(fechaInscripcionInicio.value)

    let boolGrado=true;
    let boolInstitucion=true;

    const instituciones=document.getElementById("ul-institucion").getAttribute("data-institucion");
        document.querySelectorAll(".institucion").forEach(Element=>{
            if(instituciones.includes(Element.value)){
                Element.checked=true;
                Element.classList.add("fecha-editar");  
            }else{
                boolInstitucion=false;
            }
    })

    const grados =document.getElementById("ul-grado").getAttribute("data-grado");
        document.querySelectorAll(".grado-requerido").forEach(Element=>{
            if(grados.includes(Element.value)){
                Element.checked=true;
                Element.classList.add("fecha-editar");
            }else{
                boolGrado=false;
            }

    })
    checkTodasRango.checked=boolGrado;
    chekcTodas.checked=boolInstitucion;

    if(f2<=fl2){
        checkTodasRango.disabled=boolGrado;
        chekcTodas.disabled=boolGrado;

        if(!inputGenero.checked){
            inputGenero.classList.add("fecha-editar");
        }
        if(fechaInscripcionInicio){}
        document.getElementById("ul-institucion").classList.add("fecha-editar");
        document.getElementById("todas-grado").classList.add("fecha-editar");
        
        document.querySelectorAll(".fecha-editar").forEach(Element=>{
            Element.disabled=true;
        })
        fechaInscripcionFin.min=fechaInscripcionInicio.value;
        fechaInicio.min=fechaInscripcionInicio.value+"T00:00";
        fechaFin.min=fechaInicio.value;
    }else{
        fechasMin();
    }
    fechaInscripcionFin.max=fechaFin.value.split("T")[0];
    fechaInscripcionInicio.max=fechaInicio.value.split("T")[0];
}