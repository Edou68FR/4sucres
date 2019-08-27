<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
        {{--  <meta name="user-data" content="{{ json_encode(array_merge(user()->only(['id', 'name', 'email', 'api_token']), ['permissions' => user()->getPermissionsViaRoles()->pluck('name')])) }}" />
        <meta name="user-notification-count" content="{{ json_encode($notifications_count) }}" />  --}}
    @endauth

    <title>
        @hasSection ('title')
            @yield('title') - {{  config('app.name') }}
        @else
            {{  config('app.name') }}
        @endif
    </title>
    <meta name="description" content="Et vous, combien de sucres vous prenez dans votre café ?">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ mix('css/main.css') }}" rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('/img/icons/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ url('/img/icons/apple-touch-icon-152x152.png') }}">
    <link rel="icon" type="image/png" href="{{ url('/img/icons/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ url('/img/icons/favicon-16x16.png') }}" sizes="16x16">
    <link rel="shortcut icon" href="{{ url('/img/icons/favicon.ico') }}">
    <meta name="application-name" content="4sucres">
    <meta name="theme-color" content="#3b4252">
    <meta name="msapplication-TileColor" content="#3b4252">
    <meta name="msapplication-TileImage" content="{{ url('/img/icons/mstile-144x144.png') }}">

    @routes
    <script src="{{ mix('/js/app.js') }}" defer></script>
</head>

<body class="{{ $body_classes }}">
    @inertia
</body>

</html>
