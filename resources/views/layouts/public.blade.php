<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($token))
        <meta name="jwt-token" content="{{ $token }}">
    @endif

    <title>{{ config('app.name', 'Wildcard Participa') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>

    <div class="container">
        <header>
            Header
        </header>
    </div>

    @yield('content')

    <div class="container">
        <footer>
            Footer
        </footer>
    </div>

    @yield('scripts')

</body>
</html>
