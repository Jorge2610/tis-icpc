let eventos;
let eventosFiltrados;

window.addEventListener("load", () => {
    getEventos();
});

const getEventos = async () => {
    let datos = await axios.get("/api/evento").then((response) => {
        return response.data;
    });
    eventos = await datos;
};

const buscarEvento = () => {
    let buscado = document.getElementById("buscadorDeEvento").value;
    eventosFiltrados = eventos.filter(evento => {
        let nombreEvento = evento.nombre.toLowerCase();
        return nombreEvento.includes(buscado.toLowerCase());
    });
    mostrarEventos();
};

const mostrarEventos = () => {
    let div = document.getElementById("tarjetasRow");
    let contenido = "";
    eventosFiltrados.map(evento => {
        let rutaImagen = evento.afiches.length > 0 ? evento.afiches[0].ruta_imagen : "/image/aficheDefecto.png";
        contenido +=
            `
        <div class="col-md-auto">
            <div class="tarjeta card mb-3" style="max-width: 540px; min-height: 200px">
                <div class="row g-0">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fw-bold" id="nombreEvento">${evento.nombre}</h5>
                            <h6 id="tipoDeEvento">${evento.tipo_evento.nombre}</h6>
                            <hr>
                            </hr>
                            <p class="cart-text">
                                <span>Fecha del evento:</span>
                                <span id="fechaInicioEvento"
                                    class="mx-2 fst-italic">${moment(evento.inicio_evento).format("DD-MM-YYYY")}</span>
                                <span id="fechaFinEvento"
                                    class="fst-italic">${moment(evento.fin_evento).format("DD-MM-YYYY")}</span>
                            </p>
                            <div class="row text-end">
                                <a href="http://127.0.0.1:8000/eventos/${evento.nombre}"
                                    id="linkEvento" class="text-decoration-none stretched-link">Saber
                                    más...</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex p-3 align-self-center col-md-4">
                        <img src="${rutaImagen}"
                            class="img-fluid rounded-start" alt="...">
                    </div>
                </div>
            </div>
        </div>
            `;
    });
    div.innerHTML = contenido;
};