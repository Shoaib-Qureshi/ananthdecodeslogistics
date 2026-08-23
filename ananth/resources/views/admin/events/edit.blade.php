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
    <div class="container-fluid event-editor-shell">
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

        <div class="event-admin-stats" aria-label="Event summary">
            <div class="event-admin-stat">
                <span>Date</span>
                <strong>{{ optional($event->event_date)->format('d M Y') ?: 'Not set' }}</strong>
            </div>
            <div class="event-admin-stat">
                <span>Location</span>
                <strong>{{ $event->location ?: 'Not set' }}</strong>
            </div>
            <div class="event-admin-stat">
                <span>Status</span>
                <strong>{{ $event->is_active ? 'Active event' : 'Inactive' }}</strong>
            </div>
            <div class="event-admin-stat">
                <span>Sponsor Currency</span>
                <strong>{{ $event->activeCurrency() }}</strong>
            </div>
        </div>

        <form method="POST" action="{{ $formAction ?? route('admin.events.update') }}" enctype="multipart/form-data" data-event-editor-form>
            @csrf
            <div class="event-admin-card" id="event-basics" data-editor-section data-default-open="true">
                <div class="event-admin-row-head">
                    <h3>Event Basics</h3>
                    <button type="button" class="event-section-toggle" data-section-toggle aria-label="Collapse Event Basics" aria-expanded="true"></button>
                </div>
                <div data-collapsible-body>
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
            </div>

            <div class="event-editor-tools">
                <nav class="event-page-nav" aria-label="Event page content shortcuts">
                    <a href="#event-basics"><div><strong>Basics</strong><span>Core details</span></div></a>
                    <a href="#event-main-page"><div><strong>Main Event Page</strong><span>/events/conference</span></div></a>
                    <a href="#event-marketing-partners"><div><strong>Event Partners</strong><span>Conference logos</span></div></a>
                    <a href="#event-why-page"><div><strong>Why & Who Page</strong><span>/events/why-who</span></div></a>
                    <a href="#event-delegate-logos"><div><strong>Delegate Logos</strong><span>Attendee carousel</span></div></a>
                    <a href="#event-register-page"><div><strong>Registration Page</strong><span>/events/register</span></div></a>
                    <a href="#event-sponsor-page"><div><strong>Sponsorship Page</strong><span>/events/sponsorship</span></div></a>
                    <a href="#event-settings"><div><strong>Settings & SEO</strong><span>Payment / metadata</span></div></a>
                </nav>
                <div class="event-editor-tools__actions">
                    <button type="button" class="event-admin-btn" data-expand-all>Expand All</button>
                    <button type="button" class="event-admin-btn" data-collapse-all>Collapse All</button>
                </div>
            </div>

            <div class="event-admin-divider"><span>Page Content Blocks</span></div>

            <section class="event-page-block" id="event-main-page" data-editor-section data-default-open="true">
                <div class="event-page-block__head">
                    <div>
                        <span class="event-section-kicker">Public page</span>
                        <h3>Main Event Page Content</h3>
                        <p>This content appears on the main LogiSphere event page: welcome note, about copy, and theme section.</p>
                    </div>
                    <div class="event-page-block__tools">
                        <button type="button" class="event-section-toggle" data-section-toggle aria-label="Collapse Main Event Page Content" aria-expanded="true"></button>
                        <a class="event-page-link" href="{{ route('events.conference') }}" target="_blank">View page</a>
                    </div>
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

            @php
                $defaultMarketingPartners = [
                    ['name' => 'NeuWork Solutions', 'role' => 'Marketing & Execution Partners', 'logo' => '/img/events/marketing-partners/neuwork-solutions.jpg'],
                    ['name' => '360 Degree Media', 'role' => 'Marketing & Media Partners', 'logo' => '/img/events/marketing-partners/360-media-exchange.jpg'],
                    ['name' => 'Leveragez', 'role' => 'Marketing & Delegate Management Partners', 'logo' => '/img/events/marketing-partners/leveragez-marketing.jpg'],
                ];
                $marketingPartners = old('marketing_partners');
                if ($marketingPartners === null) {
                    $marketingPartners = $event->marketing_partners ?? $defaultMarketingPartners;
                }
                $marketingPartners = collect($marketingPartners)->values();
            @endphp
            <section class="event-page-block" id="event-marketing-partners" data-editor-section>
                <div class="event-page-block__head green">
                    <div>
                        <span class="event-section-kicker">Conference page</span>
                        <h3>Marketing &amp; Execution Partners</h3>
                        <p>Add, edit, replace, or remove the partner logos and role labels shown after the Venue section.</p>
                    </div>
                    <div class="event-page-block__tools">
                        <button type="button" class="event-section-toggle" data-section-toggle aria-label="Expand Marketing and Execution Partners" aria-expanded="false"></button>
                        <a class="event-page-link" href="{{ route('events.conference') }}#marketing-partners-title" target="_blank">View section</a>
                    </div>
                </div>
                <div class="event-page-block__body">
                    <div class="marketing-partner-admin-list" data-marketing-partner-list>
                        @foreach($marketingPartners as $index => $partner)
                            @include('admin.events.partials.marketing-partner-row', ['index' => $index, 'partner' => $partner])
                        @endforeach
                    </div>
                    <div class="delegate-logo-admin-empty" data-marketing-partner-empty @if($marketingPartners->isNotEmpty()) hidden @endif>No marketing partners added yet.</div>
                    <button type="button" class="event-admin-btn primary" data-add-marketing-partner>Add Partner</button>
                    <span class="field-help">Uploads are resized to a consistent, high-quality 720×360 format. Transparent white logos automatically receive a navy background for contrast. Partner order here is used on the conference page.</span>
                </div>
            </section>

            <section class="event-page-block" id="event-why-page" data-editor-section>
                <div class="event-page-block__head blue">
                    <div>
                        <span class="event-section-kicker">Audience page</span>
                        <h3>Why & Who Page Content</h3>
                        <p>This is the dedicated editor for /events/why-who. Hero text, comparison rows, Bengaluru rationale, and attendee profiles live here.</p>
                    </div>
                    <div class="event-page-block__tools">
                        <button type="button" class="event-section-toggle" data-section-toggle aria-label="Expand Why & Who Page Content" aria-expanded="false"></button>
                        <a class="event-page-link" href="{{ route('events.why-who') }}" target="_blank">View page</a>
                    </div>
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

            @php
                $delegateLogos = collect($event->delegate_logos ?: [])
                    ->map(fn ($logo) => is_array($logo) ? ($logo['url'] ?? null) : $logo)
                    ->filter(fn ($logo) => is_string($logo) && trim($logo) !== '')
                    ->map(fn ($logo) => \App\Models\Event::normalizePublicAssetUrl($logo))
                    ->values();
            @endphp
            <section class="event-page-block" id="event-delegate-logos" data-editor-section>
                <div class="event-page-block__head blue">
                    <div>
                        <span class="event-section-kicker">Social proof</span>
                        <h3>Delegate Logos</h3>
                        <p>These logos appear in the Delegate Community carousel on /events/why-who. Images are normalized to a crisp 720×360 format when uploaded.</p>
                    </div>
                    <div class="event-page-block__tools">
                        <button type="button" class="event-section-toggle" data-section-toggle aria-label="Expand Delegate Logos" aria-expanded="false"></button>
                        <a class="event-page-link" href="{{ route('events.why-who') }}#delegate-logos-title" target="_blank">View section</a>
                    </div>
                </div>
                <div class="event-page-block__body">
                    <label>Upload delegate logos
                        <input type="file" name="delegate_logo_files[]" accept="image/jpeg,image/png,image/webp" multiple>
                        <span class="field-help">Select one or more JPG, PNG, or WebP images. Each image is resized onto a clean white 720×360 JPEG canvas.</span>
                    </label>
                    <input type="hidden" name="delegate_logos_keep" value='@json($delegateLogos->all())' data-delegate-logos-keep>
                    <div class="delegate-logo-admin-grid" data-delegate-logo-grid>
                        @forelse($delegateLogos as $logo)
                            <div class="delegate-logo-admin-card" data-delegate-logo-card data-logo-url="{{ $logo }}">
                                <img src="{{ $logo }}" alt="Delegate logo preview" loading="lazy">
                                <button type="button" data-remove-delegate-logo aria-label="Remove delegate logo">&times;</button>
                            </div>
                        @empty
                            <div class="delegate-logo-admin-empty" data-delegate-logo-empty>No delegate logos added yet.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <div class="event-admin-divider"><span>Schedule & FAQ</span></div>

            <section class="event-page-block" id="event-register-page" data-editor-section>
                <div class="event-page-block__head blue">
                    <div>
                        <span class="event-section-kicker">Lead capture</span>
                        <h3>Registration Page Content</h3>
                        <p>This controls the Interest Type dropdown on /events/register.</p>
                    </div>
                    <div class="event-page-block__tools">
                        <button type="button" class="event-section-toggle" data-section-toggle aria-label="Expand Registration Page Content" aria-expanded="false"></button>
                        <a class="event-page-link" href="{{ route('events.register') }}" target="_blank">View page</a>
                    </div>
                </div>
                <div class="event-page-block__body">
                    <div class="event-admin-grid-3">
                        <label>Page Eyebrow <input name="event[registration_eyebrow]" value="{{ old('event.registration_eyebrow', $event->registration_eyebrow ?: 'Register') }}"></label>
                        <label>Hero Heading <input name="event[registration_heading]" value="{{ old('event.registration_heading', $event->registration_heading ?: 'Register for LogiSphere') }}"></label>
                        <label>Hero Subheading <textarea name="event[registration_subheading]">{{ old('event.registration_subheading', $event->registration_subheading ?: 'Share your interest as a delegate, speaker, sponsor, or exhibitor.') }}</textarea></label>
                    </div>
                    <div class="event-admin-grid">
                        <label>Left Panel Eyebrow <input name="event[registration_panel_eyebrow]" value="{{ old('event.registration_panel_eyebrow', $event->registration_panel_eyebrow ?: 'Contact Information') }}"></label>
                        <label>Left Panel Heading <input name="event[registration_panel_heading]" value="{{ old('event.registration_panel_heading', $event->registration_panel_heading ?: 'The event team will follow up.') }}"></label>
                        <label>Form Heading <input name="event[registration_form_heading]" value="{{ old('event.registration_form_heading', $event->registration_form_heading ?: 'Register Interest') }}"></label>
                        <label>Form Subheading <textarea name="event[registration_form_subheading]">{{ old('event.registration_form_subheading', $event->registration_form_subheading ?: 'Tell us how you want to participate in LogiSphere.') }}</textarea></label>
                        <label>Register Interest Types
                            <textarea name="interest_options_text">{{ old('interest_options_text', collect($event->interestOptions())->map(fn($option) => $option['value'] . ' | ' . $option['label'])->implode("\n")) }}</textarea>
                            <span class="field-help">One per line. Use value | Label, for example delegate | Delegate.</span>
                        </label>
                        <label>Registration Steps
                            <textarea name="registration_steps_text">{{ old('registration_steps_text', collect($event->registrationSteps())->map(fn($step) => ($step['title'] ?? '') . ' | ' . ($step['text'] ?? ''))->implode("\n")) }}</textarea>
                            <span class="field-help">One per line. Use Title | Description.</span>
                        </label>
                    </div>
                </div>
            </section>

            <div class="event-admin-card" id="event-agenda" data-editor-section>
                <div class="event-admin-row-head">
                    <h3>Agenda</h3>
                    <div class="event-editor-tools__actions">
                        <button type="button" class="event-section-toggle" data-section-toggle aria-label="Expand Agenda" aria-expanded="false"></button>
                        <button type="button" class="event-admin-btn primary" data-add-agenda>Add Agenda Item</button>
                    </div>
                </div>
                <div data-agenda-list data-collapsible-body>
                    @foreach($event->agendaItems as $index => $item)
                        @include('admin.events.partials.agenda-row', ['index' => $index, 'item' => $item])
                    @endforeach
                </div>
            </div>

            <div class="event-admin-card" id="event-faqs" data-editor-section>
                <div class="event-admin-row-head">
                    <h3>FAQs</h3>
                    <div class="event-editor-tools__actions">
                        <button type="button" class="event-section-toggle" data-section-toggle aria-label="Expand FAQs" aria-expanded="false"></button>
                        <button type="button" class="event-admin-btn primary" data-add-faq>Add FAQ</button>
                    </div>
                </div>
                <div data-faq-list data-collapsible-body>
                    @foreach($event->faqs as $index => $faq)
                        @include('admin.events.partials.faq-row', ['index' => $index, 'faq' => $faq])
                    @endforeach
                </div>
            </div>

            <div class="event-admin-divider"><span>Commercial Setup</span></div>

            <section class="event-page-block" id="event-sponsor-page" data-editor-section>
                <div class="event-page-block__head green">
                    <div>
                        <span class="event-section-kicker">Commercial page</span>
                        <h3>Sponsorship Page Content</h3>
                        <p>This is the dedicated editor for /events/sponsorship. Hero text, sponsor copy, exhibitor copy, and contact details live here.</p>
                    </div>
                    <div class="event-page-block__tools">
                        <button type="button" class="event-section-toggle" data-section-toggle aria-label="Expand Sponsorship Page Content" aria-expanded="false"></button>
                        <a class="event-page-link" href="{{ route('events.sponsorship') }}" target="_blank">View page</a>
                    </div>
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
                        <label>Register Interest Types
                            <input value="Managed in Registration Page Content" readonly>
                            <span class="field-help">These choices are shared with sponsor/exhibitor enquiries. Use the Registration Page Content section above to edit them.</span>
                        </label>
                        <label>Closing Note <textarea name="event[closing_note]">{{ old('event.closing_note', $event->closing_note) }}</textarea></label>
                        <label>Exhibitor Profile <textarea name="event[exhibitor_profile]">{{ old('event.exhibitor_profile', $event->exhibitor_profile) }}</textarea></label>
                    </div>
                </div>
            </section>

            <div class="event-admin-card" id="event-settings" data-editor-section>
                <div class="event-admin-row-head">
                    <h3>Payment Settings & SEO</h3>
                    <button type="button" class="event-section-toggle" data-section-toggle aria-label="Expand Payment Settings and SEO" aria-expanded="false"></button>
                </div>
                <div data-collapsible-body>
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
            </div>

            <div class="save-bar">
                <span data-save-status aria-live="polite"></span>
                <button type="submit" data-save-button>Update Event</button>
            </div>
        </form>
    </div>
