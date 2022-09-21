<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Direccion;
use App\Models\Departamento;
use App\Models\Ciudad;
use App\Models\Barrio;

use Livewire\WithPagination;

class Direcciones extends Component
{
    use WithPagination;
    //definimos unas variables ---------- estas variasbles son para registrar,  el name y direccion_id si sirven para registar y actualizar
    public $name;
    public $direccion_id;
    public $departamentos;
    public $ciudades;
    public $barrios;
    public $selectedDepartamento = NULL;
    public $selectedCiudad = NULL;
    public $selectedBarrio = NULL;

    // VARIABLES PARA ACTUALIZAR
    public $departamentosActualizar;
    public $departamentoA;
    public $ciudadesActualizar;
    public $ciudadA;
    public $barriosActualizar;
    public $barrioA;

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
            'selectedDepartamento' => 'required',
            'selectedCiudad' => 'required',
            'selectedBarrio' => 'required',
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 2 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'selectedDepartamento.required' => 'Por favor seleccione un departamento.',
        'selectedCiudad.required' => 'Por favor seleccione una ciudad.',
        'selectedBarrio.required' => 'Por favor seleccione un barrio.',
    ];

    public function mount() 
    {
        // para registar los select anidados
        $this->departamentos = Departamento::get();
        $this->ciudades = collect();
        $this->barrios = collect();
    }

    // estos dos metodos para registar los select anidados
    public function updatedSelectedDepartamento($dpto)
    {
        $this->ciudades = Ciudad::where('departamento_id', $dpto)->get();
        $this->selectedCiudad = NULL;
        // $this->selectedCiudad = $this->ciudades->first()->id ?? null;
    }

    public function updatedSelectedCiudad($barrioDr)
    {
        $this->barrios = Barrio::where('ciudad_id', $barrioDr)->get();
        $this->selectedBarrio = NULL;
        // $this->selectedBarrio = $this->barrios->first()->id ?? null;
    }

    // para actualizar los select anidados
    private function refreshData()
    {
        $this->departamentosActualizar = Departamento::orderBy('name')->get();
        if (!empty($this->departamentoA)) {
            $this->ciudadesActualizar = Ciudad::where('departamento_id', $this->departamentoA)->get();
        } else {
            $this->ciudadA = NULL;
        }
        if (!empty($this->ciudadA)) {
            $this->barriosActualizar = Barrio::where('ciudad_id', $this->ciudadA)->get();
        } else {
            $this->barrioA = NULL;
        }
    }

    public function render()
    {
        // LLAMAR METODO PARA ACTUALIZAR
        $this->refreshData();
        $direcciones = Direccion::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('name', 'like', '%' .$this->search.'%')
        // para buscar por la materia tambien
        ->orWhereHas('departamentos', function($query) {
            return $query->where('name', 'LIKE', "%{$this->search}%");
            })
        ->orWhereHas('ciudades', function($query) {
            return $query->where('name', 'LIKE', "%{$this->search}%");
            })
        ->orWhereHas('barrios', function($query) {
            return $query->where('name', 'LIKE', "%{$this->search}%");
            })
        // fin para buscar por las foraneas
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        return view('livewire.direcciones', compact('direcciones'));
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
        $this->selectedDepartamento = '';
        $this->selectedCiudad = '';
        $this->selectedBarrio = '';
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

        $direccion = Direccion::create([
            'name' => ucfirst($this->name),
            'departamento_id' => $this->selectedDepartamento,
            'ciudad_id' => $this->selectedCiudad,
            'barrio_id' => $this->selectedBarrio,
        ]);

        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', 'registro exitoso!');
    }

    public function edit($id)
    {
        $direccion = Direccion::findOrFail($id);
        $this->direccion_id = $id;
        $this->name = $direccion->name;
        $this->departamentoA = $direccion->departamento_id;
        $this->ciudadA = $direccion->ciudad_id;
        $this->barrioA = $direccion->barrio_id;
        $this->abrirVistaEdit();
    }

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate([
            'departamentoA' => 'required',
            'ciudadA' => 'required',
            'barrioA' => 'required',
        ],
        [
            'departamentoA.required' => 'Por favor seleccione un departamento1.',
            'ciudadA.required' => 'Por favor seleccione una ciudad.',
            'barrioA.required' => 'Por favor seleccione un barrio.',
        ]);

        $direccion = Direccion::find($this->direccion_id);
        $direccion->update([
            'name' => ucfirst($this->name),
            'departamento_id' => $this->departamentoA,
            'ciudad_id' => $this->ciudadA,
            'barrio_id' => $this->barrioA,
        ]);
        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', '¡Actualización exitosa!');
    }

    public function destroy(Direccion $direccion)
    {
        $direccion->delete();
    }
}
