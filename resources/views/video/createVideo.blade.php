@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row text-center">
            <div class="col-12 pt-2 pb-4">
                <h2>Crear Nuevo Video</h2>
            </div>
            <hr>
            <form class="col-12" action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="title">Título</label>
                        <input type="text" class="form-control" id="title" aria-describedby="title" placeholder="Ingresa el título del video">
                    </div>
                    <div class="form-group col-12">
                        <label for="description">Descripción</label>
                        <textarea class="form-control" id="description" aria-describedby="description" placeholder="Ingresa la descripción del video"></textarea>
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
                        <button type="submit" class="btn btn-success">Crear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection