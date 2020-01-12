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
    /**
    * Retornar vista para crear Video
    * @return View - Vista Crear Video
    */
    public function createVideo()
    {
        return view('video.create');
    }

    /**
     * Guardar Video
     * @param Request $request
     * @return array message - Mensaje con resultado de operación
    */
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

        $video->user_id     = $user->id;
        $video->title       = $request->input('title');
        $video->description = $request->input('description');

        $image_file = $request->file('image');
        if($image_file) 
        {
            $image_path = time().$image_file->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image_file));
            $video->image = $image_path;
        }

        $video_file = $request->file('video');
        if($video_file) 
        {
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }
        
        $video->save();

        return redirect()->route('home')->with(array(
            'message' => 'Video subido correctamente'
        ));
    }

    /**
     * Obtener el archivo de imagen desde servidor
     * @param filename $filename - Nombre de la imagen
     * @return Response ($file, code) - Archivo Imagen y Código Respuesta
    */
    public function getImage($filename)
    {
        $file = Storage::disk('images')->get($filename);
        
        return new Response($file, 200);
    }

    /**
     * Obtener el archivo de video desde servidor
     * @param filename $filename - Nombre del video
     * @return Response ($file, code) - Archivo Video y Código Respuesta
    */
    public function getVideo($filename)
    {
        $file = Storage::disk('videos')->get($filename);

        return new Response($file, 200);
    }

    /**
     * Retornar vista con detalle del Video
     * @param Integer $video_id
     * @return View - Vista Detalle Video
    */
    public function getVideoDetail($video_id)
    {
        $video = Video::findOrFail($video_id);

        return view('video.detail', array(
            'video' => $video
        ));
    }

    /**
     * Eliminar Video y sus Comentarios asociados
     * @param Integer $video_id
     * @return Array message - Mensaje con resultado de operación
    */
    public function delete($video_id)
    {
        $user     = \Auth::user();
        $video    = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get();

        // Si usuario es dueño del video
        if($user && $video->user_id == $user->id)
        {
            // Eliminar Comentarios
            if($comments && count($comments) >= 1) {
                foreach($comments as $comment) {
                    $comment->delete();
                }
            }
            
            // Eliminar Archivos
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);
            
            // Eliminar Video
            $video->delete();

            $message = array(
                'message' => 'Video eliminado correctamente'
            );
        }
        else
        {
            $message = array(
                'message' => 'El usuario no es el propietario del Video'
            );
        }
            
        return redirect()->route('home')->with($message);
    }

    /**
     * Retornar vista para Editar Video
     * @param Integer $video_id
     * @return View - Vista Editar Video 
    */
    public function edit($video_id)
    {
        $user  = \Auth::user();
        $video = Video::find($video_id);
        
        // Si usuario es dueño del video
        if($user && $video->user_id == $user->id)
        {
            return view('video.edit', array('video' => $video));
        }
        else
        {
            return redirect()->route('home');
        }
    }

    /**
     * Actualizar Video
     * @param Request $request
     * @param Integer $video_id
     * @return Array message - Mensaje con resultado de operación 
    */
    public function update(Request $request, $video_id)
    {
        // Validar Formulario
        $validateData = $this->validate($request, [
            'title'       => 'required|min:5',
            'description' => 'required',
            'video'       => 'mimetypes:video/mp4'
        ]);

        $user = \Auth::user();
        $video = Video::findOrFail($video_id);

        $video->user_id     = $user->id;
        $video->title       = $request->input('title');
        $video->description = $request->input('description');

        $image_file = $request->file('image');
        if($image_file) {
            // Eliminar Archivo
            Storage::disk('images')->delete($video->image);
            
            $image_path = time().$image_file->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image_file));
            $video->image = $image_path;
        }

        $video_file = $request->file('video');
        if($video_file) {
            // Eliminar Archivo           
            Storage::disk('videos')->delete($video->video_path);

            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }

        $video->update();

        return redirect()->route('home')->with(array('message' => 'Video actualizado correctamente'));
    }

    /**
     * Buscar Videos
     * @param $search
     * @param $filter
     * @return Array - videos, search, results 
    */
    public function search($search = null, $filter = null)
    {
        $column = 'id';
        $order  = 'desc';

        if(is_null($search))
        {
            $search = \Request::get('search');
            
            if(is_null($search))
            {
                return redirect()->route('home');
            }

            return redirect()->route('searchVideo', array('search' => $search));
        }
        
        if(is_null($filter) && \Request::get('filter') && !is_null($search))
        {
            $filter = \Request::get('filter');

            return redirect()->route('searchVideo', array('search' => $search, 'filter' => $filter));
        }

        if(!is_null($filter))
        {
            switch($filter)
            {
                case 'new':
                    $column = 'id';
                    $order  = 'desc';
                break;

                case 'old':
                    $column = 'id';
                    $order  = 'asc';
                break;

                case 'alpha':
                    $column = 'title';
                    $order  = 'asc';
                break;

                default:
                break;
            }
        }
        $videos = Video::where('title','LIKE', '%'.$search.'%')->orderBy($column, $order)->paginate(6);
        
        return view('video.search', array(
            'videos'  => $videos,
            'search'  => $search,
            'results' => count($videos)
        ));
    }
}
