@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('message'))
                <div class="alert alert-success">                                    
                    {{ session('message') }}
                </div>
            @endif
        </div>
        
        @foreach($videos as $video)        
        <div class="card col-sm-12 col-md-6 col-lg-3 m-1 p-1 text-center">            
            @if(Storage::disk('images')->has($video->image))
                <img class="card-img-top" src="{{url('miniatura/'.$video->image)}}" width="250" height="250">
            @else
                <img class="card-img-top" src="{{url('miniatura/no-image.jpg')}}" width="250" height="250">
            @endif
            <div class="card-body">
                <h5 class="card-title font-weight-bold">{{$video->title}}</h5>
                <p class="card-text">{{$video->description}}</p>
                <p class="card-text">{{$video->user->surname}} | <small>{{ FormatTime::LongTimeFilter($video->created_at) }}</small></p>
            </div>            
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <a href="{{route ('detailVideo', ['video_id' => $video->id])}}" class="card-link btn btn-outline-info btn-sm btn-submit-sm my-1">Ver</a>    
                    </div>
                    @if(Auth::check() && Auth::user()->id == $video->user->id)
                    <div class="col-sm-12 col-lg-4">
                        <a href="#" class="card-link btn btn-outline-warning btn-sm btn-submit-sm my-1">Editar</a>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <a href="#" class="card-link btn btn-outline-danger btn-sm btn-submit-sm my-1">Eliminar</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <div class="row border-top mt-3 py-3">
        <div class="col-6 offset-5">
            {{$videos->links()}}
        </div>
    </div>
</div>
@endsection
