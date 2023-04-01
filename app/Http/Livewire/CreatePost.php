<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{
    public $open = false; // open a modal
    public $title;
    public $content;

    public function render()
    {
        return view('livewire.create-post');
    }

    public function save()
    {
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
