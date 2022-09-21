<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

use App\Models\User;

use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    //definimos unas variables
    public $name, $email, $password, $user_id, $user;
    // public $rol;
    public $assignRol=[];
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
            'name' => 'required|min:4|max:255',
            'email' => 'required|min:8|max:255|email|unique:users,email,' . $this->user_id,
            'password' => 'max:255',
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 4 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'email.required' => 'Por favor escribe un email.',
        'email.min' => 'Pon almenos 8 caracteres',
        'email.max' => 'máximo 255 caracteres',
        'email.email' => 'Escribe un email permitido',
        'email.unique' => 'Este email ya se encuentra registrado.',
        'password.max' => 'Este campo debe tener máximo 255 caracteres',
    ];

    public function render()
    {
        abort_if(Gate::denies('user_admin'), 403);
        $roles = Role::get();
        $users = User::where('name', 'like', '%' .$this->search.'%')
        ->orWhere('email', 'like', '%' .$this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        return view('livewire.users', compact('users', 'roles'));
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
        $this->email = '';
        $this->password = '';
        $this->assignRol = '';
    }
    // para las validaciones en tiempo real
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate([
            'name' => 'required|min:4|max:255',
            'email' => 'required|min:8|max:255|email|unique:users,email,' . $this->user_id,
            'password' => 'max:255',
        ],
        [
            'name.required' => 'El nombre es requerido.',
            'name.min' => 'Pon almenos 4 caracteres',
            'name.max' => 'máximo 255 caracteres',
            'email.required' => 'Por favor escribe un email.',
            'email.min' => 'Pon almenos 8 caracteres',
            'email.max' => 'máximo 255 caracteres',
            'email.email' => 'Escribe un email permitido',
            'email.unique' => 'Este email ya se encuentra registrado.',
            'password.max' => 'Este campo debe tener máximo 255 caracteres',
        ]);

        $user = User::create($this->getAttributes());
        $user->syncRoles($this->assignRol);
        // enviar email de verificacion
        // event(new Registered($user));
        $user->save();

        $this->closeView();
        $this->cleanFileds();
        $this->emit('alertaSweelert', 'registro exitoso!');
    }

    public function getAttributes()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password)
        ];
    }

    public function show(User $user) {
        $this->assignRol = [];
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->created_at = $user->created_at;
        $this->user_id = $user->id;

        $this->openViewShow();
    }

    public function edit(User $user)
    {
        $this->assignRol = [];
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->user_id = $user->id;

        // para marcar como seleccionados loos roles que ya pertenecen a un usuario
        foreach ($this->user->roles->pluck('id')->toArray() as  $rol) {
            array_push($this->assignRol, "$rol");
        }

        $this->openViewEdit();
    }

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        // para asignar el rol al usuario
        $this->user->roles()->sync($this->assignRol);

        $user = User::find($this->user_id);

        $user->name = $this->name;
        $user->email= $this->email;
        if($this->password)
            $user['password'] = bcrypt($this->password);
        $user->save();

        $this->cleanFileds();
        $this->closeView();
        $this->emit('alertaSweelert', '¡Actualización exitosa!');
    }

    public function destroy(User $user)
    {
        // if (auth()->user()->id == $user->id) {
        //     return back()->with('alertaSweelert', 'No puedes eliminar tu propio usuario');
        // }
        // $user->delete();

        if (auth()->user()->id == $user->id) {
            $this->emit('errorEliminar', '¡No puedes eliminar tu propio usuario!');
        } elseif ($user->delete()) {
            $this->emit('eliminadoCorrecto', '¡Usuario eliminado correctamente!');
        }
        return redirect()->to('/users');
    }
}