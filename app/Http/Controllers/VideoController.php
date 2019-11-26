<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comment;

class VideoController extends Controller
{
    public function createVideo()
    {
        return view('video.create');
    }

    public function saveVideo(Request $request)
    {
        // Validar Formulario
        $validateData = $this->validate($request, [
            'title'       => 'required|min:5',
            'description' => 'required',
            'video'       => 'mimetypes:video/mp4'
        ]);

        $video = new Video();
        $user  = \Auth::user();

        $video->user_id = $user->id;
        $video->title   = $request->input('title');
        $video->description = $request->input('description');

        $image_file = $request->file('image');
        if($image_file) {
            $image_path = time().$image_file->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image_file));
            $video->image = $image_path;
        }

        $video_file = $request->file('video');
        if($video_file) {
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }
        
        $video->save();

        return redirect()->route('home')->with(array(
            'message' => 'Video subido correctamente'
        ));
    }

    public function getImage($filename)
    {
        $file = Storage::disk('images')->get($filename);

        return new Response($file, 200);
    }

    /**
     * Método que retorna el archivo de video
     * @param - $filename
     * @return $file, code_response
     */
    public function getVideo($filename)
    {
        $file = Storage::disk('videos')->get($filename);

        return new Response($file, 200);
    }

    public function getVideoDetail($video_id)
    {
        $video = Video::find($video_id);

        return view('video.detail', array(
            'video' => $video
        ));
    }
}
