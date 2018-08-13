@php
    $languages = config('participa.languages');
    $current_language = config('app.locale', 'ca');
@endphp

<ul class="languages" role="presentation">
    <li class="languages__current">
        <a href="javascript:;" title="@lang('participa.current_language')" role="button" aria-disabled="true">
            {{ $languages[$current_language] }}
            <i class="fa fa-caret-down" aria-hidden="true"></i>
         </a>

        <ul class="languages__menu" role="presentation">
            @foreach ($languages as $code => $language)
                @unless ($current_language == $code)
                    <li>
                        <a href="{{ secure_url('lang/' . $code) }}" lang="{{ $code }}">
                            {{ $language }}
                        </a>
                    </li>
                @endunless
            @endforeach
        </ul>
    </li>
</ul>
