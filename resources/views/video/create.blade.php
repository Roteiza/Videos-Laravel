@extends('layouts.app')

@section('content')    
    <div class="col-12 pt-2 pb-4">
        <h2>Crear Nuevo Video</h2>
    </div>
    <hr>
    <form class="col-12" action="{{route('saveVideo')}}" method="POST" enctype="multipart/form-data">
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
                <input type="text" class="form-control" name="title" placeholder="Ingresa el título del video" value="{{ old('title') }}" />
            </div>
            <div class="form-group col-12">
                <label for="description">Descripción</label>
                <textarea class="form-control" name="description" placeholder="Ingresa la descripción del video">{{ old('description') }}</textarea>
            </div>
            <div class="form-group col-6">
                <label for="image">Miniatura</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group col-6">
                <label for="title">Video</label>
                <input type="file" class="form-control" id="video" name="video">
            </div>
            <div class="col-12 pt-4">
                <button type="submit" class="btn btn-success btn-submit">Crear</button>
            </div>
        </div>
    </form>        
@endsection