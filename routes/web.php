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
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
// ----------------------------------
// -- Rutas Controlador Videos --
// Form Crear Video
Route::get('/createVideo', array(
    'as'         => 'createVideo',
    'middleware' => 'auth',
    'uses'       => 'VideoController@createVideo'
));

// Guardar Video
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

// Obtener Video
Route::get('/videoFile/{filename}', array(
    'as'   => 'videoFile',
    'uses' => 'VideoController@getVideo'
));

// Detalle Video
Route::get('/video/{video_id}', array(
    'as'   => 'detailVideo',
    'uses' => 'VideoController@getVideoDetail'
))->where(['video_id' => '^[0-9]+$']);

// Eliminar Video
Route::get('/delete-video/{video_id}', array(
    'as'         => 'videoDelete',
    'middleware' => 'auth',
    'uses'       => 'VideoController@delete'
))->where(['video_id' => '^[0-9]+$']);

// Editar Video
Route::get('/edit-video/{video_id}', array(
    'as'         => 'videoEdit',
    'middleware' => 'auth',
    'uses'       => 'VideoController@edit'
))->where(['video_id' => '^[0-9]+$']);

// Actualiza Video
Route::post('/update-video/{video_id}', array(
    'as'         => 'videoUpdate',
    'middleware' => 'auth',
    'uses'       => 'VideoController@update'
))->where(['video_id' => '^[0-9]+$']);

// Buscar Video
Route::get('/search-video/{search?}/{filter?}', array(
    'as'   => 'searchVideo',
    'uses' => 'VideoController@search'
))->where(['video_id' => '^[0-9]+$']);
// -- Rutas Controlador Videos --

// ----------------------------------

// -- Rutas Comentarios --
// Guardar Comentario
Route::post('/comment', array(
    'as'         => 'comment',
    'middleware' => 'auth',
    'uses'       => 'CommentController@store'
));

// Eliminar Comentario
Route::get('/delete-comment/{comment_id}', array(
    'as'         => 'commentDelete',
    'middleware' => 'auth',
    'uses'       => 'CommentController@delete'
))->where(['video_id' => '^[0-9]+$']);
// -- Rutas Comentarios --

// -- Ruta Canal --
// Vista Mi Canal
Route::get('channel/{user_id}', array(
    'as'         => 'channel',
    'middleware' => 'auth',
    'uses'       => 'UserController@channel'
))->where(['video_id' => '^[0-9]+$']);
// -- Ruta Canal --