@extends('layouts.public')

@section('content')
<div class="container main-container">
    <h1>{{ $edition->name }}</h1>

    <div id="booth"></div>
</div>
@endsection

@section('scripts')
<!-- Scripts -->
<?php $booth_mode = (isset($booth_mode)) ? var_export($booth_mode, true) : 'false'; ?>
<script>
    window.BoothMode = {{ $booth_mode }};
    window.BoothConfig = {
        name: '{{ config('participa.municipality', 'Any City') }}',
        url: '{{ config('app.url', '') }}',
        council_url: '{{ config('participa.council_url', '') }}',
        anonymous_voting: {{ var_export(config('participa.anonymous_voting', true),true) }},
        min_age: {{ config('participa.min_age', 16) }},
        sms_max_attempts: {{ config('participa.sms_max_attempts', 3) }},
        max_per_ip: {{ config('participa.max_per_ip', 3) }}
    }
</script>
<script src="{{ mix('js/app.js') }}"></script>
@endsection
