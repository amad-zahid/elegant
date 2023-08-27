<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactsController;

use App\Http\Controllers\Web\ContactsController as WebContactController;
use App\Http\Controllers\Web\ExternalContactController;
use App\Http\Controllers\WPController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/contacts/show/{contact}', [ExternalContactController::class, 'show'])
    ->name('external.contacts.show')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //LeadContact
    Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/create', [ContactsController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactsController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{contact}', [ContactsController::class, 'show'])->name('contacts.show');
    Route::get('/contacts/{contact}/edit', [ContactsController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{contact}', [ContactsController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [ContactsController::class, 'destroy'])->name('contacts.destroy');

    // Export Contact to WP
    Route::prefix('wp')->group(function () {
        Route::post('/create-user', [WPController::class, 'createUser'])->name('wp.create.user');
    });
});

require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('contact', [WebContactController::class, 'create'])
                ->name('web.contact');
    Route::post('contact', [WebContactController::class, 'store']);
});
