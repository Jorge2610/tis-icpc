let fechaInscripcionInicio = document.getElementById('fechaInscripcionInicio')
let fechaInscripcionFin = document.getElementById('fechaInscripcionFin')
let inputGenero = document.getElementById('generoCheck');
let inputEdad = document.getElementById('edadCheck');
let inputCosto = document.getElementById('eventoPagoCheck');
let form = document.getElementById("formularioCrearEvento")

fechaInscripcionInicio.addEventListener('change', (e) => {
  let valor = e.target.value
  fechaInscripcionFin.setAttribute('min', valor)
})

let fechaInicio = document.getElementById('fechaInicio')
let fechaFin = document.getElementById('fechaFin')

fechaInicio.addEventListener('change', () => {
fechaFin.min=fechaInicio.value;
fechaFin.value="";
console.log(fechaInicio.value);
})

fechaFin.addEventListener('change',()=>{
  let fecha1 = new Date (fechaInicio.value);
  let fecha2 = new Date (fechaFin.value);
  if(fecha2<fecha1){
    mostrarA()
    fechaFin.value="";
  }
})

let edadMinima = document.getElementById("edadMinima");
let edadMaxima = document.getElementById("edadMaxima");

edadMinima.addEventListener('change', (e) => {
  let valor = e.target.value;
  edadMaxima.value = valor;
  edadMaxima.min = valor;
})

function previewAfiche(event) {
  var reader = new FileReader();
  reader.readAsDataURL(event.target.files[0]);
  reader.onloadend = function() {
    var img = document.getElementById('afiche');
    img.setAttribute('src', reader.result)
  };
}

function previewSponsorLogo(event) {
  var reader = new FileReader();
  reader.onload = function() {
    var output = document.getElementById('sponsorPreview');
    output.style.backgroundImage = 'url(' + reader.result + ')';
  };
  reader.readAsDataURL(event.target.files[0]);
}

function resetModal(idModal, idForm) {
  var output = document.getElementById('sponsorPreview');
  output.style.backgroundImage = 'url(' + '../image/uploading.png' + ')';
  let modal = document.getElementById(idModal);
  let inputs = modal.querySelectorAll('input');
  inputs.forEach((element) => element.value = '');
  let form = document.getElementById(idForm);
  form.classList.remove('was-validated');
}

function utilizarInput(indInput, check) {
  let input = document.getElementById(indInput);
  input.disabled = !check;
}

function mostrarInput(indInput, check) {
  let input = document.getElementById(indInput);
  if (!check) {
    input.style.display = "none";
  }
  else {
    input.style.display = "flex";
  }
}

//check
inputGenero.addEventListener("change", () => {
  mostrarInput('genero', inputGenero.checked);
});
inputEdad.addEventListener("change", () => {
  mostrarInput('rangosDeEdad', inputEdad.checked);
});
inputCosto.addEventListener('change', () => {
  mostrarInput('eventoPago', inputCosto.checked);
});
//validacion
form.addEventListener("submit", (event) => {
  if (!form.checkValidity()) {
    event.preventDefault()
    event.stopPropagation()
  }

  form.classList.add('was-validated')
});

//Guardar evento
document.addEventListener('DOMContentLoaded', function () {
  let form = document.getElementById('formularioCrearEvento');
  form.addEventListener('submit', function (event) {  
    event.preventDefault()
      if (!form.checkValidity()) {
          event.stopPropagation()
          $("#modalConfirmacion").modal("hide")
          
      } else {
        let formData = new FormData(this);
        if(!inputEdad .checked){
          formData.set("edad_minima","");
          formData.set("edad_maxima","");
        }
        if(!inputGenero.checked){
          formData.set("genero","");
        }
        if(!inputCosto.checked){
          formData.set("precio_inscripcion","");
        }
          // Enviar formulario con AJAX
          axios.post('/api/evento', formData)
              .then(function (response) {
                mostrarAlerta(
                  "Éxito",
                  response.data.mensaje,
                  response.data.error ? "danger" : "success"
              );
              })
              .catch(function (error) {
                  mostrarAlerta('Error', 'Hubo un error al guardar el tipo de evento', 'danger');
              });
        $("#modalConfirmacion").modal("hide")
        form.classList.add('was-validated')
      }

  });
});
//Recuperar tipos de eventos necesario para el form 
window.addEventListener("load", async () => {
  await axios.get('/api/tipo-evento')
        .then(function (response) {
            var select = document.getElementById('tipoDelEvento');
            var tiposDeEvento = response.data;
            tiposDeEvento.forEach(function (tipo) {
                var option = document.createElement('option');
                option.value = tipo.id; 
                option.text = tipo.nombre;
                select.appendChild(option);
            });
        })
        .catch(function (error) {
            console.error(error);
        });
});
       
function mostrarAlerta(titulo, mensaje, tipo) {
  var icono = "";

  // Asignar el icono y el color de fondo según el tipo
  if (tipo === "success") {
      icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#28a745" viewBox="0 0 24 24"> <path d="M9 16.17l-3.83-3.83a1 1 0 0 1 1.41-1.41L9 13.35l6.18-6.18a1 1 0 1 1 1.41 1.41L9 16.17z"/> </svg>';
    } else if (tipo === "danger") {
  } else if (tipo === "danger") {
      icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#dc3545" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#dc3545" /><path fill="#fff" d="M8.29 8.29a1 1 0 0 1 1.41 0L12 10.59l2.29-2.3a1 1 0 1 1 1.41 1.41L13.41 12l2.3 2.29a1 1 0 1 1-1.41 1.41L12 13.41l-2.29 2.3a1 1 0 1 1-1.41-1.41L10.59 12 8.29 9.71a1 1 0 0 1 0-1.42z"/></svg>';
  } else {
      icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#dc3545" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#dc3545" /><path fill="#fff" d="M8.29 8.29a1 1 0 0 1 1.41 0L12 10.59l2.29-2.3a1 1 0 1 1 1.41 1.41L13.41 12l2.3 2.29a1 1 0 1 1-1.41 1.41L12 13.41l-2.29 2.3a1 1 0 1 1-1.41-1.41L10.59 12 8.29 9.71a1 1 0 0 1 0-1.42z"/></svg>';
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
  document.getElementById("alertsContainer").innerHTML = alerta;
  setTimeout(function () {
      document.querySelector(".alert").remove(); // Remover la alerta después de 2 segundos
  }, 2000);
}