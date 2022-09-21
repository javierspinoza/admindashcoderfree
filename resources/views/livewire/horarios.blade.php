@push('micss')
    <link href="{{ asset('assets/libraryJavierSpinoza/select2/css/select2.min.css') }}" rel="stylesheet" />
@endpush
<div>
    @include('items.navbarNotifications')
    @if ($viewCreateEdit == 0)
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize text-center ps-3">HORARIOS REGISTRADOS</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end mb-n4">
                                <button wire:click="crear()" class="btn btn-sm btn-success me-3 mt-3">
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
                                @if ($horarios->count())
                                    <table class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                        style="width:100%">
                                        <thead class="bg-success text-white">
                                            <th>OPCIONES</th>
                                            <th role="button" wire:click="order('id')">ID <i class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('nombre')">Nombre <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('id_materia')">Materia <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                        </thead>
                                        <tbody>
                                            @foreach ($horarios as $horario)
                                                <tr>
                                                    <td class="td-actions text-center">
                                                        <button wire:click="edit({{ $horario->id }})"
                                                            class="btn btn-success btn btn-warning btn-icon-only rounded-circle"
                                                            title="Editar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-pencil-alt"></i></span>
                                                        </button>&nbsp;&nbsp;&nbsp;
                                                        <button
                                                            wire:click.prevent="$emit('destroyHorario', {{ $horario->id }})"
                                                            class="btn btn-danger btn-icon-only rounded-circle"
                                                            title="Eliminar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-trash"></i></span>
                                                        </button>
                                                    </td>
                                                    <td style="padding-left: 25px">{{ $horario->id }}</td>
                                                    <td style="padding-left: 25px">{{ $horario->nombre }}</td>
                                                    <td style="padding-left: 25px">{{ $horario->materias->nombre }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($horarios->hasPages())
                                        <div class="px-6 py-3">
                                            {{ $horarios->links() }}
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
                                            <input type="text" class="form-control" wire:model.defer="nombre">
                                        </div>
                                        @error('nombre')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mt-1" wire:ignore>
                                            <label for="exampleFormControlSelect1"
                                                class="ms-0 mb-3">Materia</label>
                                            <select class="form-control js-example-basic-single"
                                                wire:model="id_materia">
                                                <option value="" selected>Selecciona una opción</option>
                                                @foreach ($materias as $materia)
                                                    <option value="{{ $materia->id }}">{{ $materia->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('id_materia')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-3">
                                <button wire:click.prevent="store()" wire:loading.attr="disabled" wire:tarjet="store"
                                    type="button"
                                    class="btn btn-sm btn-primary">Guardar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button wire:click="cerrarVista()" type="button"
                                    class="btn btn-sm btn-success">Volver</button>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $('.js-example-basic-single').select2()
                                    $('.js-example-basic-single').on('change', function() {
                                        @this.set('id_materia', $(this).val())
                                    })
                                });
                            </script>
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
                                            <input type="text" class="form-control" wire:model.defer="nombre">
                                        </div>
                                        @error('nombre')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="exampleFormControlSelect1"
                                                class="ms-0">Materia</label>
                                            <select class="form-control" wire:model="id_materia">
                                                @foreach ($materias as $materia)
                                                    <option value="{{ $materia->id }}">{{ $materia->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_materia')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-3">
                                <button wire:click.prevent="update()" wire:loading.attr="disabled" wire:tarjet="update"
                                    type="button"
                                    class="btn btn-sm btn-primary">Actualizar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button wire:click="cerrarVista()" type="button"
                                    class="btn btn-sm btn-success">Volver</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>


@push('mijs')
    <script src="{{ asset('assets/libraryJavierSpinoza/sweetalert2/js/sweetalert2.js') }}"></script>
    <script>
        // destroyHorario es el nombre del metodo del boton ---- horario_id nombre del parametro que pasamos en la confirmacion de mas abajo
        Livewire.on('destroyHorario', horario_id => {
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
                    // horarios es el nombre de la vista----- destroy el metodo del controlador--- horario_id el que pasamos al inicio de este script
                    Livewire.emitTo('horarios', 'destroy', horario_id)
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
    {{-- Llamar la libreria selec2 --}}
    <script src="{{ asset('assets/libraryJavierSpinoza/select2/js/jquery-3.6.0.min.js') }}" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/libraryJavierSpinoza/select2/js/select2.min.js') }}"></script>
@endpush
