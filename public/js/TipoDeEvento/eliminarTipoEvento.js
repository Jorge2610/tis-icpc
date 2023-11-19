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

const initDataTable = async () => {
    if (tablaInicializada) {
        tablaDeTipos.destroy();
    }
    tablaDeTipos = $("#tablaTipoDeEvento").DataTable(dataTableOptions);
    tablaInicializada = true;
};

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
                recargarEventos();

            } else {
                // Si hay un error, mostramos un mensaje de error en el modal
                $('#modalEliminarTipoEvento'+id).modal('hide'); // Cerrar el modal
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

/**Para recargar eventos, si o si debemos llamar a la pagina**/
const recargarEventos = () => {
     setTimeout(() => {
         window.location.href = "/admin/tipos-de-evento/eliminar-tipo";
     },1700);
 }
