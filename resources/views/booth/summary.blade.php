@extends('layouts.app')

@section('content')

    {{ var_dump($flag) }}

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @foreach(old('options') as $question => $options)
        <?php $question_key = array_search($question, array_column($questions, 'id')); ?>
        {{ $questions[$question_key]['question'] }}

        @foreach($options as $option)
            <?php $option_key = array_search($option, array_column($questions[$question_key]['options'], 'id')); ?>
            <li>{{ $questions[$question_key]['options'][$option_key]['option'] }}</li>
        @endforeach
    @endforeach

    <form method="POST" action="{{ url('ballot/cast') }}">
        {{ csrf_field() }}
        <input type="hidden" name="SID" value="{{ old('SID') }}" />
        <input type="hidden" name="phone" value="{{ old('phone') }}" />

        @foreach(old('options') as $question => $options)
            @foreach($options as $option)
                <input type="hidden" name="options[{{ $question }}][]" value="{{ $option }}" />
            @endforeach
        @endforeach

        <input type="text" name="sms_code" />
        <button type="submit">Submit</button>
    </form>

@endsection
