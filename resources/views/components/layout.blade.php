<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '' }} | {{config('app.name')}}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>


    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <x-html.meta :metaTags="$metaTags"/>

</head>
<body class="{{\Illuminate\Support\Facades\Request::segment(1)}} text-base container-fluid">

<header class="py-10 mb-5 bg-gray-300">Header</header>

<div class="px-10 mx-auto">
    {{ $slot }}
</div>

<footer class="py-10 mt-5 bg-gray-300">Footer</footer>

</body>
</html>
