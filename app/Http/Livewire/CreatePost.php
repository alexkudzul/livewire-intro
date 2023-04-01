<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{
    public $open = true; // open a modal
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
    }
}
