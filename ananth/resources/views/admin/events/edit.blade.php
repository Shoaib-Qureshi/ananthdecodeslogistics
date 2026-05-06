<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Edit LogiSphere Event</title>
    @include('admin.events.partials.styles')
</head>
<body>
@include('admin.adminHeader')
<section class="main_section">
    <div class="container-fluid">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

        <div class="event-admin-hero">
            <div>
                <h2>{{ $event->exists ? 'Edit: ' . $event->name : 'Create New Event' }}</h2>
                <p>Manage public event pages, agenda, FAQs, sponsor currency, and tax settings.</p>
            </div>
            <div class="event-admin-actions">
                <a class="event-admin-btn" href="{{ route('admin.events.index') }}">← All Events</a>
                @if($event->exists)
                    <a class="event-admin-btn" href="{{ route('events.conference') }}" target="_blank">View Event</a>
                    <a class="event-admin-btn" href="{{ route('admin.events.packages') }}">Sponsor Packages</a>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ $formAction ?? route('admin.events.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="event-admin-card">
                <h3>Event Basics</h3>
                <div class="event-admin-grid">
                    <label>Name <input name="event[name]" value="{{ old('event.name', $event->name) }}" required></label>
                    <label>Chapter <input name="event[chapter]" value="{{ old('event.chapter', $event->chapter) }}"></label>
                    <label>Tagline <input name="event[tagline]" value="{{ old('event.tagline', $event->tagline) }}"></label>
                    <label>Date <input type="date" name="event[event_date]" value="{{ old('event.event_date', optional($event->event_date)->format('Y-m-d')) }}"></label>
                    <label>Location (City) <input name="event[location]" value="{{ old('event.location', $event->location) }}"></label>
                    <label>Format/Time Note <input name="event[event_time]" value="{{ old('event.event_time', $event->event_time) }}"></label>
                    <label>Venue Name <input name="event[venue_name]" value="{{ old('event.venue_name', $event->venue_name) }}" placeholder="e.g. The Leela Palace, Bengaluru"></label>
                    <label>Venue Address <input name="event[venue_address]" value="{{ old('event.venue_address', $event->venue_address) }}" placeholder="Full street address"></label>
                </div>
                <div style="margin-top:14px">
                    <label style="display:block;margin-bottom:4px">Venue Map Embed URL
                        <input name="event[venue_map_embed]" value="{{ old('event.venue_map_embed', $event->venue_map_embed) }}" placeholder="Paste the src URL from Google Maps > Share > Embed a map">
                    </label>
                    <p style="font-size:.75rem;color:#94a3b8;margin:4px 0 0">In Google Maps: click Share → Embed a map → copy only the URL inside <code>src="..."</code></p>
                </div>
                <div style="margin-top:14px">
                    <label style="display:block;margin-bottom:4px;font-weight:600">Hero Image</label>
                    <div style="display:flex;flex-direction:column;gap:10px">
                        <div>
                            <label style="display:block;font-size:.8rem;color:#64748b;margin-bottom:4px;font-weight:400">Upload from device</label>
                            <input type="file" name="hero_image_file" accept="image/*" style="display:block;font-size:.85rem;color:#334155;padding:6px 0">
                            <p style="font-size:.75rem;color:#94a3b8;margin:3px 0 0">JPEG, PNG, WebP — max 4 MB. Uploading a file replaces the URL below.</p>
                        </div>
                        <div>
                            <label style="display:block;font-size:.8rem;color:#64748b;margin-bottom:4px;font-weight:400">Or enter an image URL</label>
                            <input name="event[hero_image]" value="{{ old('event.hero_image', $event->hero_image) }}" placeholder="https://… (full URL to image)">
                        </div>
                    </div>
                    @if($event->hero_image)
                        <div style="margin-top:10px;display:flex;align-items:center;gap:10px">
                            <img src="{{ $event->hero_image }}" alt="Hero preview" style="height:56px;border-radius:8px;border:1px solid #d8e3f0;object-fit:cover;width:120px">
                            <span style="font-size:.78rem;color:#64748b">Current hero image</span>
                        </div>
                    @endif
                </div>
            </div>

            <nav class="event-page-nav" aria-label="Event page content shortcuts">
                <a href="#event-main-page"><div><strong>Main Event Page</strong><span>/events/conference</span></div></a>
                <a href="#event-why-page"><div><strong>Why & Who Page</strong><span>/events/why-who</span></div></a>
                <a href="#event-sponsor-page"><div><strong>Sponsorship Page</strong><span>/events/sponsorship</span></div></a>
            </nav>

            <div class="event-admin-divider"><span>Page Content Blocks</span></div>

            <section class="event-page-block" id="event-main-page">
                <div class="event-page-block__head">
                    <div>
                        <h3>Main Event Page Content</h3>
                        <p>This content appears on the main LogiSphere event page: welcome note, about copy, and theme section.</p>
                    </div>
                    <a class="event-page-link" href="{{ route('events.conference') }}" target="_blank">View page</a>
                </div>
                <div class="event-page-block__body">
                    <label>Welcome Note <textarea name="event[welcome_note]">{{ old('event.welcome_note', $event->welcome_note) }}</textarea><span class="field-help">Shown near the top of the main event page.</span></label>
                    <label>About LogiSphere <textarea name="event[about]">{{ old('event.about', $event->about) }}</textarea><span class="field-help">Main description block on the event page.</span></label>
                    <div class="event-admin-grid">
                        <label>Theme Title <input name="event[theme_title]" value="{{ old('event.theme_title', $event->theme_title) }}"><span class="field-help">Example: From Visibility to Velocity.</span></label>
                        <label>Theme Points, one per line <textarea name="theme_points_text">{{ old('theme_points_text', implode("\n", $event->theme_points ?: [])) }}</textarea><span class="field-help">Each line becomes a bullet point.</span></label>
                    </div>
                </div>
            </section>

            <section class="event-page-block" id="event-why-page">
                <div class="event-page-block__head blue">
                    <div>
                        <h3>Why & Who Page Content</h3>
                        <p>This is the dedicated editor for /events/why-who. Hero text, comparison rows, Bengaluru rationale, and attendee profiles live here.</p>
                    </div>
                    <a class="event-page-link" href="{{ route('events.why-who') }}" target="_blank">View page</a>
                </div>
                <div class="event-page-block__body">
                    <div class="event-admin-grid-3">
                        <label>Page Eyebrow <input name="event[why_who_eyebrow]" value="{{ old('event.why_who_eyebrow', $event->why_who_eyebrow ?: 'Why LogiSphere') }}"></label>
                        <label>Hero Heading <input name="event[why_who_heading]" value="{{ old('event.why_who_heading', $event->why_who_heading ?: 'Why now? Why Bengaluru?') }}"></label>
                        <label>Hero Subheading <textarea name="event[why_who_subheading]">{{ old('event.why_who_subheading', $event->why_who_subheading) }}</textarea></label>
                    </div>
                    <label>Why Now / Bengaluru Rationale <textarea name="event[why_now]">{{ old('event.why_now', $event->why_now) }}</textarea><span class="field-help">Used as the page rationale and as fallback hero copy if the subheading is empty.</span></label>
                    <div class="event-admin-grid">
                        <label>Comparison Rows, one per line: Traditional | LogiSphere <textarea name="comparison_rows_text">{{ old('comparison_rows_text', collect($event->comparison_rows ?: [])->map(fn($row) => ($row['traditional'] ?? '') . ' | ' . ($row['logisphere'] ?? ''))->implode("\n")) }}</textarea><span class="field-help">Use a pipe character to separate the two table columns.</span></label>
                        <label>Attendee Profiles, one per line <textarea name="attendee_profiles_text">{{ old('attendee_profiles_text', implode("\n", $event->attendee_profiles ?: [])) }}</textarea><span class="field-help">Each line appears as one audience bullet.</span></label>
                    </div>
                </div>
            </section>

            <div class="event-admin-divider"><span>Schedule & FAQ</span></div>

            <div class="event-admin-card">
                <div class="event-admin-row-head">
                    <h3>Agenda</h3>
                    <button type="button" class="event-admin-btn primary" data-add-agenda>Add Agenda Item</button>
                </div>
                <div data-agenda-list>
                    @foreach($event->agendaItems as $index => $item)
                        @include('admin.events.partials.agenda-row', ['index' => $index, 'item' => $item])
                    @endforeach
                </div>
            </div>

            <div class="event-admin-card">
                <div class="event-admin-row-head">
                    <h3>FAQs</h3>
                    <button type="button" class="event-admin-btn primary" data-add-faq>Add FAQ</button>
                </div>
                <div data-faq-list>
                    @foreach($event->faqs as $index => $faq)
                        @include('admin.events.partials.faq-row', ['index' => $index, 'faq' => $faq])
                    @endforeach
                </div>
            </div>

            <div class="event-admin-divider"><span>Commercial Setup</span></div>

            <section class="event-page-block" id="event-sponsor-page">
                <div class="event-page-block__head green">
                    <div>
                        <h3>Sponsorship Page Content</h3>
                        <p>This is the dedicated editor for /events/sponsorship. Hero text, sponsor copy, exhibitor copy, and contact details live here.</p>
                    </div>
                    <a class="event-page-link" href="{{ route('events.sponsorship') }}" target="_blank">View page</a>
                </div>
                <div class="event-page-block__body">
                    <div class="event-admin-grid-3">
                        <label>Page Eyebrow <input name="event[sponsorship_eyebrow]" value="{{ old('event.sponsorship_eyebrow', $event->sponsorship_eyebrow ?: 'Sponsor & Exhibit') }}"></label>
                        <label>Hero Heading <input name="event[sponsorship_heading]" value="{{ old('event.sponsorship_heading', $event->sponsorship_heading ?: 'Partner with LogiSphere') }}"></label>
                        <label>Hero Subheading <textarea name="event[sponsorship_subheading]">{{ old('event.sponsorship_subheading', $event->sponsorship_subheading) }}</textarea></label>
                    </div>
                    <div class="event-admin-grid">
                        <label>Sponsor Intro <textarea name="event[sponsor_intro]">{{ old('event.sponsor_intro', $event->sponsor_intro) }}</textarea><span class="field-help">Top sponsorship section copy.</span></label>
                        <label>Sponsor Benefits, one per line <textarea name="sponsor_benefits_text">{{ old('sponsor_benefits_text', implode("\n", $event->sponsor_benefits ?: [])) }}</textarea></label>
                        <label>Sponsor Inclusions, one per line <textarea name="sponsor_inclusions_text">{{ old('sponsor_inclusions_text', implode("\n", $event->sponsor_inclusions ?: [])) }}</textarea></label>
                        <label>Exhibitor Intro <textarea name="event[exhibitor_intro]">{{ old('event.exhibitor_intro', $event->exhibitor_intro) }}</textarea></label>
                        <label>Exhibitor Benefits, one per line <textarea name="exhibitor_benefits_text">{{ old('exhibitor_benefits_text', implode("\n", $event->exhibitor_benefits ?: [])) }}</textarea></label>
                        <label>Exhibitor Package Notes, one per line <textarea name="exhibitor_package_notes_text">{{ old('exhibitor_package_notes_text', implode("\n", $event->exhibitor_package_notes ?: [])) }}</textarea></label>
                        <label>Contact Email <input name="event[contact_email]" value="{{ old('event.contact_email', $event->contact_email) }}"></label>
                        <label>Contact Note <textarea name="event[contact_note]">{{ old('event.contact_note', $event->contact_note) }}</textarea></label>
                        <label>Closing Note <textarea name="event[closing_note]">{{ old('event.closing_note', $event->closing_note) }}</textarea></label>
                        <label>Exhibitor Profile <textarea name="event[exhibitor_profile]">{{ old('event.exhibitor_profile', $event->exhibitor_profile) }}</textarea></label>
                    </div>
                </div>
            </section>

            <div class="event-admin-card">
                <h3>Payment Settings & SEO</h3>
                <div class="event-admin-grid-3">
                    <label>Active Sponsor Currency
                        <div class="currency-choice">
                            <label>
                                <input type="radio" name="event[active_sponsor_currency]" value="INR" {{ old('event.active_sponsor_currency', $event->activeCurrency()) === 'INR' ? 'checked' : '' }}>
                                <span>INR</span>
                            </label>
                            <label>
                                <input type="radio" name="event[active_sponsor_currency]" value="USD" {{ old('event.active_sponsor_currency', $event->activeCurrency()) === 'USD' ? 'checked' : '' }}>
                                <span>USD</span>
                            </label>
                        </div>
                        <p class="payment-note">Frontend pricing and checkout will use only this selected currency.</p>
                    </label>
                    <label>Tax Label <input name="event[tax_label]" value="{{ old('event.tax_label', $event->tax_label ?: 'GST') }}"></label>
                    <label>Tax Percentage <input type="number" step="0.01" min="0" name="event[tax_percentage]" value="{{ old('event.tax_percentage', $event->tax_percentage) }}"></label>
                </div>
                <div class="event-admin-grid">
                    <label>Meta Title <input name="event[meta_title]" value="{{ old('event.meta_title', $event->meta_title) }}"></label>
                    <label>Canonical URL <input name="event[canonical_url]" value="{{ old('event.canonical_url', $event->canonical_url) }}"></label>
                    <label>Meta Description <textarea name="event[meta_description]">{{ old('event.meta_description', $event->meta_description) }}</textarea></label>
                </div>
            </div>

            <div class="save-bar"><button type="submit">Update Event</button></div>
        </form>
    </div>
</section>

<template id="agenda-template">@include('admin.events.partials.agenda-row', ['index' => '__INDEX__', 'item' => null])</template>
<template id="faq-template">@include('admin.events.partials.faq-row', ['index' => '__INDEX__', 'faq' => null])</template>
<script>
document.addEventListener('click', function (event) {
    if (event.target.matches('[data-add-agenda]')) addRow('agenda-template', '[data-agenda-list]');
    if (event.target.matches('[data-add-faq]')) addRow('faq-template', '[data-faq-list]');
    if (event.target.matches('[data-remove-row]')) {
        const row = event.target.closest('.event-admin-row');
        const del = row.querySelector('[data-delete-input]');
        if (del) { del.value = '1'; row.style.display = 'none'; } else { row.remove(); }
    }
});
function addRow(templateId, targetSelector) {
    const template = document.getElementById(templateId).innerHTML.replaceAll('__INDEX__', Date.now());
    document.querySelector(targetSelector).insertAdjacentHTML('beforeend', template);
}
</script>
@include('admin.adminFooter')
</body>
</html>
