<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(auth()->check()){
        return redirect()->route('farm.index');
    }
    else{
        return view('homefertility.index');
    }
})->name('fertility.index');

Route::get('/sobre-nosotros', function () {
    return view('homefertility.sobreNosotros');
})->name('fertility.sobreNosotros');

Route::get('/contactanos', function () {
    return view('homefertility.contactanos');
})->name('fertility.contactanos');

Route::get('/login', function() {
    return view('auth.login');
})->name('login');

/* Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); */

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    return back();
    // return 'DONE'; //Return anything
})->name('clearCache');

Route::get('storage-link', function(){
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder,$linkFolder);
    // $exitCode = Artisan::call('storage:link');
    return 'Imagenes mostradas';
});

// primera ruta para acceder solo usuaios autencidas, segunda para verificado el correo
// Route::group(['middleware' => 'auth'], function() {
    Route::group(['middleware' => ['auth', 'verified']], function () {

    /* Route::get('markAsReadNotifications', function(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsReadNotifications'); */

    Route::get('/notifys', App\Livewire\Notifications\Index::class)->name('notifys.index');

    Route::get('/permissions', App\Livewire\Permissions\Index::class)->name('permissions.index');
    Route::get('/permissionsCreate', App\Livewire\Permissions\Create::class)->name('permissions.create');
    Route::get('permissions/{id}/edit', App\Livewire\Permissions\Edit::class)->name('permissions.edit');

    Route::get('/roles', App\Livewire\Roles\Index::class)->name('roles.index');
    Route::get('/rolesCreate', App\Livewire\Roles\Create::class)->name('roles.create');
    Route::get('roles/{id}/edit', App\Livewire\Roles\Edit::class)->name('roles.edit');
    Route::get('roles/{role_id}/show', App\Livewire\Roles\Show::class)->name('roles.show');

    Route::get('/users', App\Livewire\Users\Index::class)->name('users.index');
    Route::get('/usersCreate', App\Livewire\Users\Create::class)->name('users.create');
    Route::get('user/{id}/show', App\Livewire\Users\Show::class)->name('users.show');
    Route::get('user/{id}/edit', App\Livewire\Users\Edit::class)->name('users.edit');

    // -----------------------------------------------------------------------------------------------------------------
    Route::get('/fincas', App\Livewire\Farms\Index::class)->name('farm.index');
    Route::get('/fincasCreate', App\Livewire\Farms\Create::class)->name('farm.create');
    Route::get('fincas/{id}/edit', App\Livewire\Farms\Edit::class)->name('farm.edit');

    Route::get('/ganaderia', App\Livewire\Livestocks\Index::class)->name('livestock.index');
    Route::get('/ganaderiaCreate', App\Livewire\Livestocks\Create::class)->name('livestock.create');
    Route::get('ganaderia/{id}/edit', App\Livewire\Livestocks\Edit::class)->name('livestock.edit');

    Route::get('/trabajos', App\Livewire\Works\Index::class)->name('work.index');
    Route::get('/trabajosCreate', App\Livewire\Works\Create::class)->name('work.create');
    Route::get('trabajos/{id}/edit', App\Livewire\Works\Edit::class)->name('work.edit');

    Route::get('/pagos', App\Livewire\PaymentHistorys\Index::class)->name('paymentHistorys.index');
    Route::get('pagos/{id}/edit', App\Livewire\PaymentHistorys\Edit::class)->name('paymentHistorys.edit');

    Route::post('/trabajos-agendados/pdf', [App\Http\Controllers\TrabajosPdfController::class, 'generarPDF'])->name('trabajos-agendados.pdf');
});