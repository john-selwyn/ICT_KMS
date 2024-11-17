<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntriesController;
use App\Http\Controllers\knowledge_baseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [EntriesController::class, 'dashboard'])->name('dashboard');



Route::get('/category/{category}', [CategoryController::class, 'showItems'])->name('items');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


//Items
Route::get('/items/{id}', [DashboardController::class, 'show'])->name('items.show');
Route::get('/categories/{category}/items', [CategoryController::class, 'showItems'])->name('category.items');
Route::get('items/{category}/{item_id?}', [DashboardController::class, 'showItems2'])->name('items.list');






//Entries Controller
Route::get('/entries', [EntriesController::class,'approve_entries'])->name('entries.approves');
Route::post('/entries/approve/{id}', [EntriesController::class, 'approve'])->name('entries.approve');
Route::get('/entries/pending', [EntriesController::class,'entries'])->name('entries.pending');

Route::group(['middleware' => ['admin']], function () {
Route::get('/entries/create', [EntriesController::class,'create'])->name('entries.create');
});

Route::post('/entries/create', [EntriesController::class,'store'])->name('entries.store');
Route::get('/entries/{entries}/edit', [EntriesController::class,'edit'])->name('entries.edit');
Route::put('/entries/{entries}/update', [EntriesController::class,'update'])->name('entries.update');
Route::delete('/entries/{entries}/delete', [EntriesController::class,'delete'])->name('entries.delete');


//Category Controller

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');




    Route::middleware(['auth', 'admin'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });






//USER
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
