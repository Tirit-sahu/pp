<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;


class Login extends Component
{
    public $email, $password;
    


    public function render()
    {   
        return view('livewire.login')
        ->extends('layouts.app');
    }



    public function submitLogin(){
        $validatedDate = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(\Auth::attempt(array('email' => $this->email, 'password' => $this->password))){
            return redirect('/');
            // session()->flash('success', "You are Login successful.");
        }else{
            session()->flash('error', 'email and password are wrong.');
            return redirect('/login');
        }
    }
}
