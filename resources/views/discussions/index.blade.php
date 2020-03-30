@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">Discussions</div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($discussions->count()>0)
                        @foreach($discussions as $discussion)
                        <tr>                                
                            <td><a href="{{route('discussion.show',['discussion'=>$discussion->slug])}}">{{$discussion->title}}</a></td>
                            <td><a href="{{route('discussion.edit',['discussion'=>$discussion->id])}}" class="btn btn-info btn-sm">Edit</a></td>
                            <td>
                                <form action="{{route('discussion.destroy',['discussion'=>$discussion->id])}}" method="post">
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
                <div class="text-center">{{$discussions->links()}}</div>
                <!-- <div class="card-body"></div> -->
            </div>

@endsection
