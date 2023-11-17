<div class="accordion-item border-0">
    <h2 class="accordion-header collapsed" id="panelsStayOpen-headingFour">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
            aria-controls="panelsStayOpen-collapseFour">
            PATROCINADOR
        </button>
    </h2>
    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse"
        aria-labelledby="panelsStayOpen-headingFour">
        <div class="my-1 ms-3">
            <a href="{{ url('/admin/patrocinador') }}"
                class="list-group-item list-group-item-action py-2 border-0" id="crearPatrocinadorSider">
                Crear patrocinador
            </a>
            <a href="{{ url('admin/patrocinador/eliminar') }}"
                class="list-group-item list-group-item-action py-2 border-0" id="eliminarPatrocinadorSider">
                Eliminar patrocinador
            </a>
            <a href="{{ url('admin/patrocinador/asignar') }}"
                class="list-group-item list-group-item-action py-2 border-0" id="asignarPatrocinadorSider">
                Asignar patrocinador
            </a>
            <a href="{{ url('admin/patrocinador/quitar') }}"
                class="list-group-item list-group-item-action py-2 border-0" id="quitarPatrocinadorSider">
                Quitar patrocinador
            </a>
        </div>
    </div>
</div>
