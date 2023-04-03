<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ShowPosts extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $open_edit = false; // open a modal
    public $post;
    public $image;
    public $identifier;

    // Escucha el evento 'render emitido desde CreatePost.php y ejecuta la función 'render' de ShowPosts.php
    // protected $listeners = ['render' => 'render']; // ['evento-que-escucha'=>'función-que-ejecuta']
    protected $listeners = ['render']; // Si el nombre del evento y el método al que está llamando coinciden, puede omitir la clave.

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required'
    ];

    public function mount()
    {
        $this->post = new Post();
        // Se inicializa con un número aleatorio.
        $this->identifier = rand();
    }

    // Se ejecuta después de que una propiedad cambie
    public function updatingSearch()
    {
        // Resetea la página cuando la propiedad search cambie
        $this->resetPage();
    }

    public function render()
    {
        $posts = Post::where('title', 'LIKE', '%' . $this->search . '%')
            ->orWhere('content', 'LIKE', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate(10);

        // Por defecto se utiliza el layout app.blade.php
        return view('livewire.show-posts', compact('posts'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function edit(Post $post)
    {
        // Post a editar
        $this->post = $post;

        // Abrir modal
        $this->open_edit = true;
    }

    public function update()
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
        $this->reset(['open_edit', 'image']);

        // Despues de resetear los campos, cambiamos el valor de identifier.
        // Para que al momento de renderizar de nuevo la vista detecte que tenga que generar un nuevo input pero con un "id" distinto.
        // Con esto logramos "resetear" el campo input de tipo "file".
        $this->identifier = rand();

        // Activar eventos con emit().
        $this->emit('alert', 'El post se actualizo satisfactoriamente');
    }
}
