let tablaDeTipos;
let tablaInicializada = false;

const input = document.getElementById("imageUpload");
const imagenPreview = document.getElementById("imagePreview");
const botonSubir = document.getElementById("botonSubirAfiche");
const contenedorAsignar = document.getElementById("contenedorAsignar");
const eventoSeleccionado = document.getElementById("nombreEvento");

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[2, "desc"]],
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
        botonSubir.disabled = true;
    }
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
let seleccionado;
let idSeleccionado;
const seleccionarEvento = (id, nombre) => {
    if (seleccionado) {
        seleccionado.classList.remove("table-primary");
    }
    botonSubir.disabled = false;
    seleccionado = document.getElementById(id);
    seleccionado.classList.add("table-primary");
    idSeleccionado = id;
    eventoSeleccionado.textContent = nombre;
    input.value = "";
    imagenPreview.src = "/image/uploading.png";
    botonSubir.style.display = "block";
    contenedorAsignar.style.display = "none";
};

function previsualizarImagen(event) {
    validarImagen(input, 5, (mensaje) => {
        if (!mensaje.error) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                imagenPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);

            botonSubir.style.display = "none";
            contenedorAsignar.style.display = "block";
        } else {
            mostrarAlerta("Error", mensaje.mensaje, "danger");
        }
    });
}

const asignarAfiche = async () => {
    if (idSeleccionado) {
        const form = new FormData();
        form.append("afiche", input.files[0]);
        form.append("id_evento", idSeleccionado);
        await axios.post("/api/afiche", form).then((response) => {
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
    await axios.get(`/api/afiche/${idSeleccionado}`).then((response) => {
        document.getElementById(
            `contadorAfiches${idSeleccionado}`
        ).textContent = response.data.length;
        imagenPreview.src = "/image/uploading.png";
        botonSubir.style.display = "block";
        contenedorAsignar.style.display = "none";
    });
};
