@extends('layouts.app')

@section('content')
<div class="col-12 pt-2 pb-4">
    <h2>Editar {{$video->title}}</h2>
</div>
<hr>
<form class="col-12" action="{{route('videoUpdate', $video->id)}}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="form-group col-12">
            <label for="title">Título</label>
            <input type="text" class="form-control" name="title" placeholder="Ingresa el título del video" value="{{ $video->title }}" />
        </div>
        <div class="form-group col-12">
            <label for="description">Descripción</label>
            <textarea class="form-control" name="description" placeholder="Ingresa la descripción del video">{{ $video->description }}</textarea>
        </div>
        <div class="form-group col-6">
            <label for="image">Miniatura</label>
            @if(Storage::disk('images')->has($video->image))
                <img class="card-img-top img-edit" src="{{url('miniatura/'.$video->image)}}">
            @else
                <img class="card-img-top img-edit" src="{{url('miniatura/no-image.jpg')}}">
            @endif
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="form-group col-6">
            <label for="title">Video</label>
            <video controls id="video-player video-edit">
                <source src="{{ route('videoFile', ['filename' => $video->video_path]) }}">                    
                    Tu navegador no es compatible con HTML5
            </video> 
            <input type="file" class="form-control" id="video" name="video">
        </div>
        <div class="col-12 pt-4">
            <button type="submit" class="btn btn-success btn-submit">Actualizar</button>
        </div>
    </div>
</form>        
@endsection