@extends('layouts.admin')

@section('content')
<div class="login">
    <div class="card">
        <div class="card-header sr-only">Login</div>
        <div class="card-block">
            <h1 class="login__logo"><img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Participa') }}" /></h1>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                    <label for="username" class="sr-only">Username</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="user-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus aria-describedby="user-icon">
                    </div>

                    @if ($errors->has('username'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password" class="sr-only">Password</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="key-icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>

                    @if ($errors->has('password'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Entra
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
