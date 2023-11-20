const eventoSeleccionado = document.getElementById("nombreEvento");
const contenedorAsignar = document.getElementById("contenedorAsignar");

let tablaDeTipos;
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
    if (!seleccionado) {
        eventoSeleccionado.textContent = "Selecciona un evento";
    }
});

let seleccionado;
let idEvento;
let eventoAux;

const seleccionarEvento = (evento) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
        contenedorAsignar.innerHTML = "";
    }
    seleccionado = document.getElementById(evento.id);
    seleccionado.classList.add("table-primary");
    idEvento = evento.id;
    eventoSeleccionado.textContent = evento.nombre;
    cambiarEvento(evento);
    eventoAux = evento;
};

const cambiarEvento = (evento) => {
    // Limpiar el contenedor antes de agregar nuevas actividades
    contenedorAsignar.innerHTML = "";

    evento.actividades.forEach((actividad) => {
        // Crear un elemento div para cada actividad
        const actividadDiv = document.createElement("div");
        actividadDiv.classList.add("col-auto");
        actividadDiv.id = `tarjetaActividad${actividad.id}`;

        // Agregar el contenido de la actividad al div
        actividadDiv.innerHTML = `
            <div class="card" style="width: 10rem;">
                <div class="card-body">
                    <h5 class="card-title">${actividad.nombre}</h5>
                    <p class="card-text">${actividad.descripcion}</p>
                    <p class="card-text">Inicio de la actividad:<br> ${actividad.inicio_actividad}</p>
                    <p class="card-text">Fin de la actividad:<br> ${actividad.fin_actividad}</p>
                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalEliminarActividad" onclick="seleccionarActividad(${actividad.id})">Eliminar</a>
                </div>
            </div>
        `;

        // Agregar el div al contenedor
        contenedorAsignar.appendChild(actividadDiv);
    });
};

// const cargarActividades = async (idEvento) => {
//     // Realizar una llamada a tu API para obtener las actividades asociadas al evento
//     const response = await axios.get(
//         `/api/actividad/obtener-actividad/${idEvento}`
//     );
//     const actividades = response.data;

//     // Limpiar el contenedor y volver a renderizar las actividades
//     contenedorAsignar.innerHTML = "";
//     actividades.forEach((actividad) => {
//         contenedorAsignar.innerHTML += `<div class="col-auto" id="tarjetaActividad${actividad.id}">
//             <div class="card" style="width: 10rem;">
//                 <div class="card-body">
//                     <h5 class="card-title">${actividad.nombre}</h5>
//                     <p class="card-text">${actividad.descripcion}</p>
//                     <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
//                     data-bs-target="#modalEliminarActividad" onclick="seleccionarActividad(${actividad.id})">Eliminar</a>
//                 </div>
//             </div>
//         </div>`;
//     });
// };

const seleccionarActividad = (id) => {
    actividadSeleccionada = id;
};

const eliminarActividad = async () => {
    if (actividadSeleccionada) {
        // Realizar una llamada a tu API para eliminar la actividad
        await axios
            .delete(`/api/actividad/${actividadSeleccionada}`)
            .then((response) => {
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.error ? "danger" : "success"
                );
                cargarActividades();
            });
        // Actualizar la vista después de eliminar
        
    }
};

const cargarActividades = async () => {
    await axios.get(`/api/actividad/${idEvento}`).then((response) => {
        document.getElementById(`contadorActividades${idEvento}`).textContent =
            response.data.length;

        const tarjetasActividad = document.querySelectorAll('[id^="tarjetaActividad"]');
        
        tarjetasActividad.forEach((tarjetaActividad) => {
            const actividadId = tarjetaActividad.id.replace('tarjetaActividad', '');
            const actividadEnRespuesta = response.data.find(actividad => actividad.id === parseInt(actividadId));

            if (!actividadEnRespuesta) {
                tarjetaActividad.remove();
            }
        });
    });
};


