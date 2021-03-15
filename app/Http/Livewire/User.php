<?php

namespace App\Http\Livewire;

use Livewire\Component;

class User extends Component
{
    public $name;
    public function render()
    {
        return view('livewire.user')
        ->extends('layouts.app');
    }


    public function UserCreate()
    {
       dd($this->name);
    }
}
