<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,  maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset(get_option('primary_data',true)['favicon'] ?? '') }}" type="image/png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">

    <meta name="app-name" content="{{ config('app.name') }}" />
    <meta name="app-translations" content="{{ getTranslationFile() }}" />
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <script>
        "use strict"
        if (
            localStorage.getItem('theme') === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-toastr.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/css/payment.css') }}">

    <script src="{{ asset('assets/js/initialLoader.js') }}" async></script>
    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/scss/admin/main.scss'])
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-tiptap.css') }}" media="all">
    @inertiaHead
</head>

<body>
    @include('layouts.loader')

    @routes()
    @inertia
</body>

</html>