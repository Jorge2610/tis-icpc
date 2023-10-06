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

function previewImage(event) {
  var reader = new FileReader();
  reader.readAsDataURL(event.target.files[0]);
  reader.onloadend = function() {
    var output = document.getElementById('imagePreview');
    console.log(reader.result)
    output.setAttribute('src', reader.result)
  };
  
}