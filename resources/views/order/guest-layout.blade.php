<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Include your Tailwind CSS via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Or use Tailwind CDN if you are not using Vite: <script src="https://cdn.tailwindcss.com"></script> -->
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @yield('content')
    </body>
</html>