@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">Edit Discussion: {{$discussion->title}}</div>
                <div class="card-body">
                    <form action="{{route('discussion.update', ['discussion'=>$discussion->id])}}" method="post">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="form-group">
                            <label for="title">Ask a question?</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Ask a question?" value="{{$discussion->title}}">
                        </div>
                        <div class="form-group">
                            <label for="channel_id">Pick a Channel</label>
                            <select name="channel_id" id="channel_id" class="form-control">
                                @foreach($allchannels as $channel)
                                <option value="{{$channel->id}}" @if($discussion->channel_id == $channel->id) selected @endif>{{$channel->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">A little brief</label>
                            <textarea name="content" id="content" class="form-control" placeholder="A little brief">{{$discussion->content}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>

@endsection
