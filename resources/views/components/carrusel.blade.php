<div id="carrusel" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="100000">
    @if ($evento->afiches !== null && count($evento->afiches) > 1)
        <div class="carousel-indicators" id="indicadores">
            @foreach ($evento->afiches as $afiche)
                <button type="button"  data-bs-target="#carrusel" data-bs-slide-to="{{ $loop->index }}"
                    class="{{ $loop->first ? 'active' : '' }}"></button>
            @endforeach
        </div>
    @endif
    <div class="carousel-inner" id="carruselInner">
        @if ($evento->afiches !== null)
            @foreach ($evento->afiches as $afiche)
                <div class="carousel-item {{ $afiche->id === $evento->afiches->first()->id ? 'active' : '' }}">
                    <img src="{{ $afiche->ruta_imagen }}" class="d-block" alt="...">
                </div>
            @endforeach
        @endif
    </div>
    @if ($evento->afiches !== null && count($evento->afiches) > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#carrusel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carrusel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
    integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
</script>
