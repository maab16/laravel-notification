<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                           <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <button type="button" class="btn btn-primary" id="notification" data-user="{{ Auth::user()->id }}">
                                      Notification <span class="badge badge-light" id="total_notification">{{count(Auth::user()->unreadNotifications)}}</span>
                                    </button>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <ul>
                                        @foreach(Auth::user()->unreadNotifications as $notification)
                                            <li class="unread_notification" style="background-color: #ddd">{{ $notification->data['confirm_message'] }}</li>
                                        @endforeach
                                        @foreach(Auth::user()->readNotifications as $notification)
                                            <li>{{ $notification->data['confirm_message'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script type="text/javascript">
        {{-- var APP_URL = {!! json_encode(url(config('app.url'))) !!}; --}}
        var APP_URL = {!! json_encode(url('/')) !!};
        jQuery(document).ready(function($) {
            $('#notification').on("click",function(e){
                e.preventDefault();
                
                var id = $(this).data("user");
                var response = $.ajax({
                    url: APP_URL+'/notification/markAsRead/'+id,
                    type: 'GET',
                    dataType: 'json',
                    async: false,
                    data: {
                        
                    },
                    success: function(data) {
                       $('.unread_notification').css({
                            backgroundColor: 'transparent'
                        });
                    }
                }).responseText;
                var obj = JSON.parse(response);
   
                $(this).find('#total_notification').html(obj.total);
                
            }); 
        });
</script>
</body>
</html>
