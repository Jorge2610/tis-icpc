let tablaDeTipos;
let tablaInicializada = false;

const eventoSeleccionado = document.getElementById("nombreEvento");

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [2, 'desc'],
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
        eventoSeleccionado.textContent = "Seleccione un evento";
    }
});

let seleccionado;
let idSeleccionado;
let patrocinadores;
let quitando = false;
const seleccionarEvento = async (id, nombre) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    eventoSeleccionado.textContent = nombre;
    await cargarPatrocinadores();
    mostrarPatrocinadores();
};

const cargarPatrocinadores = async () => {
    let data = await getPatrocinadoresEvento(idSeleccionado);
    patrocinadores = await data;
};

const getPatrocinadoresEvento = async (id) => {
    let data = await axios.get("/api/patrocinador/evento/" + id).then((response) => {
        return response.data;
    });
    return data;
};

const mostrarPatrocinadores = () => {
    let div = document.getElementById('divPatrocinadores');
    let content = "";
    patrocinadores.map((evento) => {
        content += `
            <div class="col text-center">
                <div class="card" style="height: 13rem">
                    <div class="row justify-content-center" style="max-height: 125px">
                        <img src="${evento.patrocinadores.ruta_imagen}" class="img-fluid"
                            alt="logoPatrocinador" style="max-height: 100%; width: auto">
                    </div>
                    <div class="card-body">
                        <h6 class="card-title text-truncate" title="${evento.patrocinadores.nombre}">
                            ${evento.patrocinadores.nombre}
                        </h6>
                        <button class="btn btn-danger btn-sm" onclick="quitarPatrocinador(${evento.id})" ${quitando ? "disabled" : ""}>Quitar</button>
                    </div>
                </div>
            </div>
        `;
    });
    div.innerHTML = content;
};

const quitarPatrocinador = async (idEventoPatrocinador) => {
    quitando = true;
    mostrarPatrocinadores();
    let resultado = await realizarPeticion(idEventoPatrocinador);
    if (resultado === "Quitado exitosamente") {
        updateNroPatrocinadores();
        await cargarPatrocinadores();
    }
    setTimeout(() => {
        quitando = false;
        mostrarPatrocinadores();
    }, 2000);
};

const realizarPeticion = async (idEventoPatrocinador) => {
    let data = await axios.delete("/api/patrocinador/quitar/" + idEventoPatrocinador).then((response) => {
        mostrarAlerta(
            "Éxito",
            response.data.mensaje,
            response.error ? "danger" : "success"
        );
        return response.data.mensaje;
    });
    return data;
};

const updateNroPatrocinadores = () => {
    let casilla = document.getElementById(
        `contadorPatrocinadores${idSeleccionado}`
    );
    let valor = parseInt(casilla.textContent);
    casilla.textContent = valor - 1;
};

const resize_ob = new ResizeObserver(function (entries) {
    let rect = entries[0].contentRect;
    let height = rect.height;
    vh = parseInt((height / window.innerHeight) * 78) + 1;
    document.getElementById("divPatrocinadores").style.height = vh + "vh";
});

resize_ob.observe(document.getElementById("tablaEventos"));