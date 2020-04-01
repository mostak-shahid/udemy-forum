@extends('layouts.app')

@section('content')
    @if($discussions->count()>0)
        @foreach($discussions as $discussion)
            <div class="card mb-4">
                <div class="card-header">
                    <img class="img-fluid img-avatar" src="{{$discussion->user->avatar}}" alt="{{$discussion->user->name}}" width="40" height="40">
                    <span class="pl-1"><strong>{{$discussion->user->name}},</strong> {{$discussion->created_at->diffForHumans()}}</span>
                    @if ($discussion->has_best_reply())
                    <span class="badge badge-pill badge-success">Closed</span>
                    @endif
                    <div class="btn-group btn-group-sm float-right" role="group">
                        @if($discussion->is_author())
                            <a href="{{route('discussion.edit', ['discussion'=>$discussion->id])}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                        @endif
                        <a href="{{route('discussions.show', ['discussion'=>$discussion->slug])}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <h5>{{$discussion->title}}</h5>
                    <div class="content">{{str_limit($discussion->content,50)}}</div>
                    
                </div>
                <div class="card-footer">
                    {{$discussion->replies->count()}} Replies
                    <a href="{{route('channels.show',['channel'=>$discussion->channel->slug])}}" class="btn btn-sm float-right">{{$discussion->channel->title}}</a>
                </div>
            </div>
        @endforeach
        {{ $discussions->appends(request()->except('page'))->links() }}
    @endif

@endsection
