@extends('layouts.app')

@section('content')

<h1>{{ $edition->name }}</h1>

<div id="booth"></div>

<?php /*
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ url ('/booth/sms') }}" id="vote">
    {{ csrf_field() }}
    <?php $old_options = old('options'); ?>

    @foreach($edition->questions as $question)
        <h2>{{ $question->question }}</h2>
        @foreach($question->options as $option)
            @if($question->max_options == 1)
                <?php  $checked = ($old_options && in_array($option->id, $old_options[$question->id])) ? 'checked="checked"' : ''; ?>
                <li><label><input type="radio" name="options[{{ $question->id }}][]" value="{{ $option->id }}" {{ $checked }}  /> {{ $option->option }}</label></li>
            @else
                <?php $checked = ($old_options && in_array($option->id, $old_options[$question->id])) ? 'checked="checked"' : ''; ?>
                <li><label><input type="checkbox" name="options[{{ $question->id }}][]" value="{{ $option->id }}" {{ $checked }}  /> {{ $option->option }}</label></li>
            @endif
        @endforeach
        <hr />
    @endforeach

<label>SID:</label> <input type="text" name="SID" value="{{ old('SID') }}" />
<label>Phone:</label> <input type="text" name="phone" value="{{ old('phone') }}" />

<input type="submit" value="Submit" />

</form> */ ?>
@endsection
