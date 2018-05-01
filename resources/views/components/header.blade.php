@php
    $logoUrl = (config('participa.navbar') == 'colorful')
                    ? config('participa.logo_dark')
                    : config('participa.logo');
@endphp

<nav class="navbar fixed-top navbar-expand-lg {{ (config('participa.navbar') == 'colorful') ? 'navbar-dark' : 'navbar-light' }}">
  <a class="navbar-brand" href="/">
        {{ $logoUrl }}
        @if($logoUrl)
            <img src="{{ secure_asset('images/' . $logoUrl) }}" alt="{{ config('app.name', 'Participa') }}" />
        @else
            {{ config('app.name', 'Participa') }}
        @endif
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav navbar-social ml-auto">
        @include('components/social')
    </ul>

    <ul class="navbar-nav navbar-languages">
      <li class="nav-item">
        @include('components/languages')
      </li>
    </ul>
  </div>
</nav>
