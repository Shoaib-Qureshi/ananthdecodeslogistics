@php
    $eventLinks = [
        'Overview'  => route('events.conference'),
        'Why & Who' => route('events.why-who'),
        'Register'  => route('events.register'),
        'Sponsor'   => route('events.sponsorship'),
        'FAQ'       => route('events.faq'),
    ];
@endphp

<div class="event-mini-nav" role="navigation" aria-label="Event pages">
    <div class="event-container">
        <div style="display:flex;align-items:center;gap:16px">
            {{-- LogiSphere brand mark --}}
            <a href="{{ route('events.conference') }}" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;flex-shrink:0;padding:6px 0" aria-label="LogiSphere home">
                <span style="font-family:'Playfair Display',Georgia,serif;font-size:.88rem;font-weight:500;color:#0f172a;letter-spacing:.01em;white-space:nowrap">LogiSphere</span>
            </a>
            <div style="width:1px;height:20px;background:#d8e3f0;flex-shrink:0"></div>
            <nav class="event-mini-nav__inner" style="flex:1">
                @foreach($eventLinks as $label => $url)
                    @php $isActive = url()->current() === $url; @endphp
                    <a href="{{ $url }}"
                       class="{{ $isActive ? 'is-active' : '' }}"
                       {{ $isActive ? 'aria-current="page"' : '' }}>{{ $label }}</a>
                @endforeach
            </nav>
        </div>
    </div>
</div>
