<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{
    public $open = false; // open a modal
    public $title;
    public $content;

    protected $rules = [
        'title' => 'required|max:10',
        'content' => 'required|min:100',
    ];

    public function render()
    {
        return view('livewire.create-post');
    }

    /**
     * Validación en tiempo real
     *
     * Se utiliza la función updated que recibe como parametro la propiedad y
     * ejecuta validateOnly para validar solo dicha propiedad para esto se debe
     * de permitir que la propiedad se actualize en tiempo real (sin defers).
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        // Restablecer los valores de propiedad pública a su estado
        // inicial. Esto es útil para limpiar los campos de entrada
        // después de realizar una acción.
        $this->reset(['open', 'title', 'content']);

        // Activar eventos con emit().
        // Es posible que solo desee emitir un evento a otro componente del mismo tipo.
        // El componente ShowPosts escuchara el evento render
        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El Post se creó satisfactoriamente');
    }
}
