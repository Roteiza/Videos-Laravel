<div class="row justify-content-center">
    <div class="col-md-12">
        @if(session('message'))
            <div class="alert alert-success">                                    
                {{ session('message') }}
            </div>
        @endif
    </div>        
    @if(count($videos) >= 1)
        @foreach($videos as $video)        
        <div class="card col-sm-12 col-md-6 col-lg-3 m-1 p-1 text-center">            
            @if(Storage::disk('images')->has($video->image))
                <img class="card-img-top" src="{{url('miniatura/'.$video->image)}}" width="250" height="250">
            @else {{-- No tiene imagen --}}
                <img class="card-img-top" src="{{url('miniatura/no-image.jpg')}}" width="250" height="250">
            @endif
            <div class="card-body">
                <h5 class="card-title font-weight-bold">{{$video->title}}</h5>
                <p class="card-text">{{$video->description}}</p>
                <p class="card-text"><a href="{{route('channel',['user_id' => $video->user->id])}}">{{$video->user->surname}}</a> | <small>{{ FormatTime::LongTimeFilter($video->created_at) }}</small></p>
            </div>            
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 {{(Auth::check() && Auth::user()->id == $video->user->id) ? 'col-lg-12' : 'col'}}">
                        <a href="{{route ('detailVideo', ['video_id' => $video->id])}}">
                            <button type="button" class="btn btn-info btn-sm btn-home">
                                    Ver
                            </button>
                        </a>    
                    </div>
                    @if(Auth::check() && Auth::user()->id == $video->user->id)
                    <div class="col-sm-12 col-lg-6">
                        <a href="{{route('videoEdit', ['video_id' => $video->id])}}">
                            <button type="button" class="btn btn-warning btn-sm btn-home mt-1">
                                    Editar
                            </button>
                        </a>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <button type="button" class="btn btn-danger btn-sm btn-home mt-1" data-toggle="modal" data-target="#deleteModal{{$video->id}}">
                                Eliminar
                        </button>
                        <!-- modal -->
                        <div class="modal fade" id="deleteModal{{$video->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content text-center">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">¿Estás seguro?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Seguro que quieres borrar este elemento?</p>
                                        <p><b>{{$video->title}}</b></p>
                                        <p class="text-danger"><small>* Si lo borras, no podrás recuperarlo.</small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <a href="{{ route('videoDelete', ['video_id' => $video->id])}}" class="btn btn-danger">Eliminar</a>
                                    </div>
                                </div><!-- modal-content-->
                            </div><!-- modal-dialog-->
                        </div><!-- modal -->
                    </div><!-- col-sm-12 col-lg-4 -->
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="alert alert-warning">No hay videos disponibles.</div>
    @endif
</div>
<div class="row border-top mt-3 py-3 justify-content-center">
    {{$videos->links()}}
</div>