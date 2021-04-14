<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ee-lar-weather</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body class="h-100">
<div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
    @include('header')
    <div id="app">
        <example-component></example-component>
    </div>
    @include('footer')
</div>
<script src="{{ asset('/js/app.js') }}"></script>
</body>
