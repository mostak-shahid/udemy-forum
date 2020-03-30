@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">Add new Channels:</div>
                <div class="card-body">
                    <form action="{{route('channel.store')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Channel Title">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Channel</button>
                    </form>
                </div>
            </div>

@endsection
