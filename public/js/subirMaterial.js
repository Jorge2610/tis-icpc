let tablaDeTipos;
let tablaInicializada = false;

const nombrePatrocinador = document.getElementById("nombreMaterial");
const urlPatricinador = document.getElementById("urlMaterial");
const cancelar = document.getElementById("asignarMaterialCancelar");
const asignar = document.getElementById("asignarMaterialAsignar");
const eventoSeleccionado = document.getElementById("tituloMaterial");

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
        tituloMaterial.disabled = true;
        urlMaterial.disabled = true;
        cancelar.disabled = true;
        asignar.disabled = true;
    }
});
let seleccionado;
let idSeleccionado;
const seleccionarEvento = (id, nombre) => {
    console.log(id + " " + nombre)
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    tituloMaterial.disabled = false;
    urlMaterial.disabled = false;
    cancelar.disabled = false;
    asignar.disabled = false;
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    eventoSeleccionado.textContent = nombre;
    input.value = "";
};


const validarDatos = () => {
    let form = document.getElementById("formularioAgregarMaterial");
    if (form.checkValidity() && input.files[0] != undefined) {
        form.classList.remove("was-validated");
        crearFormData();
        return;
    }
    form.classList.add("was-validated");
}

const crearFormData = () => {
    const formData = new FormData();
    formData.append("titulo", tituloMaterial.value);
    formData.append("enlace", urlMaterial.value);
    formData.append("id_evento", idSeleccionado);
    asignarMaterial(formData);
}

const resetInputs = () => {
    let form = document.getElementById("formularioAgregarMaterial");
    form.classList.remove("was-validated");
    tituloMaterial.value = "";
    urlMaterial.value = "";
    input.value = "";
}