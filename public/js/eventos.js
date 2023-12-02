let eventos;
let eventosFiltrados;
let eventosVer;
let eventosTipo;
let eventosOrden;
let eventosBuscar;

window.addEventListener("load", () => {
    getEventos();
    getTiposEventos();
});

const getEventos = async () => {
    let datos = await axios.get("/api/evento").then((response) => {
        return response.data;
    });
    eventos = await datos;
    eventosFiltrados = eventosVer = eventosTipo = eventosOrden = eventosBuscar = [...eventos]
};

const getTiposEventos = async () => {
    axios.get("/api/tipo-evento")
    .then(function (response) {
        const select = document.getElementById("select_tipo_evento");
        const tiposDeEvento = response.data;
        tiposDeEvento.forEach(function (tipo) {
            const option = document.createElement("option");
            option.value = tipo.id;
            option.text = tipo.nombre;
            select.appendChild(option);
        })
    })
    .catch(function (error) {
        console.error(error);
    });
}

const buscarEvento = () => {
    let buscado = document.getElementById("buscadorDeEvento").value;
    eventosBuscar = eventos.filter(evento => {
        let datos = evento.nombre.toLowerCase();
        datos += " " + moment(evento.inicio_evento).format("DD-MM-YYYY");
        datos += " " + moment(evento.fin_evento).format("DD-MM-YYYY");
        datos += " " + evento.tipo_evento.nombre;
        return datos.includes(buscado.toLowerCase());
    });
    mostrarEventos();
};

const filtrarVer = () =>{
    let seleccionado = document.getElementById("select_ver")
    let valor = parseInt(seleccionado.value)
    switch (valor) {
        case 1: 
            eventosVer = eventos;
            break;

        case 2: 
            eventosVer = eventos.filter(evento =>
                ((moment()).isSame(moment(evento.inicio_evento)) ||(moment()).isAfter(moment(evento.inicio_evento))) && 
                moment().isBefore(moment(evento.fin_evento))
            );
            break;

        case 3: 
            eventosVer = eventos.filter(evento =>
                moment(evento.inicio_evento).isAfter(moment())
            );
            break;
            
        case 4: 
            eventosVer = eventos.filter(evento =>
                moment(evento.fin_evento).isBefore(moment())
            );
            break;
    }
    mostrarEventos();
}

const filtrarTipo = () =>{
    let seleccionado = document.getElementById("select_tipo_evento")
    let tipo = seleccionado.options[seleccionado.selectedIndex].text
    if(tipo !== "Todos"){
        eventosTipo = eventos.filter(evento =>{
            return evento.tipo_evento.nombre == tipo    
        })
    }else{
        eventosTipo = eventos
    }
    mostrarEventos()
}

const interseccionMultiple = (arreglos) =>{
    if (!arreglos || arreglos.length === 0) {
      return [];
    }
  
    // Tomar el primer arreglo como base
    const base = arreglos[0];
  
    // Aplicar la intersección sucesiva con los demás arreglos
    const intersection = arreglos.slice(1).reduce((result, arreglos) => {
      return result.filter(element => arreglos.includes(element));
    }, base);
  
    return intersection;
  }

const mostrarEventos = () => {
    let div = document.getElementById("tarjetasRow");
    let contenido = "";
    let seleccionado = document.getElementById("select_por")
    eventosFiltrados = interseccionMultiple([eventos,eventosVer,eventosTipo,eventosBuscar])
    switch(seleccionado.value){
        case "1":
                eventosFiltrados.sort((a, b) => a.nombre.localeCompare(b.nombre));
                break;
        case "2":
                eventosFiltrados.sort((a, b) => b.nombre.localeCompare(a.nombre));
                break;
        case "3":
                eventosFiltrados.sort((a,b)=> new Date(a.created_at) - new Date(b.created_at))
                break;
        case "4":
                eventosFiltrados.sort((a,b)=> new Date(b.created_at) - new Date(a.created_at))
                break;                            
    }

    eventosFiltrados.map(evento => {
        let rutaImagen = evento.afiches.length > 0 ? evento.afiches[0].ruta_imagen : "/image/aficheDefecto.png";
        contenido +=
            `
        <div class="col-md-auto">
            <div class="tarjeta card mb-3" style="width: 540px; height: 200px">
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
                                <a href="/eventos/${evento.nombre}"
                                    id="linkEvento" class="text-decoration-none stretched-link">Saber
                                    más...</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex p-3 align-self-center col-md-4" style="height: 195px">
                        <img src="${rutaImagen}"
                            class="img-fluid rounded-start object-fit-scale" alt="...">
                    </div>
                </div>
            </div>
        </div>
            `;
    });
    div.innerHTML = contenido;
};