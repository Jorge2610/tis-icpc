function changeColor(color) {
    let colorDisplay = document.querySelector("#color-display");
    colorDisplay.style.backgroundColor = color;
}


document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formularioTipoEvento').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita la recarga de la página

        var formData = new FormData(this);

        // Enviar formulario con AJAX
        axios.post('/eventos/crear-evento', formData)
            .then(function (response) {
                mostrarAlerta('Éxito', response.data.mensaje, 'success');
            })
            .catch(function (error) {
                mostrarAlerta('Error', 'Hubo un error al guardar el tipo de evento', 'danger');
            });
    });

});

function mostrarAlerta(titulo, mensaje, tipo) {
    var icono = '';
    
    // Asignar el icono y el color de fondo según el tipo
    if (tipo === 'success') {
        icono = '<i class="bi bi-check-circle"></i>'; // Icono de círculo con check verde de Bootstrap Icons
    } else if (tipo === 'danger') {
        icono = '<i class="bi bi-x-circle"></i>'; // Icono de círculo con cruz roja de Bootstrap Icons
    } else {
        icono = '<i class="bi bi-info-circle"></i>'; // Icono de círculo con información azul de Bootstrap Icons por defecto
    }
    
    var alerta = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="mr-2">${icono}</div>
                <div>
                    ${mensaje}
                </div>
            </div>
        </div>
    `;
    document.getElementById('alertsContainer').innerHTML = alerta;
    setTimeout(function(){
        document.querySelector('.alert').remove(); // Remover la alerta después de 2 segundos
    }, 2000);
}
