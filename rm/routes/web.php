<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\MenuItemsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer Routes
   
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.list');
    Route::get('/customers/list', [CustomerController::class, 'customers_datatables'])->name('customers.datatables');


    // Staff Routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.list');
    Route::get('/staff/list', [StaffController::class, 'staff_datatables'])->name('staff.datatables');
   
    // Menu Item Routes
    Route::get('/menuitems', [MenuItemsController::class, 'index'])->name('menuitems.list');
    Route::get('/menuitemstable/list', [MenuItemsController::class, 'menuitems_datatables'])->name('menuitems.datatables');

    //tables
     Route::get('/tables', [TableController::class, 'index'])->name('tables.list');
     Route::get('/tables/list', [TableController::class, 'tables_datatables'])->name('tables.datatables');
        });

require __DIR__.'/auth.php';
