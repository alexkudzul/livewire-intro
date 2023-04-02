<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $open = false; // open a modal
    public $title;
    public $content;
    public $image;
    public $identifier; // Agrega un identificador unico al input file para resetear su valor.

    protected $rules = [
        'title' => 'required',
        'content' => 'required',
        'image' => 'required|image|max:2048'
    ];

    public function mount()
    {
        // Se inicializa con un número aleatorio.
        $this->identifier = rand();
    }

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
    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    public function save()
    {
        $this->validate();

        // Guarda la imagen temporal en posts
        $image = $this->image->store('posts');

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image,
        ]);

        // Restablecer los valores de propiedad pública a su estado
        // inicial. Esto es útil para limpiar los campos de entrada
        // después de realizar una acción.
        $this->reset(['open', 'title', 'content', 'image']);

        // Despues de resetear los campos, cambiamos el valor de identifier.
        // Para que al momento de renderizar de nuevo la vista detecte que tenga que generar un nuevo input pero con un "id" distinto.
        // Con esto logramos "resetear" el campo input de tipo "file".
        $this->identifier = rand();


        // Activar eventos con emit().
        // Es posible que solo desee emitir un evento a otro componente del mismo tipo.
        // El componente ShowPosts escuchara el evento render
        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El Post se creó satisfactoriamente');
    }
}