</section>

<template id="agenda-template">@include('admin.events.partials.agenda-row', ['index' => '__INDEX__', 'item' => null])</template>
<template id="faq-template">@include('admin.events.partials.faq-row', ['index' => '__INDEX__', 'faq' => null])</template>
<template id="marketing-partner-template">@include('admin.events.partials.marketing-partner-row', ['index' => '__INDEX__', 'partner' => []])</template>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var sections = Array.prototype.slice.call(document.querySelectorAll('[data-editor-section]'));
    var hasErrors = !!document.querySelector('.alert-danger');

    sections.forEach(function (section) {
        if (!hasErrors && section.dataset.defaultOpen !== 'true') {
            setSection(section, false, false);
        } else {
            setSection(section, true, false);
        }
    });

    var form = document.querySelector('[data-event-editor-form]');
    if (form) {
        form.addEventListener('submit', function () {
            var button = form.querySelector('[data-save-button]');
            var status = form.querySelector('[data-save-status]');
            if (button) {
                button.disabled = true;
                button.textContent = 'Saving...';
            }
            if (status) {
                status.textContent = 'Saving event changes';
            }
        });
    }
});

document.addEventListener('click', function (event) {
    var toggle = event.target.closest('[data-section-toggle]');
    if (toggle) {
        var section = toggle.closest('[data-editor-section]');
        if (section) setSection(section, section.classList.contains('is-collapsed'), true);
    }

    if (event.target.matches('[data-expand-all]')) {
        document.querySelectorAll('[data-editor-section]').forEach(function (section) {
            setSection(section, true, true);
        });
    }

    if (event.target.matches('[data-collapse-all]')) {
        document.querySelectorAll('[data-editor-section]').forEach(function (section) {
            setSection(section, false, true);
        });
    }

    var navLink = event.target.closest('.event-page-nav a[href^="#"]');
    if (navLink) {
        var target = document.querySelector(navLink.getAttribute('href'));
        if (target && target.matches('[data-editor-section]')) {
            setSection(target, true, true);
        }
    }

    if (event.target.matches('[data-add-agenda]')) {
        setSection(event.target.closest('[data-editor-section]'), true, true);
        addRow('agenda-template', '[data-agenda-list]');
    }
    if (event.target.matches('[data-add-faq]')) {
        setSection(event.target.closest('[data-editor-section]'), true, true);
        addRow('faq-template', '[data-faq-list]');
    }
    if (event.target.matches('[data-add-marketing-partner]')) {
        setSection(event.target.closest('[data-editor-section]'), true, true);
        addRow('marketing-partner-template', '[data-marketing-partner-list]');
        var partnerEmpty = document.querySelector('[data-marketing-partner-empty]');
        if (partnerEmpty) partnerEmpty.hidden = true;
    }
    if (event.target.matches('[data-remove-row]')) {
        const row = event.target.closest('.event-admin-row');
        const del = row.querySelector('[data-delete-input]');
        if (del) { del.value = '1'; row.style.display = 'none'; } else { row.remove(); }
    }

    if (event.target.matches('[data-remove-delegate-logo]')) {
        var logoCard = event.target.closest('[data-delegate-logo-card]');
        if (logoCard) {
            logoCard.remove();
            var keep = document.querySelector('[data-delegate-logos-keep]');
            if (keep) {
                keep.value = JSON.stringify(Array.prototype.map.call(document.querySelectorAll('[data-delegate-logo-card]'), function (card) {
                    return card.dataset.logoUrl;
                }));
            }
            var grid = document.querySelector('[data-delegate-logo-grid]');
            if (grid && !grid.querySelector('[data-delegate-logo-card]')) {
                grid.innerHTML = '<div class="delegate-logo-admin-empty" data-delegate-logo-empty>No delegate logos added yet.</div>';
            }
        }
    }
    if (event.target.matches('[data-remove-marketing-partner]')) {
        var partnerRow = event.target.closest('[data-marketing-partner-row]');
        if (partnerRow) partnerRow.remove();
        var partnerList = document.querySelector('[data-marketing-partner-list]');
        var partnerEmpty = document.querySelector('[data-marketing-partner-empty]');
        if (partnerEmpty && partnerList && !partnerList.querySelector('[data-marketing-partner-row]')) {
            partnerEmpty.hidden = false;
        }
    }
});

