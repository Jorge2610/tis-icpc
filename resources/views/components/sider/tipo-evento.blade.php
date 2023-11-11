<div class="accordion-item border-0">
    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
            aria-controls="panelsStayOpen-collapseOne">
            TIPO DE EVENTO
        </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse"
        aria-labelledby="panelsStayOpen-headingOne">
        <div class="my-1 ms-3">
            <a href="{{ url('/admin/tipos-de-evento') }}"
                class="list-group-item list-group-item-action sider-custom-bg py-2 border-0"
                id="verTiposEventoSider">
                Ver tipos de evento
            </a>
            <a href="{{ url('/admin/tipos-de-evento/crear-tipo') }}"
                class="list-group-item list-group-item-action py-2 border-0"
                id="crearTipoEventoSider">
                Crear tipo de evento
            </a>
            <a href="{{ url('/admin/tipos-de-evento/editar-tipo') }}"
                class="list-group-item list-group-item-action py-2 border-0"
                id="crearTipoEventoSider">
                Editar tipo de evento
            </a>
            <a href="{{ url('/admin/tipos-de-evento/eliminar-tipo') }}"
                class="list-group-item list-group-item-action py-2 border-0"
                id="crearTipoEventoSider">
                Eliminar tipo de evento
            </a>
        </div>
    </div>
</div>