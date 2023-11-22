<div class="accordion-item border-0">
    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
            ACTIVIDAD
        </button>
    </h2>
    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
        <div class="my-1 ms-3">
            <a href="{{ url('/admin/actividad') }}"
                class="list-group-item list-group-item-action py-2 border-0" id="crearActividadSider">
                Crear actividad
            </a>
            <a href="{{ url('/admin/actividad/eliminar') }}"
                class="list-group-item list-group-item-action py-2 border-0" id="eliminaActividadSider">
                Eliminar actividad
            </a>
        </div>
    </div>
</div>
