let tablaDeTipos;
let tablaInicializada = false;
let formulario = document.getElementById("formularioTipoEvento");

const dataTableOptions = {
    order: [[0,"desc"]],
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
                    <td>${element.nombre}</td>
                    <td class="text-center">${element.descripcion}</td>
                    <td class="container-color">
                        <div class="color-cell" style="background-color:${element.color};"></div>
                    </td>
                    <td class="text-center">Yo</td>
                    <td class="text-center">${fechaFormateada}</td>
                </tr>
            `;
        }).join("");

        tableBody.innerHTML = content;
    } catch (error) {
        alert(error);
    }
};

function editarTipoEvento(id) {
    const formularioTipoEvento = document.getElementById('formularioTipoEvento');
    formularioTipoEvento.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(formularioTipoEvento);
        axios.post(`/tipo-evento/actualizar/${id}`, formData)
            .then((response) => {
                if (response.data.error === false) {
                    window.location.href = '/admin/tipos-de-evento';
                } else {
                    alert(response.data.mensaje);
                }
            })
            .catch((error) => {
                console.error(error);
            });
    });
}

async function eliminarTipoEvento(id) {
    axios.delete(`/api/tipo-evento/${id}`)
        .then(response => {
            if (!response.data.error) {
                $('#modalEliminarTipoEvento'+id).modal('hide'); 
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
                cargarTiposDeEvento();
            } else {
                $('#modalEliminarTipoEvento'+id).modal('hide'); 
                $('#modalMensaje').text('Error: ' + response.data.mensaje);
                $('#modalError').modal('show');
            }
        })
        .catch(error => {
            console.error(error);
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
