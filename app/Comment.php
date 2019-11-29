<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    // Relación de Muchos a Uno
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    // Relación de Muchos a Uno
    public function video() {
        return $this->belongsTo('App\Video', 'video_id');
    }
}
