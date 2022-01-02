<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Properties extends Component
{
    public   $saludo = 'Hola Mundo';
    //public $id = 0; //esta palabra es reservada y no la podemos usar como variable

    public function render()
    {
        return view('livewire.properties', ['saludo2' => 'hola nuevamente'])
            ->layout('layouts.theme');
    }
}
 