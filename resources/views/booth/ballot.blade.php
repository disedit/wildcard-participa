@extends('layouts.public')

@section('content')
<div class="container">
<h1>{{ $edition->name }}</h1>

<div id="booth"></div>
</div>
@endsection

@section('scripts')
<!-- Scripts -->
<?php $booth_mode = (isset($booth_mode)) ? var_export($booth_mode, true) : 'false'; ?>
<script>window.BoothMode = {{ $booth_mode }};</script>
<script src="{{ mix('js/app.js') }}"></script>
@endsection
