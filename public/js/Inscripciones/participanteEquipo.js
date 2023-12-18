let idEvento;
let nombreEvento;
let idEquipo;
let codEquipo;

window.addEventListener("load", async () => {
    idEvento = window.location.href.split("/");
    idEquipo = idEvento[5]
    idEvento = idEvento[7];
    nombreEvento = document.getElementById("nombreEvento").innerText;
    let pais = document.getElementById("codPaisCarnet");
    if (pais.innerText === "") {
        if (localStorage.getItem("paisCarnet") === null) {
            accesoNoAutorizado();
        } else {
            document.getElementById("codPaisCarnet").innerText = localStorage.getItem("paisCarnet");
            //localStorage.removeItem("paisCarnet");
        }
    }
    cargarPaises();
});

const accesoNoAutorizado = () => {
    let pagina = document.getElementById("formularioInscripcionEvento");
    let content = `
        <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh">
            <h2 class="text-center text-secondary"><i>Acceso no autorizado...</i></h2>
        </div>
    `;
    pagina.innerHTML = content;
};

const cargarPaises = () => {
    let select = document.getElementById("selectPais");
    let lit = document.getElementById("codPaisLit").value;
    let codPaisLit = lit != "" ? lit : "+591"; 
    let options = "";
    PAISES.map(pais => {
        options += `
            <option title=${pais.name_es} value=${pais.dial_code} ${pais.dial_code=== codPaisLit ? "selected" : ""}>
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
    await axios.post("/api/equipo/addIntegrante/"+idEquipo, formData).then((response) => {
        mostrarAlerta(
            "Éxito",
            response.data.mensaje,
            response.error ? "danger" : "success"
        );
        setTimeout(() => {
            codEquipo =localStorage.getItem("codigo");
            window.location.href = "/eventos/tabla-equipo/"+codEquipo+'/'+idEvento ;
        }, 1750);
    });
};

const getParticipanteData = () => {
    let formData = new FormData();
    formData.append("ci", document.getElementById("carnetParticipante").value);
    formData.append("nombres", document.getElementById("nombreParticipante").value);
    formData.append("apellidos", document.getElementById("apellidoParticipante").value);
    formData.append("correo", document.getElementById("correoParticipante").value);
    formData.append("codigo_telefono", document.getElementById("selectPais").value);
    formData.append("telefono", document.getElementById("telefonoParticipante").value);
    formData.append("fecha_nacimiento", document.getElementById("fechaNacParticipante").value);
    formData.append("pais", document.getElementById("codPaisCarnet").innerText);
    formData.append("institucion", document.getElementById("institucionParticipante").value);
    formData.append("grado_academico", document.getElementById("gradoAcademicoParticipante").value);
    formData.append("genero", document.getElementById("generoParticipante").value);
    formData.append("talla", document.getElementById("tallaParticipante").value);
    formData.append("talla", document.getElementById("tallaParticipante").value);
    formData.append("id_evento", idEvento);
    return formData;
};

const resetForm = () => {
    let form = document.getElementById("formInscripcionParticipante");
    form.reset();
    setCodPais();
    form.classList.remove("was-validated");
};