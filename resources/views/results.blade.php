@extends('layouts.public')

@section('content')
<div class="row results-page">
    <div class="col-md-8">
        <h2><i class="fa fa-bar-chart" aria-hidden="true"></i> @lang('participa.results')</h2>

        <table class="census table table-bordered">
            @if(config('participa.display_census_number'))
                <colgroup>
                    <col width="25%" />
                    <col width="25%" />
                    <col width="25%" />
                    <col width="25%" />
                </colgroup>
            @else
                <colgroup>
                    <col width="50%" />
                    <col width="50%" />
                </colgroup>
            @endif
            <tbody>
                <tr>
                    @if(config('participa.display_census_number'))
                        <th class="text-right">@lang('participa.census')</th>
                        <td>{{ number($census, 0) }}</td>
                    @endif
                    <th class="text-right">@lang('participa.turnout')</th>
                    <td>
                        {{ number($turnout, 0) }}
                        @if(config('participa.display_census_number'))
                            <span class="results__points">{{ number(($turnout * 100 / $census), 2) . '%' }}</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        @foreach($results as $block)
            @php
                $classes = [
                    1 => 'col-sm-12',
                    2 => 'col-sm-6',
                    3 => 'col-sm-4',
                    4 => 'col-sm-6',
                ];
                $resultsToHighlight = $block['results_to_highlight'];
                $topResults = collect($block['options']);
                $results = $topResults->splice($resultsToHighlight);
                $pos = 0;
            @endphp
            <div class="results">
                <h3>{{ $block['question'] }}</h3>

                @if($resultsToHighlight > 0)
                    <h4 class="results__section results__section--top">{{ trans_choice('participa.top_results', $resultsToHighlight, ['num' => $resultsToHighlight]) }}</h4>

                    <div class="row">
                        @foreach($topResults->all() as $option)
                            @php
                                $pos++;
                            @endphp

                            <div class="d-flex justify-content-center {{ $class = ($resultsToHighlight <= 4) ? $classes[$resultsToHighlight] : 'col-sm-4' }}">
                                <a href="" class="results__card">
                                    <span class="results__pos">{{ $pos }}</span>
                                    <h5>{{ $option['option'] }}</h5>

                                    <div class="results__votes">
                                        <div class="results__points">{{ number($option['points'], 0) }} {{ trans_choice('participa.votes', $option['points']) }}</div>
                                        <div class="progress">
                                            <div class="d-flex" style="width: {{ $option['percentage'] . '%' }}" aria-valuenow="{{ $option['percentage'] }}" aria-valuemin="0" aria-valuemax="100" role="progressbar">
                                                <div class="progress-bar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    @if(count($results->all()) > 0)
                        <h4 class="results__section results__section--other">@lang('participa.other_results')</h4>
                    @endif
                @endif

                @if(count($results->all()) > 0)
                    <table class="table table-bordered">
                        <colgroup>
                            <col width="40" />
                            <col />
                            <col width="150" />
                            <col width="60" />
                        </colgroup>

                        <tbody>
                            @foreach($results->all() as $option)
                                @php
                                    $pos++;
                                @endphp

                                <tr>
                                    <td class="text-right align-middle">{{ $pos }}.</td>
                                    <td><a href="">{{ $option['option'] }}</a></td>
                                    <td class="align-middle">
                                        <div class="progress">
                                            <div class="d-flex" style="width: {{ $option['percentage'] . '%' }}" aria-valuenow="{{ $option['percentage'] }}" aria-valuemin="0" aria-valuemax="100" role="progressbar">
                                                <div class="progress-bar"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right align-middle">{{ number($option['points'], 0) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach
    </div>
    <div class="col-md-4">
        @include('components/sidebar')
    </div>
</div>
@endsection
