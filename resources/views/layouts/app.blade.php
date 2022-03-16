<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="content-type" content="text/plain; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KMS</title>

    <!-- Scripts -->

    <script src="{{ mix('js/app.js') }}" defer></script>
    <!-- <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> -->

  

   
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="{{asset('fileinput/css/fontawesome5.css')}}" crossorigin="anonymous"> -->
   
    <!-- <script src="{{asset('fileinput/themes/explorer-fas/theme.js')}}" type="text/javascript"></script> -->
    <!-- file input -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- <link rel="ICON" href="/mmsu_logo_icon.ico" type="image/ico" /> -->
    <style>
        .sidebar {
            /* don't forget to add all the previously mentioned styles here too */
            background: #7386D5;
            color: #fff;
            transition: all 0.3s;

            /*  */
            background: #BBD2C5;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(180deg, #292E49, #536976, #BBD2C5);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(180deg, #292E49, #536976, #BBD2C5);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            /*  */


            /* background: linear-gradient(0deg, rgba(11, 93, 2, 1) 0%, rgba(113, 120, 23, 1) 0%, rgba(0, 0, 0, 1) 92%); */

        }



        .sidebar .nav-item .nav-link {
            font-size: 15px;
            color: #ffffff;


        }

        .footer {
            /* position: fixed; */
            left: 0;
            bottom: 0;
            width: 100%;
            height: 1%;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-dark p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/home">Plant Grafting</a>
            <ul class="nav navbar-nav mr-auto"></ul>
            <ul class="navbar-nav px-3">


                <li class="nav-item dropdown">

                    <a class="nav-link">
                        {{ Auth::user()->name }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </li>
            </ul>
        </nav>

        @if(Auth::user()->role == 1)
        <admin-sidebar></admin-sidebar>
        @endif
        @if(Auth::user()->role == 2)
        <expert-sidebar></expert-sidebar>
        @endif

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                @yield('content')
            </div>

            <footer class="sticky-footer">
                <div class="container">
                    <div class="text-center">
                        <small>© Project {{date("Y")}}</small>
                    </div>
                </div>
            </footer>
        </main>



    </div>
    <!-- <footer class="footer py-4 bg-dark flex-shrink-0">
        <div class="container-fluid text-center">
            <a href="https://www.mmsu.edu.ph" class="text-muted">Mariano Marcos State University <i class="fa fa-copyright"></i></a>



        </div>
    </footer> -->


    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script>
        feather.replace()
    </script>

</body>

</html>