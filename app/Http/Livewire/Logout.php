<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;

class Logout extends Component
{
    public function render()
    {
        return view('livewire.logout')
        ->extends('layouts.app');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }


}
