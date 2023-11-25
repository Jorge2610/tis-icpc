const eventoSeleccionado = document.getElementById("nombreEvento");
const contenedorAsignar = document.getElementById("contenedorAsignar");

let tablaDeTipos;
let tablaInicializada = false;

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[2, "desc"]],
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
    if (!seleccionado) {
        eventoSeleccionado.textContent = "Selecciona un evento";
    }
});

let seleccionado;
let idEvento;

const seleccionarEvento = (afiche) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
        contenedorAsignar.innerHTML = "";
    }
    seleccionado = document.getElementById(afiche.id);
    seleccionado.classList.add("table-primary");
    idEvento = afiche.id;
    eventoSeleccionado.textContent = afiche.nombre;
    cambiarEvento(afiche);
};

const cambiarEvento = (evento) => {
    evento.afiches.map((afiche) => {
        contenedorAsignar.innerHTML += `<div class="col-auto" id="tarjetaAfiche${afiche.id}">
        <div class="card" style="width: 10rem;">
            <img src="${afiche.ruta_imagen}" class="card-img-top" alt="Afiche" id="imagenAfichepreview${afiche.id}">
            <div class="card-body d-flex justify-content-around gap-2">
                <input type="file" id="imageUpload${afiche.id}" style="display: none;" onchange="previsualizarImagen(event, ${afiche.id})" accept="image/jpeg, image/png, image/jpg">
                <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#modalEliminarAfiche" onclick="seleccionarAfiche(${afiche.id})">Eliminar</a>
            </div>
        </div>
    </div>`;
    });
};

const seleccionarAfiche = (id) => {
    aficheSeleccion = id;
};
const eliminarAfiche = async () => {
    if (aficheSeleccion) {
        await axios
            .delete(`/api/afiche/${aficheSeleccion}`)
            .then((response) => {
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.error ? "danger" : "success"
                );
                cargarAfiche();
            });
    }
};

const cargarAfiche = async () => {
    await axios.get(`/api/afiche/${idEvento}`).then((response) => {
        document.getElementById(`contadorAfiches${idEvento}`).textContent =
            response.data.length;
        document.getElementById(`tarjetaAfiche${aficheSeleccion}`).remove();
    });
};
