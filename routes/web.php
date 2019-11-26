<?php

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

Use App\Video;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Rutas Controlador Videos
Route::get('/createVideo', array(
    'as'         => 'createVideo',
    'middleware' => 'auth',
    'uses'       => 'VideoController@createVideo'
));

Route::post('/saveVideo', array(
    'as' => 'saveVideo',
    'middleware' => 'auth',
    'uses'       => 'VideoController@saveVideo'
));

// Obtener Imagen Miniatura
Route::get('/miniatura/{filename}', array(
    'as'   => 'imageVideo',
    'uses' => 'VideoController@getImage'
));

Route::get('/videoFile/{filename}', array(
    'as'   => 'videoFile',
    'uses' => 'VideoController@getVideo'
));

Route::get('/video/{video_id}', array(
    'as'   => 'detailVideo',
    'uses' => 'VideoController@getVideoDetail'
));

// Rutas Comentarios
Route::post('/comment', array(
    'as' => 'comment',
    'middleware' => 'auth',
    'uses'       => 'CommentController@store'
));
