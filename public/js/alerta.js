const mostrarAlerta = (titulo, mensaje, tipo) => {
    let icono = "";

    if (tipo === "success") {
        icono = '<i class="fa-regular fa-circle-check"></i>';
    } else if (tipo === "danger") {
        icono = '<i class="fa-regular fa-circle-xmark"></i>';
    }

    const alerta = `
      <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
          <div class="mr-2">${icono}</div>
          <div class="mx-2">${mensaje}</div>
        </div>
      </div>
    `;

    document.getElementById("alertsContainer").innerHTML = alerta;

    setTimeout(() => {
        document.querySelector(".alert").remove();
    }, 2000);
};