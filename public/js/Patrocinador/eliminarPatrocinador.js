let tablaDePatrocinadores;
let tablaInicializada = false;

const input = document.getElementById("imageUpload");
const imagenPreview = document.getElementById("imagePreview");
const botonSubir = document.getElementById("botonSubirLogoPatrocinador");
const nombrePatrocinador = document.getElementById("nombrePatricinador");
const urlPatricinador = document.getElementById("urlPatrocinador");
const cancelar = document.getElementById("crearPatrocinadorCancelar");
const asignar = document.getElementById("crearPatrocinadorCrear");

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
    tablaDePatrocinadores = $("#tablaEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

window.addEventListener("load", () => {
    initDataTable();
});

const eliminarPatrocinador = async (id) => {
    await axios.delete("/api/patrocinador/" + id).then((response) => {
        mostrarAlerta(
            "Éxito",
            response.data.mensaje,
            response.error ? "danger" : "success"
        );
        updateTablaPatrocinadores();
    });
};

const updateTablaPatrocinadores = () => {
    setTimeout(() => {
        window.location.href = "/admin/patrocinador/eliminar";
    }, 1700);
};