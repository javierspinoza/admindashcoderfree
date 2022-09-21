<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Materia;
use App\Models\User;

use Livewire\WithPagination;

use App\Notifications\MateriaNotification;

class Materias extends Component
{
    use WithPagination;
    //definimos unas variables
    public $nombre, $materia_id;
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
            'nombre' => 'required|min:4|max:255|unique:materias,nombre,' . $this->materia_id,
        ];
    }
    protected $messages = [
        'nombre.required' => 'El nombre es requerido.',
        'nombre.min' => 'Pon almenos 4 caracteres',
        'nombre.max' => 'máximo 255 caracteres',
        'nombre.unique' => 'Este nombre ya se encuentra registrado.',
    ];

    public function render()
    {
        abort_if(Gate::denies('materia_admin'), 403);

        $materias = Materia::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('nombre', 'like', '%' .$this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        return view('livewire.materias', compact('materias'));
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

        // Materia::create([
        //     'nombre' => ucfirst($this->nombre),
        // ]);

        $materia = Materia::create([
            'nombre' => ucfirst($this->nombre),
        ]);

        // enviar notificacion
        // auth()->user()->notify(new MateriaNotification($materia));
        $user = User::role('Admin')
        ->each(function(User $user) use ($materia){
            $user->notify(new MateriaNotification($materia));
        });
        // fin enviar notificacion
        // session()->flash('message', $this->materia_id ? '¡Actualización exitosa!' : '¡Alta Exitosa!');

        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', 'registro exitoso!');
    }

    public function edit($id)
    {
        $materia = Materia::findOrFail($id);
        $this->materia_id = $id;
        $this->nombre = $materia->nombre;
        // $this->cantidad = $producto->cantidad;
        $this->abrirVistaEdit();
    }

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        $materia = Materia::find($this->materia_id);
        $materia->update([
            'nombre' => ucfirst($this->nombre),
        ]);
        $this->cerrarVista();
        $this->limpiarCampos();
        $this->emit('alertaSweelert', '¡Actualización exitosa!');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();
    }
}
