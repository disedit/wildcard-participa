@php
    $inPerson = (isset($inPerson)) ? $inPerson : false;
@endphp
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

    <title>{{ config('app.name', 'Participa') }}</title>

    <link href="https://rsms.me/interface/interface.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div class="container main-container">
        @section('header')
            <header class="header row">
                <div class="col-sm-6">
                    <h1><img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Participa') }}" /></h1>
                </div>
                <div class="col-sm-6">
                    @include('components/social')
                    @include('components/languages')
                </div>
            </header>
            @if(!$inPerson)
                <div class="row">
                    <div class="col">
                        @include('components/voteinfo')
                    </div>
                </div>
            @endif
        @show

        @yield('content')

        @section('footer')
            <hr />

            <footer class="footer">
                <div class="row">
                    <div class="col-2 council-logo">
                        <img src="{{ public_path('images/council.png') }}" alt="{{ config('participa.council_name', 'Any Council') }}" />
                    </div>
                    <div class="col council-details">
                        <address>
                            <h5>{{ config('participa.council_name', 'Any Council') }}</h5>
                            <p>
                                <i class="fa fa-map-marker" aria-hidden="true"></i> {{ config('participa.contact_address') }}
                                <i class="fa fa-phone" aria-hidden="true"></i> {{ config('participa.contact_phone') }}
                            </p>
                            <p>@lang('participa.help'): <a href="mailto:{{ config('participa.contact_email', 'participa@disedit.com') }}">{{ config('participa.contact_email', 'participa@disedit.com') }}</a></p>
                        </address>
                    </div>
                </div>
            </footer>
        @show
    </div>

    @stack('scripts')

</body>
</html>
