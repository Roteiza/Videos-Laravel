<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Video;
use App\User;

class UserController extends Controller
{
    /**
     * Mostrar vista de Mi Canal
     * @param Integer $user_id
     * @return View (array('user','videos)) 
    */
    public function channel($user_id)
    {
        $user   = User::find($user_id);
        $videos = Video::where('user_id','=',$user_id)->paginate(6);

        if(!is_object($user))
        {
            return redirect()->route('home');
        }

        return view('user.channel', array(
            'user'   => $user,
            'videos' => $videos
        ));
    }
}
