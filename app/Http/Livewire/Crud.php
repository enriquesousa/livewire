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
