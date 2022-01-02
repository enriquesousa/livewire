<div>
    
    <label for="">Nombre</label>

    {{-- Refresca inmediatamente lso cambios en $nombre --}}
    {{-- <input wire:model='nombre' type="text"> --}}
    <br>

    {{-- magic actions set(), actualiza $nombre hasta dar el enter --}}
    <input wire:keydown.enter="$set('nombre','Sousa')" type="text">
    <br>

    {{-- Para mandar llamar una funcion en app/Http/Livewire/Actions.php --}}
    <button wire:click="cambiarNombre('Ivonne')">Cambiar</button>
    <br>

    Nombre: {{$nombre}}

</div>