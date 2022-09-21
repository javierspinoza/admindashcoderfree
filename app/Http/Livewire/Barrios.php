<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Barrio;
use App\Models\Ciudad;

use Livewire\WithPagination;

class Barrios extends Component
{
    use WithPagination;
    //definimos unas variables
    public $name, $ciudad_id, $barrio_id;
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
            'ciudad_id' => 'required',
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 2 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'ciudad_id.required' => 'Por favor seleccione una ciudad.',
    ];

    public function render()
    {
        $barrios = Barrio::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('name', 'like', '%' .$this->search.'%')
        // para buscar por la materia tambien
        ->orWhereHas('ciudades', function($query) {
            return $query->where('name', 'LIKE', "%{$this->search}%");
            })
        // fin para buscar por ciudad
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        $ciudades = Ciudad::get();
        return view('livewire.barrios', compact('barrios', 'ciudades'));
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
        $this->ciudad_id = '';
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

        $barrio = Barrio::create([
            'name' => ucfirst($this->name),
            'ciudad_id' => $this->ciudad_id,
        ]);

        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', 'registro exitoso!');
    }

    public function edit($id)
    {
        $barrio = Barrio::findOrFail($id);
        $this->barrio_id = $id;
        $this->name = $barrio->name;
        $this->ciudad_id = $barrio->ciudad_id;
        $this->abrirVistaEdit();
    }

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        $barrio = Barrio::find($this->barrio_id);
        $barrio->update([
            'name' => ucfirst($this->name),
            'ciudad_id' => $this->ciudad_id,
        ]);
        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', '¡Actualización exitosa!');
    }

    public function destroy(Barrio $barrio)
    {
        $barrio->delete();
    }
}
