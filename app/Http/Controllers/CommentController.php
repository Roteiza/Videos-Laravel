<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;

class CommentController extends Controller
{
    /**
     * Guardar comentario
     * @param Request $request
     * @return View (array message) 
    */
    public function store(Request $request)
    {
        $validate = $this->validate($request, array(
            'body' => 'required'
        ));

        $comment = new Comment();
        $user    = \Auth::user();

        $comment->user_id  = $user->id;
        $comment->video_id = $request->input('video_id');
        $comment->body     = $request->input('body');

        $comment->save();

        return redirect()->route('detailVideo', ['video_id' => $comment->video_id])->with(array(
            'message' => 'Comentario añadido correctamente.'
        ));
    }

    /**
     * Eliminar Comentario
     * @param Integer $comment_id
     * @return View (array message) 
    */
    public function delete($comment_id)
    {
        $user    = \Auth::user();
        $comment = Comment::find($comment_id);
        
        if($user && ($comment->user_id == $user->id || $comment->video->user_id == $user->id)) {
            $comment->delete();
        }
        
        return redirect()->route('detailVideo', ['video_id' => $comment->video_id])->with(array(
            'message' => 'Comentario eliminado correctamente.'
        ));
    }
}
