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


  const alertsContainer = document.getElementById("alertsContainer");
  alertsContainer.style.zIndex = "9999";
  alertsContainer.innerHTML = alerta;
  alertsContainer.style.display = 'block';

  setTimeout(function () {
    alertsContainer.style.display = 'none';
  }, 2000);
  alertsContainer.innerHTML = alerta;
};

