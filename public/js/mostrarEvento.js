window.addEventListener("load", () => {
    cargarPatrocinadores();
});

const cargarPatrocinadores = async () => {
    try {
        const response = await getPatrocinadores();
        const patrocinadores = response.data;
        const contenedor = document.getElementById("contenedorPatrocinadores");

        const content = patrocinadores
            .map((patrocinador) => {
                const ruta = patrocinador.enlace_web
                    ? patrocinador.enlace_web
                    : "#";
                return `
            <div class="col-12 col-md-12 d-flex justify-content-center">
                <div id="imagenPatrocinador">
                    <a href="${ruta}" target="_blank">
                        <img id="imagenPatrocinador" src="${patrocinador.ruta_imagen}" title="${patrocinador.nombre}"
                            alt="Imagen del patrocinador" style="object-fit: cover; max-height: 7rem; max-width: 100%;">
                    </a>
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