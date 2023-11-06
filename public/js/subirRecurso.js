let tablaDeTipos;
let tablaInicializada = false;

const tituloRecurso = document.getElementById("tituloRecurso");
const urlRecurso = document.getElementById("urlRecurso");
const cancelar = document.getElementById("asignarRecursoCancelar");
const asignar = document.getElementById("asignarRecursoAsignar");

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
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
    tablaDeTipos = $("#tablaEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

window.addEventListener("load", () => {
    initDataTable();
    if (!seleccionado) {
        eventoSeleccionado.textContent = "Selecciona un evento";
        tituloRecurso.disabled = true;
        urlRecurso.disabled = true;
        cancelar.disabled = true;
        asignar.disabled = true;
    }
});

let seleccionado;
let idSeleccionado;
const seleccionarEvento = (id, nombre) => {
    console.log(id + " " + nombre);
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    tituloRecurso.disabled = false;
    urlRecurso.disabled = false;
    cancelar.disabled = false;
    asignar.disabled = false;
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    eventoSeleccionado.textContent = nombre;
    input.value = "";
};

const validarDatos = () => {
    const form = crearFormData();
    if (form.checkValidity()) {
        axios.post("/api/recurso", form).then((response) => {
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.error ? "danger" : "success"
            );
        });
    }
};

const crearFormData = () => {
    const formData = new FormData();
    formData.append("titulo", tituloRecurso.value);
    formData.append("enlace", urlRecurso.value);
    formData.append("id_evento", idSeleccionado);
    asignarRecurso(formData);
    return formData;
};

const resetInputs = () => {
    let form = document.getElementById("formularioAgregarRecurso");
    form.classList.remove("was-validated");
    tituloRecurso.value = "";
    urlRecurso.value = "";
    input.value = "";
};
