function handleImageUpload() {
    document.getElementById('uploadButton').style.display = 'none';
    document.getElementById('uploadIcon').style.display = 'none';
    document.getElementById('imagePreview').style.display = 'block';
  
    var reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById('imagePreview').src = e.target.result;
    }
    reader.readAsDataURL(document.getElementById('imageUpload').files[0]);
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

  // Esta función se llama cuando se hace clic en el botón "Confirmar"
function guardarPatrocinador() {
  // Obtén los valores del formulario
  const nombre = document.getElementById('validationCustomName').value;
  const enlaceWeb = document.getElementById('validationCustomLink').value;
  const imagen = document.getElementById('validationCustomImage').files[0];
  const id_evento = document.getElementById('id_evento').value;
  // Crea un objeto FormData para enviar los datos
  const formData = new FormData();
  formData.append('nombre', nombre);
  formData.append('enlace_web', enlaceWeb);
  formData.append('imagen', imagen);
  formData.append('id_evento', id_evento);
  // Realiza una solicitud POST a la ruta de Laravel
  axios.post('/api/patrocinador', formData)
      .then(response => {
          // Maneja la respuesta exitosa aquí
          console.log(response.data);
      })
      .catch(error => {
          // Maneja errores aquí
          console.error(error);
      });
}