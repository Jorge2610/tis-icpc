const linkSubir = document.getElementById("uploadButton");
const imagenPredeterminada = document.getElementById("uploadIcon");
const imagenPrevisualizada = document.getElementById("imagePreview");
const botonBorrarAfiche = document.getElementById("botonBorrarAfiche");
const botonSubirAfiche = document.getElementById("botonSubirAfiche");

const subirAfiche = (id) => {
    ocultarElementosIniciales();
    validarImagen("imageUpload", 2, (response) => {
        if (!response.error) {
            const input = document.getElementById("imageUpload");
            mostrarImagenPrevisualizada(input, id);
        } else {
            const mensaje = "Imagen no válida, vuelve a subir el afiche";
            restaurarValoresIniciales(mensaje);
        }
    });
};

const ocultarElementosIniciales = () => {
    linkSubir.style.display = "none";
    imagenPredeterminada.style.display = "none";
    imagenPrevisualizada.style.display = "block";
    botonBorrarAfiche.style.visibility = "visible";
    botonSubirAfiche.style.visibility = "visible";
};

const restaurarValoresIniciales = (mensaje) => {
    imagenPredeterminada.style.display = "block";
    imagenPrevisualizada.style.display = "none";
    botonBorrarAfiche.style.visibility = "hidden";
    botonSubirAfiche.style.visibility = "hidden";
    linkSubir.textContent = mensaje;
    linkSubir.style.display = "block";
};

const mostrarImagenPrevisualizada = (input, id) => {
    const reader = new FileReader();
    reader.onload = (e) => {
        imagenPrevisualizada.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);

    const form = new FormData();
    form.append("afiche", input.files[0]);

    axios.post(`/api/evento/afiche/${id}`, form);
};

const previsualizacionPatrocinador = (event) => {
    validarImagen("validationCustomImage", 2, (response) => {
        if (!response.error) {
            mostrarImagenPatrocinador(event.target);
        } else {
            let output = document.getElementById("sponsorPreview");
            output.style.backgroundImage = `url(../image/uploading.png)`;
        }
    });
};

const mostrarImagenPatrocinador = (input) => {
    const reader = new FileReader();
    reader.onload = () => {
        const output = document.getElementById("sponsorPreview");
        output.style.backgroundImage = `url(${reader.result})`;
    };
    reader.readAsDataURL(input.files[0]);
};

const reiniciarModal = (idModal, idForm) => {
    const output = document.getElementById("sponsorPreview");
    output.style.backgroundImage = "url(" + "../image/uploading.png" + ")";
    const modal = document.getElementById(idModal);
    const inputs = modal.querySelectorAll("input");
    inputs.forEach((element) => (element.value = ""));
    const form = document.getElementById(idForm);
    form.classList.remove("was-validated");
};

// Esta función se llama cuando se hace clic en el botón "Confirmar"
const guardarPatrocinador = async () => {
    const form = document.getElementById("formularioAgregarPatrocinador");
    if (form.checkValidity()) {
        try {
            const formData = obtenerDatosFormulario();
            const response = await axios.post("/api/patrocinador", formData);
            cargarPatrocinadores();
            manejarRespuesta();
        } catch (error) {
            console.error(error);
        }
    } else {
        form.classList.add("was-validated");
    }
};

const obtenerDatosFormulario = () => {
    const nombre = document.getElementById("validationCustomName").value;
    const enlaceWeb = document.getElementById("validationCustomLink").value;
    const imagen = document.getElementById("validationCustomImage").files[0];
    const id_evento = document.getElementById("id_evento").value;

    const formData = new FormData();
    formData.append("nombre", nombre);
    formData.append("enlace_web", enlaceWeb);
    formData.append("logo", imagen);
    formData.append("id_evento", id_evento);

    return formData;
};

const manejarRespuesta = () => {
    $("#modalAgregarPatrocinador").modal("hide");
    document.getElementById("formularioAgregarPatrocinador").reset();
    const output = document.getElementById("sponsorPreview");
    output.style.backgroundImage = `url(../image/uploading.png)`;
};

const validarImagen = (id, peso, callback) => {
    const input = document.getElementById(id);
    if (input.files.length > 0) {
        const imagen = input.files[0];
        const maxFileSize = peso * 1024 * 1024;
        let mensaje = { mensaje: "", error: false };

        const type = !/image\/(png|jpeg|jpg)/.test(imagen.type);

        if (type || imagen.size > maxFileSize) {
            input.value = "";
            mensaje = { mensaje: "Archivo no válido", error: true };
        }

        if (typeof callback === "function") {
            callback(mensaje);
        }
    }
};

window.addEventListener("load", () => {
    cargarPatrocinadores();
    let ruta = document.getElementById("rutaImagen").textContent;
    if (ruta != "/evento/afiche.jpg") {
        imagenPrevisualizada.src = ruta;
        imagenPredeterminada.style.display = "none";
        linkSubir.style.display = "block";
        imagenPrevisualizada.style.display = "block";
        botonBorrarAfiche.style.visibility = "visible";
        botonSubirAfiche.style.visibility = "visible";
    }
});

const borrarAfiche = (id) => {
    axios.delete("/api/evento/afiche/" + id).then((response) => {
        const mensaje = "Borrado correctamente, presione para a subir afiche";
        restaurarValoresIniciales(mensaje);
    });
};
const cargarPatrocinadores = async () => {
    try {
        const response = await getPatrocinadores();
        const patrocinadores = response.data;
        const contenedor = document.getElementById("contenedorPatrocinadores");

        const content = patrocinadores
            .map((patrocinador) => {
                const ruta = patrocinador.enlaceWeb
                    ? patrocinador.enlace_web
                    : "#";
                return `
            <div class="col-12 col-md-12 d-flex justify-content-center">
                <div id="imagenPatrocinador">
                    <a href="${ruta}" target="_blank">
                        <img id="imagenPatrocinador" src="${patrocinador.ruta_logo}" title="${patrocinador.nombre}"
                            alt="Imagen del patrocinador" style="object-fit: cover; max-height: 7rem; max-width: 100%;">
                    </a>
                    <button class="borrar-patrocinador" data-bs-toggle="modal" data-bs-whateve="${patrocinador.id}" 
                        data-bs-target="#modalBorrarPatrocinador" onclick="borrarPatrocinador(${patrocinador.id})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        `;
            })
            .join("");

        contenedor.innerHTML = content;
    } catch (error) {
        alert(error);
    }
};

const getPatrocinadores = async () => {
    const id_evento = document.getElementById("id_evento").value;
    const datos = await axios
        .get(`/api/patrocinador/${id_evento}`)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            return error;
        });
    return datos;
};

const borrarPatrocinador = (id) => {
    const modalBorrar = document.getElementById("modalBorrarPatrocinador");
    modalBorrar.setAttribute("idpatrocinador", id);
};

const borrar1 = async () => {
    const modalBorrar = document.getElementById("modalBorrarPatrocinador");
    await axios
        .delete(
            `/api/patrocinador/${modalBorrar.getAttribute("idpatrocinador")}`
        )
        .then((response) => {
            return response;
        })
        .catch((error) => {
            return error;
        });
    await cargarPatrocinadores();
};
