<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script src="https://kit.fontawesome.com/2a272cf09f.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    @guest

    <div id="app-guest" class="bg-primary">

    @else

    <div id="app-admin">

    @endguest

        @include('partials.menu')

        @guest

        <main class="py-4 bg-primary">
            @yield('content')
        </main>

        @else

        <main class="p-2 p-sm-3 p-md-5 pb-5 z-index-0">
            @yield('content')
        </main>

        @endguest

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('.toggle-menu').on('click', function() {
                $('#navbar-admin').toggleClass('z-index-1');
                $('#navbar-admin .navbar-brand').toggleClass('invisible');
                $('#navbar-admin-nav').toggleClass('d-none');
                $('#navbar-admin-nav').toggleClass('d-flex');
                $('.toggle-menu i').toggleClass('fas fa-2x fa-ellipsis-v');
                $('.toggle-menu i').toggleClass('fas fa-2x fa-times-circle');
            })
        });
    </script>

    @section('scripts')
    @show

</body>
</html>
