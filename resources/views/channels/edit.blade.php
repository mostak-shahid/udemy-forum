@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">Edit Channel: {{$channel->title}}</div>
                <div class="card-body">
                    <form action="{{route('channel.update', ['channel'=>$channel->id])}}" method="post">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{$channel->title}}" placeholder="Channel Title">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>

@endsection
