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
                                <h6 class="text-white text-capitalize text-center ps-3">DIRECCIONES REGISTRADAS</h6>
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
                                @if ($direcciones->count())
                                    <table class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                        style="width:100%">
                                        <thead class="bg-success text-white">
                                            <th>OPCIONES</th>
                                            <th role="button" wire:click="order('id')">ID <i class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('departamento_id')">Departamento <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('ciudad_id')">Ciudad <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('barrio_id')">Barrio <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('name')">Dirección <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                        </thead>
                                        <tbody>
                                            @foreach ($direcciones as $direccion)
                                                <tr>
                                                    <td class="td-actions text-center">
                                                        <button wire:click="edit({{ $direccion->id }})"
                                                            class="btn btn-success btn btn-warning btn-icon-only rounded-circle"
                                                            title="Editar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-pencil-alt"></i></span>
                                                        </button>&nbsp;&nbsp;&nbsp;
                                                        <button
                                                            wire:click.prevent="$emit('destroyDireccion', {{ $direccion->id }})"
                                                            class="btn btn-danger btn-icon-only rounded-circle"
                                                            title="Eliminar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-trash"></i></span>
                                                        </button>
                                                    </td>
                                                    <td style="padding-left: 25px">{{ $direccion->id }}</td>
                                                    <td style="padding-left: 25px">{{ $direccion->departamentos->name }}
                                                    <td style="padding-left: 25px">{{ $direccion->ciudades->name }}
                                                    <td style="padding-left: 25px">{{ $direccion->barrios->name }}
                                                    <td style="padding-left: 25px">{{ $direccion->name }}</td>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($direcciones->hasPages())
                                        <div class="px-6 py-3">
                                            {{ $direcciones->links() }}
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
                                            <input type="text" class="form-control" wire:model.defer="name">
                                        </div>
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mt-1">
                                            <label for="exampleFormControlSelect1"
                                                class="ms-0 mb-3">Departamento</label>
                                            <select class="form-control js-example-basic-dptoAgregar1"
                                                wire:model="selectedDepartamento">
                                                <option value="" selected>Selecciona una opción</option>
                                                @foreach ($departamentos as $departamento)
                                                    <option value="{{ $departamento->id }}">{{ $departamento->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('selectedDepartamento')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mt-1">
                                            <label for="exampleFormControlSelect1" class="ms-0 mb-3">Ciudad</label>
                                            <select class="form-control js-example-basic-single-ciudad1"
                                                wire:model="selectedCiudad">
                                                @if ($selectedDepartamento == '')
                                                    <option value="" selected>Selecciona una opción</option>
                                                @endif
                                                @if ($selectedDepartamento != '')
                                                    <option value="" selected>Selecciona una opción</option>
                                                    @foreach ($ciudades as $ciudad)
                                                        <option value="{{ $ciudad->id }}">{{ $ciudad->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('selectedCiudad')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mt-1" {{-- wire:ignore --}}>
                                            <label for="exampleFormControlSelect1" class="ms-0 mb-3">Barrios</label>
                                            <select class="form-control js-example-basic-single-barrio1"
                                                wire:model="selectedBarrio">
                                                @if ($selectedCiudad == '')
                                                    <option value="">Selecciona una opción</option>
                                                @endif
                                                @if ($selectedCiudad != '')
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($barrios as $barrio)
                                                        <option value="{{ $barrio->id }}">{{ $barrio->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('selectedBarrio')
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
                                    $('.js-example-basic-dptoAgregar').select2()
                                    $('.js-example-basic-dptoAgregar').on('change', function() {
                                        @this.set('selectedDepartamento', $(this).val())
                                    })
                                });
                            </script>
                            <script>
                                $(document).ready(function() {
                                    $('.js-example-basic-single-ciudad').select2()
                                    $('.js-example-basic-single-ciudad').on('change', function() {
                                        @this.set('selectedCiudad', $(this).val())
                                    })
                                });
                            </script>
                            <script>
                                $(document).ready(function() {
                                    $('.js-example-basic-single-barrio').select2()
                                    $('.js-example-basic-single-barrio').on('change', function() {
                                        @this.set('barrio_id', $(this).val())
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
                                            <input type="text" class="form-control" wire:model.defer="name">
                                        </div>
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4 mt-2">
                                            <label for="exampleFormControlSelect1" class="ms-0">Departamento</label>
                                            <select class="form-control js-example-basic-single-dpto1"
                                                wire:model="departamentoA">
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($departamentosActualizar as $departamento)
                                                    <option value="{{ $departamento->id }}">{{ $departamento->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('departamentoA')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4 mt-2">
                                            <label for="exampleFormControlSelect1" class="ms-0">Ciudad</label>
                                            <select class="form-control js-example-basic-single-ciudad1"
                                                wire:model="ciudadA">
                                                @if ($departamentoA == "")
                                                    <option value="" selected>Selecciona una opción</option>
                                                @endif
                                                @if ($departamentoA != "")
                                                    <option value="" selected>Selecciona una opción</option>
                                                    @foreach ($this->ciudadesActualizar as $ciudad)
                                                        <option value="{{ $ciudad->id }}">{{ $ciudad->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('ciudadA')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4 mt-2">
                                            <label for="exampleFormControlSelect1" class="ms-0">Barrio</label>
                                            <select class="form-control js-example-basic-single-barrio1"
                                                wire:model="barrioA">
                                                @if ($ciudadA == "")
                                                    <option value="">Selecciona una opción</option>
                                                @endif
                                                @if ($ciudadA > 0)
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($this->barriosActualizar as $barrio)
                                                        <option value="{{ $barrio->id }}">{{ $barrio->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('barrioA')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-3">
                                <button wire:click.prevent="update()" wire:loading.attr="disabled"
                                    wire:tarjet="update" type="button"
                                    class="btn btn-sm btn-primary">Actualizar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button wire:click="cerrarVista()" type="button"
                                    class="btn btn-sm btn-success">Volver</button>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $('.js-example-basic-single-dpto').select2()
                                    $('.js-example-basic-single-dpto').on('change', function() {
                                        @this.set('departamento_id', $(this).val())
                                    })
                                });
                            </script>
                            <script>
                                $(document).ready(function() {
                                    $('.js-example-basic-single-ciudad').select2()
                                    $('.js-example-basic-single-ciudad').on('change', function() {
                                        @this.set('ciudad_id', $(this).val())
                                    })
                                });
                            </script>
                            <script>
                                $(document).ready(function() {
                                    $('.js-example-basic-single-barrio').select2()
                                    $('.js-example-basic-single-barrio').on('change', function() {
                                        @this.set('barrio_id', $(this).val())
                                    })
                                });
                            </script>
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
        // destroyDireccion es el nombre del metodo del boton ---- direccion_id nombre del parametro que pasamos en la confirmacion de mas abajo
        Livewire.on('destroyDireccion', direccion_id => {
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
                    // direcciones es el nombre de la vista----- destroy el metodo del controlador--- direccion_id el que pasamos al inicio de este script
                    Livewire.emitTo('direcciones', 'destroy', direccion_id)
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
