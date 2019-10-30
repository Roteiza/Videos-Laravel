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

    $videos = Video::all();
    foreach($videos as $video){
        echo $video->title;
        echo $video->user->email."<br>";
        foreach($video->comments as $comment){
            echo $comment->body;
        }
        echo "<hr>";
    }

    return view('welcome');
});
