{{-- @extends('layouts.main') --}}

{{-- @section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libraryJavierSpinoza/dataTable/css/datatables.min.css') }}"/>
@endsection --}}
<div>
    @include('items.navbarNotifications')

    <div class="container-fluid py-4">
        @if (session()->has('message'))
            <div class="alert alert-danger text-light" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card my-4">

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Usuarios Registrados</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end mb-n4">
                            <button wire:click="create()" class="btn btn-sm btn-success me-3 mt-3">
                                Create Student
                            </button>
                            @if ($isModalOpen)
                                @include('livewire.create')
                            @endif
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <div class="row d-flex justify-content-end me-2">
                                <div class="col-md-3 ms-4">
                                    <div class="input-group input-group-static my-3 mb-n1">
                                        <label class="mb-n3">Buscar</label>
                                        <input type="search" class="form-control" wire:model="search">
                                    </div>
                                </div>
                            </div>
                            @if ($students->count())
                                <table id="iniciarDataTables"
                                    class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                    style="width:100%">
                                    <thead class="bg-success text-white">
                                        <th>OPCIONES</th>
                                        <th role="button" wire:click="order('id')">ID <i class="fas fa-sort"></i>
                                        </th>
                                        <th role="button" wire:click="order('name')">name <i class="fas fa-sort"></i>
                                        </th>
                                        <th role="button" wire:click="order('email')">EMAIL <i
                                                class="fas fa-sort"></i>
                                        </th>
                                        <th role="button" wire:click="order('mobile')">TELÉFONO <i
                                                class="fas fa-sort"></i></th>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td role="button" class="td-actions text-center">
                                                    <button wire:click="edit({{ $student->id }})"
                                                        class="btn btn-warning btn-icon-only rounded-circle"
                                                        title="Editar registro">
                                                        <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                class="fas fa-pencil-alt"></i></span>
                                                    </button>&nbsp;&nbsp;&nbsp;
                                                    <button
                                                        wire:click.prevent="$emit('destroyCrud', {{ $student->id }})"
                                                        class="btn btn-danger btn-icon-only rounded-circle"
                                                        title="Eliminar registro">
                                                        <span class="btn-inner--icon"><i style="font-size: 16px"
                                                                class="fas fa-trash"></i></span>
                                                    </button>
                                                </td>
                                                <td style="padding-left: 25px">{{ $student->id }}</td>
                                                <td style="padding-left: 25px">{{ $student->name }}</td>
                                                <td style="padding-left: 25px">{{ $student->email }}</td>
                                                <td style="padding-left: 25px">{{ $student->mobile }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($students->hasPages())
                                    <div class="px-6 py-3">
                                        {{ $students->links() }}
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
</div>


@push('mijs')
    <script src="{{ asset('assets/libraryJavierSpinoza/sweetalert2/js/sweetalert2.js') }}"></script>
    <script>
        // destroyCrud es el nombre del metodo del boton ---- student_id nombre del parametro que pasamos en la confirmacion de mas abajo
        Livewire.on('destroyCrud', student_id => {
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
                    // crud es el nombre de la vusta----- destroy el metodo--- student_id el que pasamos al inicio de este script
                    Livewire.emitTo('crud', 'destroy', student_id)
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
@endpush
