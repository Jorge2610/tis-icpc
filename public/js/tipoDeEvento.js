let tablaDeTipos;
let tablaInicializada = false;

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    language: {
        lengthMenu: "Mostrar _MENU_  entradas",
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
    await tiposDeEvento();
    tablaDeTipos = $("#tablaTipoDeEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

const tiposDeEvento = async () => {
    try {
        const response = await cargarTiposDeEvento();
        const tiposDeEvento = response.data;
        let content = ``;
        let contador = 1;
        tiposDeEvento.forEach((element) => {
            // Convierte la cadena a un objeto Date
            var fecha = new Date(element.created_at);

            // Obtiene los componentes de la fecha
            var dia = fecha.getDate();
            var mes = fecha.getMonth() + 1; // Los meses en JavaScript se cuentan desde 0, así que sumamos 1.
            var anio = fecha.getFullYear();

            // Formatea la fecha en el nuevo formato 'd-m-Y'
            var fechaFormateada = dia + "-" + mes + "-" + anio;
            content += `
            <tr>
                <th scope='row'>${contador}</th>
                <td>${element.nombre}</td>
                <td>${element.color}</td>
                <td>Yo</td>
                <td>${fechaFormateada}</td>
            </tr>`;
            contador++;
        });
        let tableBody = document.getElementById("datosTabla");
        tableBody.innerHTML = content;
    } catch (error) {
        alert(error);
    }
};

window.addEventListener("load", async () => {
    await initDataTable();
});

document.addEventListener("DOMContentLoaded", function () {
    let form = document.getElementById("formularioTipoEvento");
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        if (!form.checkValidity()) {
            event.stopPropagation();
        } else {
            // Enviar formulario con AJAX
            var formData = new FormData(this);
            axios
                .post("/api/tipo-evento", formData)
                .then(function (response) {
                    mostrarAlerta(
                        "Éxito",
                        response.data.mensaje,
                        response.data.error ? "danger" : "success"
                    );
                })
                .catch(function (error) {
                    mostrarAlerta(
                        "Error",
                        "Hubo un error al guardar el tipo de evento",
                        "danger"
                    );
                });
            $("#modalCrearTipoEvento").modal("hide");
            initDataTable();
        }
        form.classList.add("was-validated");
    });
});

async function cargarTiposDeEvento() {
    datos = await axios
        .get("/api/tipo-evento")
        .then((response) => {
            return response;
        })
        .catch((error) => {
            return error;
        });
    return datos;
}

function mostrarAlerta(titulo, mensaje, tipo) {
    var icono = "";

    // Asignar el icono y el color de fondo según el tipo
    if (tipo === "success") {
        icono = '<i class="bi bi-check-circle"></i>'; // Icono de círculo con check verde de Bootstrap Icons
    } else if (tipo === "danger") {
        icono = '<i class="bi bi-x-circle"></i>'; // Icono de círculo con cruz roja de Bootstrap Icons
    } else {
        icono = '<i class="bi bi-info-circle"></i>'; // Icono de círculo con información azul de Bootstrap Icons por defecto
    }

    var alerta = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="mr-2">${icono}</div>
                <div>
                    ${mensaje}
                </div>
            </div>
        </div>
    `;
    document.getElementById("alertsContainer").innerHTML = alerta;
    setTimeout(function () {
        document.querySelector(".alert").remove(); // Remover la alerta después de 2 segundos
    }, 2000);
}
