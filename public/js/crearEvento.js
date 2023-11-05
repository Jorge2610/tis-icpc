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
const chekcTodas = document.getElementById("check-institucion-TODAS");

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
    //setMinDate(fechaFin, fechaInicio);
    setMinDate(fechaInicio,fechaFin);
    validarFechas(fechaInicio, fechaFin);
});

fechaFin.addEventListener("change", () => {
    validarFechas(fechaInicio, fechaFin);
});

fechaInscripcionInicio.addEventListener("change", () => {
    setMinDate(fechaInscripcionInicio, fechaInscripcionFin);
   // setMinDate(fechaInscripcionFin, fechaInscripcionInicio);
    validarFechas(fechaInscripcionInicio, fechaInscripcionFin);
});

fechaInscripcionFin.addEventListener("change", () => {
    validarFechas(fechaInscripcionInicio, fechaInscripcionFin);
});

edadMaxima.addEventListener("change",()=>{
    if(edadMaxima.value<edadMaxima.min&&edadMaxima.value!==""){
        edadMaxima.value=edadMaxima.min;
    }
    validarEdad();
})
edadMinima.addEventListener("change", () => {
    if(edadMinima.value<edadMinima.min&&edadMinima.value!==""){
        edadMinima.value=0;
    }
    edadMaxima.min=edadMinima.value;
    validarEdad();
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
    fechasMin();
    console.log(new Date().toISOString().split('T')[0]);
    if (document.getElementById("nombreDelEvento").value != "") {
        tipoForm = 1;
    //    document.getElementById("select-region").disabled=true;
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
    chekcTodas.classList.remove("institucion");
    console.log(edadMaxima.value=="");
    console.log(edadMinima.value);
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
        if(!Element.classList.contains("input-edad")||Element.id!=="costoEvento"){
            if(Element.hasAttribute("required") && Element.value===""){
                Element.classList.remove("is-valid");
                Element.classList.add("is-invalid");
            }
            else{
                Element.classList.remove("is-invalid");
                Element.classList.add("is-valid");
            }
        }
    })
});
form.addEventListener("submit",(event)=>{
    validarEdad();
    event.preventDefault();
    form.querySelectorAll(".form-control, .form-select").forEach(Element=>{
        Element.dispatchEvent(new Event("change"));
    })
    if(!validar()){
        $("#modalConfirmacion").modal("hide");
    }
    else{
        let aux="";
        form.querySelectorAll(".institucion").forEach(Element=>{
            if(Element.checked){
                aux= Element.value+", "+aux;
            }
        })
        let insti="";
        form.querySelectorAll(".grado-requerido").forEach(Element=>{
            if(Element.checked){
                insti= Element.value+", "+insti;
            }
        })
        const formData = prepararFormData();

        const eventoId = formData.get("evento_id");
        const imagen = document.getElementById("imagen").value;
        formData.set("ruta_afiche", imagen);
        formData.set("institucion", aux);
        formData.set("grado_academico",insti);
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
    if(form.querySelector(".is-invalid")===null){
        return true;
    }
    else{
        return false;
    }
};

chekcTodas.addEventListener("change",()=>{
    document.querySelectorAll(".institucion").forEach(Element=>{
        if(chekcTodas.checked){
            Element.checked=true;
        }
        else{
            Element.checked=false;
        }
    })
});

document.querySelectorAll(".institucion").forEach(Element=>{
    Element.addEventListener("change",()=>{
        let bandera=true;
        document.querySelectorAll(".institucion").forEach(Element=>{
            if(!Element.checked){
                bandera=false;
            }
        })
        chekcTodas.checked=bandera;
    })
})

const validarEdad=()=>{
    if(edadMaxima.value===""&& edadMinima.value==="" &&inputEdad.checked){
        inputEdad.classList.remove("is-valid");
        inputEdad.classList.add("is-invalid");
    }
    else{
        inputEdad.classList.add("is-valid");
        inputEdad.classList.remove("is-invalid");
    }
};

const fechasMin=()=>{
    fechaInicio.min=new Date().toISOString().slice(0, 16);
    fechaFin.min=new Date().toISOString().slice(0, 16);
    fechaInscripcionInicio.min=new Date().toISOString().split("T")[0];
    fechaInscripcionFin.min=new Date().toISOString().split("T")[0];

};

inputCosto.addEventListener("change",()=>{
    validarCosto();
});

document.getElementById("costoEvento").addEventListener("change",()=>{
    validarCosto();
})

validarCosto=()=>{
    let costoValor=document.getElementById("costoEvento").value;
    console.log(costoValor+"holaqs");
    if(inputCosto.checked&&costoValor==""){
            inputCosto.classList.add("is-invalid");
            inputCosto.classList.remove("is-valid");
    }
    else{
        inputCosto.classList.remove("is-invalid");
        inputCosto.classList.add("is-valid");
    }
};
fechaInscripcionInicio.addEventListener("change",()=>{
    if(fechaInscripcionInicio.value=="" && fechaInscripcionFin.value!=""){
        fechaInscripcionInicio.classList.remove("is-valid");
        fechaInscripcionInicio.classList.add("is-invalid");
    }
})

fechaInicio.addEventListener("change",()=>{
    if(fechaInicio.value=="" && fechaFin.value!=""){
        fechaInicio.classList.remove("is-valid");
        fechaInicio.classList.add("is-invalid");
    }
})

fechaInscripcionFin.addEventListener("change",()=>{
    let fech = fechaFin.value.split('T')[0];
    console.log(fech);
    if(fechaInscripcionFin.value>fech && fech!==""){
        fechaInscripcionFin.classList.remove("is-valid");
        fechaInscripcionFin.classList.add("is-invalid");
    }

})