<div class="col-md-12">
    @if(session('message'))
        <div class="alert alert-success">                                    
            {{ session('message') }}
        </div>
    @endif
</div>
@if(Auth::check())
    <form action="{{ url('/comment') }}" method="POST">
        @csrf

        <input class="form-control" name="video_id" type="hidden" value="{{ $video->id }}">
        <textarea class="form-control" name="body"></textarea>
        <br>
        <button class="btn btn-outline-danger" id="btn-comment">Comentar</button>
    </form>
@endif
<br>
@if($video->comments)
    @foreach ($video->comments as $comment)
        <div class="row comment-panel mt-2">
            <div class="col-6 mt-2">
                <p class="float-left">
                    {{$comment->user->surname}} | <small>{{ FormatTime::LongTimeFilter($comment->created_at) }}</small>
                </p>
            </div>
            @if(Auth::check() && (Auth::user()->id == $comment->user_id || Auth::user()->id == $video->user_id))
            <div class="col-4 offset-2 mt-2">
                <p class="float-right">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$comment->id}}">
                            Eliminar
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$comment->id}}">
                            Editar
                    </button>
                </p>
            </div><!-- col -->            
            @endif            
            <div class="col-12">
                <p class="float-left">
                    {{$comment->body}}
                </p>
            </div>
                        
            <!-- modal -->
            <div class="modal fade" id="deleteModal{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                            <p><b>{{$comment->body}}</b></p>
                            <p class="text-danger"><small>* Si lo borras, nunca podrás recuperarlo.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <a href="{{ route('commentDelete', ['comment_id' => $comment->id])}}" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div><!-- modal-content-->
                </div><!-- modal-dialog-->
            </div><!-- modal -->
        </div>
    @endforeach
@endif