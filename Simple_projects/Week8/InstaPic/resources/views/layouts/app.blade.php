<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
{{HTML::style('css/styles.css')}}
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
    <div id="app">
        <div class="row">
            <nav class="col-md-12 nav-insta">
                <div class="col-md-10 col-md-offset-2">
                    <div class="col-md-2">
                        <a class="navbar-brand" href="{{ url('/dashboard') }}">
                            <svg version="1.1" id="logo-insta" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                width="30px" height="30px" viewBox="0 0 169.063 169.063" style="enable-background:new 0 0 169.063 169.063;"
                                xml:space="preserve">
                                <path d="M122.406,0H46.654C20.929,0,0,20.93,0,46.655v75.752c0,25.726,20.929,46.655,46.654,46.655h75.752
                                    c25.727,0,46.656-20.93,46.656-46.655V46.655C169.063,20.93,148.133,0,122.406,0z M154.063,122.407
                                    c0,17.455-14.201,31.655-31.656,31.655H46.654C29.2,154.063,15,139.862,15,122.407V46.655C15,29.201,29.2,15,46.654,15h75.752
                                    c17.455,0,31.656,14.201,31.656,31.655V122.407z"/>
                                <path d="M84.531,40.97c-24.021,0-43.563,19.542-43.563,43.563c0,24.02,19.542,43.561,43.563,43.561s43.563-19.541,43.563-43.561
                                    C128.094,60.512,108.552,40.97,84.531,40.97z M84.531,113.093c-15.749,0-28.563-12.812-28.563-28.561
                                    c0-15.75,12.813-28.563,28.563-28.563s28.563,12.813,28.563,28.563C113.094,100.281,100.28,113.093,84.531,113.093z"/>
                                <path d="M129.921,28.251c-2.89,0-5.729,1.17-7.77,3.22c-2.051,2.04-3.23,4.88-3.23,7.78c0,2.891,1.18,5.73,3.23,7.78
                                    c2.04,2.04,4.88,3.22,7.77,3.22c2.9,0,5.73-1.18,7.78-3.22c2.05-2.05,3.22-4.89,3.22-7.78c0-2.9-1.17-5.74-3.22-7.78
                                    C135.661,29.421,132.821,28.251,129.921,28.251z"/>
                            </svg>
                        </a>
                        <div class = "border-split"></div>
                        <div class = "add-post">
                            <a href="{{url('/post/create')}}" class="add-post">Add Post</a>
                        </div>
                        
                    </div>
                    <div class="col-md-5 search-field">
                    </div>
                            <ul class="col-md-4 col-md-offset-1 nav-icons">
                                <li>
                                    <a class="col-md-1 insta-icon" href="{{ url('/explore') }}">
                                        <svg version="1.1" width="30px" height="30px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 64.292 64.292" style="enable-background:new 0 0 64.292 64.292;" xml:space="preserve">
                                            <path d="M32.146,64.292c7.824,0,15.18-3.047,20.713-8.581c5.533-5.532,8.58-12.888,8.58-20.712s-3.047-15.18-8.58-20.712
                                                c-4.094-4.094-9.188-6.823-14.729-7.968C38.136,6.214,38.146,6.107,38.146,6c0-3.309-2.691-6-6-6s-6,2.691-6,6
                                                c0,0.107,0.01,0.213,0.016,0.32c-5.542,1.145-10.635,3.874-14.729,7.968C5.9,19.82,2.854,27.176,2.854,35s3.047,15.18,8.58,20.712
                                                C16.965,61.245,24.32,64.292,32.146,64.292z M32.146,2c2.2,0,3.989,1.785,3.998,3.983c-1.314-0.178-2.648-0.275-3.998-0.275
                                                s-2.684,0.097-3.998,0.275C28.156,3.785,29.945,2,32.146,2z M12.847,15.702c4.918-4.918,11.384-7.723,18.299-7.97V12h2V7.732
                                                c6.915,0.248,13.38,3.052,18.299,7.97C56.362,20.62,59.167,27.086,59.414,34h-4.268v2h4.268
                                                c-0.248,6.914-3.051,13.38-7.969,18.298c-4.919,4.918-11.384,7.723-18.299,7.97V58h-2v4.268
                                                c-6.915-0.248-13.381-3.052-18.299-7.97S5.125,42.914,4.878,36h4.268v-2H4.878C5.125,27.086,7.929,20.62,12.847,15.702z"/>
                                            <path d="M37.507,40.932l0.56-0.544l8-19l-1.31-1.31l-19,8l-0.544,0.56l-7,18l1.294,1.294L37.507,40.932z M36.8,38.241
                                                l-8.896-8.896l15.367-6.471L36.8,38.241z M26.521,30.791l8.833,8.833L20.9,45.245L26.521,30.791z"/>
                                    </a>
                                </li>
                                <li>
                                    <a class="col-md-1 col-md-offset-1 insta-icon" href="{{ url('/profile/view') }}">
                                        <svg version="1.1" width="30px" height="30px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 488.9 488.9" style="enable-background:new 0 0 488.9 488.9;" xml:space="preserve">
                                            <path d="M477.7,454.8v-26c0-26.5-12.4-52-33.1-68.1c-48.2-37.4-97.3-63.5-114.5-72.2v-29.7c3.5-7.8,6.4-16.3,8.6-25.5
                                                c12.8-4.6,19.8-23.4,24.5-40c6.3-22.1,5.6-37.6-1.8-46.2c7.8-42.5,4.3-73.8-10.3-93.1c-7.7-10.1-16.7-14.4-22.7-16.3
                                                c-4.3-6-13-16.1-27.7-24.2C285.5,4.5,268.4,0,249.6,0c-3.4,0-6.8,0.2-9.8,0.4c-8.4,0.4-16.7,2-24.9,4.7c-0.1,0-0.2,0.1-0.3,0.1
                                                c-9,3.1-17.8,7.6-26.3,13.4c-9.7,6.2-18.6,13.6-26.3,21.8c-15.1,15.5-25.1,33-29.4,51.7c-4.1,15.5-4.4,31.1-1,46.4
                                                c-1.8,1.3-3.4,2.8-4.8,4.6c-6.9,9.1-7.2,23.4-1.1,45.1c4.2,15,9.8,30.3,19.3,37.2c2.8,14.4,7.5,27.5,13.8,39.1v24.1
                                                c-17.2,8.7-66.3,34.7-114.5,72.2c-20.7,16.1-33.1,41.5-33.1,68.1v26c0,18.8,15.3,34,34,34h398.5
                                                C462.4,488.9,477.7,473.6,477.7,454.8z M35.6,454.8v-26c0-19,8.8-37.2,23.6-48.7c52-40.3,104.9-66.9,115-71.8
                                                c5.6-2.7,9.1-8.3,9.1-14.6v-32.5c0-2.2-0.6-4.3-1.7-6.2c-6.6-11.2-11.2-24.6-13.5-39.9c-0.8-4.9-4.4-8.8-9.1-10
                                                c-1.3-1.5-5-6.9-9.7-23.6c-3.9-13.8-3.6-20.2-3.2-22.5c3.9,0.2,7.8-1.6,10.3-4.7c2.6-3.3,3.3-7.7,1.9-11.6
                                                c-5.2-14.5-5.8-29.4-1.8-44.6c3.4-14.6,11.2-28.2,23.3-40.6c6.5-7,14-13.1,22-18.2c0.1-0.1,0.3-0.2,0.4-0.3
                                                c6.7-4.7,13.7-8.2,20.6-10.6c0.1,0,0.2-0.1,0.2-0.1c5.9-2,12-3.1,18.4-3.4c17.5-1.5,33.2,1.8,47.1,9.9
                                                c15.2,8.4,21.4,19.4,21.4,19.4c1.9,3.9,5.3,6.2,9.7,6.5c0.3,0,6.8,1,12.4,8.9c5.9,8.4,14.3,30,3.8,80.4c-1.2,5.6,1.7,11.2,6.8,13.6
                                                c0.5,1.8,1.3,7.9-3,23.1c-3.8,13.4-6.9,19.5-8.7,22.2c-2.3-0.4-4.7-0.2-6.9,0.8c-3.8,1.6-6.6,5.1-7.3,9.1c-2.1,12-5.5,22.8-9.9,32
                                                c-0.8,1.7-1.2,3.5-1.2,5.3v37.6c0,6.3,3.5,11.8,9.1,14.6c10.1,4.9,63,31.6,114.9,71.8c14.8,11.5,23.6,29.7,23.6,48.7v26
                                                c0,5.2-4.3,9.5-9.5,9.5H45.2C39.9,464.4,35.6,460.1,35.6,454.8z"/>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a class="col-md-1 col-md-offset-1 insta-icon" href="{{ url('/inbox') }}">
                                        <svg version="1.1" width="30px" height="30px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 59 59" style="enable-background:new 0 0 59 59;" xml:space="preserve">
                                            <path d="M20.187,28.313c-0.391-0.391-1.023-0.391-1.414,0s-0.391,1.023,0,1.414l9.979,9.979C28.938,39.895,29.192,40,29.458,40
                                                c0.007,0,0.014-0.004,0.021-0.004c0.007,0,0.013,0.004,0.021,0.004c0.333,0,0.613-0.173,0.795-0.423l9.891-9.891
                                                c0.391-0.391,0.391-1.023,0-1.414s-1.023-0.391-1.414,0L30.5,36.544V1c0-0.553-0.447-1-1-1s-1,0.447-1,1v35.628L20.187,28.313z"/>
                                            <path d="M36.5,16c-0.553,0-1,0.447-1,1s0.447,1,1,1h13v39h-40V18h13c0.553,0,1-0.447,1-1s-0.447-1-1-1h-15v43h44V16H36.5z"/>
                                        </a>
                                </li>
                            </ul>
                </div>
            </nav>
        </div>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
