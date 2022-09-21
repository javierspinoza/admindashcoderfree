<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Livewire\WithPagination;

class Roles extends Component
{
    use WithPagination;
    //definimos unas variables
    public $name, $perm = [], $role_id;
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
            'name' => 'required|min:4|max:255|unique:roles,name,' . $this->role_id,
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 4 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'name.unique' => 'Este rol ya se encuentra registrado',
    ];

    public function render()
    {
        abort_if(Gate::denies('role_admin'), 403);

        $roles = Role::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('name', 'like', '%' .$this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        $permissions = Permission::all()->sortBy('name');
        return view('livewire.roles', compact('roles', 'permissions'));
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

    public function openViewShow() {
        $this->viewCreateEdit = 3;
    }

    public function closeView() {
        $this->viewCreateEdit = 0;
    }

    public function cleanFileds(){
        $this->name = '';
        $this->perm = '';
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

        $role = Role::create($this->getAttributes());
        $role->syncPermissions($this->perm);
        $role->save();

        $this->closeView();
        $this->cleanFileds();
        $this->emit('alertaSweelert', 'registro exitoso!');
    }

    public function getAttributes()
    {
        return [
            'name' => $this->name
        ];
    }

    public function show(Role $role) {
        $this->perm = [];
        $this->role = $role;
        $this->name = $role->name;
        $this->created_at = $role->created_at;
        $this->role_id = $role->id;

        $this->openViewShow();
    }

    public function edit(Role $role)
    {
        $this->perm = [];
        $this->role = $role;
        $this->name = $role->name;
        $this->role_id = $role->id;
        if ($this->role) {
            $this->perm = $this->role->getAllPermissions()
                ->sortBy('name')
                ->pluck('id', 'id')
                ->toArray();
        }

        $this->openViewEdit();
    }

    public function update()
    {
        if ($this->perm) {   // remove unchecked values that comes with false assign it
            $this->perm = Arr::where($this->perm, function ($value) {
                return $value;
            });
        }
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        Role::where('id', $this->role->id)->update($this->getAttributes());
        $this->role->syncPermissions(Permission::find(array_keys($this->perm))->pluck('name'));
        $this->perm = $this->role->getAllPermissions()->sortBy('name')
            ->pluck('id', 'id')
            ->toArray();
        $this->cleanFileds();
        $this->closeView();
        $this->emit('alertaSweelert', '¡Actualización exitosa!');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->to('/roles');
    }
}
