@extends('layouts.public')

@section('content')
<div class="row">
    <div class="col-md-8">
        {!! $edition->about !!}
    </div>
    <div class="col-md-4">
        @include('components/sidebar')
    </div>
</div>
@endsection
