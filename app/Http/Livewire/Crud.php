<?php
namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Crud extends Component
{
    use WithPagination;

    public $search;
    protected $paginationTheme = 'bootstrap';

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
