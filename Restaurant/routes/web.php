<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\MenuItemsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer Routes
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.list');
    Route::get('/customers/list', [CustomerController::class, 'customers_datatables']);
    Route::post('/customers/store', [CustomerController::class, 'store']);
    Route::post('/customers/update/{id}', [CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Staff Routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.list');
    Route::get('/staff/list', [StaffController::class, 'staff_datatables']);
    Route::post('/staff/store', [StaffController::class, 'store']);
    Route::post('/staff/update/{id}', [StaffController::class, 'update']);
    Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
   
    // Menu Item Routes
    Route::get('/menuitems', [MenuItemsController::class, 'index'])->name('menuitems.list');
    Route::get('/menuitems/list', [MenuItemsController::class, 'menuitems_datatables'])->name('menuitems.datatables');
    Route::post('/menuitems/store', [MenuItemsController::class, 'store'])->name('menuitems.store');
    Route::post('/menuitems/update/{id}', [MenuItemsController::class, 'update'])->name('menuitems.update');
    Route::delete('/menuitems/{id}', [MenuItemsController::class, 'destroy'])->name('menuitems.destroy');


    // Table Routes
     Route::get('/tables', [TableController::class, 'index'])->name('tables.list');
    Route::get('/tables/list', [TableController::class, 'tables_datatables']);
    Route::post('/tables/store', [TableController::class, 'store']);
    Route::post('/tables/update/{id}', [TableController::class, 'update']);
    Route::delete('/tables/{id}', [TableController::class, 'destroy'])->name('tables.destroy');
        });

require __DIR__.'/auth.php';