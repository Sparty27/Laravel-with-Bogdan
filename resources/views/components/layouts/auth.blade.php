<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ page()->getTitle() }}</title>

    @include('parts.layouts.favicon')

    @stack('meta-data')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="min-h-screen bg-[#faf9f0] flex items-center justify-center max-sm:px-5">
        @component('parts.layouts.card', [ 'class' => 'w-[450px]'])
            @yield('content')
        @endcomponent
</div>
</body>
</html>
