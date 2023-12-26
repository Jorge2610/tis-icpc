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
        zeroRecords: "Ningún evento encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ningún evento encontrado",
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
        if(actividad.descripcion==null){
            actividad.descripcion="";
        }
        // Crear un elemento div para cada actividad
        const actividadDiv = document.createElement("div");
        actividadDiv.classList.add("col-auto");
        actividadDiv.id = `tarjetaActividad${actividad.id}`;

        // Verificar si la fecha de inicio es mayor al día de hoy
        const fechaFin = new Date(actividad.fin_actividad);
        const hoy = new Date();
        const inscripcion = actividad.inscripcion ? `<div class="d-flex justify-content-end align-items-center" style="border-radius: 10px; width: 100%; height: 25px;"> <p class=" text-center rounded m-2 py-1 px-2 text-info">Inscripción</p> </div>` : ``;
        if (fechaFin > hoy) {
            // Agregar el contenido de la actividad al div con el botón de eliminar
            actividadDiv.innerHTML = `
                <div class="container col-12 col-md-12 col-lg-12">
                    <div class="card w-100 my-3 shadow" style="min-height: 150px; width: 17rem !important">
                        <div class="card-body">
                            <h3 class="card-title">${actividad.nombre}</h3>
                            <h5 class="card-text text-truncate d-block" style="max-width: 300px;" title="${actividad.descripcion}">${actividad.descripcion}</h5>
                            <h6 class="card-text text-truncate d-block" style="max-width: 300px;">Inicio: ${actividad.inicio_actividad}</h6>
                            <h6 class="card-text text-truncate d-block" style="max-width: 300px;">Fin: ${actividad.fin_actividad}</h6>
                            ${inscripcion}
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalEliminarActividad" onclick="seleccionarActividad(${actividad.id})">Editar
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
                            <h3 class="card-title">${actividad.nombre}</h3>
                            <h5 class="card-text text-truncate d-block" style="max-width: 300px;" title="${actividad.descripcion}">${actividad.descripcion}</h5>
                            <h6 class="card-text text-truncate d-block" style="max-width: 300px;">Inicio: ${actividad.inicio_actividad}</h6>
                            <h6 class="card-text text-truncate d-block" style="max-width: 300px;">Fin: ${actividad.fin_actividad}</h6>
                            ${inscripcion}
                        </div>
                    </div>
                </div>
            `;
        }

        // Agregar el div al contenedor de actividades
        actividadesContainer.appendChild(actividadDiv);
    });
};

const seleccionarActividad = (id) => {
    window.location.href="/admin/actividad/editar-actividad/"+id;
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
