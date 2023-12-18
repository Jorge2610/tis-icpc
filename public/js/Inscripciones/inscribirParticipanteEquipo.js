const formModalInscripcion = document.getElementById("formModalInscripcion");
const inputCI = document.getElementById("carnetParticipante");
const feedback = document.getElementById("validacionCarnetFeedback");
const displayCodigo = document.getElementById("displayCodAcceso");
const inputCod = document.getElementById("codParticipante");
let idEvento;
let idEquipo;
let idParticipante;
let onclick;

window.addEventListener("load", async () => {
    onclick = document.getElementById("botonPrincipal").getAttribute("onclick");
    cargarPaises();
});

const cargarPaises = () => {
    let select = document.getElementById("selectPais");
    let options = "";
    PAISES.map(pais => {
        options += `
            <option title=${pais.name_es} value="${pais.emoji} ${pais.code_3}" ${pais.code_3 === "BOL" ? "selected" : ""}>
                ${pais.emoji} ${pais.code_3}
            </option>
        `;
    });
    select.innerHTML = options;
};

const validarDatos = (idEv,id_equipo) => {
    idEvento = idEv;
    idEquipo=id_equipo;
    if (formModalInscripcion.checkValidity()) {
        verificarInscripcion(idEvento,id_equipo);
    } else {
        formModalInscripcion.classList.add("was-validated");
    }
};

const setCarnetFeedBack = () => {
    if (inputCI.value === "") {
        feedback.innerText = "El número de carnet no puede estar vacio."
    } else {
        feedback.innerText = "Número de carnet no valido."
    }
};

const resetModal = () => {
    displayCodigo.style.display = "none";
    inputCod.removeAttribute("required");
    let boton = document.getElementById("botonPrincipal");
    boton.innerText = "Inscribirme";
    boton.setAttribute("onclick", onclick);
    formModalInscripcion.reset();
    formModalInscripcion.classList.remove("was-validated");
};

const verificarInscripcion = async (idEvento,id_equipo) => {
    let formData = new FormData();
    formData.append("ci", inputCI.value);
    formData.append("id_evento", idEvento);
    let estaInscrito = await axios.post("/api/equipo/existe/"+inputCI.value
    +"/"+id_equipo+"/"+idEvento).then(response => {
        return response.data;
    });
    
    if (estaInscrito.error) {
        participanteYaInscrito(estaInscrito);
    } else {
        if (estaInscrito.participante) {
            estaRegistrado(estaInscrito.participante);
        } else {
            localStorage.setItem("paisCarnet", document.getElementById("selectPais").value);
            window.location.href = "/eventos/inscripcion-equipo/" +parseInt(id_equipo) + "/" + inputCI.value+"/"+idEvento;
        }
    }
};

const participanteYaInscrito = (response) => {
    $('#modal-inscribir').modal('hide');
    resetModal();
    mostrarAlerta(
        "Éxito",
        response.mensaje,
        response.error ? "danger" : "success"
    );
};

const estaRegistrado = (participante) => {
    idParticipante = participante.id;
    enviarCodigoAcceso();
    let mensaje = "El código de acceso se envio al correo ";
    let correo = participante.correo.split("@");
    correo[0] = correo[0].substring(0, 2) + correo[0].substring(2).replace(/./g, '*');
    document.getElementById("correoParticipante").innerText = mensaje + correo[0] + "@" + correo[1];
    displayCodigo.style.display = "block";
    inputCod.setAttribute("required", "");
    let boton = document.getElementById("botonPrincipal");
    boton.innerText = "Verificar";
    boton.setAttribute("onclick", "validarCodigoAcceso()");
};

const enviarCodigoAcceso = async () => {
    let data = await axios.post("/api/participante/enviarCodigo/" + idEvento + "/" + idParticipante).then(response => {
        return response.data;
    });
    return data;
};

const reEnviarCodigo = async () => {
    let res = await enviarCodigoAcceso();
    mostrarAlerta(
        "Éxito",
        res.mensaje,
        res.error ? "danger" : "success"
    );
};

const validarCodigoAcceso = () => {
    if (formModalInscripcion.checkValidity()) {
        verificarCodigoAcceso();
    } else {
        formModalInscripcion.classList.add("was-validated");
        actualizarPattern();
    }
};

const verificarCodigoAcceso = async () => {
    let formData = new FormData();
    formData.append("codigo", inputCod.value);
    let data = await axios.post("/api/participante/verificarCodigo/" + idParticipante, formData).then(response => {
        return response.data;
    });
    if (data.error) {
        actualizarPattern();
        formModalInscripcion.classList.add("was-validated");
    } else {
        let ci = inputCI.value;
        localStorage.setItem("codigo",inputCod.value);
        resetModal();
        window.location.href = "/eventos/inscripcion-evento/" + idEquipo + "/" + ci+"/"+idEvento;
    }
};

let patternBase = "^(";
const actualizarPattern = () => {
    let nuevoPattern = patternBase + "(?!" + inputCod.value + "$)";
    patternBase = nuevoPattern;
    nuevoPattern = nuevoPattern + ").+";
    inputCod.setAttribute("pattern", nuevoPattern);
};