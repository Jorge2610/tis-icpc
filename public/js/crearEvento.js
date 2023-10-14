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
  reader.onloadend = function () {
    var img = document.getElementById('afiche');
    img.setAttribute('src', reader.result)
  };
}

function previewSponsorLogo(event) {
  var reader = new FileReader();
  reader.onload = function () {
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