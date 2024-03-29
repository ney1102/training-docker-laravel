<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;

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
   return Redirect('/login');
});
Route::group(['middleware' => ['auth']], function () {
   Route::get('/dashboard', function () {
      return redirect('/products');
   });
   //logout
   Route::get('/logout', [AuthController::class, 'Logout']);
   //User Management
   Route::get('/users/load', [UserController::class, 'LoadUsers'])->name('users.loadUsers');
   Route::post('/users/save', [UserController::class, 'SaveUsers'])->name('users.saveUsers');
   Route::delete('/users/delete', [UserController::class, 'DeleleUserAjax']);
   Route::put('/users/toggle-status-user', [UserController::class, 'ToggleLockStatusUserAjax']);
   //Customer Management
   Route::get('/customers', [CustomerController::class, 'index']);
   Route::post('/customers/create', [CustomerController::class, 'Create']);
   Route::put('/customers/update', [CustomerController::class, 'Update']);
   Route::get('/customers/export', [CustomerController::class, 'export']);
   Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');
   //Product Management
   Route::get('/products', [ProductController::class, 'index']);
   Route::get('/products/get-img', [ProductController::class, 'getImageProductById']);
   Route::post('/products/save', [ProductController::class, 'save']);
   Route::delete('/products/delete', [ProductController::class, 'delete']);
   Route::delete('/products/delete-image', [ProductController::class, 'deleleImageProductById']);
});

//Authentication
Route::get('/login', [AuthController::class, 'Login'])->name('login');
Route::post('/login', [AuthController::class, 'LoginAction'])->name('login.post');
Route::get('/register', [AuthController::class, 'Register']);
Route::post('/register', [AuthController::class, 'RegisterAction'])->name('register.post');
