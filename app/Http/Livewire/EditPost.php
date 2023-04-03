<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class EditPost extends Component
{
    use WithFileUploads;

    public $open = false; // open a modal
    public $post;
    public $image;
    public $identifier;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required'
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        // Se inicializa con un número aleatorio.
        $this->identifier = rand();
    }

    public function render()
    {
        return view('livewire.edit-post');
    }

    public function save()
    {
        $this->validate();

        // Si se tiene almacenado algo en la propiedad $image;
        if ($this->image) {
            // Elimina la imagen del servidor
            Storage::delete([$this->post->image]);

            // Guarda la nueva imagen temporal en posts
            $this->post->image = $this->image->store('posts');
        }

        $this->post->save();

        // Restablecer los valores de propiedad pública a su estado
        // inicial. Esto es útil para limpiar los campos de entrada
        // después de realizar una acción.
        $this->reset(['open', 'image']);

        // Despues de resetear los campos, cambiamos el valor de identifier.
        // Para que al momento de renderizar de nuevo la vista detecte que tenga que generar un nuevo input pero con un "id" distinto.
        // Con esto logramos "resetear" el campo input de tipo "file".
        $this->identifier = rand();

        // Activar eventos con emit().
        // Es posible que solo desee emitir un evento a otro componente del mismo tipo.
        // El componente ShowPosts escuchara el evento render
        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se actualizo satisfactoriamente');
    }
}
