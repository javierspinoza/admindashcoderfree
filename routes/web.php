<?php

use Illuminate\Support\Facades\Route;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\FacebookController;

use App\Http\Livewire\Materias;
// use App\Http\Livewire\Crud;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(auth()->check()){
        return redirect()->route('dashboard');
    }
    else{
        return view('auth.login');
    }
});

// Route::get('/', function () {
//     if(auth()->id()){
//         return redirect()->route('dashboard');
//     }
//     else{
//         return view('auth.login');
//     }
// });

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    return 'DONE'; //Return anything
});

Route::get('/storage-link', function() {
    $exitCode = Artisan::call('storage:link');
    return 'DONE'; //Return anything
});

Route::get('markAsReadNotifications', function(){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markAsReadNotifications');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// para el login con facebook
Route::get('auth/facebook', [FacebookController::class, 'redirectFacebook']);
Route::get('auth/facebook/callback', [FacebookController::class, 'callbackFacebook']);

// login con google
Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/google-callback', function () {
    $user = Socialite::driver('google')->user();

    $userExists = User::where('google_id', $user->id)->where('tipo_auth', 'google')->first();
    if ($userExists) {
        Auth::login($userExists);
    } else {
        $fechaVerificacion = Carbon::now();
        $UserNew = User::create([
            'name' => $user->name,
            'email' => $user->email,
            // 'email_verified_at' => 'Hola',
            'password' => Hash::make($user->email.'1212'),
            'profile_photo_path' => $user->avatar,
            'google_id' => $user->id,
            'tipo_auth' => 'google',
        ]);
        Auth::login($UserNew);
    }
    // dd($user);
    return redirect('/materias');
});

// primera ruta para acceder solo usuaios autencidas, segunda para verificado el correo
// Route::group(['middleware' => 'auth'], function() {
Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/users', App\Http\Livewire\Users::class)->name('users.index');

    Route::get('/permissions', App\Http\Livewire\Permissions::class)->name('permissions.index');
    Route::get('/roles', App\Http\Livewire\Roles::class)->name('roles.index');

    Route::get('/students', App\Http\Livewire\Crud::class)->name('crud.index');

    Route::get('/materias', App\Http\Livewire\Materias::class)->name('materias.index');

    Route::get('/horarios', App\Http\Livewire\Horarios::class)->name('horarios.index');

    Route::get('/libros', App\Http\Livewire\Libros::class)->name('libros.index');

    Route::get('/departamentos', App\Http\Livewire\Departamentos::class)->name('departamentos.index');

    Route::get('/ciudades', App\Http\Livewire\Ciudades::class)->name('ciudades.index');

    Route::get('/barrios', App\Http\Livewire\Barrios::class)->name('barrios.index');

    Route::get('/direcciones', App\Http\Livewire\Direcciones::class)->name('direcciones.index');

});