@extends('layouts.app')

@section('content')

            <div class="card mb-4">
                <div class="card-header">
                    <img class="img-fluid img-avatar" src="{{$discussion->user->avatar}}" alt="{{$discussion->user->name}}" width="40" height="40">
                    <span class="pl-1"><strong>{{$discussion->user->name}},</strong> {{$discussion->created_at->diffForHumans()}}</span>
            @if(Auth::check())
                <div class="btn-group float-right" role="group">
                    @if($discussion->user_id == Auth::id())
                        <a href="{{route('discussion.edit', ['discussion'=>$discussion->id])}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                    @endif
                    @if($discussion->is_beign_watched_by_auth_user())
                        <a href="{{route('discussion.unwatch', ['id'=>$discussion->id])}}" class="btn btn-warning"><i class="fa fa-bell-slash"></i></a>
                    @else
                        <a href="{{route('discussion.watch', ['id'=>$discussion->id])}}" class="btn btn-success"><i class="fa fa-bell"></i></a>
                    @endif
                </div>
            @endif
                </div>
                <div class="card-body">
                    <h5>{{$discussion->title}}</h5>
                    <div class="content">{!!Markdown::convertToHtml($discussion->content)!!}</div>
                </div>
                <div class="card-footer">
                    {{$discussion->replies->count()}} Replies
                </div>
            </div>
        @if ($discussion->has_best_reply())    
            <div class="card mb-4">
                <div class="card-header">
                    <img class="img-fluid img-avatar" src="{{$best->user->avatar}}" alt="{{$best->user->name}}" width="40" height="40">
                    <span class="pl-1"><strong>{{$best->user->name}},</strong> {{$best->created_at->diffForHumans()}}</span>
                    <span class="badge badge-success float-right">Best Answer</span>

                </div>
                <div class="card-body">
                    <div class="reply-content">{{$best->content}}</div>               
                </div>
                <div class="card-footer">
                    @if($best->is_liked_by_auth_user())  
                        <a href="{{route('reply.dislike',['id'=>$best->id])}}" class="btn btn-danger"><i class="fa fa-thumbs-down"></i></a>
                    @else                
                        <a href="{{route('reply.like',['id'=>$best->id])}}" class="btn btn-success"><i class="fa fa-thumbs-up"></i></a>
                    @endif
                    <span class="badge badge-success float-right">{{$best->likes()->count()}} Likes</span>
                </div>
            </div>
        @else
            @if(Auth::check())
                <div id="comment-card" class="card mb-4">
                    <div class="card-body">
                        <form action="{{route('reply.create')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="content">Leave a comment...</label>
                                <textarea class="form-control" name="content" id="content" rows="3"></textarea>
                            </div>
                            <input type="hidden" name="discussion_id" value="{{$discussion->id}}">
                            <button type="submit" class="btn btn-sm btn-success">Leave a comment</button>
                        </form>
                    </div>
                </div>
            @else
                <h4 class="text-center mb-4"><a href="{{route('login')}}">Sign in to leave a reply</a></h4>
            @endif

        @endif
    @if ($discussion->replies->count()>0)
        @php 
        $replies = $discussion->replies()->orderBy('id','desc')->get()
        @endphp
        @foreach($replies as $reply)
            <div class="card mb-2">
                <div class="card-header">
                    <img class="img-fluid img-avatar" src="{{$reply->user->avatar}}" alt="{{$reply->user->name}}" width="40" height="40">
                    <span class="pl-1"><strong>{{$reply->user->name}},</strong> {{$reply->created_at->diffForHumans()}}</span>

                    <div class="btn-group float-right" role="group">
                        @if(!$discussion->has_best_reply()) 
                            @if($reply->user_id == Auth::id())
                                <button type="button" class="btn btn-info comment-edit"><i class="fa fa-edit"></i></button>
                            @endif
                            @if($discussion->user_id == Auth::id()) 
                                <a href="{{route('reply.best',['id'=>$reply->id])}}" class="btn btn-success"><i class="fa fa-check-square-o"></i></a>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="reply-content">{{$reply->content}}</div>
                    @if (Auth::id() === $reply->user_id)
                        <div class="reply-edit" style="display:none">
                            <form action="{{route('reply.update',['id'=>$reply->id])}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <textarea class="form-control" name="content" id="content" rows="3">{{$reply->content}}</textarea>
                                </div>
                                <input type="hidden" name="discussion_id" value="{{$discussion->id}}">
                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                            </form>
                        </div>
                    @endif
                    
                </div>
                <div class="card-footer">
                    @if($reply->is_liked_by_auth_user())  
                        <a href="{{route('reply.dislike',['id'=>$reply->id])}}" class="btn btn-danger"><i class="fa fa-thumbs-down"></i></a>
                    @else                
                        <a href="{{route('reply.like',['id'=>$reply->id])}}" class="btn btn-success"><i class="fa fa-thumbs-up"></i></a>
                    @endif
                    <span class="badge badge-success float-right">{{$reply->likes()->count()}} Likes</span>
                </div>
            </div>
        @endforeach
    @endif

@endsection
@section('script')
<script>
jQuery(document).ready(function($){
    $('.comment-edit').on('click', function(e){
        var ths = $(this).closest('.card-header').siblings('.card-body');
        ths.find('.reply-edit').show();
        ths.find('.reply-content').hide();
    });
});
</script>
@endsection
