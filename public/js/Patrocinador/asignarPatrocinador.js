let tablaDeTipos;
let tablaInicializada = false;

const input = document.getElementById("imageUpload");
const imagenPreview = document.getElementById("imagePreview");
const botonSubir = document.getElementById("botonSubirLogoPatrocinador");
const nombrePatrocinador = document.getElementById("nombrePatricinador");
const urlPatricinador = document.getElementById("urlPatrocinador");
const cancelar = document.getElementById("asignarPatrocinadorCancelar");
const asignar = document.getElementById("asignarPatrocinadorAsignar");
const eventoSeleccionado = document.getElementById("nombreEvento");

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[3, "desc"]],
    language: {
        lengthMenu: "Mostrar _MENU_ eventos",
        zeroRecords: "Ningún tipo de evento encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ningún usuario encontrado",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
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
        tablaDeTipos.destroy();
    }
    DataTable.datetime("DD-MM-YYYY");
    tablaDeTipos = $("#tablaEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

window.addEventListener("load", () => {
    initDataTable();
    if (!seleccionado) {
        eventoSeleccionado.textContent = "Selecciona un evento";
        botonSubir.disabled = true;
        nombrePatrocinador.disabled = true;
        urlPatricinador.disabled = true;
        cancelar.disabled = true;
        asignar.disabled = true;
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

let seleccionado;
let idSeleccionado;
const seleccionarEvento = (id, nombre) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    botonSubir.disabled = false;
    nombrePatrocinador.disabled = false;
    urlPatricinador.disabled = false;
    cancelar.disabled = false;
    asignar.disabled = false;
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    eventoSeleccionado.textContent = nombre;
    input.value = "";
    imagenPreview.src = "/image/uploading.png";
    botonSubir.style.display = "block";
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
    let form = document.getElementById("formularioAgregarPatrocinador");
    if (form.checkValidity() && input.files[0] != undefined) {
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
    formData.append("id_evento", idSeleccionado);
    asignarPatrocinador(formData);
};

const asignarPatrocinador = async (formData) => {
    await axios.post("/api/patrocinador", formData).then((response) => {
        mostrarAlerta(
            "Éxito",
            response.data.mensaje,
            response.error ? "danger" : "success"
        );
        updateNroPatrocinadores();
        resetInputs();
    });
};

const updateNroPatrocinadores = () => {
    let casilla = document.getElementById(
        `contadorPatrocinadores${idSeleccionado}`
    );
    let valor = parseInt(casilla.textContent);
    casilla.textContent = valor + 1;
};

const resetInputs = () => {
    let form = document.getElementById("formularioAgregarPatrocinador");
    botonSubir.classList.remove("btn-outline-danger");
    botonSubir.classList.add("btn-light", "text-primary");
    form.classList.remove("was-validated");
    nombrePatrocinador.value = "";
    urlPatricinador.value = "";
    input.value = "";
    imagenPreview.src = "/image/uploading.png";
};