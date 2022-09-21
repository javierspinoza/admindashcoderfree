<div>
    @include('items.navbarNotifications')

    @if ($viewCreateEdit == 0)
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-uppercase ps-3 text-center">USUARIOS REGISTRADOS</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end mb-n4">
                                <button wire:click="createdData()" wire:click="like" class="btn btn-sm btn-success me-3 mt-3">
                                    Nuevo
                                </button>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="input-group input-group-static my-3 mb-n1">
                                                <div class="d-flex justify-content-start">
                                                    <label class="mb-n2 me-1">Mostrar</label>
                                                    <select class="select-pagination" wire:model="cant"
                                                        id="choices-state">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="30">30</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    <label class="mb-n2 ms-1">Registros por pagina</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ms-auto">
                                            <div class="input-group input-group-static my-3 mb-n1">
                                                <label class="mb-n3">Buscar</label>
                                                <input type="search" class="form-control" wire:model="search">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($users->count())
                                    <table class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                        style="width:100%">
                                        <thead class="bg-success text-white">
                                            <th>OPCIONES</th>
                                            <th role="button" wire:click="order('name')">NOMBRE <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('email')">EMAIL <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('created_at')">FECHA CREACIÓN <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th>ROL ASIGNADO
                                            </th>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td class="td-actions text-center">
                                                        <button wire:click="show({{ $user->id }})"
                                                            class="btn btn-success btn-icon-only rounded-circle"
                                                            title="Ver detalle">
                                                            <span class="btn-inner--icon"><i style="font-size: 14px"
                                                                    class="fas fa-eye-slash"></i></span>
                                                        </button>&nbsp;&nbsp;&nbsp;
                                                        <button wire:click="edit({{ $user->id }})"
                                                            class="btn btn-success btn btn-warning btn-icon-only rounded-circle"
                                                            title="Editar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-pencil-alt"></i></span>
                                                        </button>&nbsp;&nbsp;&nbsp;
                                                        <button
                                                            wire:click.prevent="$emit('destroyUser', {{ $user->id }})"
                                                            class="btn btn-danger btn-icon-only rounded-circle"
                                                            title="Eliminar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-trash"></i></span>
                                                        </button>
                                                    </td>
                                                    <td style="padding-left: 25px">{{ $user->name }}</td>
                                                    <td style="padding-left: 25px">{{ $user->email }}</td>
                                                    <td style="padding-left: 25px">
                                                        {{ $user->created_at->toFormattedDateString() }}</td>
                                                    <td>
                                                        @forelse ($user->roles as $role)
                                                            <span class="badge bg-success">{{ $role->name }}</span>
                                                        @empty
                                                            <span class="badge bg-danger">No tiene roles
                                                                asignados</span>
                                                        @endforelse
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($users->hasPages())
                                        <div class="px-6 py-3">
                                            {{ $users->links() }}
                                        </div>
                                    @endif
                                @else
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="p-2">No existe ningún registro</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($viewCreateEdit == 1)
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <form class="form-horizontal">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-center ps-3">REGISTRAR DATOS</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="mb-n2 mt-2" for="name">Nombre</label>
                                            <input type="text" class="form-control" wire:model="name">
                                        </div>
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="mb-n2 mt-2" for="email">Email</label>
                                            <input type="email" class="form-control" wire:model="email">
                                        </div>
                                        @error('email')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="mb-n2 mt-2" for="password">Contraseña</label>
                                            <input type="password" class="form-control" wire:model="password">
                                        </div>
                                        @error('password')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 mt-n4 tab-pane active">
                                <div class="table-responsive p-0 d-flex justify-content-center">
                                    <div class="col-md-5">
                                        <table class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                            style="width:100%">
                                            <thead class="bg-success text-white">
                                                <th class="col-md-2">ACCIONES</th>
                                                <th class="text-center">ROLES</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $role)
                                                    <tr>
                                                        <td style="padding-left: 25px">
                                                            <div class="form-check">
                                                                <label class="form-check-label mb-3">
                                                                    <div id="ready-checkbox">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            data-checkboxes="mygroup"
                                                                            wire:model="assignRol.{{ $role->id }}"
                                                                            value="{{ $role->id }}">
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td style="padding-left: 25px">
                                                            {{ $role->name }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-3">
                                <button wire:click.prevent="store()" wire:loading.attr="disabled" wire:tarjet="store"
                                    type="button"
                                    class="btn btn-sm btn-primary">Guardar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button wire:click="closeView()" type="button"
                                    class="btn btn-sm btn-success">Volver</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($viewCreateEdit == 2)
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <form class="form-horizontal">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-center ps-3">ACTUALIZAR DATOS</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="mb-n2 mt-2" for="name">Nombre</label>
                                            <input type="text" class="form-control" wire:model="name">
                                        </div>
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="mb-n2 mt-2" for="email">Email</label>
                                            <input type="email" class="form-control" wire:model="email">
                                        </div>
                                        @error('email')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="mb-n2 mt-2" for="password">Contraseña</label>
                                            <input type="password" class="form-control" wire:model="password">
                                        </div>
                                        @error('password')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 mt-n4 tab-pane active">
                                <div class="table-responsive p-0 d-flex justify-content-center">
                                    <div class="col-md-5">
                                        {{-- data:    @json($this->assignRol) --}}
                                        <table id="iniciarDataTables"
                                            class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                            style="width:100%">
                                            <thead class="bg-success text-white">
                                                <th class="col-md-2">ACCIONES</th>
                                                <th class="text-center">ROLES</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $role)
                                                    <tr>
                                                        <td style="padding-left: 25px">
                                                            <div class="form-check">
                                                                <label class="form-check-label mb-3">
                                                                    <div id="ready-checkbox">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="chek-{{ $role->id }}"
                                                                            data-checkboxes="mygroup"
                                                                            wire:model="assignRol"
                                                                            value="{{ $role->id }}">
                                                                        <span class="check"></span>
                                                                        </span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td style="padding-left: 25px">
                                                            {{ $role->name }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-3">
                                <button wire:click.prevent="update" wire:loading.attr="disabled" wire:tarjet="update"
                                    type="button"
                                    class="btn btn-sm btn-primary">Actualizar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button wire:click="closeView()" type="button"
                                    class="btn btn-sm btn-success">Volver</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($viewCreateEdit == 3)
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-uppercase text-center ps-3">Detalle de usuario</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card bg-gradient-light shadow-lg">
                                        <span class="badge rounded-pill bg-primary w-30 mt-n2 mx-auto">Detalle</span>
                                        <div class="card-header text-center pt-4 pb-3 bg-transparent">
                                            <h1 class="font-weight-bold mt-2 text-dark">
                                                <small class="text-lg mb-auto"></small><small
                                                    class="text-lg">{{ $name }}</small>
                                            </h1>
                                        </div>
                                        <div class="card-body text-lg-start text-center pt-0">
                                            <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                <i class="material-icons my-auto text-dark">favorite</i>
                                                <span class="ps-3 text-dark">Estos son algunos de tus datos</span>
                                            </div>

                                            <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                <i class="material-icons my-auto text-dark">done</i>
                                                <span class="ps-3 text-dark">Nombre: {{ $name }} </span>
                                            </div>

                                            <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                <i class="material-icons my-auto text-dark">done</i>
                                                <span class="ps-3 text-dark">Email: {{ $email }} </span>
                                            </div>

                                            <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                <i class="material-icons my-auto text-dark">done</i>
                                                <span class="ps-3 text-dark">Creación:
                                                    {{ $created_at->toFormattedDateString() }} </span>
                                            </div>
                                            <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                <i class="material-icons my-auto text-dark">remove</i>
                                                <span class="ps-3 text-dark">Roles:</span>
                                                <span class="ps-3 text-white">
                                                    @forelse ($user->roles as $role)
                                                        <span
                                                            class="badge rounded-pill bg-success text-white">{{ $role->name }}</span>
                                                    @empty
                                                        <span class="badge bg-danger">No tiene permisos
                                                            asignados</span>
                                                    @endforelse
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button wire:click="closeView()"
                                                    class="btn btn-icon bg-gradient-light d-lg-block mt-3 mb-0 fw-bold fs-6">
                                                    Regresar
                                                    <i class="fas fa-arrow-left ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('mijs')
    <script src="{{ asset('assets/libraryJavierSpinoza/sweetalert2/js/sweetalert2.js') }}"></script>
    <script>
        // destroyUser es el nombre del metodo del boton ---- user_id nombre del parametro que pasamos en la confirmacion de mas abajo
        Livewire.on('destroyUser', user_id => {
            Swal.fire({
                title: '¿Está seguro de eliminar este registro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, confirmar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // users es el nombre de la vusta o el nombre que esta en render creo----- destroy el metodo del controlador--- user_id el que pasamos al inicio de este script
                    Livewire.emitTo('users', 'destroy', user_id)
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Registro eliminado exitosamente!',
                        showConfirmButton: false,
                        timer: 0.1
                    })
                }
            })
        });
    </script>
    {{-- esta alerta es para cuando se crea y se actualiza --}}
    <script>
        Livewire.on('alertaSweelert', function(message) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1100
            })
        })
    </script>
    {{-- esta alerta es para cuando elimina registros --}}
    <script>
        Livewire.on('errorEliminar', function(message) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: message,
                showConfirmButton: false,
                timer: 1100
            })
        })
    </script>
    <script>
        Livewire.on('eliminadoCorrecto', function(message) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1100
            })
        })
    </script>
@endpush
