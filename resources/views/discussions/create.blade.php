@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">Add new Discussion</div>
                <div class="card-body">
                    <form action="{{route('discussion.store')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="title">Ask a question?</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Ask a question?">
                        </div>
                        <div class="form-group">
                            <label for="channel_id">Pick a Channel</label>
                            <select name="channel_id" id="channel_id" class="form-control">
                                @foreach($allchannels as $channel)
                                <option value="{{$channel->id}}">{{$channel->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">A little brief</label>
                            <textarea name="content" id="content" class="form-control" placeholder="A little brief"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Discussion</button>
                    </form>
                </div>
            </div>

@endsection
