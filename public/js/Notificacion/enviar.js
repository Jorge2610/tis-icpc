let tablaDeTipos;
let tablaInicializada = false;

const eventoSeleccionado = document.getElementById("nombreEvento");
const form = document.getElementById("formNotificacion");
const asunto = document.getElementById("asunto");
const mensaje = document.getElementById("mensaje");
const archivo = document.getElementById("archivo");

let patrocinadores;

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [2, "desc"],
    ordering: true,
    language: {
        lengthMenu: "Mostrar _MENU_ eventos",
        zeroRecords: "Ningún evento encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ eventos",
        infoEmpty: "Ningún evento encontrado",
        infoFiltered: "(filtrados desde _MAX_ eventos totales)",
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
        inhabilitarForm();
        eventoSeleccionado.textContent = "Seleccione un evento";
    }
});

const inhabilitarForm = () => {
    asunto.disabled = true;
    mensaje.disabled = true;
    archivo.disabled = true;
    document.getElementById("botonEnviar").disabled = true;
};

const habilitarForm = () => {
    asunto.disabled = false;
    mensaje.disabled = false;
    archivo.disabled = false;
    document.getElementById("botonEnviar").disabled = false;
};

let seleccionado;
let idSeleccionado;

const seleccionarEvento = async (id, nombre) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    habilitarForm();
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    eventoSeleccionado.textContent = nombre;
};

const validarForm = () => {
    if (form.checkValidity()) {
        form.classList.remove("was-validated");

        $("#modalEnviarNotificacion").modal("show");
    }
    form.classList.add("was-validated");
};

const enviar = async () => {
    const formulario = new FormData(form);
    formulario.append("id_evento", idSeleccionado);
    formulario.append("nombre", eventoSeleccionado.textContent);
    const res = await axios.post("/api/notificacion/", formulario);
    $("#modalEnviarNotificacion").modal("hide");
    mostrarAlerta(
        res.data.error ? "Peligro" : "Éxito",
        res.data.mensaje,
        res.data.error ? "danger" : "success"
    );
    resetInputs();
};

const resetInputs = () => {
    form.reset();
    form.classList.remove("was-validated");

    asunto.value = "";

    mensaje.value = "";

    archivo.value = "";
};

const onchangeArchivo = () => {
    const inputArchivo = document.getElementById("archivo");
    const archivo = inputArchivo.files[0];

    if (archivo) {
      
        const maxSize = 5 * 1024 * 1024; // 3 megabytes
        if (archivo.size > maxSize) {
            mostrarAlerta(
                "danger",
                "El archivo no debe superar los 5 MB",
                'danger'
            )
            inputArchivo.value = "";
        }
    }
};
