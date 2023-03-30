<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class ShowPosts extends Component
{
    public function render()
    {
        $posts = Post::all();

        // Por defecto se utiliza el layout app.blade.php
        return view('livewire.show-posts', compact('posts'));
    }
}
