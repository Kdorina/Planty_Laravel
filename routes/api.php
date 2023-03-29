<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\MyPlantController;
use App\Http\Controllers\User\WaterController;
use App\Http\Controllers\User\NutrientSolutionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User
Route::post("/login",[AuthController::class, "login"]);
Route::post("/register",[AuthController::class, "register"]);
Route::post("/logout",[AuthController::class, "logout"]);


Route::group(['middleware'=>['auth:sanctum']], function(){

    Route::get("/myplants",[MyPlantController::class, "index"]);
    Route::post("/myplant",[MyPlantController::class, "create"]);

    Route::get("/water",[WaterController::class, "index"]);
    Route::post("/addwater",[WaterController::class, "create"]);

    Route::get("/nutrients",[NutrientSolutionController::class, "index"]);
    Route::post("/addnutrients",[NutrientSolutionController::class, "create"]);

});


//ADMIN 
Route::post('/adminReg', [AdminController::class, "adminRegister" ]); 
Route::post('/adminLog', [AdminController::class, "adminLogin" ]); 



Route::group(['middleware'=>['auth:sanctum']], function(){

    Route::post("/logoutAdmin",[AdminController::class, "logout"]);
   
    Route::get('/plants', [PlantController::class, "index"]);
    Route::post('/plant', [PlantController::class, "create"]);
    Route::get('/plant/{id}', [PlantController::class, "show"]);
    Route::put('/plantUpdate/{id}', [PlantController::class, "update"]);
    Route::delete('/plantDelete/{id}', [PlantController::class, "destroy"]);
    
    Route::get('/types', [TypeController::class, "index"]);
    Route::post('/type', [TypeController::class, "create"]);
    Route::get('/type/{id}', [TypeController::class, "show"]);
    Route::put('/typeUpdate/{id}', [TypeController::class, "update"]);
    Route::delete('/typeDelete/{id}', [TypeController::class, "destory"]);

});

Route::get('/diseases', [DiseaseController::class, "index"]);
    Route::post('/disease', [DiseaseController::class, "create"]);
    Route::get('/disease/{id}', [DiseaseController::class, "show"]);
    Route::put('/disease/{id}', [DiseaseController::class, "update"]);
    Route::delete('/disease/{id}', [DiseaseController::class, "destory"]);

