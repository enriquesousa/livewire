<?php
namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Crud extends Component
{
    use WithPagination;
    public $search, $action='Registrar';
    public $name, $email, $password, $user_id=0, $hiddenpassword;
    protected $paginationTheme = 'bootstrap';

    // Validaciones, $rules y $messages al inicio del componente!
    // Y el método updated($propiedad) valida solo la propiedad que en tiempo real se le esta pasando desde el frontend.
    // Y en el método store() solo dejar $this->validate(); esto automáticamente detecta los $rules y $messages globales protected. 
    // y los aplica.
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

    public function edit(User $user)
    {
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = null;
        $this->hiddenpassword = $user->password;
        $this->action = "Actualizar";
        $this->dispatchBrowserEvent('modal', ['action' => 'show']);
    }

    public function store()
    {
        // $this->validate();

        $user = User::updateOrCreate(
            ['id' => $this->user_id],
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => strlen($this->password) > 0 ? bcrypt($this->password) : $this->hiddenpassword,
            ]
        );

        $this->dispatchBrowserEvent('notify',
            ['result' => $this->user_id > 0 ? 'Usuario Actualizado' : 'Usuario Registrado']
        );

        $this->reset('name', 'email', 'user_id', 'hiddenpassword', 'action', 'search');
        $this->dispatchBrowserEvent('modal', ['action' => 'hide']);
    }

    protected $listeners = ['destroy'];
    public function destroy(User $user){
        $user->delete();
        $this->dispatchBrowserEvent('notify', ['result' => 'Usuario Eliminado']);
        $this->resetPage(); // reset paginado metodo de livewire
    }

    public function closeModal(){
        $this->reset('name', 'email', 'user_id', 'hiddenpassword', 'action', 'search');
        $this->dispatchBrowserEvent('modal', ['action' => 'hide']);
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $users = User::where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orderBy('name', 'asc')
                    ->paginate(5);
        }else{
            $users = User::orderBy('name', 'asc')->paginate(5);
        }

        return view('livewire.crud', [
            'users' => $users
        ])->layout('layouts.theme');
    }
}
