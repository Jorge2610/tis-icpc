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
const nombreEvento = document.getElementById("nombreDelEvento");
const mensajeNombre = document.getElementById("mensajeNombre");
const checkEquipo = document.getElementById("equipoCheck");
const checkNotificacion = document.getElementById("notificacion");
const equipoMaximo = document.getElementById("equipoMaximo");
const equipoMinimo = document.getElementById("equipoMinimo");

let boolCheckEquipo=true;
let boolMinEquipo =true;
let boolMaxEquipo = true;
let boolFecha = true;
let boolCosto = true;
let boolMinEdad = true;
let boolcheckEdad = true;
let boolMaxEdad = true;
let crear = true; //0-> Crear  1->Editar
let datosActualizados = false;
let nombreAnterior = ''
let mensajeRepetido = ''

let fechaLocal = new Date();
fechaLocal.setHours(fechaLocal.getHours() - 4);
let laFecha = fechaLocal.toISOString().substring(0, 16);

const mostrarInput = (indInput, check) => {
    let input = document.getElementById(indInput);
    if (!check) {
        input.style.display = "none";
    } else {
        input.style.display = "flex";
    }
};

const prepararFormData = () => {
    if(!crear){
        document.querySelectorAll(".fecha-editar").forEach(Element=>{
            Element.disabled=false;
        })
    }
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
    if(!checkEquipo.checked){
        formData.set("cantidad_equipo","");
    }
    if(!document.getElementById("tallaCheck").checked){
        formData.set("talla","");
    }
    if(!crear){
        if(!checkNotificacion.checked){
            formData.set("notificacion","");
        }else{
            formData.set("notificacion","on");
        }    
    }
    
    return formData;
};

const editarEvento = (formData) => {
    if (!datosActualizados) {
        window.location.href =
            "/eventos/" + document.getElementById("nombreDelEvento").value;
    }
    nombreAnterior = nombreEvento.value
    axios
        .post("/api/evento/actualizar/" + formData.get("evento_id"), formData)
        .then(function (response) {
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.data.error ? "danger" : "success"
            );
            mensajeRepetido = response.data.mensaje
            if(mensajeRepetido !== 'El evento ya existe')  {
                setTimeout(()=>{
                    window.location.href = "/editarEvento";
               },1800);
                form.reset();
            }else{
                nombreEvento.classList.remove("is-valid")
                nombreEvento.classList.add("is-invalid")
                mensajeNombre.textContent = 'El evento ya existe.'
            } 
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
    nombreAnterior = nombreEvento.value
    axios
        .post("/api/evento", formData)
        .then(function (response) {
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.data.error ? "danger" : "success"
            );
            mensajeRepetido = response.data.mensaje
            if(mensajeRepetido === 'El evento ya existe')  {
                nombreEvento.classList.remove("is-valid")
                nombreEvento.classList.add("is-invalid")
                mensajeNombre.textContent = 'El evento ya existe.'
            }else{
               setTimeout(() => {
                    window.location.href = "/eventos/" ;
                }, 1800);
            }    
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
    if (!crear) {
        datosActualizados = true;
    }
};
//Recuperar tipos de eventos necesario para el form

window.addEventListener("load", () => {
    checkTodasRango.classList.remove("grado-requerido");
    chekcTodas.classList.remove("institucion");
    if (document.getElementById("nombreDelEvento").value != "") {
        crear = false;
        iniciarEditar();
    }else{
        fechasMin();
        fechaFin.disabled=true;
    }
    axios
        .get("/api/tipo-evento")
        .then(function (response) {
            const idTipoEvento = document.getElementById("tipoDelEvento").getAttribute("data-id");
            const select = document.getElementById("tipoDelEvento");
            const tiposDeEvento = response.data;
            tiposDeEvento.forEach(function (tipo) {
                if(idTipoEvento != tipo.id){
                    const option = document.createElement("option");
                    option.value = tipo.id;
                    option.text = tipo.nombre;
                    select.appendChild(option);
                }
            });
            if (idTipoEvento != "") {
                select.value = idTipoEvento;
            }
        })
        .catch(function (error) {
            console.error(error);
        });
});

const cerrar = (edicion) => {
    if (crear) {
        location.reload();
        form.reset();   
    }
    else{
        window.location.href = "/editarEvento/";
    }
};

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
        formData.set("institucion", aux.slice(0, -1));
        formData.set("grado_academico", insti.slice(0, -1));
        if (!crear) {
            editarEvento(formData);
        } else {
            crearEvento(formData);
        }
        $("#modalConfirmacion").modal("hide");
    }
});

const validar = () => {
    if (form.querySelector(".is-invalid") === null) {
        return true;
    } else {
        return false;
    }
};

inputGenero.addEventListener("change", () => {
    mostrarInput("genero", inputGenero.checked);
});
inputEdad.addEventListener("change", () => {
    mostrarInput("rangosDeEdad", inputEdad.checked);
});
inputCosto.addEventListener("change", () => {
    mostrarInput("eventoPago", inputCosto.checked);
});
checkEquipo.addEventListener("change",()=>{
    mostrarInput("numero-integrantes",checkEquipo.checked);
});

nombreEvento.addEventListener("input",validarNombreRepetido);
nombreEvento.addEventListener("change",validarNombreRepetido);

//iniciar editar un evento
const iniciarEditar=()=>{
    mostrarInput("genero", inputGenero.checked);
    mostrarInput("rangosDeEdad", inputEdad.checked);
    mostrarInput("eventoPago", inputCosto.checked);
    let f1=new Date(fechaInicio.value);
    let fl1=new Date(laFecha);
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

    if(f1<=fl1){
        checkTodasRango.disabled=boolGrado;
        chekcTodas.disabled=boolInstitucion;

        if(!inputGenero.checked){
            inputGenero.classList.add("fecha-editar");
        }
        document.getElementById("ul-institucion").classList.add("fecha-editar");
        document.getElementById("todas-grado").classList.add("fecha-editar");
        
        document.querySelectorAll(".fecha-editar").forEach(Element=>{
            Element.disabled=true;
        })
        fechaFin.min=laFecha;
    }else{
        fechasMin();
    }
}

const fechasMin = () => {
    let fechaLocal = new Date();
    fechaLocal.setHours(fechaLocal.getHours() - 4);
    let laFecha = fechaLocal.toISOString().substring(0, 16);
    fechaInicio.min = laFecha;
    fechaFin.min = laFecha;
};

function validarNombreRepetido(){
    if(nombreAnterior === ''){
         if(nombreEvento.value === ''){
             nombreEvento.classList.remove("is-valid");
             nombreEvento.classList.add("is-invalid");
             mensajeNombre.textContent = "El nombre no puede estar vacío.";
         }else{
             nombreEvento.classList.remove("is-invalid");
             nombreEvento.classList.add("is-valid");
         }    
    }else{
         if (nombreEvento.value !== nombreAnterior && nombreEvento.value !== '') {
             nombreEvento.classList.remove("is-invalid");
             nombreEvento.classList.add("is-valid");
         }else if(nombreEvento.value == ''){
             nombreEvento.classList.remove("is-valid");
             nombreEvento.classList.add("is-invalid");
             mensajeNombre.textContent = 'El nombre no puede estar vacío.'
         }else{
             nombreEvento.classList.remove("is-valid");
             nombreEvento.classList.add("is-invalid");
             mensajeNombre.textContent = 'La actividad ya existe'
         }
    }
 }