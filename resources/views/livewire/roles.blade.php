<div>
    @include('items.navbarNotifications')

    @if ($viewCreateEdit == 0)
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-uppercase ps-3 text-center">ROLES REGISTRADOS</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end mb-n4">
                                <button wire:click="createdData()" class="btn btn-sm btn-success me-3 mt-3">
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
                                @if ($roles->count())
                                    <table class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                        style="width:100%">
                                        <thead class="bg-success text-white">
                                            <th>OPCIONES</th>
                                            <th role="button" wire:click="order('name')">NOMBRE ROL<i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('created_at')">FECHA CREACIÓN <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th>VER PERMISOS ASIGNADOS</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                                <tr>
                                                    <td class="td-actions text-center">
                                                        <button wire:click="edit({{ $role->id }})"
                                                            class="btn btn-success btn btn-warning btn-icon-only rounded-circle"
                                                            title="Editar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-pencil-alt"></i></span>
                                                        </button>&nbsp;&nbsp;&nbsp;
                                                        <button
                                                            wire:click.prevent="$emit('destroyRole', {{ $role->id }})"
                                                            class="btn btn-danger btn-icon-only rounded-circle"
                                                            title="Eliminar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-trash"></i></span>
                                                        </button>
                                                    </td>
                                                    <td style="padding-left: 25px">{{ $role->name }}</td>
                                                    <td style="padding-left: 25px">
                                                        {{ $role->created_at->toFormattedDateString() }}</td>
                                                    <td style="padding-left: 25px">
                                                        <button wire:click="show({{ $role->id }})"
                                                            style="font-size: 1px"
                                                            class="btn btn-success btn-icon-only rounded-circle"
                                                            title="Ver permisos asignados"><i style="font-size: 14px"
                                                                class="fas fa-eye-slash"></i>
                                                        </button>
                                                        {{-- @forelse ($role->permissions as $permission)
                                                            <span
                                                                class="badge bg-gradient-info text-wrap">{{ $permission->name }}</span>
                                                        @empty
                                                            <span class="badge bg-danger">No tiene permisos
                                                                agregados</span>
                                                        @endforelse --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($roles->hasPages())
                                        <div class="px-6 py-3">
                                            {{ $roles->links() }}
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
                                </div>
                            </div>
                            <div class="row">
                                <label
                                    class="col-md-12 col-form-label ms-3 text-uppercase text-center fw-bold text-success">Asignar
                                    permisos a rol</label>
                            </div>
                            <div class="card-body px-0 mt-n4 tab-pane active">
                                <div class="table-responsive p-0 d-flex justify-content-center">
                                    <div class="col-md-5">
                                        <div class="scroll-table-permissions">
                                            <table
                                                class="table table-bordered shadow-lg display nowrap table-striped mt-4 "
                                                style="width:100%">
                                                <thead class="bg-success text-white">
                                                    <th class="col-md-2">ACCIONES</th>
                                                    <th class="text-center">PERMISOS</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($permissions as $permission)
                                                        <tr>
                                                            <td style="padding-left: 25px">
                                                                <div class="form-check">
                                                                    <label class="form-check-label mb-3">
                                                                        <div id="ready-checkbox">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                data-checkboxes="mygroup"
                                                                                wire:model="perm.{{ $permission->id }}"
                                                                                value="{{ $permission->id }}">
                                                                            <span class="form-check-sign">
                                                                                <span class="check"></span>
                                                                            </span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td style="padding-left: 25px">
                                                                {{ $permission->name }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
                                </div>
                            </div>
                            <div class="row">
                                <label
                                    class="col-md-12 col-form-label ms-3 text-uppercase text-center fw-bold text-success">Actualizar
                                    permisos a rol</label>
                            </div>
                            <div class="card-body px-0 mt-n4 tab-pane active">
                                <div class="table-responsive p-0 d-flex justify-content-center">
                                    <div class="col-md-5">
                                        <div class="scroll-table-permissions">
                                            <table id="iniciarDataTables"
                                                class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                                style="width:100%">
                                                <thead class="bg-success text-white">
                                                    <th class="col-md-2">ACCIONES</th>
                                                    <th class="text-center">PERMISOS</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($permissions as $permission)
                                                        <tr>
                                                            <td style="padding-left: 25px">
                                                                <div class="form-check">
                                                                    <label class="form-check-label mb-3">
                                                                        <div id="ready-checkbox">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                data-checkboxes="mygroup"
                                                                                wire:model="perm.{{ $permission->id }}"
                                                                                value="{{ $permission->id }}"
                                                                                {{-- {{ $role->permissions->contains($id) ? 'checked' : '' }} --}} <span
                                                                                class="form-check-sign">
                                                                            <span class="check"></span>
                                                                            </span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td style="padding-left: 25px">
                                                                {{ $permission->name }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-3">
                                <button wire:click.prevent="update()" wire:loading.attr="disabled" wire:tarjet="update"
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
                                <h6 class="text-white text-uppercase ps-3 text-center">Permisos asignados al rol
                                </h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5 mb-4">
                                    <div class="card bg-gradient-light shadow-lg">
                                        <span
                                            class="badge rounded-pill bg-primary w-30 mt-n2 mx-auto text-white">Detalle</span>
                                        <div class="card-header text-center pt-4 pb-3 bg-transparent">
                                            <h1 class="font-weight-bold mt-2 text-white">
                                                <small class="text-lg mb-auto"></small><small
                                                    class="text-lg text-dark">Rol : {{ $name }}</small>
                                            </h1>
                                        </div>
                                        <div class="card-body text-lg-start text-center pt-0">
                                            <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                <i class="material-icons my-auto text-dark">favorite</i>
                                                <span class="ps-3 fw-bold text-dark">Estos son los permisos
                                                    asignados a tu
                                                    rol</span>
                                            </div>
                                            <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                <i class="material-icons my-auto text-dark">remove</i>
                                                <span class="ps-3 text-dark">Permisos asignados:</span>
                                            </div>
                                            <span class="ps-3 text-white">
                                                @forelse ($role->permissions as $permission)
                                                    <span
                                                        class="badge rounded-pill bg-success text-white mt-2">{{ $permission->name }}</span>
                                                @empty
                                                    <span class="badge bg-danger">No tiene permisos
                                                        asignados</span>
                                                @endforelse
                                            </span>
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
        // destroyRole es el nombre del metodo del boton ---- role_id nombre del parametro que pasamos en la confirmacion de mas abajo
        Livewire.on('destroyRole', role_id => {
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
                    // roles es el nombre de la vusta o el nombre que esta en render creo----- destroy el metodo del controlador--- role_id el que pasamos al inicio de este script
                    Livewire.emitTo('roles', 'destroy', role_id)
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Registro eliminado exitosamente!',
                        showConfirmButton: false,
                        timer: 1100
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
@endpush
