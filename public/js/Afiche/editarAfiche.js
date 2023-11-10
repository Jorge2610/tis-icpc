const eventoSeleccionado = document.getElementById("nombreEvento");
const contenedorAsignar = document.getElementById("contenedorAsignar");

let tablaDeTipos;
let tablaInicializada = false;

const dataTableOptions = {
    pageLength: 10,
    lengthMenu: [5, 10, 15, 20],
    destroy: true,
    order: [[3, 'desc']],
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
    DataTable.datetime('DD-MM-YYYY');
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
                <a href="#" class="btn btn-primary btn-sm" onclick="document.getElementById('imageUpload${afiche.id}').click()">Cambiar</a>
            </div>
        </div>
    </div>`;
    });
};

let aficheSeleccion;
let rutaSeleccion;
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

const previsualizarImagen = (event, idAfiche) => {
    const input = document.getElementById(`imageUpload${idAfiche}`);
    validarImagen(input, 5, (mensaje) => {
        if (!mensaje.error) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                const imagen = document.getElementById(
                    `imagenAfichepreview${idAfiche}`
                );
                rutaSeleccion = imagen.src;
                imagen.src = e.target.result;
            };
            reader.readAsDataURL(file);
            aficheSeleccion = idAfiche;
            const modal = new bootstrap.Modal(
                document.getElementById("modalCambiarAfiche")
            );
            modal.show();
        } else {
            mostrarAlerta("Error", mensaje.mensaje, "danger");
        }
    });
};

const cambiarAfiche = async () => {
    if (aficheSeleccion) {
        const input = document.getElementById(`imageUpload${aficheSeleccion}`);
        const form = new FormData();
        form.append("afiche", input.files[0]);
        await axios
            .post(`/api/afiche/${aficheSeleccion}`, form)
            .then((response) => {
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.error ? "danger" : "success"
                );
            });
    }
};

const asignarAfiche = async () => {
    if (idEvento) {
        const form = new FormData();
        form.append("afiche", input.files[0]);
        form.append("id_evento", idEvento);
        await axios.post("/api/afiche", form).then((response) => {
            mostrarAlerta(
                "Éxito",
                response.data.mensaje,
                response.error ? "danger" : "success"
            );
        });
    }
};

const cancelarSubidaAfiche = async () => {
    if (aficheSeleccion && rutaSeleccion) {
        const imagen = document.getElementById(
            `imagenAfichepreview${aficheSeleccion}`
        );
        imagen.src = rutaSeleccion;
        aficheSeleccion = null;
        rutaSeleccion = null;
    }
};

const seleccionarAfiche = (id) => {
    aficheSeleccion = id;
};

const cargarAfiche = async () => {
    await axios.get(`/api/afiche/${idEvento}`).then((response) => {
        document.getElementById(`contadorAfiches${idEvento}`).textContent =
            response.data.length;
        document.getElementById(`tarjetaAfiche${aficheSeleccion}`).remove();
    });
};
