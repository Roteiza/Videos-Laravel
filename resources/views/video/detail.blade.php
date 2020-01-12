@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card-header">                
            <h5 class="card-title">{{ $video->title }}</h5>
        </div>
            <div class="card-body">
                <video controls id="video-player" width="320" height="240">
                    <source src="{{ route('videoFile', ['filename' => $video->video_path]) }}" width="200">                    
                        Tu navegador no es compatible con HTML5
                </video>                
                <p class="card-text">{{ $video->description}}</p>                
            </div>
            <div class="card-footer text-muted">
                <a href="{{route('channel',['user_id' => $video->user->id])}}">{{$video->user->surname}}</a> | <small>{{ FormatTime::LongTimeFilter($video->created_at) }}</small>
            </div>
            <hr>
            <h5 class="display-6">Comentarios</h5>
            @include('video.comments')
        </div>
    </div>
@endsection