<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

use Livewire\WithPagination;

class Permissions extends Component
{
    use WithPagination;
    //definimos unas variables
    public $name, $guard_name, $permission_id;
    public $viewCreateEdit = 0;
    public $search;
    // PARA MOSTRAR LA CANTIDAD DE REGISTREOS POR PAGUINA
    public $cant = 5;
    // dos siguientes lineas para ordenar columnas
    public $sort = 'id';
    public $direction = 'desc';
    // para que funcione el sweealert2
    protected $listeners = ['destroy'];
    // para que use la paguinacion de bootstrap
    protected $paginationTheme = 'bootstrap';
    // para las validaciones de campos unicos y en tiempo real
    protected function rules()
    {
        return [
            'name' => 'required|min:4|max:255|unique:permissions,name,' . $this->permission_id,
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 4 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'name.unique' => 'Este permiso ya se encuentra registrado',
    ];

    public function render()
    {
        abort_if(Gate::denies('permission_admin'), 403);

        $permissions = Permission::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('name', 'like', '%' .$this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        return view('livewire.permissions', compact('permissions'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }

        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
    // esto es para que me funcione el buscador en cualquier pag, no solo en la primera
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createdData()
    {
        $this->cleanFileds();
        $this->openViewCreated();
    }

    public function openViewCreated() {
        $this->viewCreateEdit = 1;
    }

    public function openViewEdit() {
        $this->viewCreateEdit = 2;
    }

    public function closeView() {
        $this->viewCreateEdit = 0;
    }

    public function cleanFileds(){
        $this->name = '';
    }
    // para las validaciones en tiempo real
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        try{
            $permission = Permission::create([
                'name' => $this->name,
            ]);

            // Set Flash Message
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Permiso creado correctamente!!"
            ]);
            // $this->emit('alertaSweelert', 'registro exitoso!');

            $this->closeView();
            $this->cleanFileds();
        }catch(\Exception $e){
            // Set Flash Message
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"A ocurrido un error, vuelva a intentarlo!!"
            ]);
            // $this->emit('alertaSweelert', 'registro exitoso!');

            $this->closeView();
            $this->cleanFileds();
        }
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $this->permission_id = $id;
        $this->name = $permission->name;
        $this->openViewEdit();
    }

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        try{
            $permission = Permission::find($this->permission_id);

            $permission->update([
                'name' => $this->name,
            ]);
            $this->closeView();
            $this->cleanFileds();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Permiso editado correctamente"
            ]);
        }catch(\Exception $e){
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"A ocuurido un error, vuelva a intentarlo!!"
            ]);
            $this->closeView();
            $this->cleanFileds();
        }
        // $this->emit('alertaSweelert', '¡Actualización exitosa!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
    }
}
