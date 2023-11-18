let tablaDeTipos;
let tablaInicializada = false;

const tituloSitio = document.getElementById("tituloSitio");
const urlSitio = document.getElementById("urlSitio");
const cancelar = document.getElementById("asignarSitioCancelar");
const asignar = document.getElementById("asignarSitioAsignar");
const eventoSeleccionado = document.getElementById("nombreEvento");

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[3, 'desc']],
    language: {
        lengthMenu: "Mostrar _MENU_ entradas",
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
    DataTable.datetime('DD-MM-YYYY');
    tablaDeTipos = $("#tablaEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

window.addEventListener("load", () => {
    initDataTable();
    if (!seleccionado) {
        eventoSeleccionado.textContent = "Selecciona un evento";
        tituloSitio.disabled = true;
        urlSitio.disabled = true;
        cancelar.disabled = true;
        asignar.disabled = true;
    }
});

let seleccionado;
let idSeleccionado;
const seleccionarEvento = (id, nombre) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    tituloSitio.disabled = false;
    urlSitio.disabled = false;
    cancelar.disabled = false;
    asignar.disabled = false;
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    eventoSeleccionado.textContent = nombre;
};

const validarDatos = () => {
    const form = document.getElementById("formularioAgregarSitio");
    if (form.checkValidity()) {
        form.classList.remove("was-validated");
        crearFormData(form);
    }
    form.classList.add("was-validated");
};

const crearFormData = (form) => {
    const formData = new FormData(form);
    formData.append("id_evento", idSeleccionado);
    axios
        .post("/api/recurso", formData)
        .then((response) => {
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.error ? "danger" : "success"
            );
            resetInputs();
            sumarContador();
        })
        .catch((err) => {
            console.error(err);
        });
};

const sumarContador = async () => {
    const contadorSitios = document.getElementById(
        `contadorSitios${idSeleccionado}`
    );
    contadorSitios.textContent = parseInt(contadorSitios.textContent) + 1;
};
const resetInputs = () => {
    let form = document.getElementById("formularioAgregarSitio");
    form.classList.remove("was-validated");
    tituloSitio.value = "";
    urlSitio.value = "";
};
