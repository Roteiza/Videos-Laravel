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
            <div class="col-12">
                <p class="float-left">
                    {{$comment->user->surname}} | <small>{{ FormatTime::LongTimeFilter($comment->created_at) }}</small>
                </p>
            </div>
            <div class="col">
                <p class="float-left">
                    {{$comment->body}}
                </p>
            </div>        
        </div>
        @endforeach
    @endif