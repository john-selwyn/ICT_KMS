<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntriesController;
use App\Http\Controllers\knowledge_baseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\New_EntryController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\AuditTrailController;


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
Route::get('/dashboard/category_list', [DashboardController::class, 'list'])->name('dashboards');


//Items
Route::get('/items/{id}', [DashboardController::class, 'show'])->name('items.show');
Route::get('/categories/{category}/items', [CategoryController::class, 'showItems'])->name('category.items');
Route::get('items/{category}/{item_id?}', [DashboardController::class, 'showItems2'])->name('items.list');



//New Entries Controller
Route::get('new-entry/create', [New_EntryController::class, 'create'])->name('new_entry.create');
Route::post('new-entry/store', [New_EntryController::class, 'new_store'])->name('new_entry.store');
Route::get('new-entry/show', [New_EntryController::class, 'showEntries'])->name('new_entry.show');



//Entries pending view
Route::get('/entries/pending', [EntriesController::class, 'entries'])->name('entries.pending');
Route::get('/entries/pending/{entry}', [EntriesController::class, 'show_pending'])->name('show.pending'); // Show Pending Item


//Entries Controller
Route::get('/approve_entries', [EntriesController::class, 'approve_entries'])->name('entries.approves');
Route::post('/entries/approve/{id}', [EntriesController::class, 'approve'])->name('entries.approve');


Route::get('/entries/create', [EntriesController::class, 'create'])->name('entries.create');


//Approval Controller

Route::get('/entries/{entry}', [ApprovalController::class, 'show'])->name('entries.show');
Route::get('/entries/{entry}/edit', [ApprovalController::class, 'edit'])->name('entriess.edit');
Route::put('/entries/{entry}', [ApprovalController::class, 'update'])->name('entriess.update');
Route::delete('/entries/{entry}', [ApprovalController::class, 'destroy'])->name('entriesss.delete');

//Trash Approval
Route::delete('/approve_entries/{entry}/trash', [ApprovalController::class, 'trash'])->name('entries.trash');
Route::get('/approve_entries/trash', [ApprovalController::class, 'trashIndex'])->name('entries.trash.index');
Route::post('/approve_entries/{entry}/restore', [ApprovalController::class, 'restore'])->name('entries.restore');
Route::get('/trash/{id}', [TrashController::class, 'viewTrash'])->name('trash.view');

Route::delete('/trash/{id}', [TrashController::class, 'destroy'])->name('trash.destroy');


//User Pending Entries

Route::get('/pending/entries/{entry}/edit', [EntriesController::class, 'entry_edit'])->name('pending.entries.edit');
Route::put('/pending/entries/{entry}', [EntriesController::class, 'entry_update'])->name('pending.entries.update');






Route::get('/search', [EntriesController::class, 'search'])->name('entries.search');

Route::post('/entries/create', [EntriesController::class, 'store'])->name('entries.store');
Route::get('/entries/{entries}/edit', [EntriesController::class, 'edit'])->name('entries.edit');
Route::put('/entries/{entries}/update', [EntriesController::class, 'update'])->name('entries.update');
Route::delete('/entries/{entries}/delete', [EntriesController::class, 'delete'])->name('entries.delete');


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


//Reports
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');

//FAQs
// FAQs
Route::get('/faqs', [FAQController::class, 'index'])->name('faqs.index');
Route::get('/faqs/create', [FAQController::class, 'create'])->name('faqs.create');
Route::post('/faqs', [FAQController::class, 'store'])->name('faqs.store');
Route::get('/faqs/{id}/edit', [FAQController::class, 'edit'])->name('faqs.edit');
Route::put('/faqs/{id}', [FAQController::class, 'update'])->name('faqs.update');
Route::delete('/faqs/{id}', [FAQController::class, 'destroy'])->name('faqs.destroy');



Route::middleware(['auth', 'super-admin'])->group(function () {
    Route::get('/audit-trails', [AuditTrailController::class, 'index'])->name('audit-trails.index');
});




//Edit user

Route::post('/users/{user}/promote', [UserController::class, 'promote'])->name('users.promote');
Route::post('/users/{user}/demote', [UserController::class, 'demote'])->name('users.demote');
Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');



//Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
