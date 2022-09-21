<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Libro;

use Livewire\WithPagination;
use Livewire\WithFileUploads;
// para eliminar la imagen que ya estaba antes al momento de actualizar
use Illuminate\Support\Facades\File;

class Libros extends Component
{
    use WithPagination;
    // para las imagenes
    use WithFileUploads;
    //definimos unas variables
    public $name, $imageBook, $old_imageBook, $new_imageBook, $book_id;
    public $viewCreateEdit = 0;
    public $search;
    public $libro;
    // PARA MOSTRAR LA CANTIDAD DE REGISTREOS POR PAGUINA
    public $cant = 5;
    // dos siguientes lineas para ordenar columnas
    public $sort = 'id';
    public $direction = 'desc';
    // para que funcione el sweealert2
    protected $listeners = ['destroy'];
    // para que use la paguinacion de bootstrap
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // abort_if(Gate::denies('materia_admin'), 403);

        $libros = Libro::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('name', 'like', '%' .$this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        return view('livewire.libros', compact('libros'));
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
        $this->cleanFileds();
    }

    public function cleanFileds(){
        $this->name = '';
        $this->imageBook = '';
        $this->old_imageBook = '';
        $this->new_imageBook = '';
    }

    public function create()
    {
        $libro = new Libro();
        $this->validate([
            'name' => 'required|min:3|max:255',
            'imageBook' => 'required|image|max:5080'
        ],
        [
            'name.required' => 'El nombre es requerido.',
            'name.min' => 'Su nombre es demsiado corto',
            'name.max' => 'Su nombre es muy extenso',
            'imageBook.required' => 'Por favor selecciona una imagen',
            'imageBook.image' => 'Solo es permitido cargar imagenes',
            'imageBook.max' => 'Su imagen no puede pesar mas de 5MB',
        ]);

        $filename = "";
        if ($this->imageBook) {
            $filename = $this->imageBook->store('imageBooks', 'public');
        } else {
            $filename = Null;
        }

        $libro->name = $this->name;
        $libro->photoBook = $filename;
        $result = $libro->save();
        if ($result) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Libro creado correctamente!!"
            ]);
            $this->closeView();
        } else {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Intente nuevamente"
            ]);
        }
    }

    public function edit($id)
    {
        $this->openViewEdit();
        $libro = Libro::findOrFail($id);
        $this->libro_id = $libro->id;
        $this->name = $libro->name;
        $this->old_imageBook = $libro->photoBook;
    }

    public function update($id)
    {
        $libro =Libro::findOrFail($id);
        $this->validate([
            'name' => 'required|min:3|max:255',
            'new_imageBook' => 'max:5080',
        ],
        [
            'name.required' => 'El nombre es requerido.',
            'name.min' => 'Su nombre es demsiado corto',
            'name.max' => 'Su nombre es muy extenso',
            'new_imageBook.max' => 'Su imagen no puede pesar mas de 5MB',
        ]);

        $filename = "";
        $destination=public_path('storage\\'.$libro->photoBook);
        if ($this->new_imageBook != null) {
            if(File::exists($destination)){
                File::delete($destination);
            }
            $filename = $this->new_imageBook->store('imageBooks', 'public');
        } else {
            $filename = $this->old_imageBook;
        }

        $libro->name = $this->name;
        $libro->photoBook = $filename;
        $result = $libro->save();
        if ($result) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Libro actualizado correctamente!!"
            ]);
            $this->closeView();
        } else {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Intente nuevamente!!"
            ]);
        }
    }

    public function destroy($id)
    {
        $libro=Libro::findOrFail($id);
        $destination=public_path('storage\\'.$libro->photoBook);
        if(File::exists($destination)){
            File::delete($destination);
        }

        $result=$libro->delete();
        if ($result) {
            $this->emit('alertaSweelert', '¡Registro eliminado!');
        } else {
            $this->emit('alertaSweelert', '¡A ocurrido un error!');
        }
    }
}
