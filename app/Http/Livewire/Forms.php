<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Forms extends Component
{
    use WithFileUploads;
    public $name, $email, $password, $photo;

    // Los $rules y $messages los dejamos con un accessor de tipo protected y los movemos al inicio del componente Forms, para poder tenerlos en forma global en el componente. Y el método updated($propiedad) valida solo la propiedad que en tiempo real se le esta pasando desde el frontend. Y en el método store() solo dejar $this->validate(); esto automáticamente detecta los $rules y $messages globales protected. y los aplica.
    protected $rules = [
        'name' => 'required|max:10|min:3',
        'email' => 'required|email',
        'password' => 'required|min:3'
    ];
    protected $messages = [
        'name.required' => 'El nombre es requerido',
        'name.min' => 'El nombre debe tener al menos 3 caracteres',
        'name.max' => 'El nombre debe tener máximo 10 caracteres',
        'email.required' => 'Ingresa el email',
        'email.email' => 'El email es inválido',
        'password.required' => 'Password requerido',
        'password.min' => 'El password debe tener al menos 3 caracteres',
    ];

    public function updated($propertyName)
    {   
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.forms')->layout('layouts.theme');
    }

    public function Store()
    {
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password)
        ]);

        if (!empty($this->photo)) {
            // generar nombre único
            $customFileName = uniqid() . '_.' . $this->photo->extension();
            $this->photo->storeAs('public/avatars', $customFileName);
            $user->photo = $customFileName;
            $user->save();
        }

        // feedback hacia el front p/notificar al usuario
        $this->dispatchBrowserEvent('user-register', ['result' => 'Usuario registrado']);

        // forma clásica de limpiar propiedades
        //$this->name = '';
        // Forma moderna de limpiar, reset de las propiedades
        $this->reset('name', 'email', 'password', 'photo');
    }
}