document.addEventListener('change', function (event) {
    if (!event.target.matches('[data-marketing-partner-file]') || !event.target.files.length) return;

    var row = event.target.closest('[data-marketing-partner-row]');
    var preview = row ? row.querySelector('[data-marketing-partner-preview]') : null;
    var placeholder = row ? row.querySelector('[data-marketing-partner-placeholder]') : null;
    if (!preview) return;

    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.hidden = false;
    if (placeholder) placeholder.hidden = true;
});
function addRow(templateId, targetSelector) {
    const template = document.getElementById(templateId).innerHTML.replaceAll('__INDEX__', Date.now());
    document.querySelector(targetSelector).insertAdjacentHTML('beforeend', template);
}

function sectionBody(section) {
    var children = Array.prototype.slice.call(section.children);
    return children.find(function (child) {
        return child.classList.contains('event-page-block__body') || child.hasAttribute('data-collapsible-body');
    });
}

function setSection(section, open, animate) {
    if (!section) return;

    var body = sectionBody(section);
    var toggle = section.querySelector('[data-section-toggle]');
    if (!body) return;

    section.classList.toggle('is-collapsed', !open);
    if (toggle) {
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', (open ? 'Collapse ' : 'Expand ') + sectionTitle(section));
    }

    if (!animate || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        body.style.display = open ? '' : 'none';
        body.style.height = '';
        body.style.overflow = '';
        body.style.transition = '';
        return;
    }

    body.style.overflow = 'hidden';
    body.style.transition = 'height 220ms ease';

    if (open) {
        body.style.display = '';
        body.style.height = '0px';
        requestAnimationFrame(function () {
            body.style.height = body.scrollHeight + 'px';
        });
    } else {
        body.style.height = body.scrollHeight + 'px';
        requestAnimationFrame(function () {
            body.style.height = '0px';
        });
    }

    body.addEventListener('transitionend', function finish(event) {
        if (event.propertyName !== 'height') return;
        body.removeEventListener('transitionend', finish);
        body.style.transition = '';
        body.style.overflow = '';
        body.style.height = '';
        if (!open) body.style.display = 'none';
    });
}

function sectionTitle(section) {
    var heading = section.querySelector('h3');
    return heading ? heading.textContent.trim() : 'section';
}
</script>
@include('admin.adminFooter')
</body>
</html>
