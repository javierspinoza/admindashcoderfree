<div>
    @include('items.navbarNotifications')

    @push('micss')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
            crossorigin="anonymous">
        <link href="{{ asset('assets/libraryJavierSpinoza/fileInputBootstrap/css/fileinput.min.css') }}" media="all"
            rel="stylesheet" type="text/css" />
    @endpush
    @if ($viewCreateEdit == 0)
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-uppercase text-center ps-3">LIBROS REGISTRADAS</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end mb-n4">
                                <button wire:click="createdData()" class="btn btn-sm btn-success me-3 mt-3"
                                    wire:loading.attr="disabled" wire:tarjet="createdData">
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
                                @if ($libros->count())
                                    <table class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                        style="width:100%">
                                        <thead class="bg-success text-white">
                                            <th>OPCIONES</th>
                                            <th role="button" wire:click="order('id')">ID <i class="fas fa-sort"></i>
                                            </th>
                                            <th role="button" wire:click="order('name')">Nombre Libro <i
                                                    class="fas fa-sort"></i>
                                            </th>
                                            <th>Imagen Libro
                                            </th>
                                        </thead>
                                        <tbody>
                                            @foreach ($libros as $libro)
                                                <tr>
                                                    <td class="td-actions text-center">
                                                        <button wire:click="edit({{ $libro->id }})"
                                                            wire:loading.attr="disabled" wire:tarjet="edit"
                                                            class="btn btn-success btn btn-warning btn-icon-only rounded-circle"
                                                            title="Editar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-pencil-alt"></i></span>
                                                        </button>&nbsp;&nbsp;&nbsp;
                                                        <button
                                                            wire:click.prevent="$emit('destroyLibro', {{ $libro->id }})"
                                                            class="btn btn-danger btn-icon-only rounded-circle"
                                                            title="Eliminar">
                                                            <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                    class="fas fa-trash"></i></span>
                                                        </button>
                                                    </td>
                                                    <td style="padding-left: 25px">{{ $libro->id }}</td>
                                                    <td style="padding-left: 25px">{{ $libro->name }}</td>
                                                    <td style="padding-left: 25px">
                                                        <div class="avatar avatar-xl position-relative">
                                                            <img class="w-100 mt-3 border-radius-lg shadow-sm"
                                                                {{-- src="{{ Storage::url($libro->photoBook) }}" alt=""> --}}
                                                                src="{{ asset('storage') }}/{{ $libro->photoBook }}"
                                                                alt="">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($libros->hasPages())
                                        <div class="px-6 py-3">
                                            {{ $libros->links() }}
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
                    <form class="form-horizontal" action="" wire:submit.prevent='create'>
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-center ps-3">REGISTRAR LIBROS</h6>
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
                                        <label class="mb-n2 mt-2" for="imageBook">Imagen</label>
                                        <div class="mb-1 mt-4" wire:ignore>
                                            <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true"
                                                x-on:livewire-upload-finish="isUploading = false; progress = 5"
                                                x-on:livewire-upload-error="isUploading = false"
                                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                <input type="file" class="form-control" wire:model="imageBook"
                                                    id="imagen">
                                                <div x-show.transition="isUploading"
                                                    class="progress progress-sm mt-2 rounded">
                                                    <div class="progress-bar bg-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                                        aria-valuemax="100" x-bind:style="`width: ${progress}%`">
                                                        <span class="sr-only">35% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('imageBook')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $("#imagen").fileinput({
                                        language: 'es',
                                        allowedFileExtensions: ['jpg', 'png', 'svg', 'bmp'],
                                        maxFileSize: 5080,
                                        browseOnZoneClick: true,
                                        dropZoneTitle: 'Da click en examinar',
                                        browseClass: 'btn btn-light',
                                        showUpload: false,
                                        showClose: false,
                                        showRemove: false, //ocultar el boton de quitar la imagen
                                        // initialPreviewAsData: true,
                                        dropZoneEnabled: true,
                                        removeFromPreviewOnError: true, //Para que no muestre la vista previa del archivo si no es el permitido
                                        theme: "fas",
                                        required: true,
                                        maxFilePreviewSize: 3000, //tamaño maximo para visualizacion aqui lo puedo modificar
                                    });
                                });
                            </script>
                            <div class="d-flex justify-content-center mb-3">
                                <button type="submit" wire:loading.attr="disabled" wire:tarjet="imageBook"
                                    wire:tarjet="create"
                                    class="btn btn-sm btn-primary">Guardar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button wire:click="closeView()" type="button" wire:loading.attr="disabled"
                                    wire:tarjet="closeView" class="btn btn-sm btn-success">Volver</button>
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
                    <form class="form-horizontal" wire:submit.prevent='update({{ $libro_id }})'>
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-center ps-3">ACTUALIZAR LIBRO</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <input type="hidden" wire:model='old_imageBook' name="" id="">
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
                                        <label class="mb-n2 mt-2 " for="new_imageBook">Imagen</label>
                                        <div class="mb-1 mt-4" wire:ignore>
                                            <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true"
                                                x-on:livewire-upload-finish="isUploading = false; progress = 5"
                                                x-on:livewire-upload-error="isUploading = false"
                                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                <input type="file" class="form-control" wire:model="new_imageBook"
                                                    id="imagen">
                                                <div x-show.transition="isUploading"
                                                    class="progress mt-2 rounded">
                                                    <div class="progress-bar bg-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                                        aria-valuemax="100" x-bind:style="`width: ${progress}%`">
                                                        <span class="sr-only">35% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('new_imageBook')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $("#imagen").fileinput({
                                        language: 'es',
                                        allowedFileExtensions: ['jpg', 'png', 'svg', 'bmp'],
                                        maxFileSize: 5080,
                                        browseOnZoneClick: true,
                                        dropZoneTitle: 'Da click en examinar',
                                        browseClass: 'btn btn-light',
                                        showUpload: false,
                                        showClose: false,
                                        showRemove: false, //ocultar el boton de quitar la imagen
                                        // initialPreviewAsData: true,
                                        initialPreview: [
                                            '<img src="{{ asset('storage') }}/{{ $old_imageBook }}" id="imagenSeleccionada" class="w-75 mt-3 border-radius-lg shadow-sm"  alt="Imagen previamente cargada">'
                                        ],
                                        dropZoneEnabled: true,
                                        removeFromPreviewOnError: true, //Para que no muestre la vista previa del archivo si no es el permitido
                                        theme: "fas",
                                        maxFilePreviewSize: 3000, //tamaño maximo para visualizacion aqui lo puedo modificar
                                    });
                                });
                            </script>
                            <div class="d-flex justify-content-center mb-3">
                                <button type="submit" wire:loading.attr="disabled" wire:tarjet="new_imageBook"
                                    wire:tarjet="update"
                                    class="btn btn-sm btn-primary">Actualizar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button wire:click="closeView()" type="button" wire:loading.attr="disabled"
                                    wire:tarjet="closeView" class="btn btn-sm btn-success">Volver</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

