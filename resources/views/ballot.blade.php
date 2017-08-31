@extends('layouts.public')

@section('content')
    <div class="ballot-receipt">
        <div class="ballot">
            <h3 class="ballot__edition">
                {{ $ballot->edition->name }}
                <a href="javascript:window.print()" class="pull-right btn-sm btn btn-success d-print-none"><i class="fa fa-print" aria-hidden="true"></i> @lang('participa.print')</a>
            </h3>
            <h2 class="ballot__ref">
                <img src="{{ url('api/ballot/qr/' . $ballot->ref) }}" alt="QR code" />
                {{ $ballot->ref }}
            </h2>

            <div class="ballot__contents">
                @foreach($ballot->decryptWithOptions() as $questionId => $content)
                    <h4>{{ $content['question']->question }}</h4>
                    <table class="table table-sm table-striped mt-3">
                        @foreach($content['options'] as $option)
                            <tr>
                                <td>{{ $option->option }}</td>
                                <td class="text-right">+{{ $content['points'][$option->id] }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endforeach
            </div>

            <div class="ballot__signature">
                {{ $ballot->signature }}
            </div>
        </div>
    </div>

    <div class="text-center mt-4">

    </div>
@endsection
