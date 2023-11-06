let tablaDeTipos;
let tablaInicializada = false;
let formulario = document.getElementById("formularioTipoEvento");

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

const remover = () => {
    formulario.classList.remove("was-validated");
    formulario.reset();
};

const initDataTable = async () => {
    if (tablaInicializada) {
        tablaDeTipos.destroy();
    }
    //await cargarTiposDeEvento();
    tablaDeTipos = $("#tablaTipoDeEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

const cargarTiposDeEvento = async () => {
    try {
        const response = await axios.get("/api/tipo-evento");
        tablaDeTipos.destroy();
        const tiposDeEvento = response.data;
        const tableBody = document.getElementById("datosTabla");

        let content = tiposDeEvento.map((element, index) => {
            const fecha = new Date(element.created_at);
            const dia = fecha.getDate();
            const mes = fecha.getMonth() + 1;
            const anio = fecha.getFullYear();
            const fechaFormateada = `${dia}-${mes}-${anio}`;

            return `
                <tr>
                    <th scope='row'>${index + 1}</th>
                    <td>${element.nombre}</td>
                    <td class="container-color">
                        <div class="color-cell" style="background-color:${element.color};"></div>
                    </td>
                    <td class="text-center">Yo</td>
                    <td class="text-center">${fechaFormateada}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm" onclick="editarTipoEvento(${element.id})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTipoEvento(${element.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join("");

        tableBody.innerHTML = content;
    } catch (error) {
        alert(error);
    }
};

//Llenado de formulario test
function llenarFormularioTipoEvento(nombre, descripcion, color) {
    const nombreTipoEvento = document.getElementById("nombreTipoEvento");
    const detalleTipoEvento = document.getElementById("detalleTipoEvento");
    const colorTipoEvento = document.getElementById("colorTipoEvento");

    nombreTipoEvento.value = nombre;
    detalleTipoEvento.value = descripcion;
    colorTipoEvento.value = color;
}


//Editar evento
function editarTipoEvento(id) {
    // Obtener el formulario
    const formularioTipoEvento = document.getElementById('formularioTipoEvento');
    console.log(id);
    console.log(formularioTipoEvento);
    // Agregar un manejador de eventos al formulario
    formularioTipoEvento.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(formularioTipoEvento);
        axios.post(`/tipo-evento/actualizar/${id}`, formData)
            .then((response) => {
                if (response.data.error === false) {
                    // El tipo de evento se actualizó con éxito, puedes redirigir o mostrar un mensaje de éxito.
                    window.location.href = '/admin/tipos-de-evento'; // Reemplaza esto con la URL de redirección deseada
                } else {
                    // Manejar errores, por ejemplo, mostrar un mensaje de error.
                    alert(response.data.mensaje);
                }
            })
            .catch((error) => {
                // Manejar errores de la solicitud Axios
                console.error(error);
            });
    });
}

//Borrar tipo de evento
async function eliminarTipoEvento(id) {
    // Aquí utilizamos Axios para enviar una solicitud de eliminación al servidor
    axios.delete(`/api/tipo-evento/${id}`)
        .then(response => {
            if (!response.data.error) {
                // Si la eliminación es exitosa, mostramos un mensaje de éxito en el modal
                $('#modalEliminarTipoEvento'+id).modal('hide'); // Cerrar el modal
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
                //$('#modalMensaje').text('Tipo de evento eliminado exitosamente.');
                //$('#modalExito').modal('show');
                cargarTiposDeEvento();
                //window.location.reload();
                console.log("Exito");
            } else {
                // Si hay un error, mostramos un mensaje de error en el modal
                console.log("Error " + response.data.error);
                $('#modalEliminarTipoEvento'+id).modal('hide'); // Cerrar el modal
                $('#modalMensaje').text('Error: ' + response.data.mensaje);
                $('#modalError').modal('show');
            }
        })
        .catch(error => {
            console.error(error);
            // Manejar cualquier error de la solicitud Axios
        });
}

window.addEventListener("load", async () => {
    await initDataTable();
});

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formularioTipoEvento");
    form.addEventListener("submit", async function (event) {
        event.preventDefault();
        form.classList.add("was-validated");
        if (!form.checkValidity()) {
            event.stopPropagation();
        } else {
            const formData = new FormData(this);
            try {
                const response = await axios.post("/api/tipo-evento", formData);
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
                form.classList.remove("was-validated");
                form.reset();
                $("#modalCrearTipoEvento").modal("hide");
                initDataTable();
            } catch (error) {
                mostrarAlerta("Error", "Hubo un error al guardar el tipo de evento", "danger");
            }
        }
    });
});
