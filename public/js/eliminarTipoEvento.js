
async function eliminarTipoEvento(id) {
    axios.delete(`/api/tipo-evento/${id}`)
        .then(response => {
            if (!response.data.error) {
                $('#modalEliminarTipoEvento' + id).modal('hide');
                mostrarAlerta(
                    "Éxito",
                    response.data.mensaje,
                    response.data.error ? "danger" : "success"
                );
                recargarEventos();
            } else {
                $('#modalEliminarTipoEvento' + id).modal('hide');
                $('#modalMensaje').text('Error: ' + response.data.mensaje);
                $('#modalError').modal('show');
            }
        })
        .catch(error => {
            console.error(error);
        });
}
