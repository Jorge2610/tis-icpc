let fechaInscripcionInicio = document.getElementById('fechaInscripcionInicio')
let fechaInscripcionFin = document.getElementById('fechaInscripcionFin')
let inputGenero = document.getElementById('generoCheck');
let inputEdad = document.getElementById('edadCheck');
let inputCosto = document.getElementById('eventoPagoCheck');
let form = document.getElementById("formularioCrearEvento")
let edadCheck = document.getElementById("edadCheck");

fechaInscripcionInicio.addEventListener('change', (e) => {
  let valor = e.target.value
  fechaInscripcionFin.setAttribute('min', valor)
})

let fechaInicio = document.getElementById('fechaInicio')
let fechaFin = document.getElementById('fechaFin')

fechaInicio.addEventListener('change', (e) => {
  let valor = e.target.value
  fechaFin.setAttribute('min', valor)
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
  mostrarInput('limiteDeEdad', inputEdad.checked);
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

edadCheck.addEventListener('change', () => {
  mostrarInput('rangosDeEdad', edadCheck.checked);
});

//Guardar evento
document.addEventListener('DOMContentLoaded', function () {
  let form = document.getElementById('formularioCrearEvento');
  form.addEventListener('submit', function (event) {
    console.log(typeof(document.getElementById('costoEvento').value));  
    event.preventDefault()
      if (!form.checkValidity()) {
          event.stopPropagation()
      } else {
          // Enviar formulario con AJAX
          var formData = new FormData(this);
          axios.post('/api/evento', formData)
              .then(function (response) {
                  mostrarAlerta('Éxito', response.data.mensaje, 'success');
              })
              .catch(function (error) {
                  mostrarAlerta('Error', 'Hubo un error al guardar el tipo de evento', 'danger');
              });
      }
      form.classList.add('was-validated')
  });
});
//Recuperar tipos de eventos
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

