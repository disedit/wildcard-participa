@if(config('participa.facebook'))
    <li class="nav-item">
        <a href="{{ config('participa.facebook') }}" target="_blank" rel="noopener">
            <i class="fab fa-facebook" aria-hidden="true"></i>
        </a>
    </li>
@endif

@if(config('participa.twitter'))
    <li class="nav-item">
        <a href="https://twitter.com/{{ config('participa.twitter') }}" target="_blank" rel="noopener">
            <i class="fab fa-twitter-square" aria-hidden="true"></i> {{ '@' . config('participa.twitter') }}
        </a>
    </li>
@endif

@if(config('participa.council_url'))
    @php
        $simpleUrl = config('participa.council_url');
        $simpleUrl = preg_replace('/(https?\:\/\/)(www\.)?/', '', $simpleUrl);
    @endphp
    <li class="nav-item">
        <a href="{{ config('participa.council_url') }}" target="_blank" rel="noopener">
            <i class="fa fa-home" aria-hidden="true"></i> {{ $simpleUrl }}
        </a>
    </li>
@endif
