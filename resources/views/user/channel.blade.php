@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-6 align-self-center">
            <h4>Canal de {{$user->name}} {{$user->surname}}</h4>
        </div>        
    </div>
    <br>
    @include('video.videoList')
@endsection