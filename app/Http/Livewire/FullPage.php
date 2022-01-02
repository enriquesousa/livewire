<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FullPage extends Component
{
    public function render()
    {
        // Esta es la manera antigua de hacerlo y tenemos que usar @yield('content') en resources/views/layouts/theme.blade.php
        // return view('livewire.fullpage')->extends('layouts.theme')->section('content');

        // $slot, nueva manera de hacerlo, tenemos que usar {{ $slot }} en resources/views/layouts/theme.blade.php
        return view('livewire.fullpage')->layout('layouts.theme');
    }
}
