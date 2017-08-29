<footer class="footer">
    <div class="row">
        <div class="col-2 council-logo">
            <img src="{{ public_path('images/council.png') }}" alt="{{ config('participa.council_name', 'Any Council') }}" />
        </div>
        <div class="col council-details">
            <address>
                <h5>{{ config('participa.council_name', 'Any Council') }}</h5>
                <p>
                    @if(config('participa.contact_address'))
                        <span><i class="fa fa-map-marker" aria-hidden="true"></i> {{ config('participa.contact_address') }}</span>
                    @endif

                    @if(config('participa.contact_phone'))
                        <span><i class="fa fa-phone" aria-hidden="true"></i> {{ config('participa.contact_phone') }}</span>
                    @endif

                    @if(config('participa.council_url'))
                        @php
                            $simpleUrl = config('participa.council_url');
                            $simpleUrl = preg_replace('/(https?\:\/\/)(www\.)?/', '', $simpleUrl);
                        @endphp
                        <span>
                            <a href="{{ config('participa.council_url') }}" target="_blank" rel="noopener">
                                <i class="fa fa-globe" aria-hidden="true"></i> {{ $simpleUrl }}
                            </a>
                        </span>
                    @endif
                </p>
                <p>@lang('participa.help'): <a href="mailto:{{ config('participa.contact_email', 'participa@disedit.com') }}">{{ config('participa.contact_email', 'participa@disedit.com') }}</a></p>
            </address>
        </div>
    </div>
</footer>
