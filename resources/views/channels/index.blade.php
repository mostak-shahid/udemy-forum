@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">Channels</div>                
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($channels->count()>0)
                        @foreach($channels as $channel)
                        <tr>                                
                            <td>{{$channel->title}}</td>
                            <td><a href="{{route('channel.edit',['channel'=>$channel->id])}}" class="btn btn-info btn-sm">Edit</a></td>
                            <td>
                                <form action="{{route('channel.destroy',['channel'=>$channel->id])}}" method="post">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr><td colspan="3" class="text-center"><strong>Nothing Found</strong></td></tr>
                    @endif
                    </tbody>
                </table>
                <div class="text-center">{{$channels->links()}}</div>
                <!-- <div class="card-body"></div> -->
            </div>

@endsection
