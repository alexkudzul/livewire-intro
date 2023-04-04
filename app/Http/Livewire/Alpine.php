<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Alpine extends Component
{
    public $count = 0;

    public function render()
    {
        return view('livewire.alpine');
    }

    public function increase()
    {
        $this->count++;
    }
}
