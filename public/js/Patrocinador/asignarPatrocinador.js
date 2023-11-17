let tablaDeTipos;
let tablaInicializada = false;

const eventoSeleccionado = document.getElementById("nombreEvento");
let patrocinadores;

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order:[2, 'desc'],
    ordering: true,
    language: {
        lengthMenu: "Mostrar _MENU_ eventos",
        zeroRecords: "Ningún evento encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ eventos",
        infoEmpty: "Ningún evento encontrado",
        infoFiltered: "(filtrados desde _MAX_ eventos totales)",
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
    getPatrocinadores();
});

const getPatrocinadores = async () => {
    let datos = await axios.get("/api/patrocinador").then((response) => {
        return response.data;
    });
    patrocinadores = await datos;
};

let seleccionado;
let idSeleccionado;
const seleccionarEvento = async (id, nombre) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    eventoSeleccionado.textContent = nombre;
    cargarPatrocinadores();  
};

const cargarPatrocinadores = async () => {
    let patrocinadoresEvento = await getPatrocinadoresEvento(idSeleccionado);
    mostrarPatrocinadores(patrocinadoresEvento);
};

const getPatrocinadoresEvento = async (id) => {
    let data = await axios.get("/api/patrocinador/" + id).then((response) => {
        return response.data;
    });
    return data;
};

const mostrarPatrocinadores = (patrocinadoresEvento) => {
    let patrocinadoresNoAsigandos = getNoAsignados(patrocinadoresEvento);
    let div = document.getElementById('divPatrocinadores');
    let content = "";
    patrocinadoresNoAsigandos.map((patrocinador) => {
        content += `
            <div class="col text-center">
                <div class="card" style="height: 13rem">
                    <img src="${patrocinador.ruta_imagen}" class="img-fluid rounded"
                        alt="logoPatrocinador">
                    <div class="card-body">
                        <h6 class="card-title text-truncate" title="${patrocinador.nombre}">
                            ${patrocinador.nombre}
                        </h6>
                        <button class="btn btn-primary btn-sm" onclick="asignarPatrocinador(${patrocinador.id})">Asignar</button>
                    </div>
                </div>
            </div>
        `;
    });
    div.innerHTML = content;
};

const getNoAsignados = (patrocinadoresEvento) => {
    let patrocinadoresNoAsignados = [];
    let indice = 0;
    patrocinadores.map((patrocinador) => {
        if (indice < patrocinadoresEvento.length && patrocinadoresEvento[indice].id_patrocinador === patrocinador.id) {
            indice++;
        } else {
            patrocinadoresNoAsignados.push(patrocinador);
        }
    });
    return patrocinadoresNoAsignados;
};

const asignarPatrocinador = async (idPatrocinador) => {
    console.log(idPatrocinador);
    let formData = new FormData();
    formData.append('id_evento', idSeleccionado);
    formData.append('id_patrocinador', idPatrocinador);
    let data = await axios.post("/api/patrocinador/asignar", formData).then((response) => {
        mostrarAlerta(
            "Éxito",
            response.data.mensaje,
            response.error ? "danger" : "success"
        );
        updateNroPatrocinadores();
        cargarPatrocinadores();
    });
};

const updateNroPatrocinadores = () => {
    let casilla = document.getElementById(
        `contadorPatrocinadores${idSeleccionado}`
    );
    let valor = parseInt(casilla.textContent);
    casilla.textContent = valor + 1;
};

const resize_ob = new ResizeObserver(function (entries) {
    let rect = entries[0].contentRect;
    let height = rect.height;
    vh = parseInt((height / window.innerHeight) * 78) + 1;
    document.getElementById("divPatrocinadores").style.height = vh + "vh";
});

resize_ob.observe(document.getElementById("tablaEventos"));