@push('mijs')
    {{-- Script para visializar la barra de carga --}}
    <script defer src="{{ asset('assets/libraryJavierSpinoza/alpinejs/js/alpinejs.min.js') }}"></script>
    {{-- Fin barra de carga --}}
    <script src="{{ asset('assets/libraryJavierSpinoza/sweetalert2/js/sweetalert2.js') }}"></script>
    <script>
        // destroyLibro es el nombre del metodo del boton ---- libro_id nombre del parametro que pasamos en la confirmacion de mas abajo
        Livewire.on('destroyLibro', libro_id => {
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
                    // libros es el nombre de la vusta o el nombre que esta en render creo----- destroy el metodo del controlador--- libro_id el que pasamos al inicio de este script
                    Livewire.emitTo('libros', 'destroy', libro_id)
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
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        window.addEventListener('alert', ({
            detail: {
                type,
                message
            }
        }) => {
            Toast.fire({
                icon: type,
                title: message
            })
        })
    </script>
    {{-- script para el bootstrap file input --}}
    <script src="{{ asset('assets/libraryJavierSpinoza/select2/js/jquery-3.6.0.min.js') }}" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/libraryJavierSpinoza/fileInputBootstrap/js/piexif.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/libraryJavierSpinoza/fileInputBootstrap/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/libraryJavierSpinoza/fileInputBootstrap/js/idioma.js') }}"></script>
@endpush
