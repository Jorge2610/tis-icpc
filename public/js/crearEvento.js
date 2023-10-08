let fechaInscripcionInicio = document.getElementById('fechaInscripcionInicio')
let fechaInscripcionFin = document.getElementById('fechaInscripcionFin')

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