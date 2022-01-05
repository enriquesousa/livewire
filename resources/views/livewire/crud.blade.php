<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        <div class="col-sm-12">
            <input wire:model='search' type="text" class="form-control" placeholder="Buscar por nombre / correo">
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
                                <button class="btn btn-danger">Eliminar</button>
                                <button class="btn btn-warning">Editar</button>
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
</div>
