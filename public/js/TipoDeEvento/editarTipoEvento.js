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
                    </td>
                </tr>
            `;
        }).join("");

        tableBody.innerHTML = content;
    } catch (error) {
        alert(error);
    }
};

//Editar evento
function editarTipoEvento(id) {
    // Obtener el formulario
    const formularioTipoEvento = document.getElementById('formularioTipoEvento');
    console.log(id);
    console.log(formularioTipoEvento);
    // Agregar un manejador de eventos al formulario
    formularioTipoEvento.addEventListener('submit', (event) => {
        event.preventDefault();
        formularioTipoEvento.classList.add("was-validated");
        const formData = new FormData(formularioTipoEvento);
        axios.post(`/api/tipo-evento/actualizar/${id}`, formData)
            .then((response) => {
                if (response.data.error === false) {
                    // El tipo de evento se actualizó con éxito, puedes redirigir o mostrar un mensaje de éxito.
                    mostrarAlerta(
                        "Éxito",
                        response.data.mensaje,
                        response.data.error ? "danger" : "success"
                    );
                    recargarEventos(); // Reemplaza esto con la URL de redirección deseada
                } else {
                    // Manejar errores, por ejemplo, mostrar un mensaje de error.
                    //alert(response.data.mensaje);
                }
            })
            .catch((error) => {
                // Manejar errores de la solicitud Axios
                console.error(error);
            });
    });
}

window.addEventListener("load", async () => {
    await initDataTable();
});


