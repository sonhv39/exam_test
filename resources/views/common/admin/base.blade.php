<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>THK Holdings Vietman Hanoi</title>
        {{-- individual CSS --}}
        {{-- @vite('resources/css/reset.css') --}}
        @vite('resources/css/admin/base.css')
        @vite('resources/scss/admin/side-menu.scss')
        @vite('resources/scss/admin/base.scss')
        @yield('custom_css')
    </head>
    <body>
        <div class="container">
            <x-admin.side-menu />
            @yield('main_contents')
        </div>
        @yield('page_js')
    </body>
</html>
