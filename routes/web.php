<?php

use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

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
    return view('welcome');
});

// Start Authentication
Route::get("/login", [LoginController::class, "index"])->name("login");
Route::post("/login", [LoginController::class, "store"])->name("login.store");

Route::get("/logout", function() {
    Auth::logout();
    Alert::success("Sukses!", "Berhasil logout!");
    return redirect()->route("login");
});
// End Authentication

Route::middleware(["auth"])->group(function() {
    Route::get("/app/dashboard", DashboardController::class)->name("app.dashboard");

    Route::post("/app/users/get", [UserController::class, "get"])->name("app.users.get");
    Route::resource("/app/users", UserController::class, ["as" => "app"]);
});