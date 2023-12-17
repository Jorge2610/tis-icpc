const formModalInscripcion = document.getElementById("formModalInscripcion");
const inputCI = document.getElementById("carnetParticipante");
const feedback = document.getElementById("validacionCarnetFeedback");
const displayCodigo = document.getElementById("displayCodAcceso");
const inputCod = document.getElementById("codParticipante");

window.addEventListener("load", async () => {
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

const validarDatos = (idEvento) => {
    if (formModalInscripcion.checkValidity()) {
        verificarInscripcion(idEvento);
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
    formModalInscripcion.reset();
    formModalInscripcion.classList.remove("was-validated");
};

const verificarInscripcion = async (idEvento) => {
    let formData = new FormData();
    formData.append("ci", inputCI.value);
    formData.append("id_evento", idEvento);
    let estaInscrito = await axios.post("/api/participante/existe", formData).then(response => {
        return response.data;
    });
    if (estaInscrito != null) {
        localStorage.setItem("paisCarnet", document.getElementById("selectPais").value);
        window.location.href = "/eventos/inscripcion-evento/" + idEvento + "/" + inputCI.value;
    } else {
        displayCodigo.style.display = "block";
        inputCod.setAttribute("required", "");
    }
};