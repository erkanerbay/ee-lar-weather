<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <script>var config = {!! $config !!};</script>
</head>
<body>
<div class="d-flex flex-column justify-content-center">
    @include('header')
    <div id="app" class="container">
        <app-content></app-content>
    </div>
    @include('footer')
</div>
<script src="{{ asset('/js/app.js') }}"></script>
</body>
