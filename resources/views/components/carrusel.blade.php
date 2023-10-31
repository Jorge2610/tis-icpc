<div id="carrusel" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="100000">
    <div class="carousel-indicators" id="indicadores">
        @if ($evento->afiches !== null)
            @foreach ($evento->afiches as $afiche)
                <button type="button"  data-bs-target="#carrusel" data-bs-slide-to="{{ $loop->index }}"
                    class="{{ $loop->first ? 'active' : '' }}"></button>
            @endforeach
        @endif
    </div>
    <div class="carousel-inner" id="carruselInner">
        @if ($evento->afiches !== null)
            @foreach ($evento->afiches as $afiche)
                <div class="carousel-item {{ $afiche->id === $evento->afiches->first()->id ? 'active' : '' }}">
                    <img src="{{ $afiche->ruta_imagen }}" class="d-block" alt="...">
                </div>
            @endforeach
        @endif
    </div>
    @if ($evento->afiches !== null)
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>
