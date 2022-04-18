<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
//Route::get('{vue_route?}', [App\Http\Controllers\HomeController::class, 'index'])->where('vue_route', '[\/\w\.-]*');
//Route::get('/', 'App\Http\Controllers\PublicController@public_index');
Route::get('/public/plants', 'App\Http\Controllers\PublicController@plants_home');
Route::get('/public/plant/{id}', 'App\Http\Controllers\PublicController@plant_show');
Route::get('/public/plant/arc/{id}', 'App\Http\Controllers\PublicController@plant_show');

Route::get('/public/plant-methods', 'App\Http\Controllers\PublicController@index_methods');
Route::get('/public/view-plant-methods/{id}', 'App\Http\Controllers\PublicController@view_plant_methods');

Route::get('/hasher', function () {

    $h = Hash::make('qweasdzxc');
    //$h = App\Task::all();

    return $h;
});

Auth::routes(['reset' => false]);

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => ['admin']], function () {
    Route::prefix('admin')->group(function () {

        Route::resource('/plants', 'App\Http\Controllers\Administrator\PlantNameController');
        Route::resource('/plant-variety', 'App\Http\Controllers\Administrator\PlantVarietyController');

        Route::resource('/adminreg', 'App\Http\Controllers\Administrator\CustomRegisterController');

        Route::resource('/plant-details', 'App\Http\Controllers\Administrator\PlantDetailController');
        Route::get('/get-plant-names', 'App\Http\Controllers\Administrator\PlantDetailController@get_plant_names');
        Route::post('/update-plantphoto/{id}', 'App\Http\Controllers\Administrator\PlantDetailController@updatePhoto');
        Route::post('/delete-plantphoto/{id}', 'App\Http\Controllers\Administrator\PlantDetailController@deletePhoto');

        Route::get('/logout', 'App\Http\Controllers\Administrator\AdministratorController@logout');

        Route::get('/{any}', function () {
            return view('/administrator/home');
        })->where('any', '.*');
    });
});

Route::group(['middleware' => ['expert']], function () {
    Route::prefix('expert')->group(function () {

        Route::post('/update-graft/{id}', 'App\Http\Controllers\Expert\GraftTechniqueController@update');

        Route::post('/save-docs/{id}', 'App\Http\Controllers\Expert\GraftTechniqueController@updateDocs');
        Route::post('/delete-doc/{id}', 'App\Http\Controllers\Expert\GraftTechniqueController@deleteDoc');
        Route::post('/update-doc/{id}', 'App\Http\Controllers\Expert\GraftTechniqueController@updateDoc');

        Route::resource('/graft-techniques', 'App\Http\Controllers\Expert\GraftTechniqueController');
        Route::get('/get-plant-names', 'App\Http\Controllers\Expert\PlantDetailController@get_plant_names');
        Route::get('/logout', 'App\Http\Controllers\Expert\ExpertController@logout');

        Route::resource('/plants', 'App\Http\Controllers\Expert\PlantNameController');

        Route::resource('/plant-variety', 'App\Http\Controllers\Expert\PlantVarietyController');

        Route::resource('/plant-methods', 'App\Http\Controllers\Expert\PlantMethodController');
        Route::get('/get-plant-names-met', 'App\Http\Controllers\Expert\PlantMethodController@get_plant_names');
        Route::get('/view-plant-methods/{id}', 'App\Http\Controllers\Expert\PlantMethodController@view_plant_methods');

        Route::resource('/plant-details', 'App\Http\Controllers\Expert\PlantDetailController');
        Route::post('/update-plantphoto/{id}', 'App\Http\Controllers\Expert\PlantDetailController@updatePhoto');
        Route::post('/delete-plantphoto/{id}', 'App\Http\Controllers\Expert\PlantDetailController@deletePhoto');

        Route::get('/{any}', function () {
            return view('/expert/home');
        })->where('any', '.*');
    });
});

Route::group(['middleware' => ['pubuser']], function () {
    Route::prefix('publicuser')->group(function () {

        Route::get('/logout', 'App\Http\Controllers\PublicUser\PublicUserController@logout');

        Route::get('/{any}', function () {
            return view('/publicuser/home');
        })->where('any', '.*');
    });
});
Route::get('/{any}', function () {
    return view('/welcome');
})->where('any', '.*');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');