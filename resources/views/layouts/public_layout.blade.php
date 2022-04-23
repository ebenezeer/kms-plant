<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KMS</title>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet">
    <link href="{{ asset('css/album.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <style>
    .jumbotron-image {
        background-position: center;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        min-height: 700px;
    }
    </style>
</head>

<body>
    <div id="app">
        <div class="container">
            <header class="blog-header py-3">
                <div class="row flex-nowrap justify-content-between align-items-center">
                    <div class="col-4 pt-1">

                    </div>
                    <div class="col-4 text-center">
                        <a class="blog-header-logo text-dark" href="#">Knowledge Management</a>
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <a class="text-muted" href="/login">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mx-3">
                                <circle cx="10.5" cy="10.5" r="7.5"></circle>
                                <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
                            </svg>
                        </a>
                        <a class="btn btn-sm btn-outline-secondary" href="/login">LOG IN</a>
                    </div>
                </div>
            </header>

            <div class="nav-scroller py-1 mb-2">
                <nav class="nav d-flex justify-content-between">
                    <a class="p-2 text-muted" href="/">Home</a>
                    <a class="p-2 text-muted" href="/">Plant Details</a>
                    <router-link class="p-2 text-muted" to="/public/method-details">Technology</router-link>
                    <a class="p-2 text-muted" href="#">Variety</a>
                    <a class="p-2 text-muted" href="#">Treatment</a>
                </nav>
            </div>

            <div class="jumbotron text-white jumbotron-image shadow"
                style="background-image: url(/avatar/Jumbotron.jpg);">

            </div>
            <!-- 
            <div class="jumbotron ext-white rounded">
                <div class="col-md-6 px-0">
                    <h1 class="display-4 font-italic">Content Here</h1>
                    <p class="lead my-3">Whats on your mind.</p>

                </div>
            </div> -->

            <div class="row">

                @yield('content')
            </div><!-- /.row -->

            </main><!-- /.container -->

            <footer class="blog-footer">
                <p>Thesis Project</p>
                <p>
                    <a href="#">Back to top</a>
                </p>
            </footer>
        </div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{asset('js/holder.min.js') }}"></script>
    <script>
    Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
    });
    </script>
</body>

</html>