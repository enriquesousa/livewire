<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        <div class="col-sm-12 col-md-10">
            <input wire:model='search' type="text" class="form-control" placeholder="Buscar por nombre / correo">
        </div>
        <div class="col-sm-12 col-md-2">
            <button class="btn btn-primary" data-toggle="modal" data-terget="#modalUser">Agregar</button>
        </div>
        <div class="col-sm-12 mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($users->count() > 0)
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button onclick="confirmar({{ $user->id }})" class="btn btn-danger">Eliminar</button>
                                <button wire:click="edit({{ $user->id }})" class="btn btn-warning">Editar</button>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>Sin resultados</td>
                        </tr>    
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-sm-12">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div wire:ignore.self class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ $action }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <label>Nombre</label>
                        <input wire:model="name" type="text" class="form-control">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Email</label>
                        <input wire:model="email" type="text" class="form-control">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label>Password</label>
                        <input wire:model="password" type="password" class="form-control">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            
            </div>
            <div class="modal-footer">
            <button wire:click='closeModal' type="button" class="btn btn-secondary">Cerrar</button>
            <button wire:click='store' type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
        </div>
    </div>    


    <script>

        function confirmar(id){
            var opcion = confirm("¿Confirmas eliminar el registro?")
            if(opcion == true){
                window.livewire.emit('destroy', id)
            }
        }

        window.addEventListener('modal', event => {
            $('#modalUser').modal(event.detail.action)
        })

        window.addEventListener('notify', event => {
            alert(event.detail.result)
        })


    </script>


</div>
