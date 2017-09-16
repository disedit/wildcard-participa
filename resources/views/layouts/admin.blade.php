<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($token)
        <meta name="jwt-token" content="{{ $token }}">
    @endisset

    <title>Admin</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
    <link href="/fonts/fontawesome/css/combined.css" rel="stylesheet">

</head>
<body>
    @yield('content')

    @stack('scripts')
</body>
</html>
