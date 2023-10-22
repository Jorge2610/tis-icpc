function mostrarAlerta(titulo, mensaje, tipo) {
    let icono = "";
  
    // Asignar el icono y el color de fondo según el tipo
    if (tipo === "success") {
        icono =
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#28a745" viewBox="0 0 24 24"> <path d="M9 16.17l-3.83-3.83a1 1 0 0 1 1.41-1.41L9 13.35l6.18-6.18a1 1 0 1 1 1.41 1.41L9 16.17z"/> </svg>';
    } else if (tipo === "danger") {
        icono =
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#dc3545" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#dc3545" /><path fill="#fff" d="M8.29 8.29a1 1 0 0 1 1.41 0L12 10.59l2.29-2.3a1 1 0 1 1 1.41 1.41L13.41 12l2.3 2.29a1 1 0 1 1-1.41 1.41L12 13.41l-2.29 2.3a1 1 0 1 1-1.41-1.41L10.59 12 8.29 9.71a1 1 0 0 1 0-1.42z"/></svg>';
    } else {
        icono =
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#dc3545" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#dc3545" /><path fill="#fff" d="M8.29 8.29a1 1 0 0 1 1.41 0L12 10.59l2.29-2.3a1 1 0 1 1 1.41 1.41L13.41 12l2.3 2.29a1 1 0 1 1-1.41 1.41L12 13.41l-2.29 2.3a1 1 0 1 1-1.41-1.41L10.59 12 8.29 9.71a1 1 0 0 1 0-1.42z"/></svg>';
    }
  
    const alerta = `
      <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
          <div class="d-flex align-items-center">
              <div class="mr-2">${icono}</div>
              <div>
                  ${mensaje}
              </div>
          </div>
      </div>
  `;
    document.getElementById("alertsContainer").innerHTML = alerta;
    setTimeout(function () {
        document.querySelector(".alert").remove();
        if (tipoForm === 0) {
            window.location.href = "/eventos"; // Remover la alerta después de 2 segundos
        }
        window.location.href = "/eventos/" + nombreEvento;
    }, 2000);
  }
  