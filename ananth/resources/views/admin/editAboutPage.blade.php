<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Edit About Page</title>
    <style>
        html{scroll-behavior:smooth;scroll-padding-top:24px}
        .page-editor-hero{display:flex;align-items:flex-start;justify-content:space-between;gap:24px;margin:18px 0 22px;padding:22px 24px;border:1px solid #d8e3f0;border-radius:18px;background:linear-gradient(135deg,#fff,#f8fbff);box-shadow:0 18px 50px rgba(15,23,42,.06)}
        .page-editor-eyebrow{margin:0 0 8px;color:#2562E9;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
        .page-editor-hero h2{margin:0;color:#0f172a;font-size:1.75rem;font-weight:800}
        .page-editor-hero p{max-width:720px;margin:8px 0 0;color:#64748b;line-height:1.65}
        .page-editor-pill{display:inline-flex;align-items:center;gap:8px;white-space:nowrap;border:1px solid #d8e3f0;border-radius:40px;background:#fff;padding:10px 14px;color:#475569;font-weight:700;font-size:.86rem}
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
        .grid-2>*{min-width:0}
        .form_input label{display:block;min-width:0}
        .form_input input,.form_input select,.form_input textarea{max-width:100%;width:100%;box-sizing:border-box}
        .form_input input[type="checkbox"]{width:auto}
        .form_input textarea{resize:vertical}
        .row-card{min-width:0;overflow:hidden;border:1px solid #d8e3f0;border-radius:14px;padding:16px;margin-bottom:12px;background:#fff}
        .row-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:12px}
        .row-card-head h5{margin:0;color:#0f172a;font-size:1rem;font-weight:800}
        .visibility-toggle{display:inline-flex!important;align-items:center;gap:8px;white-space:nowrap;color:#475569;font-size:.82rem;font-weight:800}
        .visibility-toggle input{position:absolute;opacity:0;pointer-events:none}
        .visibility-toggle span{position:relative;width:42px;height:24px;border-radius:999px;background:#cbd5e1;transition:background .2s}
        .visibility-toggle span::after{content:"";position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:50%;background:#fff;box-shadow:0 1px 4px rgba(15,23,42,.2);transition:transform .2s}
        .visibility-toggle input:checked+span{background:#2562E9}
        .visibility-toggle input:checked+span::after{transform:translateX(18px)}
        .thumb{max-width:180px;border-radius:10px;border:1px solid #d8e3f0;margin-bottom:8px}
        .ck.ck-editor{max-width:100%}
        .ck-editor__main,.ck-editor__editable{max-width:100%;overflow:auto}
        .ck-editor__editable{min-height:220px}
        .save-bar{position:sticky;bottom:0;z-index:5;display:flex;justify-content:flex-end;margin-top:22px;padding:14px 0;background:linear-gradient(180deg,rgba(255,255,255,0),#fff 30%)}
        .save-bar button{border:0;border-radius:40px;background:#2562E9;color:#fff;padding:12px 24px;font-weight:800;box-shadow:0 12px 28px rgba(37,98,233,.22);transition:background .2s}
        .save-bar button:hover{background:#181A3F}
        @media(max-width:1100px){.editor-layout{grid-template-columns:1fr}.editor-nav{position:relative;top:auto}.editor-nav-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:6px}.page-editor-hero{flex-direction:column}}
        @media(max-width:900px){.grid-2{grid-template-columns:1fr}}
        @media(max-width:640px){.editor-nav-list{grid-template-columns:1fr}.section-head{display:block}.section-chip{display:inline-flex;margin-top:10px}}
    </style>
</head>
<body>
@include('admin.adminHeader')
<section class="main_section">
    <div class="container-fluid">
        @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if ($errors->any())
            <div class="alert alert-danger">@foreach ($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach</div>
        @endif

        <div class="outer_wrapper mt-3">
            <div class="wrapper_head"><h3>Edit About Page</h3></div>
            <div class="wrapper_body">
                <div class="page-editor-hero">
                    <div>
                        <p class="page-editor-eyebrow">About Page Content</p>
                        <h2>Edit About Page Content</h2>
                        <p>Update the About page in focused sections. Use the left navigation to jump straight to the part you need.</p>
                    </div>
                    <span class="page-editor-pill"><i class="fas fa-address-card"></i> Section editor</span>
                </div>
                <form class="form_input" action="{{ route('updateAboutPage') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="editor-layout">
                        <aside class="editor-nav" aria-label="About page editor sections">
                            <p class="editor-nav-title">Edit Sections</p>
                            <div class="editor-nav-list">
                                <a href="#hero-section"><span class="dot"></span>Hero Section</a>
                                <a href="#intro-section"><span class="dot"></span>Company Intro</a>
                                <a href="#founders-section"><span class="dot"></span>Founders</a>
                                <a href="#purpose-section"><span class="dot"></span>Vision / Mission</a>
                                <a href="#services-section"><span class="dot"></span>Services</a>
                                <a href="#cta-section"><span class="dot"></span>CTA Strip</a>
                                <a href="#seo-section"><span class="dot"></span>SEO</a>
                            </div>
                        </aside>

                        <div class="editor-content">

                    <div class="section-box alt" id="hero-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">First viewport</p>
                                <h4 class="section-title">Hero Section</h4>
                                <p class="section-desc">Controls the About page hero headline, supporting copy, and background image.</p>
                            </div>
                            <span class="section-chip">Page top</span>
                        </div>
                        <div class="grid-2">
                            <label>Eyebrow<input name="settings[hero_eyebrow]" value="{{ old('settings.hero_eyebrow', $settings->hero_eyebrow) }}"></label>
                            <label>Heading<input name="settings[hero_heading]" value="{{ old('settings.hero_heading', $settings->hero_heading) }}"></label>
                            <label>Subheading<input name="settings[hero_subheading]" value="{{ old('settings.hero_subheading', $settings->hero_subheading) }}"></label>
                            <label>Hero Image
                                @if($settings->hero_image)<img class="thumb d-block" src="{{ Storage::url($settings->hero_image) }}" alt="Current hero">@endif
                                <input name="settings[hero_image]" type="file" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div class="section-box" id="intro-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Who we are</p>
                                <h4 class="section-title">Company Intro</h4>
                                <p class="section-desc">Edit the main introduction that explains ADL and the page’s opening narrative.</p>
                            </div>
                            <span class="section-chip">Intro copy</span>
                        </div>
                        <div class="grid-2">
                            <label>Eyebrow<input name="settings[intro_eyebrow]" value="{{ old('settings.intro_eyebrow', $settings->intro_eyebrow) }}"></label>
                            <label>Heading<input name="settings[intro_heading]" value="{{ old('settings.intro_heading', $settings->intro_heading) }}"></label>
                        </div>
                        <label>Intro Body<textarea class="wysiwyg" name="settings[intro_body]">{{ old('settings.intro_body', $settings->intro_body) }}</textarea></label>
                    </div>

                    <div class="section-box alt" id="founders-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Leadership</p>
                                <h4 class="section-title">Founders</h4>
                                <p class="section-desc">Manage the founder profiles, bios, photos, signatures, visibility, and order.</p>
                            </div>
                            <span class="section-chip">Repeatable rows</span>
                        </div>
                        @foreach($founders->concat([new \App\Models\Founder]) as $index => $founder)
                            <div class="row-card">
                                <div class="row-card-head">
                                    <h5>Founder {{ $index + 1 }}</h5>
                                    <label class="visibility-toggle">
                                        <input type="hidden" name="founders[{{ $index }}][visible]" value="0">
                                        <input type="checkbox" name="founders[{{ $index }}][visible]" value="1" {{ old("founders.$index.visible", $founder->visible ?? true) ? 'checked' : '' }}>
                                        <span aria-hidden="true"></span>
                                        Visible
                                    </label>
                                </div>
                                <input type="hidden" name="founders[{{ $index }}][id]" value="{{ $founder->id }}">
                                <div class="grid-2">
                                    <label>Eyebrow<input name="founders[{{ $index }}][eyebrow]" value="{{ old("founders.$index.eyebrow", $founder->eyebrow) }}"></label>
                                    <label>Name<input name="founders[{{ $index }}][name]" value="{{ old("founders.$index.name", $founder->name) }}"></label>
                                    <label>Title<input name="founders[{{ $index }}][title]" value="{{ old("founders.$index.title", $founder->title) }}"></label>
                                    <label>Sort Order<input name="founders[{{ $index }}][sort_order]" type="number" value="{{ old("founders.$index.sort_order", $founder->sort_order ?? $index) }}"></label>
                                    <label>Photo
                                        @if($founder->photo)<img class="thumb d-block" src="{{ Storage::url($founder->photo) }}" alt="{{ $founder->name }}">@endif
                                        <input name="founders[{{ $index }}][photo]" type="file" accept="image/*">
                                    </label>
                                    <label>Signature Image
                                        @if($founder->signature_image)<img class="thumb d-block" src="{{ Storage::url($founder->signature_image) }}" alt="Signature">@endif
                                        <input name="founders[{{ $index }}][signature_image]" type="file" accept="image/*">
                                    </label>
                                </div>
                                <label>Bio<textarea class="wysiwyg" name="founders[{{ $index }}][bio]">{{ old("founders.$index.bio", $founder->bio) }}</textarea></label>
                            </div>
                        @endforeach
                    </div>

                    <div class="section-box" id="purpose-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Purpose</p>
                                <h4 class="section-title">Vision, Mission, Values</h4>
                                <p class="section-desc">Edit the purpose cards that explain what ADL stands for and where it is heading.</p>
                            </div>
                            <span class="section-chip">3 cards</span>
                        </div>
                        @foreach(['vision' => 'Vision', 'mission' => 'Mission', 'values' => 'Values'] as $prefix => $label)
                            <div class="row-card">
                                <label>{{ $label }} Title<input name="settings[{{ $prefix }}_title]" value="{{ old("settings.{$prefix}_title", $settings->{$prefix.'_title'}) }}"></label>
                                <label>{{ $label }} Body<textarea class="wysiwyg" name="settings[{{ $prefix }}_body]">{{ old("settings.{$prefix}_body", $settings->{$prefix.'_body'}) }}</textarea></label>
                            </div>
                        @endforeach
                    </div>

                    <div class="section-box alt" id="services-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">What ADL does</p>
                                <h4 class="section-title">Services + Transparency</h4>
                                <p class="section-desc">Edit the service cards and transparency note shown on the About page.</p>
                            </div>
                            <span class="section-chip">Cards + note</span>
                        </div>
                        <div class="grid-2">
                            <label>Services Eyebrow<input name="settings[services_eyebrow]" value="{{ old('settings.services_eyebrow', $settings->services_eyebrow) }}"></label>
                            <label>Services Heading<input name="settings[services_heading]" value="{{ old('settings.services_heading', $settings->services_heading) }}"></label>
                        </div>
                        <label>Services Intro<textarea name="settings[services_intro]" rows="3">{{ old('settings.services_intro', $settings->services_intro) }}</textarea></label>
                        @foreach($services->concat([new \App\Models\ServiceCard]) as $index => $service)
                            <div class="row-card">
                                <div class="row-card-head">
                                    <h5>Service Card {{ $index + 1 }}</h5>
                                    <label class="visibility-toggle">
                                        <input type="hidden" name="services[{{ $index }}][visible]" value="0">
                                        <input type="checkbox" name="services[{{ $index }}][visible]" value="1" {{ old("services.$index.visible", $service->visible ?? true) ? 'checked' : '' }}>
                                        <span aria-hidden="true"></span>
                                        Visible
                                    </label>
                                </div>
                                <input type="hidden" name="services[{{ $index }}][id]" value="{{ $service->id }}">
                                <div class="grid-2">
                                    <label>Title<input name="services[{{ $index }}][title]" value="{{ old("services.$index.title", $service->title) }}"></label>
                                    <label>Status
                                        <select name="services[{{ $index }}][status]">
                                            <option value="active" {{ old("services.$index.status", $service->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="coming_soon" {{ old("services.$index.status", $service->status) === 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                                        </select>
                                    </label>
                                    <label>Link URL<input name="services[{{ $index }}][link_url]" value="{{ old("services.$index.link_url", $service->link_url) }}"></label>
                                    <label>Sort Order<input name="services[{{ $index }}][sort_order]" type="number" value="{{ old("services.$index.sort_order", $service->sort_order ?? $index) }}"></label>
                                </div>
                                <label>Description<textarea name="services[{{ $index }}][description]" rows="3">{{ old("services.$index.description", $service->description) }}</textarea></label>
                            </div>
                        @endforeach
                        <div class="row-card">
                            <label>Transparency Title<input name="settings[transparency_note_title]" value="{{ old('settings.transparency_note_title', $settings->transparency_note_title) }}"></label>
                            <label>Transparency Body<textarea class="wysiwyg" name="settings[transparency_note_body]">{{ old('settings.transparency_note_body', $settings->transparency_note_body) }}</textarea></label>
                            <label>Disclaimer<textarea name="settings[transparency_note_disclaimer]" rows="3">{{ old('settings.transparency_note_disclaimer', $settings->transparency_note_disclaimer) }}</textarea></label>
                        </div>
                    </div>

                    <div class="section-box" id="cta-section">
                        <div class="section-head">
                            <div>
                                <p class="section-kicker">Conversion</p>
                                <h4 class="section-title">CTA Strip</h4>
                                <p class="section-desc">Edit the page call-to-action copy and button links.</p>
                            </div>
                            <span class="section-chip">Buttons</span>
                        </div>
                        <div class="grid-2">
                            <label>Heading<input name="settings[cta_heading]" value="{{ old('settings.cta_heading', $settings->cta_heading) }}"></label>
                            <label>Body<input name="settings[cta_body]" value="{{ old('settings.cta_body', $settings->cta_body) }}"></label>
                            <label>CTA 1 Label<input name="settings[cta1_label]" value="{{ old('settings.cta1_label', $settings->cta1_label) }}"></label>
                            <label>CTA 1 Link<input name="settings[cta1_link]" value="{{ old('settings.cta1_link', $settings->cta1_link) }}"></label>
                            <label>CTA 2 Label<input name="settings[cta2_label]" value="{{ old('settings.cta2_label', $settings->cta2_label) }}"></label>
                            <label>CTA 2 Link<input name="settings[cta2_link]" value="{{ old('settings.cta2_link', $settings->cta2_link) }}"></label>
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

                        </div>
                    </div>

                    <div class="save-bar">
                        <button type="submit">Update About Page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@include('admin.adminFooter')
<script src="/js/ckeditor.js"></script>
<script>
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
