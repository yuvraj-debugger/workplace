<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LoginRegister extends Component
{
    public $users, $email, $password, $name;
    
    public function render()
    {
        return view('livewire.login-register');
    }
    public function login()
    {
        dd('9999');
    }
}
