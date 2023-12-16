<div class="accordion-item border-0">
    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
            EVENTO
        </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
        <div class="my-1 ms-3">
            <a href="{{ url('/admin/eventos/crear-evento') }}"
                class="list-group-item list-group-item-action py-2 border-0" id="crearEventoSider">
                Crear evento
            </a>
            <a href="{{ url('/editarEvento/') }}" class="list-group-item list-group-item-action py-2 border-0"
                id="cancelarEventoSider">
                Editar evento
            </a>
            <a href="{{ url('/admin/eventos/cancelar-evento') }}"
                class="list-group-item list-group-item-action py-2 border-0" id="cancelarEventoSider">
                Cancelar evento
            </a>
            <a href="{{url('/admin/eventos/anular-evento')}}"
            class="list-group-item list-group-item-action py-2 border-0" id="cancelarEventoSider">
                Anular evento
            </a>
            <a href="{{ url('/admin/notificacion/enviar') }}"
                class="list-group-item list-group-item-action py-2 border-0" id="cancelarEventoSider">
                Notificar evento
            </a>
        </div>
    </div>
</div>
