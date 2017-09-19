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

    <title>@yield('title'){{ config('app.name', 'Participa') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="/fonts/fontawesome/css/combined.css" rel="stylesheet">

    @include('components.metatags')
</head>
<body>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', '{{ config('participa.google_analytics_ID', 'UA-106217417-1') }}', 'auto');
      ga('send', 'pageview');
    </script>

    <div class="container main-container">
        @section('header')
            <header class="header row flex-column flex-sm-row">
                <div class="col-12 col-md-5 logo">
                    <a href="/">
                        <h1><img src="{{ secure_asset('images/' . config('participa.logo', 'logo.png')) }}" alt="{{ config('app.name', 'Participa') }}" /></h1>
                    </a>
                </div>
                <div class="col-12 col-md-7 links d-print-none">
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
            @else
                <hr />
            @endif
        @show

        @isset($isArchive)
            <div class="alert alert-info mb-4"><i class="far fa-archive" aria-hidden="true"></i> @lang('participa.is_archive', ['end_date' => human_date($edition->end_date) . ' ' . date('Y', strtotime($edition->end_date))])</div>
        @endisset

        @yield('content')

        @section('footer')
            <hr />

            @include('components/footer')
        @show
    </div>

    @stack('scripts')

</body>
</html>
