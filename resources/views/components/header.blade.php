<header class="header header-colorful row flex-column flex-sm-row">
    <div class="header-logo col-md-5 col-xs-">
        <a href="/">
            <h1><img src="{{ secure_asset('images/' . config('participa.logo', 'logo.png')) }}" alt="{{ config('app.name', 'Participa') }}" /></h1>
        </a>
    </div>
    <div class="col-12 col-md-7 header-links d-print-none">
        @include('components/social')
        @include('components/languages')
    </div>
</header>
