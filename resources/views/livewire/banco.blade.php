<div>

    <div class="row mb-5">
        <div class="col">
            <label for="">Capital del Banco</label>
            <span>${{ $capital }}</span>
            <br>
            <button wire:click="$emitTo('tarjeta','asignar', {{ $capital }})" class="btn btn-primary">Asignar Credito</button>
        </div>
    </div>

    {{-- render el view de resources/views/livewire/tarjeta.blade.php --}}
    <livewire:tarjeta />
</div>