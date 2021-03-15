<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MasterSession extends Component
{
    public function render()
    {
        return view('livewire.master-session')
        ->extends('layouts.app');
    }
}
