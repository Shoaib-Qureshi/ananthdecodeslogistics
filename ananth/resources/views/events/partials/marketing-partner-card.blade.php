<article class="event-partner-logo-card" role="listitem">
    <div class="event-partner-logo-card__visual">
        <img src="{{ $partner['logo'] }}" alt="{{ $partner['name'] }} logo" loading="lazy" width="720" height="360">
    </div>
    <div class="event-partner-logo-card__meta">
        <h3>{{ $partner['name'] }}</h3>
        @if(!empty($partner['role']))<p>{{ $partner['role'] }}</p>@endif
    </div>
</article>
