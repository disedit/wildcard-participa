<div class="social-links">
    <ul>
        @if(config('participa.facebook'))
            <li>
                <a href="{{ config('participa.facebook') }}" target="_blank" rel="noopener">
                    <i class="fa fa-facebook-square" aria-hidden="true"></i>
                </a>
            </li>
        @endif

        @if(config('participa.twitter'))
            <li>
                <a href="https://twitter.com/{{ config('participa.twitter') }}" target="_blank" rel="noopener">
                    <i class="fa fa-twitter-square" aria-hidden="true"></i> {{ '@' . config('participa.twitter') }}
                </a>
            </li>
        @endif

        @if(config('participa.council_url'))
            @php
                $simpleUrl = config('participa.council_url');
                $simpleUrl = preg_replace('/(https?\:\/\/)(www\.)?/', '', $simpleUrl);
            @endphp
            <li>
                <a href="{{ config('participa.council_url') }}" target="_blank" rel="noopener">
                    <i class="fa fa-home" aria-hidden="true"></i> {{ $simpleUrl }}
                </a>
            </li>
        @endif
    </ul>
</div>
