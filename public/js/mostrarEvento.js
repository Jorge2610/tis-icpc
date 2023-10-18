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
  validarImagen("validationCustomImage", 2, (response) => {
    if (!response.error) {
      var reader = new FileReader();
      reader.onload = function () {

        var output = document.getElementById('sponsorPreview');
        output.style.backgroundImage = 'url(' + reader.result + ')';
      };
      reader.readAsDataURL(event.target.files[0]);
    }
    else{
      var output = document.getElementById('sponsorPreview');
      output.style.backgroundImage = 'url(' + '../image/uploading.png' + ')';
    }
    console.log(response.mensaje);
  });
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
async function guardarPatrocinador() {
  let form = document.getElementById("formularioAgregarPatrocinador");
  if(form.checkValidity()){
    // Obtén los valores del formulario
    const nombre = document.getElementById('validationCustomName').value;
    const enlaceWeb = document.getElementById('validationCustomLink').value;
    const imagen = document.getElementById('validationCustomImage').files[0];
    const id_evento = document.getElementById('id_evento').value;
    // Crea un objeto FormData para enviar los datos
    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('enlace_web', enlaceWeb);
    formData.append('logo', imagen);
    formData.append('id_evento', id_evento);
    // Realiza una solicitud POST a la ruta de Laravel
    axios.post('/api/patrocinador', formData)
      .then(response => {
        // Maneja la respuesta exitosa aquí
        cargarPatrocinadores();
      })
      .catch(error => {
        // Maneja errores aquí
        console.error(error);
      });
    $("#modalAgregarPatrocinador").modal("hide");
    document.getElementById("formularioAgregarPatrocinador").reset();
    var output = document.getElementById('sponsorPreview');
    output.style.backgroundImage = 'url(' + '../image/uploading.png' + ')';
  }
  else{
    form.classList.add('was-validated');
  }
  
}

const validarImagen = (id, peso, callback) => {
  const input = document.getElementById(id);
  if (input.files.length > 0) {
    const imagen = input.files[0];
    const maxFileSize = peso * 1024 * 1024;
    let mensaje = { mensaje: "", error: false };

    let type = !/image\/(png|jpeg|jpg)/.test(imagen.type);

    if (type) {
      input.value = "";
      mensaje = { mensaje: "Archivo no válido", error: true };
    }

    if (imagen.size > maxFileSize) {
      input.value = "";
      mensaje = { mensaje: "Archivo no válido", error: true };
    }

    if (typeof callback === "function") {
      callback(mensaje);
    }
  }
};

window.addEventListener("load", async () => {
  await cargarPatrocinadores();
});


async function cargarPatrocinadores() {
  try {
    const response = await getPatrocinadores();
    const patrocinadores = response.data;
    let content = ``;
    patrocinadores.forEach((patrocinador) => {
      let ruta;
      if(patrocinador.enlace_web===null){
        ruta='#';
      }
      else{
        ruta=patrocinador.enlace_web;
      }
      content += `
        <div class="col-12 col-md-12 d-flex justify-content-center">
            <div id="imagenPatrocinador">
                <a href="${ruta}" target="_blank">
                  <img id="imagenPatrocinador" src="${patrocinador.ruta_logo}" title="${patrocinador.nombre}"
                        alt="Imagen del patrocinador" style="object-fit: cover; max-height: 7rem;">
                </a>
                <div class="borrar-patrocinador" onclick="borrarPatrocinador(${patrocinador.id})"><i class="fa-solid fa-trash-can"></i></div>
            </div>
        </div>
      `;
    });
    let contenedor = document.getElementById("contenedorPatrocinadores");
    contenedor.innerHTML = content;
  } catch (error) {
    alert(error);
  }
}

async function getPatrocinadores() {
  const id_evento = document.getElementById('id_evento').value;
  datos = await axios
    .get("/api/patrocinador/" + id_evento)
    .then((response) => {
      return response;
    })
    .catch((error) => {
      return error;
    });
  return datos;
}