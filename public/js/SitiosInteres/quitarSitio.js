let tablaDeTipos;
let tablaInicializada = false;

const eventoSeleccionado = document.getElementById("nombreEvento");
const sitiosContenedor = document.getElementById("sitiosContenedor");

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
let idSeleccionado;
const seleccionarEvento = async (id, nombre) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
        sitiosContenedor.innerHTML = "";
    }

    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    eventoSeleccionado.textContent = nombre;
    const response = await cargarSitios(id);
    mostrarSitios(response);
};

const cargarSitios = async (id) => {
    let data = await axios.get("/api/sitio/" + id).then((response) => {
        return response.data;
    });
    return data;
};

const mostrarSitios = (response) => {
    console.log(response);
    response.map((sitio) => {
        const sitioContenedor = document.createElement("div");
        sitioContenedor.id = "sitio"+sitio.id;
        sitioContenedor.innerHTML = `
            <div class="container col-12 col-md-12 col-lg-12" >
                <div class="card w-100 my-3 shadow " style="min-height: 100px; width: 18rem !important">
                    <div class="card-body" >
                        <h5 class="card-title">${sitio.titulo}</h5>
                        <a class="card-text text-truncate d-block"  style="max-width: 300px;" href="${sitio.enlace}" title="${sitio.enlace}" target="_blank">${sitio.enlace}</a>
                    </div>
                    <div class="card-footer" >
                        <button class="btn btn-danger" onclick="quitarSitio(${sitio.id})">Quitar</button>
                    </div>
                </div>
            </div>
        `;
        sitiosContenedor.appendChild(sitioContenedor);
    });
};

const quitarSitio = async (id) => {
    const response = await axios
        .delete("/api/sitio/" + id)
        .then((response) => {
            document.getElementById("sitio"+id).remove();
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.error ? "danger" : "success"
            );
            restarContador();
            return response.data;
        });
    mostrarSitios(response);
};

const restarContador = async () => {
    const contadorSitios = document.getElementById(
        `contadorSitios${idSeleccionado}`
    );
    contadorSitios.textContent = parseInt(contadorSitios.textContent) - 1;
};
const resetInputs = () => {
    let form = document.getElementById("formularioAgregarSitio");
    form.classList.remove("was-validated");
    tituloSitio.value = "";
    urlSitio.value = "";
};

const resize_ob = new ResizeObserver(function (entries) {
    let rect = entries[0].contentRect;
    let height = rect.height;
    vh = parseInt((height / window.innerHeight) * 78) + 1;
    document.getElementById("sitiosContenedor").style.height = vh + "vh";
});

resize_ob.observe(document.getElementById("tablaEvento"));