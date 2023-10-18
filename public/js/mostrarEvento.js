
function handleImageUpload(id) {
    document.getElementById("uploadButton").style.display = "none";
    document.getElementById("uploadIcon").style.display = "none";
    document.getElementById("imagePreview").style.display = "block";
    document.getElementById("botonBorrarAfiche").style.visibility = "visible";
    document.getElementById("botonSubirAfiche").style.visibility = "visible";
    validarImagen("imageUpload", 2, (response) => {
        if (!response.error) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("imagePreview").src = e.target.result;
            };
            reader.readAsDataURL(
                document.getElementById("imageUpload").files[0]
            );

            let form = new FormData();
            form.append(
                "afiche",
                document.getElementById("imageUpload").files[0]
            );

            axios.post("/api/evento/afiche/" + id, form).then((response) => {
                console.log(response.data);
            });
        } else {
            document.getElementById("uploadIcon").style.display = "block";
            document.getElementById("imagePreview").style.display = "none";
            document.getElementById("botonBorrarAfiche").style.visibility =
                "hidden";
            document.getElementById("botonSubirAfiche").style.visibility =
                "hidden";
            document.getElementById("uploadButton").textContent =
                "Imagen no valida vuelve a subir afiche";
            document.getElementById("uploadButton").style.display = "block";
        }
    });
}

function previewSponsorLogo(event) {
    validarImagen("validationCustomImage", 2, (response) => {
        if (!response.error) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById("sponsorPreview");
                output.style.backgroundImage = "url(" + reader.result + ")";
            };
            reader.readAsDataURL(event.target.files[0]);
        } else {
            var output = document.getElementById("sponsorPreview");
            output.style.backgroundImage =
                "url(" + "../image/uploading.png" + ")";
        }
        console.log(response.mensaje);
    });
}

function resetModal(idModal, idForm) {
    var output = document.getElementById("sponsorPreview");
    output.style.backgroundImage = "url(" + "../image/uploading.png" + ")";
    let modal = document.getElementById(idModal);
    let inputs = modal.querySelectorAll("input");
    inputs.forEach((element) => (element.value = ""));
    let form = document.getElementById(idForm);
    form.classList.remove("was-validated");
}

// Esta función se llama cuando se hace clic en el botón "Confirmar"
async function guardarPatrocinador() {
    let form = document.getElementById("formularioAgregarPatrocinador");
    if (form.checkValidity()) {
        // Obtén los valores del formulario
        const nombre = document.getElementById("validationCustomName").value;
        const enlaceWeb = document.getElementById("validationCustomLink").value;
        const imagen = document.getElementById("validationCustomImage")
            .files[0];
        const id_evento = document.getElementById("id_evento").value;
        // Crea un objeto FormData para enviar los datos
        const formData = new FormData();
        formData.append("nombre", nombre);
        formData.append("enlace_web", enlaceWeb);
        formData.append("logo", imagen);
        formData.append("id_evento", id_evento);
        // Realiza una solicitud POST a la ruta de Laravel
        axios
            .post("/api/patrocinador", formData)
            .then((response) => {
                // Maneja la respuesta exitosa aquí
                cargarPatrocinadores();
            })
            .catch((error) => {
                // Maneja errores aquí
                console.error(error);
            });
        $("#modalAgregarPatrocinador").modal("hide");
        document.getElementById("formularioAgregarPatrocinador").reset();
        var output = document.getElementById("sponsorPreview");
        output.style.backgroundImage = "url(" + "../image/uploading.png" + ")";
    } else {
        form.classList.add("was-validated");
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
    let ruta = document.getElementById("rutaImagen").textContent;
    if (ruta != "/evento/afiche.jpg") {
        console.log(ruta);
        document.getElementById("imagePreview").src = ruta;
        document.getElementById("uploadButton").style.display = "none";
        document.getElementById("uploadIcon").style.display = "none";
        document.getElementById("imagePreview").style.display = "block";
        document.getElementById("botonBorrarAfiche").style.visibility =
            "visible";
        document.getElementById("botonSubirAfiche").style.visibility =
            "visible";
    }
});

borrarAfiche = (id) => {
    axios.delete("/api/evento/afiche/" + id).then((response) => {
        document.getElementById("uploadIcon").style.display = "block";
        document.getElementById("imagePreview").style.display = "none";
        document.getElementById("botonBorrarAfiche").style.visibility =
            "hidden";
        document.getElementById("botonSubirAfiche").style.visibility = "hidden";
        document.getElementById("uploadButton").textContent =
            "Borrado correctamente, presione para a subir afiche";
        document.getElementById("uploadButton").style.display = "block";
    });
};
async function cargarPatrocinadores() {
    try {
        const response = await getPatrocinadores();
        const patrocinadores = response.data;
        let content = ``;
        patrocinadores.forEach((patrocinador) => {
            let ruta;
            if (patrocinador.enlace_web === null) {
                ruta = "#";
            } else {
                ruta = patrocinador.enlace_web;
            }
            content += `
        <div class="col-12 col-md-12 d-flex justify-content-center">
            <div id="imagenPatrocinador">
                <a href="${ruta}" target="_blank">
                  <img id="imagenPatrocinador" src="${patrocinador.ruta_logo}" title="${patrocinador.nombre}"
                        alt="Imagen del patrocinador" style="object-fit: cover; max-height: 7rem; max-width: 100%;">
                </a>
                <button class="borrar-patrocinador" data-bs-toggle="modal" data-bs-whateve="${patrocinador.id}" data-bs-target="#modalBorrarPatrocinador" onclick="borrarPatrocinador(${patrocinador.id})">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
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
    const id_evento = document.getElementById("id_evento").value;
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

function borrarPatrocinador(id) {
    let modalBorrar = document.getElementById("modalBorrarPatrocinador");
    modalBorrar.setAttribute("idpatrocinador", id);
}

async function borrar1() {
    let modalBorrar = document.getElementById("modalBorrarPatrocinador");
    await axios
        .delete(
            "/api/patrocinador/" + modalBorrar.getAttribute("idpatrocinador")
        )
        .then((response) => {
            return response;
        })
        .catch((error) => {
            return error;
        });
    await cargarPatrocinadores();
}