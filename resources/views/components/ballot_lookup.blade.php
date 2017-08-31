<div class="sidebar__box ballot-lookup">
    <h4>@lang('participa.ballot_lookup')</h4>
    <p>@lang('participa.ballot_lookup_help')</p>

    <form method="get" action="{{ url('ballot/lookup') }}">
        <label class="sr-only">@lang('participa.ballot_ref')</label>
        <div class="input-group">
            <input type="text" name="ref" class="form-control" placeholder="@lang('participa.ballot_ref')" aria-label="@lang('participa.ballot_ref')">
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
            </span>
        </div>
    </div>
</div>
