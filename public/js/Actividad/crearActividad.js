let tablaDeTipos;
const fechaInicio = document.getElementById("fechaInicio");
const fechaFin = document.getElementById("fechaFin");
let tablaInicializada = false;

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[3, "desc"]],
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
    DataTable.datetime("DD-MM-YYYY");
    tablaDeTipos = $("#tablaEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

window.addEventListener("load", () => {
    initDataTable();
});

/**Funciones para crear actividad**/
function crearActividad() {
    const form = document.getElementById("formularioActividad");
    form.addEventListener("submit", async function (event) {
        event.preventDefault();
        form.classList.add("was-validated");

        if (!form.checkValidity()) {
            event.stopPropagation();
        } else {
            const formData = new FormData(this);
            try {
                const response = await axios.post("/api/actividad", formData);
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
                form.classList.remove("was-validated");
                form.reset();
                window.location.href = "/admin/actividad";
            } catch (error) {
                mostrarAlerta("Error", "Hubo un error al guardar la actividad", "danger");
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", crearActividad);

