
let idEvento;
let nombreEvento;
let inscritos = [];
let patternBase = ")[0-9]{6,10}[\\-]?[0-9A-Z]*";
let patternExistentes = "^(";
let carnet = document.getElementById("carnetParticipante");
let feedback = document.getElementById("validacionCarnetFeedback");

window.addEventListener("load", async () => {
    idEvento = window.location.href.split("/");
    idEvento = idEvento[idEvento.length - 1];
    nombreEvento = document.getElementById("nombreEvento").innerText;
    cargarPaises();
});

const cargarPaises = () => {
    let select = document.getElementById("selectPais");
    let options = "";
    PAISES.map(pais => {
        options += `
            <option title=${pais.name_es} value=${pais.dial_code} ${pais.code_3 === "BOL" ? "selected" : ""}>
                ${pais.emoji} ${pais.code_3}
            </option>
        `;
    });
    select.innerHTML = options;
    setCodPais();
};

const setCodPais = () => {
    let select = document.getElementById("selectPais");
    let codPais = document.getElementById("codPais");
    codPais.innerText = select.value;
}

const validarInputs = () => {
    let form = document.getElementById("formInscripcionParticipante");
    if (form.checkValidity()) {
        insribirParticipante();
    } else {
        form.classList.add('was-validated');
    }
};

const insribirParticipante = async () => {
    let formData = getParticipanteData();
    await axios.post("/api/participante/", formData).then((response) => {
        if (response.error) {
            actualizarPattern();
        } else {
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.error ? "danger" : "success"
            );
            setTimeout(() => {
                window.location.href = "/eventos/" + nombreEvento;
            }, 1750);
        }
    });
};

const getParticipanteData = () => {
    let formData = new FormData();
    formData.append("ci", document.getElementById("carnetParticipante").value);
    formData.append("nombres", document.getElementById("nombreParticipante").value);
    formData.append("apellidos", document.getElementById("apellidoParticipante").value);
    formData.append("correo", document.getElementById("correoParticipante").value);
    formData.append("celular", document.getElementById("telefonoParticipante").value);
    formData.append("fecha_nacimiento", document.getElementById("fechaNacParticipante").value);
    formData.append("institucion", document.getElementById("institucionParticipante").value);
    formData.append("grado_academico", document.getElementById("gradoAcademicoParticipante").value);
    formData.append("genero", document.getElementById("generoParticipante").value);
    formData.append("talla", document.getElementById("tallaParticipante").value);
    formData.append("id_evento", idEvento);
    return formData;
};

const actualizarPattern = () => {
    inscritos.push(carnet.value);
    setCarnetFeedBack();
    let nuevoPattern = patternExistentes + "(?!" + carnet.value + "$)";
    patternExistentes = nuevoPattern;
    nuevoPattern += patternBase;
    carnet.setAttribute("pattern", nuevoPattern);
};

const setCarnetFeedBack = () => {
    let encontrado = inscritos.find(inscrito => {
        return inscrito === carnet.value;
    });
    if (encontrado) {
        feedback.innerText = "Ya existe un participante con este número de carnet.";
    } else {
        feedback.innerText = "";
    }
};

const resetForm = () => {
    let form = document.getElementById("formInscripcionParticipante");
    form.reset();
    setCodPais();
    form.classList.remove("was-validated");
};
