<?php

use App\Http\Controllers\AccueilController;
use Illuminate\Support\Facades\Route;

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
    // Dans routes/web.php

});
// Dans routes/web.php

Route::get('/home',[AccueilController::class,'index'])->name('index');