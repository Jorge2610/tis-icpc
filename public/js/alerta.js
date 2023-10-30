const mostrarAlerta = (titulo, mensaje, tipo) => {
    let icono = "";
    let fill = "";

    if (tipo === "success") {
        icono = "check-circle";
        fill = "#28a745";
    } else if (tipo === "danger") {
        icono = "exclamation-circle";
        fill = "#dc3545";
    }

    const iconoSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="${fill}" viewBox="0 0 24 24"><path d="${icono}" /></svg>`;

    const alerta = `
      <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
          <div class="mr-2">${iconoSvg}</div>
          <div>${mensaje}</div>
        </div>
      </div>
    `;

    document.getElementById("alertsContainer").innerHTML = alerta;

    setTimeout(() => {
        document.querySelector(".alert").remove();
    }, 2000);
};

