<div class="vote-info {{ (!Request::segment(1)) ? 'vote-info--full' : 'vote-info--compact' }}">
    <div class="left-hands"></div>
    <div class="right-hands"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 vote-info__text">
                <h2>@lang('participa.heading')</h2>
                <p class="vote-info__intro">@lang('participa.subheading')</p>
                <p class="vote-info__action">
                    @if($edition->isOpen())
                        <a href="#content" class="big-button"><i aria-hidden="true" class="fa fa-bullhorn"></i> Vote</a>
                    @elseif($edition->inProposalPhase())
                        <a href="{{ secure_url('propose') }}" class="big-button"><i aria-hidden="true" class="fa fa-comment"></i> Envia la teua proposa</a>
                    @elseif($edition->isPending())
                        <a href="#content" class="big-button"><i aria-hidden="true" class="fa fa-info-circle"></i> Més informació</a>
                    @elseif($edition->resultsPublished())
                        <a href="#content" class="big-button"><i aria-hidden="true" class="fa fa-chart-bar"></i> Resultats</a>
                    @endif
                </p>
            </div>

            <div class="col-md-4">
                @include('components/calendar')
            </div>
        </div>
    </div>
</div>
