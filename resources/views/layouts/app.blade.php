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
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <x-header></x-header>
    <div class="container">

        <!-- フラッシュメッセージ -->
        @if (session('msg_success'))
        <div class="row">
            <div class="col-sm-5 col-md-4 col-lg-3 offset-lg-1">
                <div class="alert alert-success">
                    {{ session('msg_success') }}
                </div>
            </div>
        </div>
        @endif

        <div id="app">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>