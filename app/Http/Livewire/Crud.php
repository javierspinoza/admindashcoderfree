<?php
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Student;
use Livewire\WithPagination;
use App\Http\Requests\RequestStudent;
// esta linea para enviar email
use Illuminate\Support\Facades\Mail;

class Crud extends Component
{
    use WithPagination;
    // public $students, $name, $email, $mobile, $student_id;
    public $name, $email, $mobile, $student_id;
    public $isModalOpen = 0;
    public $search;
    // dos siguientes lineas para ordenar columnas
    public $sort = 'id';
    public $direction = 'desc';
    // para que funcione el sweealert2
    protected $listeners = ['destroy'];
    // para que use la paguinacion de bootstrap
    protected $paginationTheme = 'bootstrap';
    // para las validaciones de campos unicos
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'mobile' => 'required|min:2|max:5|unique:students,mobile,' . $this->student_id,
            'email' => 'required|string|email|max:255|unique:students,email,' . $this->student_id
        ];
    }
    protected $messages = [
        'name.required' => 'Su nombre es requerido.',
        'email.email' => 'Este campo debe ser de tipo email.',
        'email.unique' => 'Este email ya se encuentra registrado.',
    ];

    // public function render()
    // {
    //     $this->students = Student::orderBy('id', 'desc')->get();
    //     return view('livewire.crud');
    // }

    public function render()
    {
        $students = Student::where('name', 'like', '%' .$this->search.'%')
        ->orWhere('email', 'like', '%' .$this->search.'%')
        ->orWhere('mobile', 'like', '%' .$this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate(5);
        return view('livewire.crud', compact('students'));
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

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->name = '';
        $this->email = '';
        $this->mobile = '';
    }
    
    // metodo para las validaciones en tiempo real
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        // VALIDACIONES QUE NO SON EN TIEMPO REAL
        $validatedData = $this->validate();
        
        Student::updateOrCreate(['id' => $this->student_id], [
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
        ]);

        // con esto envio el email
        // Mail::send('email.notifyStudents',
        // array(
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     ),
        //     function($message){
        //         $message->from('notificacionesclassifycolombia@app.classifycolombia.com');
        //         $message->to($this->email)->subject('Your Site Contect Form javier');
        //     }
        // );
        

        session()->flash('message', $this->student_id ? 'Student updated.' : 'Student created.');
        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->student_id = $id;
        $this->name = $student->name;
        $this->email = $student->email;
        $this->mobile = $student->mobile;
    
        $this->openModalPopover();
    }

    // public function destroy($id)
    // {
    //     Student::destroy($id);
    //     session()->flash('message', 'Registro eliminado correctamente');
    // }

    public function destroy(Student $student)
    {
        $student->delete();
    }
}