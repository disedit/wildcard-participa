@php
    $docs = (!empty($edition->docs)) ? explode("\n", $edition->docs) : null;
    $places = (!empty($edition->voting_places)) ? explode("\n", $edition->voting_places) : null;
@endphp

<div class="sidebar">
    <div class="sidebar__box sidebar__box--main">
        <h4>@lang('sidebar.current_poll')</h4>
        <h3>{{ $edition->name }}</h3>
        <p class="sidebar__secondary">@lang('sidebar.dates', ['start_date' => human_date($edition->start_date), 'end_date' => human_date($edition->end_date)])</p>

        <div class="sidebar__social-plugins">
            @component('components.share_buttons', ['share' => 'false'])
                @lang('participa.tweet')
            @endcomponent
        </div>

        <div v-if="docs">
            <hr />
            <ul class="sidebar__list">
                <li class="sidebar__list__item">
                    @if(Request::segment(1) == 'about' && $edition->isOpen())
                        <a href="{{ url('') }}"><i class="fa fa-bullhorn" aria-hidden="true"></i>@lang('participa.vote')</a>
                    @elseif(Request::segment(3) == 'about')
                        <a href="{{ url('archive/' . $edition->id) }}"><i class="fa fa-bar-chart" aria-hidden="true"></i>@lang('participa.results')</a>
                    @elseif($edition->isOpen())
                        <a href="{{ url('about') }}"><i class="fa fa-info-circle" aria-hidden="true"></i>@lang('sidebar.more_info')</a>
                    @elseif(isset($isArchive))
                        <a href="{{ url('archive/' . $edition->id . '/about') }}"><i class="fa fa-info-circle" aria-hidden="true"></i>@lang('sidebar.more_info')</a>
                    @endif
                </li>
                @if(count($docs) > 0)
                    @forelse($docs as $doc)
                        @php
                            $part = explode(",", $doc);
                        @endphp
                        <li>
                            <a href="{{ $var = isset($part[1]) ? $part[1] : '' }}" target="_blank" rel="noopener" class="sidebar__list__item">
                                @isset($part[2])
                                    <i class="fa fa-{{ $part[2] }}" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                @endif

                                {{ $part[0] }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>

    @if(count($places) > 0)
        <div class="sidebar__box" v-if="voting_places">
            <h4>@lang('sidebar.voting_places')</h4>
            <p class="sidebar__secondary">@lang('sidebar.voting_text')</p>
            <hr />
            <ul class="sidebar__list">
                @foreach($places as $place)
                    @php
                        $part = explode(",", $place);
                    @endphp

                    <li>
                        <span class="sidebar__list__item">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>

                            <span>
                                {{ $part[0] }}

                                @isset($part[1])
                                    <span class="sidebar__secondary">{{ $part[1] }}</span>
                                @endisset
                            </span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!$edition->isPending())
        @component('components.ballot_lookup', ['in_sidebar' => true])
        @endcomponent
    @endif

    <div class="sidebar__box">
        <h4>@lang('sidebar.contact')</h4>
        <p>@lang('sidebar.contact_text', ['contact_email' => config('participa.contact_email')])</p>
    </div>

    @isset($pastEditions)
        @if(count($pastEditions) > 0)
            <div class="sidebar__box">
                <h4>@lang('sidebar.past_editions')</h4>

                <ul class="sidebar__list">
                @foreach($pastEditions as $edition)
                    <li class="sidebar__list__item">
                        <a href="{{ url('archive/' . $edition->id) }}">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> {{ human_month($edition->start_date) }}
                        </a>
                    </li>
                @endforeach
                </ul>
            </div>
        @endif
    @endisset

    <div>
        {!! $edition->sidebar !!}
    </div>
</div>
