<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ciudad;
use App\Models\Departamento;

use Livewire\WithPagination;

class Ciudades extends Component
{
    use WithPagination;
    //definimos unas variables
    public $name, $departamento_id, $ciudad_id;
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
            'name' => 'required|min:2|max:255',
            'departamento_id' => 'required',
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 2 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'departamento_id.required' => 'Por favor seleccione un departamento.',
    ];

    public function render()
    {
        $ciudades = Ciudad::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('name', 'like', '%' .$this->search.'%')
        // para buscar por la materia tambien
        ->orWhereHas('departamentos', function($query) {
            return $query->where('name', 'LIKE', "%{$this->search}%");
            })
        // fin para buscar por departamento
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        $departamentos = Departamento::get();
        return view('livewire.ciudades', compact('ciudades', 'departamentos'));
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

    public function crear()
    {
        $this->limpiarCampos();
        $this->abrirVistaCreated();
    }

    public function abrirVistaCreated() {
        $this->viewCreateEdit = 1;
    }

    public function abrirVistaEdit() {
        $this->viewCreateEdit = 2;
    }

    public function cerrarVista() {
        $this->viewCreateEdit = 0;
    }

    public function limpiarCampos(){
        $this->name = '';
        $this->departamento_id = '';
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

        $ciudad = Ciudad::create([
            'name' => ucfirst($this->name),
            'departamento_id' => $this->departamento_id,
        ]);

        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', 'registro exitoso!');
    }

    public function edit($id)
    {
        $ciudad = Ciudad::findOrFail($id);
        $this->ciudad_id = $id;
        $this->name = $ciudad->name;
        $this->departamento_id = $ciudad->departamento_id;
        $this->abrirVistaEdit();
    }

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        $ciudad = Ciudad::find($this->ciudad_id);
        $ciudad->update([
            'name' => ucfirst($this->name),
            'departamento_id' => $this->departamento_id,
        ]);
        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', '¡Actualización exitosa!');
    }

    public function destroy(Ciudad $ciudad)
    {
        $ciudad->delete();
    }
}
