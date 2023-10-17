<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalAgregarPatrocinador extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $evento;

    public function __construct($evento)
    {
        $this->evento = $evento;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-agregar-patrocinador');
    }
}
