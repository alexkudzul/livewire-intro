<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class ShowPosts extends Component
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';

    // Escucha el evento 'render emitido desde CreatePost.php y ejecuta la función 'render' de ShowPosts.php
    // protected $listeners = ['render' => 'render']; // ['evento-que-escucha'=>'función-que-ejecuta']
    protected $listeners = ['render']; // Si el nombre del evento y el método al que está llamando coinciden, puede omitir la clave.

    public function render()
    {
        $posts = Post::where('title', 'LIKE', '%' . $this->search . '%')
            ->orWhere('content', 'LIKE', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->get();

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
}
