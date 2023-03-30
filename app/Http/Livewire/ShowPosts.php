<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class ShowPosts extends Component
{
    public $search;

    public function render()
    {
        $posts = Post::where('title', 'LIKE', '%' . $this->search . '%')
            ->orWhere('content', 'LIKE', '%' . $this->search . '%')
            ->get();

        // Por defecto se utiliza el layout app.blade.php
        return view('livewire.show-posts', compact('posts'));
    }
}
