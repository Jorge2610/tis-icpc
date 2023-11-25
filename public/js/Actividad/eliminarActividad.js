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
let actividadSeleccionada;


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

    // Cargar actividades después de cambiar de evento
    cargarActividades();
};

const cambiarEvento = (evento) => {
    // Limpiar el contenedor antes de agregar nuevas actividades
    contenedorAsignar.innerHTML = "";

    // Crear un contenedor div para las actividades con una altura fija y overflow-y: auto
    const actividadesContainer = document.createElement("div");
    actividadesContainer.style.maxHeight = "350px"; // Ajusta la altura según sea necesario
    actividadesContainer.style.overflowY = "auto";
    contenedorAsignar.appendChild(actividadesContainer);

    evento.actividades.forEach((actividad) => {
        // Crear un elemento div para cada actividad
        if(actividad.descripcion==null){
            actividad.descripcion="";
        }
        const actividadDiv = document.createElement("div");
        actividadDiv.classList.add("col-auto");
        actividadDiv.id = `tarjetaActividad${actividad.id}`;

        // Verificar si la fecha de inicio es mayor al día de hoy
        const fechaInicio = new Date(actividad.inicio_actividad);
        const hoy = new Date();

        if (fechaInicio > hoy) {
            // Agregar el contenido de la actividad al div con el botón de eliminar
            actividadDiv.innerHTML = `
                <div class="container col-12 col-md-12 col-lg-12">
                    <div class="card w-100 my-3 shadow" style="min-height: 100px; width: 17rem !important">
                        <div class="card-body">
                            <h5 class="card-title">${actividad.nombre}</h5>
                            <h4 class="card-text text-truncate d-block" style="max-width: 300px;">${actividad.descripcion}</h4>
                            <h6 class="card-text text-truncate d-block" style="max-width: 300px;">Inicio: ${actividad.inicio_actividad}</h6>
                            <h6 class="card-text text-truncate d-block" style="max-width: 300px;">Fin: ${actividad.fin_actividad}</h6>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEliminarActividad" onclick="seleccionarActividad(${actividad.id})">Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Agregar el contenido de la actividad al div sin el botón de eliminar
            actividadDiv.innerHTML = `
                <div class="container col-12 col-md-12 col-lg-12">
                    <div class="card w-100 my-3 shadow" style="min-height: 100px; width: 17rem !important">
                        <div class="card-body">
                            <h5 class="card-title">${actividad.nombre}</h5>
                            <h4 class="card-text text-truncate d-block" style="max-width: 300px;">${actividad.descripcion}</h4>
                            <h6 class="card-text text-truncate d-block" style="max-width: 300px;">Inicio: ${actividad.inicio_actividad}</h6>
                            <h6 class="card-text text-truncate d-block" style="max-width: 300px;">Fin: ${actividad.fin_actividad}</h6>
                        </div>
                    </div>
                </div>
            `;
        }

        // Agregar el div al contenedor de actividades
        actividadesContainer.appendChild(actividadDiv);
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
        await axios
            .delete(`/api/actividad/${actividadSeleccionada}`)
            .then((response) => {
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.error ? "danger" : "success"
                );

                // Actualizar el contador de actividades en la tabla
                const contadorActividadesElement = document.getElementById(`contadorActividades${idEvento}`);
                if (contadorActividadesElement) {
                    const newCount = parseInt(contadorActividadesElement.textContent) - 1;
                    contadorActividadesElement.textContent = newCount;
                }

                // Recargar las actividades después de eliminar
                cargarActividades();
            });
    }
};



const cargarActividades = async () => {
    const tarjetasActividad = document.querySelectorAll('[id^="tarjetaActividad"]');

    // Oculta todas las actividades
    tarjetasActividad.forEach((tarjetaActividad) => {
        tarjetaActividad.style.display = 'none';
    });

    await axios.get(`/api/actividad/${idEvento}`).then((response) => {
        response.data.forEach((actividad) => {
            const actividadDiv = document.getElementById(`tarjetaActividad${actividad.id}`);
            
            if (actividadDiv) {
                // Si la actividad ya existe, muéstrala
                actividadDiv.style.display = 'block';
            } else {
                // Si la actividad no existe, créala y agrégala al contenedor
                cambiarEvento(eventoAux); // Asegúrate de que eventoAux esté disponible
            }
        });

        // Actualizar el contador de actividades en la tabla después de cargar
        const contadorActividadesElement = document.getElementById(`contadorActividades${idEvento}`);
        if (contadorActividadesElement) {
            contadorActividadesElement.textContent = response.data.length;
        }
    });
};
