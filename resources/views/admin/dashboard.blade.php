@extends('layouts.admin')

@section('content')

<h1>Admin</h1>

<form method="POST" action="/logout">
    {{ csrf_field() }}
    <button type="submit">Logout</button>
</form>
@endsection
