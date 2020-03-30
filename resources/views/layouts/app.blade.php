<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('fonts/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <style>
        .content img{max-width: 100%;height: auto;}
    </style>
    @yield('stylesheet')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong> {{Session::get('success')}}
            </div>            
            @endif 
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        @if(Auth::check())
                        <a class="btn btn-success btn-block mb-3" href="{{route('discussion.create')}}">Create a new Discussion</a>
                        @endif
                        <div class="card mb-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><a href="{{route('forum')}}">Home</a></li>
                                @if(Auth::check())
                                    <li class="list-group-item"><a href="{{route('forum')}}?filter=me">My Discussions</a></li>
                                @endif
                                <li class="list-group-item"><a href="{{route('forum')}}?filter=answered">Answered</a></li>
                            </ul>
                        </div>
                        @if(Auth::check())
                            @if(Auth::user()->admin)
                                <div class="card mb-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><a href="{{route('channel.create')}}">Create Channel</a></li>
                                    </ul>
                                </div>
                            @endif
                        @endif
                        <div class="card mb-3">
                            <div class="card-header">
                                Channels
                            </div>
                            <ul class="list-group list-group-flush">
                            @if($allchannels->count()>0)
                                @foreach($allchannels as $channel)
                                    <li class="list-group-item"><a href="{{route('channels.show',['channel'=>$channel->slug])}}">{{$channel->title}}</a></li>
                                @endforeach
                            @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script>
    @if(Session::has('success'))
    toastr.success("{{Session::get('success')}}");
    @endif 
    jQuery(document).ready(function($){  
        $(document).on('click', 'a[href^="#"]', function(e) {
            // target element id
            var id = $(this).attr('href');

            // target element
            var $id = $(id);
            if ($id.length === 0) {
                return;
            }

            // prevent standard hash navigation (avoid blinking in IE)
            e.preventDefault();

            // top position relative to the document
            var pos = $id.offset().top;

            // animated top scrolling
            $('body, html').animate({scrollTop: pos});
        });

    });    
    </script>
    @yield('script')
</body>
</html>
