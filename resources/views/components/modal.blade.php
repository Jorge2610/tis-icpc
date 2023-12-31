<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">{{ $modalTitle }}</h5>
            </div>
            <div class="modal-body d-flex justify-content-center">
                {{ $modalContent }}
            </div>
            <div class="modal-footer d-flex justify-content-center">
                {{ $modalButton }}
            </div>
        </div>
    </div>
</div>
