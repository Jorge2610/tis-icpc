import {mostrarAlerta} from "./alerta.js"

let tablaDeTipos;
let tablaInicializada = false;
let formulario = document.getElementById("formularioTipoEvento");

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
function remover(){
    formulario.classList.remove("was-validated");
    formulario.reset();
}

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
            let fecha = new Date(element.created_at);

            // Obtiene los componentes de la fecha
            let dia = fecha.getDate();
            let mes = fecha.getMonth() + 1; // Los meses en JavaScript se cuentan desde 0, así que sumamos 1.
            let anio = fecha.getFullYear();

            // Formatea la fecha en el nuevo formato 'd-m-Y'
            let fechaFormateada = dia + "-" + mes + "-" + anio;
            content += `
            <tr>
                <th scope='row'>${contador}</th>
                <td >${element.nombre}</td>
                <td class="container-color">
                    <div class="color-cell" style="background-color:${element.color};"></div>
                </td>
                <td class="text-center">Yo</td>
                <td class="text-center">${fechaFormateada}</td>
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
        form.classList.add("was-validated");
        if (!form.checkValidity()) {
            event.stopPropagation();
        } else {
            // Enviar formulario con AJAX
            let formData = new FormData(this);
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
            form.classList.remove("was-validated");
            form.reset();
            $("#modalCrearTipoEvento").modal("hide");
            initDataTable();
        }
        
    });
});

async function cargarTiposDeEvento() {
    let datos = await axios
        .get("/api/tipo-evento")
        .then((response) => {
            return response;
        })
        .catch((error) => {
            return error;
        });
    return datos;
}
