let tablaDeTipos;
let tablaInicializada = false;


const contenedorAsignar = document.getElementById("contenedorAsignar");
const eventoSeleccionado = document.getElementById("nombreEvento");

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

    }
});

let seleccionado;
let idSeleccionado;
const seleccionarEvento = (id, nombre) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    console.log(idSeleccionado)
    cargarPatrocinadores();
};

const cargarPatrocinadores = async () => {
    try {
        const response = await getPatrocinadores();
        const patrocinadores = response.data;
        const contenedor = document.getElementById("contenedorPatrocinadores");

        const content = patrocinadores
            .map((patrocinador) => {
                const ruta = patrocinador.enlace_web
                    ? patrocinador.enlace_web
                    : "#";
                return `
            <div class="col-12 col-md-12 d-flex justify-content-center">
                <div id="imagenPatrocinador">
                    <a href="${ruta}" target="_blank" style="color:transparent;">
                        <img id="imagenPatrocinador" src="${patrocinador.ruta_logo}" title="${patrocinador.nombre}"
                            alt="Imagen del patrocinador" class="imagenPatrocinador">
                    </a>
                    <button class="borrar-patrocinador" data-bs-toggle="modal" data-bs-whateve="${patrocinador.id}" 
                        data-bs-target="#modalBorrarPatrocinador" onclick="borrarPatrocinador(${patrocinador.id})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        `;
            })
            .join("");

        contenedor.innerHTML = content;
    } catch (error) {
        alert(error);
    }
};

const getPatrocinadores = async () => {
    const id_evento = idSeleccionado;
    const datos = await axios
        .get(`/api/patrocinador/${id_evento}`)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            return error;
        });
    return datos;
};

 const borrarPatrocinador = (id) => {
     const modalBorrar = document.getElementById("modalBorrarPatrocinador");
     modalBorrar.setAttribute("idpatrocinador", id);
 };

 const borrar1 = async () => {
     const modalBorrar = document.getElementById("modalBorrarPatrocinador");
     await axios
         .delete(
             `/api/patrocinador/${modalBorrar.getAttribute("idpatrocinador")}`
         )
         .then((response) => {
            return response;
         })
         .catch((error) => {
             return error;
         });
     await cargarPatrocinadores();
     updateNroPatrocinadores();
 };

 const updateNroPatrocinadores = () => {
    let casilla = document.getElementById(`contadorPatrocinadores${idSeleccionado}`);
    let valor = parseInt(casilla.textContent);
    casilla.textContent = valor - 1;
}