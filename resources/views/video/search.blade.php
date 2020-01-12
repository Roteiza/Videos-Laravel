@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-6 align-self-center">
            <h4>{{$results}} resultado{{($results) > 1 ? 's':''}} para la búsqueda: "<b>{{$search}}</b>"</h4>
        </div>
        <div class="col-3 offset-3">
            <form method="GET" action="{{url('search-video/'.$search)}}">
                <label>Ordenar</label>
                <select class="form-control" name="filter">
                    <option value="new">Más nuevos primero</option>
                    <option value="old">Más antiguos primero</option>
                    <option value="alpha">De la A a la Z</option>
                </select>
                <button class="btn btn-primary btn-sm mt-2" type="submit">Ordenar</button>
            </form>
        </div>
    </div>
    <br>
    @include('video.videoList')
@endsection