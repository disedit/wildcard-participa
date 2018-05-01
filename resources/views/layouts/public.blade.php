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

    <link href="https://fonts.googleapis.com/css?family=Muli:400,600,700,900" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="/fonts/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="/fonts/fontawesome/css/fa-regular.min.css" rel="stylesheet">
    <link href="/fonts/fontawesome/css/fa-solid.min.css" rel="stylesheet">
    <link href="/fonts/fontawesome/css/fa-brands.min.css" rel="stylesheet">

    @include('components.metatags')
</head>
<body <?php if($inPerson) echo 'class="booth-mode"'; ?>>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', '{{ config('participa.google_analytics_ID', 'UA-106217417-1') }}', 'auto');
      ga('send', 'pageview');
    </script>

    @section('header')
        @include('components/header')

        @if(!$inPerson)
            @include('components/voteinfo')
        @endif
    @show

    <div class="main-background">
        <div class="container main-container">
            @isset($isArchive)
                <div class="alert alert-info mb-4"><i class="far fa-archive" aria-hidden="true"></i> @lang('participa.is_archive', ['end_date' => human_date($edition->end_date) . ' ' . date('Y', strtotime($edition->end_date))])</div>
            @endisset

            @yield('content')
        </div>
    </div>

    @section('footer')
        <div class="container">
            @include('components/footer')
        </div>
    @show


    <script>
        // Toggle Bootstrap menu without jQuery
        var toggler = document.getElementsByClassName('navbar-toggler')[0],
            collapse = document.getElementsByClassName('navbar-collapse')[0];

        function toggleMenu() {
            collapse.classList.toggle('collapse');
            collapse.classList.toggle('in');
        }

        function closeMenusOnResize() {
            if (document.body.clientWidth >= 768) {
                collapse.classList.add('collapse');
                collapse.classList.remove('in');
            }
        }

        window.addEventListener('resize', closeMenusOnResize, false);
        toggler.addEventListener('click', toggleMenu, false);
    </script>
    @stack('scripts')
</body>
</html>
