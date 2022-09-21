<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Horario;
use App\Models\Materia;

use Livewire\WithPagination;

class Horarios extends Component
{
    use WithPagination;
    //definimos unas variables
    public $nombre, $id_materia, $horario_id;
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
            'nombre' => 'required|min:2|max:255',
            'id_materia' => 'required',
        ];
    }
    protected $messages = [
        'nombre.required' => 'El nombre es requerido.',
        'nombre.min' => 'Pon almenos 2 caracteres',
        'nombre.max' => 'máximo 255 caracteres',
        'id_materia.required' => 'Por favor seleccione una materia.',
    ];

    // public function mount()
    // {
    //     $this->materias = Materia::get();
    // }

    public function render()
    {
        $horarios = Horario::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('nombre', 'like', '%' .$this->search.'%')
        // para buscar por la materia tambien
        ->orWhereHas('materias', function($query) {
            return $query->where('nombre', 'LIKE', "%{$this->search}%");
            })
        // fin para buscar por la materia
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        $materias = Materia::get();
        return view('livewire.horarios', compact('horarios', 'materias'));
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
        $this->nombre = '';
        $this->id_materia = '';
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

        Horario::create([
            'nombre' => ucfirst($this->nombre),
            'id_materia' => $this->id_materia,
        ]);

        // session()->flash('message', $this->horario_id ? '¡Actualización exitosa!' : '¡Alta Exitosa!');

        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', 'registro exitoso!');
    }

    public function edit($id)
    {
        $horario = Horario::findOrFail($id);
        $this->horario_id = $id;
        $this->nombre = $horario->nombre;
        $this->id_materia = $horario->id_materia;
        $this->abrirVistaEdit();
    }

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        $horario = Horario::find($this->horario_id);
        $horario->update([
            'nombre' => ucfirst($this->nombre),
            'id_materia' => $this->id_materia,
        ]);
        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', '¡Actualización exitosa!');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
    }
}
