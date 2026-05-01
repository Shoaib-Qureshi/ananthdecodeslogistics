<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Edit Home Page</title>
    <style>
        html{scroll-behavior:smooth;scroll-padding-top:24px}
        .home-editor-hero{display:flex;align-items:flex-start;justify-content:space-between;gap:24px;margin:18px 0 22px;padding:22px 24px;border:1px solid #d8e3f0;border-radius:18px;background:linear-gradient(135deg,#fff,#f8fbff);box-shadow:0 18px 50px rgba(15,23,42,.06)}
        .home-editor-eyebrow{margin:0 0 8px;color:#2562E9;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
        .home-editor-hero h2{margin:0;color:#0f172a;font-size:1.75rem;font-weight:800}
        .home-editor-hero p{max-width:720px;margin:8px 0 0;color:#64748b;line-height:1.65}
        .home-editor-pill{display:inline-flex;align-items:center;gap:8px;white-space:nowrap;border:1px solid #d8e3f0;border-radius:40px;background:#fff;padding:10px 14px;color:#475569;font-weight:700;font-size:.86rem}
        .editor-layout{display:grid;grid-template-columns:260px minmax(0,1fr);gap:22px;align-items:start}
        .editor-nav{position:sticky;top:18px;border:1px solid #d8e3f0;border-radius:18px;background:#fff;padding:16px;box-shadow:0 14px 40px rgba(15,23,42,.06)}
        .editor-nav-title{margin:0 0 12px;color:#0f172a;font-size:.9rem;font-weight:800}
        .editor-nav a{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;color:#475569;text-decoration:none;font-size:.9rem;font-weight:700;transition:background .2s,color .2s}
        .editor-nav a:hover,.editor-nav a:focus,.editor-nav a.is-active{background:#eff6ff;color:#2562E9}
        .editor-nav a.is-active .dot{background:#2562E9}
        .editor-nav .dot{width:7px;height:7px;border-radius:50%;background:#93c5fd;flex:0 0 auto}
        .editor-content{display:grid;gap:18px}
        .section-box{scroll-margin-top:24px;background:#fff;border:1px solid #d8e3f0;border-radius:18px;padding:22px;margin:0;box-shadow:0 14px 40px rgba(15,23,42,.05)}
        .section-box.alt{background:linear-gradient(180deg,#fff,#f8fbff)}
        .section-head{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:18px;padding-bottom:16px;border-bottom:1px solid #edf2f7}
        .section-kicker{margin:0 0 5px;color:#2562E9;font-size:.72rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
        .section-title{font-size:1.16rem;color:#0f172a;margin:0;font-weight:800}
        .section-desc{max-width:650px;margin:6px 0 0;color:#64748b;font-size:.92rem;line-height:1.6}
        .section-chip{border:1px solid #d8e3f0;border-radius:999px;background:#f8fafc;padding:6px 10px;color:#64748b;font-size:.76rem;font-weight:800}
        .grid-2{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px 16px}
        .grid-4{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}
        .grid-2>*,.grid-4>*{min-width:0}
        .form_input label{display:block;min-width:0}
        .form_input input,.form_input select,.form_input textarea{max-width:100%;width:100%;box-sizing:border-box}
        .form_input input[type="checkbox"]{width:auto}
        .form_input textarea{resize:vertical}
        .row-card{min-width:0;overflow:hidden;border:1px solid #d8e3f0;border-radius:14px;padding:16px;margin-bottom:12px;background:#fff}
        .row-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:12px}
        .row-card h5{margin:0 0 12px;color:#0f172a;font-size:1rem;font-weight:800}
        .row-card-head h5{margin:0}
        .row-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
        .admin-link-btn{display:inline-flex;align-items:center;gap:7px;border:1px solid #d8e3f0;border-radius:40px;background:#fff;color:#475569;padding:8px 12px;font-size:.82rem;font-weight:800;line-height:1;transition:background .2s,color .2s,border-color .2s}
        .admin-link-btn:hover{background:#eff6ff;border-color:#bfdbfe;color:#2562E9}
        .admin-link-btn.danger:hover{background:#fef2f2;border-color:#fecaca;color:#dc2626}
        .section-actions{display:flex;justify-content:flex-end;margin-top:14px}
        .visibility-toggle{display:inline-flex!important;align-items:center;gap:8px;white-space:nowrap;color:#475569;font-size:.82rem;font-weight:800}
        .visibility-toggle input{position:absolute;opacity:0;pointer-events:none}
        .visibility-toggle span{position:relative;width:42px;height:24px;border-radius:999px;background:#cbd5e1;transition:background .2s}
        .visibility-toggle span::after{content:"";position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:50%;background:#fff;box-shadow:0 1px 4px rgba(15,23,42,.2);transition:transform .2s}
        .visibility-toggle input:checked+span{background:#2562E9}
        .visibility-toggle input:checked+span::after{transform:translateX(18px)}
        .thumb{max-width:180px;border-radius:10px;border:1px solid #d8e3f0;margin-bottom:8px}
        .ck.ck-editor{max-width:100%}
        .ck-editor__main,.ck-editor__editable{max-width:100%;overflow:auto}
        .ck-editor__editable{min-height:180px}
        .save-bar{position:sticky;bottom:0;z-index:5;display:flex;justify-content:flex-end;margin-top:22px;padding:14px 0;background:linear-gradient(180deg,rgba(255,255,255,0),#fff 30%)}
        .save-bar button{border:0;border-radius:40px;background:#2562E9;color:#fff;padding:12px 24px;font-weight:800;box-shadow:0 12px 28px rgba(37,98,233,.22);transition:background .2s}
        .save-bar button:hover{background:#181A3F}
        @media(max-width:1100px){.editor-layout{grid-template-columns:1fr}.editor-nav{position:relative;top:auto}.editor-nav-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:6px}.home-editor-hero{flex-direction:column}}
        @media(max-width:900px){.grid-2,.grid-4{grid-template-columns:1fr}}
        @media(max-width:640px){.editor-nav-list{grid-template-columns:1fr}.section-head{display:block}.section-chip{display:inline-flex;margin-top:10px}}
    </style>
</head>
<body>
@include('admin.adminHeader')
<section class="main_section">
    <div class="container-fluid">
        @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @if ($errors->any())
            <div class="alert alert-danger">@foreach ($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach</div>
        @endif

        <div class="outer_wrapper mt-3">
            <div class="wrapper_head"><h3>Edit Home Page</h3></div>
            <div class="wrapper_body">
                <div class="home-editor-hero">
                    <div>
                        <p class="home-editor-eyebrow">Homepage Content</p>
                        <h2>Edit Home Page Content</h2>
                        <p>Update the public homepage section by section. Use the left navigation to jump to the exact area you want to edit.</p>
                    </div>
                    <span class="home-editor-pill"><i class="fas fa-layer-group"></i> Section editor</span>
                </div>
                <form class="form_input" action="{{ route('updateHomePage') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="editor-layout">
                        <aside class="editor-nav" aria-label="Home page editor sections">
                            <p class="editor-nav-title">Edit Sections</p>
                            <div class="editor-nav-list">
                                <a href="#hero-section"><span class="dot"></span>Hero Section</a>
                                <a href="#stats-section"><span class="dot"></span>Stats Strip</a>
                                <a href="#founder-section"><span class="dot"></span>Founder Preview</a>
                                <a href="#credentials-section"><span class="dot"></span>Founder Credentials</a>
                                <a href="#services-section"><span class="dot"></span>Services Section</a>
                                <a href="#content-sections"><span class="dot"></span>Content Blocks</a>
                                <a href="#seo-section"><span class="dot"></span>SEO</a>
                                <a href="#footer-section"><span class="dot"></span>Footer & Social</a>
                            </div>
                        </aside>

                        <div class="editor-content">

                    <div class="section-box alt" id="hero-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">First viewport</p>
                                <h4 class="section-title">Hero Section</h4>
                                <p class="section-desc">Controls the homepage headline, supporting copy, buttons, and hero image.</p>
                            </div>
                            <span class="section-chip">Homepage top</span>
                        </div>
                        <div class="grid-2">
                            <label>Eyebrow<input name="settings[hero_eyebrow]" value="{{ old('settings.hero_eyebrow', $settings->hero_eyebrow) }}"></label>
                            <label>Heading<input name="settings[hero_heading]" value="{{ old('settings.hero_heading', $settings->hero_heading) }}"></label>
                            <label>Subheading<input name="settings[hero_subheading]" value="{{ old('settings.hero_subheading', $settings->hero_subheading) }}"></label>
                            <label>Primary CTA Label<input name="settings[hero_cta_primary_label]" value="{{ old('settings.hero_cta_primary_label', $settings->hero_cta_primary_label) }}"></label>
                            <label>Primary CTA Link<input name="settings[hero_cta_primary_link]" value="{{ old('settings.hero_cta_primary_link', $settings->hero_cta_primary_link) }}"></label>
                            <label>Secondary CTA Label<input name="settings[hero_cta_secondary_label]" value="{{ old('settings.hero_cta_secondary_label', $settings->hero_cta_secondary_label) }}"></label>
                            <label>Secondary CTA Link<input name="settings[hero_cta_secondary_link]" value="{{ old('settings.hero_cta_secondary_link', $settings->hero_cta_secondary_link) }}"></label>
                            <label>Hero Image
                                @if($settings->hero_image)<img class="thumb d-block" src="{{ Storage::url($settings->hero_image) }}" alt="Current hero">@endif
                                <input name="settings[hero_image]" type="file" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div class="section-box" id="stats-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Proof points</p>
                                <h4 class="section-title">Stats Strip</h4>
                                <p class="section-desc">Edit the four compact metrics shown near the top of the homepage.</p>
                            </div>
                            <span class="section-chip">4 stats</span>
                        </div>
                        <div class="grid-4">
                            @for($i = 1; $i <= 4; $i++)
                                <div>
                                    <label>Stat {{ $i }} Number<input name="settings[stat{{ $i }}_number]" value="{{ old("settings.stat{$i}_number", $settings->{'stat'.$i.'_number'}) }}"></label>
                                    <label>Stat {{ $i }} Label<input name="settings[stat{{ $i }}_label]" value="{{ old("settings.stat{$i}_label", $settings->{'stat'.$i.'_label'}) }}"></label>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="section-box alt" id="founder-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Founder block</p>
                                <h4 class="section-title">Founder Preview</h4>
                                <p class="section-desc">Controls the founder intro card, bio text, badge, photo, and CTA.</p>
                            </div>
                            <span class="section-chip">Profile</span>
                        </div>
                        <div class="grid-2">
                            <label>Eyebrow<input name="settings[founder_eyebrow]" value="{{ old('settings.founder_eyebrow', $settings->founder_eyebrow) }}"></label>
                            <label>Name / Heading<input name="settings[founder_heading]" value="{{ old('settings.founder_heading', $settings->founder_heading) }}"></label>
                            <label>Title Badge<input name="settings[founder_title_badge]" value="{{ old('settings.founder_title_badge', $settings->founder_title_badge) }}"></label>
                            <label>CTA Label<input name="settings[founder_cta_label]" value="{{ old('settings.founder_cta_label', $settings->founder_cta_label) }}"></label>
                            <label>CTA Link<input name="settings[founder_cta_link]" value="{{ old('settings.founder_cta_link', $settings->founder_cta_link) }}"></label>
                            <label>Founder Photo
                                @if($settings->founder_photo)<img class="thumb d-block" src="{{ Storage::url($settings->founder_photo) }}" alt="Founder">@endif
                                <input name="settings[founder_photo]" type="file" accept="image/*">
                            </label>
                        </div>
                        <label>Bio<textarea class="wysiwyg" name="settings[founder_bio]">{{ old('settings.founder_bio', $settings->founder_bio) }}</textarea></label>
                    </div>

                    <div class="section-box" id="credentials-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Supporting details</p>
                                <h4 class="section-title">Founder Credentials</h4>
                                <p class="section-desc">Manage the short credentials listed with the founder preview.</p>
                            </div>
                            <span class="section-chip">Repeatable rows</span>
                        </div>
                        <div id="credentialRows" data-next-index="{{ $credentials->count() + 1 }}">
                        @foreach($credentials->concat([new \App\Models\FounderCredential]) as $index => $credential)
                            <div class="row-card" data-credential-row>
                                <div class="row-card-head">
                                    <h5>Pointer {{ $index + 1 }}</h5>
                                    <div class="row-actions">
                                        <button class="admin-link-btn danger" type="button" data-remove-credential>
                                            <i class="fas fa-trash-alt"></i>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="credentials[{{ $index }}][id]" value="{{ $credential->id }}">
                                <input type="hidden" name="credentials[{{ $index }}][_delete]" value="0" data-delete-flag>
                                <div class="grid-2">
                                    <label>Credential<input name="credentials[{{ $index }}][credential]" value="{{ old("credentials.$index.credential", $credential->credential) }}"></label>
                                    <label>Sort Order<input name="credentials[{{ $index }}][sort_order]" type="number" value="{{ old("credentials.$index.sort_order", $credential->sort_order ?? $index) }}"></label>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        <div class="section-actions">
                            <button class="admin-link-btn" type="button" id="addCredentialPointer">
                                <i class="fas fa-plus"></i>
                                Add Pointer
                            </button>
                        </div>
                    </div>

                    <div class="section-box alt" id="services-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Offerings</p>
                                <h4 class="section-title">Services Section</h4>
                                <p class="section-desc">Edit the homepage services intro and the service cards shown to visitors.</p>
                            </div>
                            <span class="section-chip">Cards</span>
                        </div>
                        <div class="grid-2">
                            <label>Eyebrow<input name="settings[services_eyebrow]" value="{{ old('settings.services_eyebrow', $settings->services_eyebrow) }}"></label>
                            <label>Heading<input name="settings[services_heading]" value="{{ old('settings.services_heading', $settings->services_heading) }}"></label>
                        </div>
                        <label>Intro<textarea name="settings[services_intro]" rows="3">{{ old('settings.services_intro', $settings->services_intro) }}</textarea></label>
                        <div id="homeServiceRows" data-next-index="{{ $services->count() + 1 }}">
                        @foreach($services->concat([new \App\Models\ServiceCard]) as $index => $service)
                            <div class="row-card" data-service-row>
                                <div class="row-card-head">
                                    <h5>Service Card {{ $index + 1 }}</h5>
                                    <div class="row-actions">
                                        <button class="admin-link-btn danger" type="button" data-remove-service>
                                            <i class="fas fa-trash-alt"></i>
                                            Remove
                                        </button>
                                        <label class="visibility-toggle">
                                            <input type="hidden" name="services[{{ $index }}][visible]" value="0">
                                            <input type="checkbox" name="services[{{ $index }}][visible]" value="1" {{ old("services.$index.visible", $service->visible ?? true) ? 'checked' : '' }}>
                                            <span aria-hidden="true"></span>
                                            Visible
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="services[{{ $index }}][id]" value="{{ $service->id }}">
                                <input type="hidden" name="services[{{ $index }}][_delete]" value="0" data-delete-flag>
                                <div class="grid-2">
                                    <label>Title<input name="services[{{ $index }}][title]" value="{{ old("services.$index.title", $service->title) }}"></label>
                                    <label>Status
                                        <select name="services[{{ $index }}][status]">
                                            @foreach(['active' => 'Active', 'coming_soon' => 'Coming Soon'] as $value => $label)
                                                <option value="{{ $value }}" {{ old("services.$index.status", $service->status ?? 'active') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label>Link URL<input name="services[{{ $index }}][link_url]" value="{{ old("services.$index.link_url", $service->link_url) }}"></label>
                                    <label>Sort Order<input name="services[{{ $index }}][sort_order]" type="number" value="{{ old("services.$index.sort_order", $service->sort_order ?? $index) }}"></label>
                                </div>
                                <label>Description<textarea name="services[{{ $index }}][description]" rows="3">{{ old("services.$index.description", $service->description) }}</textarea></label>
                            </div>
                        @endforeach
                        </div>
                        <div class="section-actions">
                            <button class="admin-link-btn" type="button" id="addHomeServiceCard">
                                <i class="fas fa-plus"></i>
                                Add Service Card
                            </button>
                        </div>
                    </div>

                    <div class="section-box" id="content-sections">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Editorial areas</p>
                                <h4 class="section-title">Blog, Expert Desk, Board Insights</h4>
                                <p class="section-desc">Update the section headings, body copy, and CTAs for homepage editorial blocks.</p>
                            </div>
                            <span class="section-chip">3 sections</span>
                        </div>
                        <div class="grid-2">
                            @foreach(['blog' => 'Blog', 'expertdesk' => 'Expert Desk', 'boardinsights' => 'Board Insights'] as $prefix => $label)
                                <div class="row-card">
                                    <h5>{{ $label }}</h5>
                                    <label>Eyebrow<input name="settings[{{ $prefix }}_eyebrow]" value="{{ old("settings.{$prefix}_eyebrow", $settings->{$prefix.'_eyebrow'}) }}"></label>
                                    <label>Heading<input name="settings[{{ $prefix }}_heading]" value="{{ old("settings.{$prefix}_heading", $settings->{$prefix.'_heading'}) }}"></label>
                                    @if($prefix === 'blog')
                                        <label>Subheading<input name="settings[blog_subheading]" value="{{ old('settings.blog_subheading', $settings->blog_subheading) }}"></label>
                                        <label>CTA Label<input name="settings[blog_cta_label]" value="{{ old('settings.blog_cta_label', $settings->blog_cta_label) }}"></label>
                                        <label>CTA Link<input name="settings[blog_cta_link]" value="{{ old('settings.blog_cta_link', $settings->blog_cta_link) }}"></label>
                                    @elseif($prefix === 'expertdesk')
                                        <label>Body<textarea class="wysiwyg" name="settings[expertdesk_body]">{{ old('settings.expertdesk_body', $settings->expertdesk_body) }}</textarea></label>
                                        <label>CTA 1 Label<input name="settings[expertdesk_cta1_label]" value="{{ old('settings.expertdesk_cta1_label', $settings->expertdesk_cta1_label) }}"></label>
                                        <label>CTA 1 Link<input name="settings[expertdesk_cta1_link]" value="{{ old('settings.expertdesk_cta1_link', $settings->expertdesk_cta1_link) }}"></label>
                                        <label>CTA 2 Label<input name="settings[expertdesk_cta2_label]" value="{{ old('settings.expertdesk_cta2_label', $settings->expertdesk_cta2_label) }}"></label>
                                        <label>CTA 2 Link<input name="settings[expertdesk_cta2_link]" value="{{ old('settings.expertdesk_cta2_link', $settings->expertdesk_cta2_link) }}"></label>
                                    @else
                                        <label>Body<textarea class="wysiwyg" name="settings[{{ $prefix }}_body]">{{ old("settings.{$prefix}_body", $settings->{$prefix.'_body'}) }}</textarea></label>
                                        <label>CTA Label<input name="settings[{{ $prefix }}_cta_label]" value="{{ old("settings.{$prefix}_cta_label", $settings->{$prefix.'_cta_label'} ?? null) }}"></label>
                                        <label>CTA Link<input name="settings[{{ $prefix }}_cta_link]" value="{{ old("settings.{$prefix}_cta_link", $settings->{$prefix.'_cta_link'} ?? null) }}"></label>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <h5 class="mt-3 mb-2">Expert Desk Pillars</h5>
                        <div id="pillarRows" data-next-index="{{ $pillars->count() + 1 }}">
                        @foreach($pillars->concat([new \App\Models\ExpertDeskPillar]) as $index => $pillar)
                            <div class="row-card" data-pillar-row>
                                <div class="row-card-head">
                                    <h5>Pillar {{ $index + 1 }}</h5>
                                    <div class="row-actions">
                                        <button class="admin-link-btn danger" type="button" data-remove-pillar>
                                            <i class="fas fa-trash-alt"></i>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="pillars[{{ $index }}][id]" value="{{ $pillar->id }}">
                                <input type="hidden" name="pillars[{{ $index }}][_delete]" value="0" data-delete-flag>
                                <div class="grid-2">
                                    <label>Title<input name="pillars[{{ $index }}][title]" value="{{ old("pillars.$index.title", $pillar->title) }}"></label>
                                    <label>Sort Order<input name="pillars[{{ $index }}][sort_order]" type="number" value="{{ old("pillars.$index.sort_order", $pillar->sort_order ?? $index) }}"></label>
                                    <label style="grid-column:1/-1">Body<textarea name="pillars[{{ $index }}][body]" rows="3">{{ old("pillars.$index.body", $pillar->body) }}</textarea></label>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        <div class="section-actions">
                            <button class="admin-link-btn" type="button" id="addExpertPillar">
                                <i class="fas fa-plus"></i>
                                Add Pillar
                            </button>
                        </div>
                    </div>

                    <div class="section-box alt" id="seo-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Search & sharing</p>
                                <h4 class="section-title">SEO</h4>
                                <p class="section-desc">Manage metadata, canonical URL, social image path, robots, and schema markup.</p>
                            </div>
                            <span class="section-chip">Metadata</span>
                        </div>
                        <div class="grid-2">
                            <label>Meta Title<input name="settings[meta_title]" value="{{ old('settings.meta_title', $settings->meta_title) }}"></label>
                            <label>Canonical URL<input name="settings[canonical_url]" value="{{ old('settings.canonical_url', $settings->canonical_url) }}"></label>
                            <label>OG Image Path<input name="settings[og_image]" value="{{ old('settings.og_image', $settings->og_image) }}"></label>
                            <label>Robots
                                <select name="settings[robots_index]"><option value="1" {{ old('settings.robots_index', $settings->robots_index ?? 1) ? 'selected' : '' }}>Index</option><option value="0" {{ !old('settings.robots_index', $settings->robots_index ?? 1) ? 'selected' : '' }}>No Index</option></select>
                                <select name="settings[robots_follow]"><option value="1" {{ old('settings.robots_follow', $settings->robots_follow ?? 1) ? 'selected' : '' }}>Follow</option><option value="0" {{ !old('settings.robots_follow', $settings->robots_follow ?? 1) ? 'selected' : '' }}>No Follow</option></select>
                            </label>
                        </div>
                        <label>Meta Description<textarea name="settings[meta_description]" rows="3">{{ old('settings.meta_description', $settings->meta_description) }}</textarea></label>
                        <label>Meta Keywords<textarea name="settings[meta_keywords]" rows="2">{{ old('settings.meta_keywords', $settings->meta_keywords) }}</textarea></label>
                        <label>Schema JSON-LD<textarea name="settings[schema_json_ld]" rows="5">{{ old('settings.schema_json_ld', $settings->schema_json_ld) }}</textarea></label>
                    </div>

                    <div class="section-box" id="footer-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Global footer</p>
                                <h4 class="section-title">Footer & Social Links</h4>
                                <p class="section-desc">Update footer identity, copyright details, company identifiers, and social links.</p>
                            </div>
                            <span class="section-chip">Site-wide</span>
                        </div>
                        <div class="grid-2">
                            <label>Footer Tagline<input name="site[footer_tagline]" value="{{ old('site.footer_tagline', $site->footer_tagline) }}"></label>
                            <label>Company Name<input name="site[footer_company_name]" value="{{ old('site.footer_company_name', $site->footer_company_name) }}"></label>
                            <label>Copyright<input name="site[footer_copyright]" value="{{ old('site.footer_copyright', $site->footer_copyright) }}"></label>
                            <label>CIN<input name="site[cin]" value="{{ old('site.cin', $site->cin) }}"></label>
                            <label>LinkedIn<input name="site[social_linkedin]" value="{{ old('site.social_linkedin', $site->social_linkedin) }}"></label>
                            <label>X / Twitter<input name="site[social_twitter]" value="{{ old('site.social_twitter', $site->social_twitter) }}"></label>
                            <label>Instagram<input name="site[social_instagram]" value="{{ old('site.social_instagram', $site->social_instagram) }}"></label>
                            <label>Footer Logo
                                @if($site->footer_logo)<img class="thumb d-block" src="{{ Storage::url($site->footer_logo) }}" alt="Footer logo">@endif
                                <input name="site[footer_logo]" type="file" accept="image/*">
                            </label>
                        </div>
                    </div>

                        </div>
                    </div>

                    <div class="save-bar">
                        <button type="submit">Update Home Page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@include('admin.adminFooter')
<script src="/js/ckeditor.js"></script>
<script>
const credentialRows = document.getElementById('credentialRows');
const addCredentialPointer = document.getElementById('addCredentialPointer');
const homeServiceRows = document.getElementById('homeServiceRows');
const addHomeServiceCard = document.getElementById('addHomeServiceCard');
const pillarRows = document.getElementById('pillarRows');
const addExpertPillar = document.getElementById('addExpertPillar');

function removeRepeatableRow(row, renumberCallback) {
    const idInput = row.querySelector('input[name$="[id]"]');
    const deleteFlag = row.querySelector('[data-delete-flag]');
    if (idInput && idInput.value && deleteFlag) {
        deleteFlag.value = '1';
        row.style.display = 'none';
    } else {
        row.remove();
    }
    if (renumberCallback) renumberCallback();
}

function renumberCredentialRows() {
    if (!credentialRows) return;
    Array.from(credentialRows.querySelectorAll('[data-credential-row]'))
        .filter(function (row) { return row.style.display !== 'none'; })
        .forEach(function (row, index) {
            const title = row.querySelector('.row-card-head h5');
            const sortInput = row.querySelector('input[name$="[sort_order]"]');
            if (title) title.textContent = 'Pointer ' + (index + 1);
            if (sortInput && !sortInput.value) sortInput.value = index;
        });
}

function bindCredentialRemove(row) {
    const removeButton = row.querySelector('[data-remove-credential]');
    if (!removeButton) return;
    removeButton.addEventListener('click', function () {
        removeRepeatableRow(row, renumberCredentialRows);
    });
}

if (credentialRows) {
    credentialRows.querySelectorAll('[data-credential-row]').forEach(bindCredentialRemove);
}

if (credentialRows && addCredentialPointer) {
    addCredentialPointer.addEventListener('click', function () {
        const index = Number(credentialRows.dataset.nextIndex || 0);
        credentialRows.dataset.nextIndex = String(index + 1);
        const row = document.createElement('div');
        row.className = 'row-card';
        row.setAttribute('data-credential-row', '');
        row.innerHTML = `
            <div class="row-card-head">
                <h5>Pointer</h5>
                <div class="row-actions">
                    <button class="admin-link-btn danger" type="button" data-remove-credential>
                        <i class="fas fa-trash-alt"></i>
                        Remove
                    </button>
                </div>
            </div>
            <input type="hidden" name="credentials[${index}][id]" value="">
            <input type="hidden" name="credentials[${index}][_delete]" value="0" data-delete-flag>
            <div class="grid-2">
                <label>Credential<input name="credentials[${index}][credential]" value=""></label>
                <label>Sort Order<input name="credentials[${index}][sort_order]" type="number" value=""></label>
            </div>
        `;
        credentialRows.appendChild(row);
        bindCredentialRemove(row);
        renumberCredentialRows();
    });
}

function renumberServiceRows() {
    if (!homeServiceRows) return;
    Array.from(homeServiceRows.querySelectorAll('[data-service-row]'))
        .filter(function (row) { return row.style.display !== 'none'; })
        .forEach(function (row, index) {
            const title = row.querySelector('.row-card-head h5');
            const sortInput = row.querySelector('input[name$="[sort_order]"]');
            if (title) title.textContent = 'Service Card ' + (index + 1);
            if (sortInput && !sortInput.value) sortInput.value = index;
        });
}

function bindServiceRemove(row) {
    const removeButton = row.querySelector('[data-remove-service]');
    if (!removeButton) return;
    removeButton.addEventListener('click', function () {
        removeRepeatableRow(row, renumberServiceRows);
    });
}

if (homeServiceRows) {
    homeServiceRows.querySelectorAll('[data-service-row]').forEach(bindServiceRemove);
}

if (homeServiceRows && addHomeServiceCard) {
    addHomeServiceCard.addEventListener('click', function () {
        const index = Number(homeServiceRows.dataset.nextIndex || 0);
        homeServiceRows.dataset.nextIndex = String(index + 1);
        const row = document.createElement('div');
        row.className = 'row-card';
        row.setAttribute('data-service-row', '');
        row.innerHTML = `
            <div class="row-card-head">
                <h5>Service Card</h5>
                <div class="row-actions">
                    <button class="admin-link-btn danger" type="button" data-remove-service>
                        <i class="fas fa-trash-alt"></i>
                        Remove
                    </button>
                    <label class="visibility-toggle">
                        <input type="hidden" name="services[${index}][visible]" value="0">
                        <input type="checkbox" name="services[${index}][visible]" value="1" checked>
                        <span aria-hidden="true"></span>
                        Visible
                    </label>
                </div>
            </div>
            <input type="hidden" name="services[${index}][id]" value="">
            <input type="hidden" name="services[${index}][_delete]" value="0" data-delete-flag>
            <div class="grid-2">
                <label>Title<input name="services[${index}][title]" value=""></label>
                <label>Status
                    <select name="services[${index}][status]">
                        <option value="active" selected>Active</option>
                        <option value="coming_soon">Coming Soon</option>
                    </select>
                </label>
                <label>Link URL<input name="services[${index}][link_url]" value=""></label>
                <label>Sort Order<input name="services[${index}][sort_order]" type="number" value=""></label>
            </div>
            <label>Description<textarea name="services[${index}][description]" rows="3"></textarea></label>
        `;
        homeServiceRows.appendChild(row);
        bindServiceRemove(row);
        renumberServiceRows();
    });
}

function renumberPillarRows() {
    if (!pillarRows) return;
    Array.from(pillarRows.querySelectorAll('[data-pillar-row]'))
        .filter(function (row) { return row.style.display !== 'none'; })
        .forEach(function (row, index) {
            const title = row.querySelector('.row-card-head h5');
            const sortInput = row.querySelector('input[name$="[sort_order]"]');
            if (title) title.textContent = 'Pillar ' + (index + 1);
            if (sortInput && !sortInput.value) sortInput.value = index;
        });
}

function bindPillarRemove(row) {
    const removeButton = row.querySelector('[data-remove-pillar]');
    if (!removeButton) return;
    removeButton.addEventListener('click', function () {
        removeRepeatableRow(row, renumberPillarRows);
    });
}

if (pillarRows) {
    pillarRows.querySelectorAll('[data-pillar-row]').forEach(bindPillarRemove);
}

if (pillarRows && addExpertPillar) {
    addExpertPillar.addEventListener('click', function () {
        const index = Number(pillarRows.dataset.nextIndex || 0);
        pillarRows.dataset.nextIndex = String(index + 1);
        const row = document.createElement('div');
        row.className = 'row-card';
        row.setAttribute('data-pillar-row', '');
        row.innerHTML = `
            <div class="row-card-head">
                <h5>Pillar</h5>
                <div class="row-actions">
                    <button class="admin-link-btn danger" type="button" data-remove-pillar>
                        <i class="fas fa-trash-alt"></i>
                        Remove
                    </button>
                </div>
            </div>
            <input type="hidden" name="pillars[${index}][id]" value="">
            <input type="hidden" name="pillars[${index}][_delete]" value="0" data-delete-flag>
            <div class="grid-2">
                <label>Title<input name="pillars[${index}][title]" value=""></label>
                <label>Sort Order<input name="pillars[${index}][sort_order]" type="number" value=""></label>
                <label style="grid-column:1/-1">Body<textarea name="pillars[${index}][body]" rows="3"></textarea></label>
            </div>
        `;
        pillarRows.appendChild(row);
        bindPillarRemove(row);
        renumberPillarRows();
    });
}

const editorNavLinks = Array.from(document.querySelectorAll('.editor-nav a[href^="#"]'));
const editorSections = editorNavLinks
    .map(function (link) { return document.querySelector(link.getAttribute('href')); })
    .filter(Boolean);

if ('IntersectionObserver' in window && editorSections.length) {
    const sectionObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            editorNavLinks.forEach(function (link) {
                link.classList.toggle('is-active', link.getAttribute('href') === '#' + entry.target.id);
            });
        });
    }, { rootMargin: '-20% 0px -65% 0px', threshold: 0.01 });

    editorSections.forEach(function (section) {
        sectionObserver.observe(section);
    });
}

document.querySelectorAll('.wysiwyg').forEach(function (textarea) {
    ClassicEditor.create(textarea, { ckfinder: { uploadUrl: "{{ '/admin/image_upload?_token=' . csrf_token() }}" } }).catch(console.error);
});
</script>
</body>
</html>
