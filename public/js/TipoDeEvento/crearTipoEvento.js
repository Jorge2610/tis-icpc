const form = document.getElementById("formularioTipoEvento");
const botonCancelar = document.getElementById("cancelarBoton");
const inputNombre = document.getElementById("nombreTipoEvento");
const mensajeNombre = document.getElementById("mensajeNombre");
const inputDescripcion = document.getElementById("detalleTipoEvento");
const color = document.getElementById("colorTipoEvento");
let nombreAnterior = "";

let idTipoEvento;
const crearTipoEvento = (formData) => {
    axios
        .post("/api/tipo-evento", formData)
        .then(function (response) {
            console.log(response.data);
            const mensaje = response.data.mensaje;
            const nombreIgual = "El tipo de evento ya existe";
            if (response.data.borrado) {
                idTipoEvento = response.data.id;
                $("#modalTipoEventoExistente").modal("show");
            } else {
                mostrarAlerta(
                    response.data.error ? "Peligro" : "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
            }
            /**Si existe un tipo de evento con el mismo nombre, se mantiene los datos del formulario**/
            if (mensaje === nombreIgual) {
                //Si el tipo de evento existe entonces se guarda este valor y servirá para la validación
                nombreAnterior = inputNombre.value;
                inputNombre.classList.remove("is-valid");
                inputNombre.classList.add("is-invalid");
                inputDescripcion.classList.add("is-valid");
                mensajeNombre.textContent = "El tipo de evento ya existe";
            } else {
                form.querySelectorAll(".form-control, .form-select").forEach(
                    (Element) => {
                        Element.classList.remove("is-valid");
                    }
                );
                if (!response.data.borrado) {
                    form.reset();
                    setTimeout(() => {
                        window.location.href = "/admin/tipos-de-evento";
                    }, 1800);
                }
            }
        })
        .catch(function () {
            mostrarAlerta(
                "Error",
                "Hubo un error al guardar el tipo de evento",
                "danger"
            );
        });
};

const restaurarTipoEvento = async () => {
    modalActualizar();
    await axios
        .post("/api/tipo-evento/restaurar/" + idTipoEvento)
        .then(() => {
            $("#modalTipoEventoExistente").modal("hide");
            $("#modalActualizarTipoEvento").modal("show");
        })
        .catch((error) => {
            console.log(error);
        });
};

const actualizarTipoEvento = async (bb) => {
    const formulario = document.getElementById("formularioTipoEvento");
    const formData = new FormData(formulario);
    
    let error = false;
    let mensaje = "Restaurado exitosamente.";

    if (bb) {
        const response = await axios.post(
            "/api/tipo-evento/actualizar/" + idTipoEvento,
            formData
        );
        error = response.data.error;
        mensaje = response.data.mensaje;

        $("#modalActualizarTipoEvento").modal("hide");
    }
    mostrarAlerta(
        error ? "Peligro" : "Éxito",
        mensaje,
        error ? "danger" : "success"
    );
    setTimeout(() => {
        window.location.href = "/admin/tipos-de-evento";
    }, 1800);
};

form.addEventListener("submit", (event) => {
    event.preventDefault();
    form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
        Element.dispatchEvent(new Event("change"));
    });
    if (validar()) {
        const formData = new FormData(form);
        crearTipoEvento(formData);
    }
});

const modalActualizar = async () => {
    
    let nuevo = document.getElementById("nuevoNombre");
    let nuevaDescripcion =
        document.getElementById("nuevoDescripcion");
    let nuevoColor = document.getElementById("nuevoColor");
    let nombreAnterior = document.getElementById("antiguoNombre");
    let colorAnterior = document.getElementById("antiguoColor");
    let descripcionAnterior =
        document.getElementById("antiguoDescripcion");
    const response = await axios.get("/api/tipo-evento/" + idTipoEvento);
    nombre.textContent = inputNombre.value;
    nuevaDescripcion.textContent = inputDescripcion.value;
    nuevoColor.style.backgroundColor = color.value;
    colorAnterior.style.backgroundColor = response.data.color;
    descripcionAnterior.textContent = response.data.descripcion;
};

const validar = () => {
    return form.querySelector(".is-invalid") === null;
};

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

function validarNombreRepetido() {
    //Validaciones antes de que se guarde el nombre repetido
    if (nombreAnterior === "") {
        if (inputNombre.value === "") {
            inputNombre.classList.remove("is-valid");
            inputNombre.classList.add("is-invalid");
            mensajeNombre.textContent = "El nombre no puede estar vacío.";
        } else {
            inputNombre.classList.remove("is-invalid");
            inputNombre.classList.add("is-valid");
        }
    } else if (
        inputNombre.value !== nombreAnterior &&
        inputNombre.value !== ""
    ) {
        inputNombre.classList.remove("is-invalid");
        inputNombre.classList.add("is-valid");
        mensajeNombre.textContent = "";
    } else if (inputNombre.value === "") {
        inputNombre.classList.remove("is-valid");
        inputNombre.classList.add("is-invalid");
        mensajeNombre.textContent = "El nombre no puede estar vacío.";
    } else {
        inputNombre.classList.remove("is-valid");
        inputNombre.classList.add("is-invalid");
        mensajeNombre.textContent = "El tipo de evento ya existe";
    }
}

inputNombre.addEventListener("input", validarNombreRepetido);
inputNombre.addEventListener("change", validarNombreRepetido);

function quitarValidacion() {
    form.querySelectorAll(".form-control, .form-select").forEach((Element) => {
        Element.classList.remove("is-valid");
        Element.classList.remove("is-invalid");
    });
}

const limpiarForm = () => {
    form.reset();
    quitarValidacion();
    $("#modalTipoEventoExistente").modal("hide");
};
