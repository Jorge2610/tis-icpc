let tablaDePatrocinadores;
let tablaInicializada = false;

const input = document.getElementById("imageUpload");
const imagenPreview = document.getElementById("imagePreview");
const botonSubir = document.getElementById("botonSubirLogoPatrocinador");
const nombrePatrocinador = document.getElementById("nombrePatricinador");
const urlPatricinador = document.getElementById("urlPatrocinador");
const cancelar = document.getElementById("cancelarEditarPatrocinador");
const asignar = document.getElementById("editarPatrocinador");
const patrociandorSeleccionado = document.getElementById("nombrePatrocinador");

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[3, "desc"]],
    language: {
        lengthMenu: "Mostrar _MENU_ patrocinadores",
        zeroRecords: "Ningún patrociandor encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ patrocinadores",
        infoEmpty: "Ningún patrocinador encontrado",
        infoFiltered: "(filtrados desde _MAX_ patrocinadores en total)",
        search: "Buscar:",
        loadingRecords: "Cargando...",
        paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior",
        },
    },
};

const initDataTable = async () => {
    if (tablaInicializada) {
        tablaDePatrocinadores.destroy();
    }
    DataTable.datetime("DD-MM-YYYY");
    tablaDePatrocinadores = $("#tablaPatrocinadores").DataTable(
        dataTableOptions
    );
    tablaInicializada = true;
};

window.addEventListener("load", () => {
    initDataTable();
    if (!seleccionado) {
        patrociandorSeleccionado.textContent = "Seleccione un patrocinador";
        inhabilitarFormulario();
    }
});

const validarImagen = (input, peso, callback) => {
    if (input.files.length > 0) {
        const imagen = input.files[0];
        const maxFileSize = peso * 1024 * 1024;
        let mensaje = { mensaje: "", error: false };

        const type = !/image\/(png|jpeg|jpg)/.test(imagen.type);

        if (type || imagen.size > maxFileSize) {
            input.value = "";
            mensaje = { mensaje: "Archivo no válido", error: true };
        }

        if (typeof callback === "function") {
            callback(mensaje);
        }
    }
};

function previsualizarImagen(event) {
    validarImagen(input, 2, (mensaje) => {
        if (!mensaje.error) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                imagenPreview.src = e.target.result;
                botonSubir.classList.remove("btn-outline-danger");
                botonSubir.classList.add("btn-light", "text-primary");
            };
            reader.readAsDataURL(file);
        } else {
            mostrarAlerta("Error", mensaje.mensaje, "danger");
        }
    });
}

const validarDatos = () => {
    let form = document.getElementById("formularioEditarPatrocinador");
    if (form.checkValidity()) {
        form.classList.remove("was-validated");
        crearFormData();
        return;
    }
    if (input.files[0] === undefined) {
        botonSubir.classList.remove("btn-light", "text-primary");
        botonSubir.classList.add("btn-outline-danger");
    }
    form.classList.add("was-validated");
};

const crearFormData = () => {
    const formData = new FormData();
    formData.append("nombre", nombrePatrocinador.value);
    formData.append("enlace_web", urlPatricinador.value);
    formData.append("logo", input.files[0]);
    editarPatrocinador(formData);
};

const updateTablaPatrocinadores = () => {
    setTimeout(() => {
        window.location.href = "editar";
    }, 1700);
};

const resetInputs = () => {
    window.location.reload();
    /*
    document
        .getElementById("formularioEditarPatrocinador")
        .classList.remove("was-validated");
    botonSubir.classList.remove("btn-outline-danger");
    botonSubir.classList.add("btn-light", "text-primary");
    nombrePatrocinador.value = "";
    urlPatricinador.value = "";
    input.value = "";
    imagenPreview.src = "/image/uploading.png";*/
};

const inhabilitarFormulario = () => {
    botonSubir.disabled = true;
    nombrePatrocinador.disabled = true;
    urlPatricinador.disabled = true;
    input.disabled = true;
    asignar.disabled = true;
    cancelar.disabled = true;
    document.getElementById("formularioEditarPatrocinador").disabled = true;
};

const habilitarFormulario = () => {
    botonSubir.disabled = false;
    urlPatricinador.disabled = false;
    input.disabled = false;
    asignar.disabled = false;
    cancelar.disabled = false;
    document.getElementById("formularioEditarPatrocinador").disabled = false;
};

let seleccionado;
let idSeleccionado;
let asignando = false;
let patrocinadoresNoAsigandos;
const seleccionarPatrocinador = async (id, nombre) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    habilitarFormulario();
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    patrociandorSeleccionado.textContent = nombre;
    await llenarFormulario(id);
    await cargarPatrocinadoresNoAsignados();
    mostrarPatrocinadores();
};

const editarPatrocinador = async (formData) => {
    await axios.post(`/api/patrocinador/editar/${idSeleccionado}`, formData).then((response) => {
        mostrarAlerta(
            "Éxito",
            response.data.mensaje,
            response.error ? "danger" : "success"
        );
        resetInputs();
        updateTablaPatrocinadores();
    });
};

const getPatrocinador = async (id) => {
    const response = await axios.get(`/api/patrocinador/show/${id}`);
    return response.data;
};

const llenarFormulario = async (id) => {
    const patrocinador = await getPatrocinador(id);
    nombrePatrocinador.value = patrocinador.nombre;
    urlPatricinador.value = patrocinador.enlace_web;
    imagenPreview.src = patrocinador.ruta_imagen;
};