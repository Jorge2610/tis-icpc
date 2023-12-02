let tablaDePatrocinadores;
let tablaInicializada = false;

const input = document.getElementById("imageUpload");
const imagenPreview = document.getElementById("imagePreview");
const botonSubir = document.getElementById("botonSubirLogoPatrocinador");
const nombrePatrocinador = document.getElementById("nombrePatricinador");
const urlPatricinador = document.getElementById("urlPatrocinador");
const cancelar = document.getElementById("crearPatrocinadorCancelar");
const asignar = document.getElementById("crearPatrocinadorCrear");

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[3, "desc"]],
    language: {
        lengthMenu: "Mostrar _MENU_ patrocinadores",
        zeroRecords: "Ningún patrocinador encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ patrocinadores",
        infoEmpty: "Ningún patrocinador encontrado",
        infoFiltered: "(filtrados desde _MAX_ patrocinadores en total)",
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
        tablaDePatrocinadores.destroy();
    }
    DataTable.datetime("DD-MM-YYYY");
    tablaDePatrocinadores = $("#tablaEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

window.addEventListener("load", () => {
    initDataTable();
});

const validarImagen = (input, peso, callback) => {
    if (input.files.length > 0) {
        const imagen = input.files[0];
        const maxFileSize = peso * 1024 * 1024;
        let mensaje = { mensaje: "", error: false };

        const type = !/image\/(png|jpeg|jpg)/.test(imagen.type);

        if (type || imagen.size > maxFileSize) {
            input.value = "";
            mensaje = { mensaje: "Archivo no válido", error: true };
        }

        if (typeof callback === "function") {
            callback(mensaje);
        }
    }
};

function previsualizarImagen(event) {
    validarImagen(input, 2, (mensaje) => {
        if (!mensaje.error) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                imagenPreview.src = e.target.result;
                botonSubir.classList.remove("btn-outline-danger");
                botonSubir.classList.add("btn-light", "text-primary");
            };
            reader.readAsDataURL(file);
        } else {
            mostrarAlerta("Error", mensaje.mensaje, "danger");
        }
    });
}

const validarDatos = () => {
    let form = document.getElementById("formularioAgregarPatrocinador");
    if (form.checkValidity() && input.files[0] != undefined) {
        form.classList.remove("was-validated");
        crearPatrocinador();
        return;
    }
    if (input.files[0] === undefined) {
        botonSubir.classList.remove("btn-light", "text-primary");
        botonSubir.classList.add("btn-outline-danger");
    }
    form.classList.add("was-validated");
};

const getFormData = () => {
    const formData = new FormData();
    formData.append("nombre", nombrePatrocinador.value);
    formData.append("enlace_web", urlPatricinador.value);
    formData.append("logo", input.files[0]);
    return formData;
};

let idPatrocinador;
const crearPatrocinador = async () => {
    let res = await axios.post("/api/patrocinador/esta-borrado", getFormData()).then((response) => {
        return response.data;
    });

    if (res.borrado) {
        idPatrocinador = res.id;
        $('#modalPatrocinadroExistente').modal('show');
    } else {
        mostrarAlerta(
            res.error ? "Peligro" : "Éxito",
            res.mensaje,
            res.error ? "danger" : "success"
        );
        resetInputs();
        if (!res.error) {
            updateTablaPatrocinadores();
        }
    }
};

let restoreResponseData;
const restaurarPatrocinador = async () => {
    $('#modalPatrocinadroExistente').modal('hide');
    let res = await axios.post("/api/patrocinador/restaurar/" + idPatrocinador).then((response) => {
        return response.data;
    });
    restoreResponseData = res;
    document.getElementById("nombrePatrocinador").innerText = nombrePatrocinador.value;
    await getDatosPatrocinadorRestaurado();
    getDatosNuevosPatrocinador();
    $('#modalActualizarPatrocinador').modal('show');
};

const getDatosPatrocinadorRestaurado = async () => {
    let patrocinador = await axios.get("/api/patrocinador/show/" + idPatrocinador).then((response) => {
        return response.data;
    });
    let img = document.getElementById("imagenPatrocinadorRestaurada");
    img.src = patrocinador.ruta_imagen;
    img.alt = patrocinador.nombre;
    let datosDiv = document.getElementById("datosPatrocinadorRestaurado");
    let enlace = patrocinador.enlace_web === null ? "" : patrocinador.enlace_web;
    datosDiv.innerHTML = `<p class="text-truncate" title="${enlace}"><a href="${enlace}" target="_blank"> ${enlace}</a></p>`;
};

const getDatosNuevosPatrocinador = () => {
    let img = document.getElementById("nuevaImagenPatrocinador");
    img.src = imagenPreview.src;
    img.alt = nombrePatrocinador.value;
    let datosDiv = document.getElementById("nuevosDatosPatrocinador");
    let enlace = urlPatricinador.value === null ? "" : urlPatricinador.value;
    datosDiv.innerHTML = `<p class="text-truncate" title="${enlace}"><a href="${enlace}" target="_blank"> ${enlace}</a></p>`;
};

const actualizarDatosPatrocinador = async (actualizar) => {
    $('#modalActualizarPatrocinador').modal('hide');
    if (actualizar) {
        let res = await axios.post("/api/patrocinador/editar/" + idPatrocinador, getFormData()).then((response) => {
            return response.data;
        });
    }
    mostrarAlerta(
        restoreResponseData.error ? "Peligro" : "Éxito",
        restoreResponseData.mensaje,
        restoreResponseData.error ? "danger" : "success"
    );
    resetInputs();
    updateTablaPatrocinadores();
};

const updateTablaPatrocinadores = () => {
    setTimeout(() => {
        window.location.href = "/admin/patrocinador";
    }, 1750);
};

const resetInputs = () => {
    document.getElementById("formularioAgregarPatrocinador").classList.remove("was-validated");
    botonSubir.classList.remove("btn-outline-danger");
    botonSubir.classList.add("btn-light", "text-primary");
    nombrePatrocinador.value = "";
    urlPatricinador.value = "";
    input.value = "";
    imagenPreview.src = "/image/uploading.png";

};
