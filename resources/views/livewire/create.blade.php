
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <form class="form-horizontal">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Datos a llenar</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-1">
                                    <label class="mb-n2 mt-2" for="name">Nombre</label>
                                    <input type="text" class="form-control" wire:model="name">
                                </div>
                                @error('name') <span class="error text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-1">
                                    <label class="mb-n2 mt-2" for="email">Email</label>
                                    <input type="email" class="form-control" wire:model="email">
                                </div>
                                @error('email') <span class="error text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-1">
                                    <label class="mb-n2 mt-2" for="email">Teléfono</label>
                                    <input type="text" class="form-control" wire:model="mobile">
                                </div>
                                @error('mobile') <span class="error text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <button wire:click.prevent="store()" wire:loading.attr="disabled" wire:tarjet="store" type="button" class="btn btn-sm btn-primary">Guardar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button wire:click="closeModalPopover()" type="button" class="btn btn-sm btn-success">Volver</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>