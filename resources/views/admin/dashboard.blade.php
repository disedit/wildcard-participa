@extends('layouts.admin')

@section('content')
    <div id="admin"></div>
@endsection

@push('scripts')
<script>
    window.app = {
        name: '{{ config('app.name', 'Wildcard Participa') }}',
        config: {!! json_encode(config('participa')) !!},
        user: {!! $user !!},
        edition_is_open: {!! $editionIsOpen !!}
    }
</script>
@endpush
