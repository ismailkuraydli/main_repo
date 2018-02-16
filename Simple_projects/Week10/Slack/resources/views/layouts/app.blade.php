<!DOCTYPE html>
{{HTML::style('css/styles.css')}}
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="container" class = "border">
            <div id= "sidebar" class = "col-md-2">
                 <div class="sidebar-text col-md-10">
                     Slack
                 </div> 
                <div class="rooms col-md-10">
                     {{$user->name}}
                 </div> 
                 <div class="rooms col-md-10">
                     Channels
                    <div class="col-md-10">
                        #Channel 1
                    </div>
                 </div> 
                 <div class="add-sign col-md-2">+</div> 
                <div class="rooms col-md-10">
                   Direct Messages 
                 </div> 
                 <div class="add-sign col-md-2">+</div> 
            </div>
            <div id = "nav" class = "col-md-10 col-md-offset-2">
                <div class="col-md-3">
                    Channel 1 
                </div>
                <div class="col-md-1 col-md-offset-8">
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>

            <div id= "content" class = "col-md-10 col-md-offset-2">
                 @yield('content')   
            </div>
            
        
    </div>
    <div id= "footer" class = "col-md-10 col-md-offset-2">
        <div id="input-container" class = "col-md-12">
            <input type="hidden" name="_token" id = "csrf-token" value = "{{Session::token()}}">
            <textarea name="chatmessage" placeholder="Enter Message" id="input-text-chat"></textarea>
        </div>
        
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- <script src="{{ asset('../../websocket/src/vendor/devristo/phpws/js/phpws.js') }}"></script> -->
</body>
</html>
