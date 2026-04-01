<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Edit About Page Content</title>
    <style>
        .html-highlight-wrapper {
            position: relative;
        }
        .html-highlight-display {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 8px 12px;
            color: transparent;
            white-space: pre-wrap;
            word-wrap: break-word;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
            pointer-events: none;
            overflow: hidden;
            border: 1px solid transparent;
        }
        .html-highlight-display .html-tag {
            color: #e74c3c;
            font-weight: bold;
            background-color: rgba(231, 76, 60, 0.1);
        }
        .html-highlight-wrapper textarea {
            position: relative;
            background: transparent;
            z-index: 1;
        }
        .ck-editor__editable {
            min-height: 250px;
        }
        .section-divider:nth-of-type(odd) {
            background: #f8f9fb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
        }
        .section-divider:nth-of-type(even) {
            background: #ffffff;
            border: 1px solid #eef1f5;
            border-radius: 8px;
            padding: 16px;
        }
        .section-title {
            margin-top: 0;
            font-size: 1.15rem;
            color: #0f6bdc;
        }
    </style>
</head>

<body>
    @include('admin.adminHeader')
    <section class="main_section">
        <div class="container-fluid">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session()->has('errors'))
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="outer_wrapper mt-3">
                <div class="wrapper_head">
                    <h3>Edit About Page Content</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ route('updateAboutPage') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Hero Banner Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Hero Banner Section</h4>
                            <input type="hidden" name="sections[0][section_key]" value="about_hero">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[0][heading]" type="text" class="html-input"
                                           value="{{ $sections['about_hero']->heading ?? 'Navigating the Future of Logistics' }}"
                                           placeholder="Enter heading">
                                    <small>Use <strong style="color: #e74c3c; background: rgba(231,76,60,0.1); padding: 2px 4px; font-weight: bold;">&lt;br&gt;</strong> to break lines and <strong style="color: #e74c3c; background: rgba(231,76,60,0.1); padding: 2px 4px; font-weight: bold;">&lt;span class="highlight-blue"&gt;word&lt;/span&gt;</strong> for the blue highlight (#3882fa).</small>
                                </div>
                                <div class="col-md-12">
                                    <h5>Subheading</h5>
                                    <input name="sections[0][subheading]" type="text"
                                           value="{{ $sections['about_hero']->subheading ?? 'From warehouse to world — we cover it all.' }}"
                                           placeholder="Enter subheading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Background Image</h5>
                                    @if(isset($sections['about_hero']->image))
                                        <img src="{{ asset($sections['about_hero']->image) }}" alt="Current Image" style="max-width: 200px; margin-bottom: 10px;">
                                    @endif
                                    <input name="image_about_hero" type="file" accept="image/*">
                                    <small class="d-block text-muted">Leave empty to keep current image</small>
                                    <small class="d-block mt-1" style="color: #0f6bdc; font-weight: 500;">📐 Recommended: 1920×1080px (Full HD) or 1600×900px | Max size: 2MB | Format: JPG, PNG, WebP</small>
                                </div>
                            </div>
                        </div>

                        <!-- Main Heading Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Main Heading Section</h4>
                            <input type="hidden" name="sections[1][section_key]" value="about_main_heading">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[1][heading]" type="text" class="html-input"
                                           value="{{ $sections['about_main_heading']->heading ?? 'Over two decades of transport and logistics expertise.' }}"
                                           placeholder="Enter heading">
                                    <small>Use <strong style="color: #e74c3c; background: rgba(231,76,60,0.1); padding: 2px 4px; font-weight: bold;">&lt;br&gt;</strong> to break lines and <strong style="color: #e74c3c; background: rgba(231,76,60,0.1); padding: 2px 4px; font-weight: bold;">&lt;span class="highlight-blue"&gt;phrase&lt;/span&gt;</strong> for blue highlight (#3882fa).</small>
                                </div>
                            </div>
                        </div>

                        <!-- Founder Profile Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Founder Profile Section</h4>
                            <input type="hidden" name="sections[2][section_key]" value="founder_profile">
                            <p class="text-muted small mb-2">Note: This profile also appears on blog detail pages.</p>

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading (Name)</h5>
                                    <input name="sections[2][heading]" type="text"
                                           value="{{ $sections['founder_profile']->heading ?? 'Ananthakrishnan J' }}"
                                           placeholder="Enter name">
                                </div>
                                <div class="col-md-12">
                                    <h5>Subheading (Title)</h5>
                                    <input name="sections[2][subheading]" type="text"
                                           value="{{ $sections['founder_profile']->subheading ?? 'CEO and Founder' }}"
                                           placeholder="Enter title">
                                </div>
                                <div class="col-md-12">
                                    <h5>Profile Content</h5>
                                    <textarea name="sections[2][content]" rows="5"
                                              placeholder="Enter profile content">{{ $sections['founder_profile']->content ?? '' }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <h5>Profile Image</h5>
                                    @if(isset($sections['founder_profile']->image))
                                        <img src="{{ asset($sections['founder_profile']->image) }}" alt="Current Image" style="max-width: 200px; margin-bottom: 10px;">
                                    @endif
                                    <input name="image_founder_profile" type="file" accept="image/*">
                                    <small class="d-block text-muted">Leave empty to keep current image</small>
                                    <small class="d-block mt-1" style="color: #0f6bdc; font-weight: 500;">📐 Recommended: 500×500px (Square) or 400×400px | Max size: 500KB | Format: JPG, PNG (Professional headshot)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Journey Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Journey Section</h4>
                            <input type="hidden" name="sections[3][section_key]" value="journey_section">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Section Title</h5>
                                    <input name="sections[3][heading]" type="text"
                                           value="{{ $sections['journey_section']->heading ?? 'JOURNEY' }}"
                                           placeholder="Enter section title">
                                </div>
                                <div class="col-md-12">
                                    <h5>Name</h5>
                                    <input name="sections[3][subheading]" type="text"
                                           value="{{ $sections['journey_section']->subheading ?? 'Ananthakrishnan J' }}"
                                           placeholder="Enter name">
                                </div>
                                <div class="col-md-12">
                                    <h5>Journey Content</h5>
                                    <textarea name="sections[3][content]" rows="5"
                                              placeholder="Enter journey content">{{ $sections['journey_section']->content ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Executive Leadership Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Executive Leadership Section</h4>
                            <input type="hidden" name="sections[4][section_key]" value="executive_leadership">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[4][heading]" type="text"
                                           value="{{ $sections['executive_leadership']->heading ?? 'Executive Leadership and Strategic Vision' }}"
                                           placeholder="Enter heading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Content</h5>
                                    <textarea name="sections[4][content]" rows="8"
                                              placeholder="Use paragraphs to outline leadership story. Blank lines become new paragraphs.">{{ $sections['executive_leadership']->content ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Expertise Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Expertise Section</h4>
                            <input type="hidden" name="sections[5][section_key]" value="expertise_section">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[5][heading]" type="text"
                                           value="{{ $sections['expertise_section']->heading ?? 'Proven Expertise Across Global Enterprises' }}"
                                           placeholder="Enter heading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Content</h5>
                                    <textarea name="sections[5][content]" rows="8"
                                              placeholder="Break into paragraphs to keep it readable.">{{ $sections['expertise_section']->content ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Innovation Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Innovation & Sustainability Section</h4>
                            <input type="hidden" name="sections[6][section_key]" value="innovation_section">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[6][heading]" type="text"
                                           value="{{ $sections['innovation_section']->heading ?? 'Innovation, Sustainability, and Continuous Improvement' }}"
                                           placeholder="Enter heading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Content</h5>
                                    <textarea name="sections[6][content]" rows="8"
                                              placeholder="Describe innovation focus. Paragraphs will be preserved.">{{ $sections['innovation_section']->content ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Credentials Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Academic Credentials Section</h4>
                            <input type="hidden" name="sections[7][section_key]" value="academic_credentials">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[7][heading]" type="text"
                                           value="{{ $sections['academic_credentials']->heading ?? 'Academic Credentials' }}"
                                           placeholder="Enter heading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Credentials</h5>
                                    <textarea name="sections[7][content]" rows="12"
                                              placeholder="Example format (separate credentials with blank line OR &lt;br&gt;):&#10;Pursuing&#10;Doctorate in Business Administration&#10;Rushford Business School, Switzerland&#10;&#10;Bachelor's Degree&#10;Business Administration&#10;University of Madras, India&#10;&#10;Other Expertise&#10;Six Sigma Master Black Belt">{{ $sections['academic_credentials']->content ?? '' }}</textarea>
                                    <small><strong>Format:</strong> Each credential has 3 lines:<br>
                                    Line 1: Label (small, italic) - e.g., "Pursuing", "Bachelor's Degree"<br>
                                    Line 2: Degree name (bold, blue color) - e.g., "Doctorate in Business Administration"<br>
                                    Line 3: Institution/Location (small, white) - e.g., "Rushford Business School, Switzerland"<br>
                                    <strong>Separate credentials with a blank line OR use &lt;br&gt; tag.</strong></small>
                                </div>
                            </div>
                        </div>

                        <!-- Commitment Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Commitment to Industry Section</h4>
                            <input type="hidden" name="sections[8][section_key]" value="commitment_section">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[8][heading]" type="text"
                                           value="{{ $sections['commitment_section']->heading ?? 'Commitment to the Industry' }}"
                                           placeholder="Enter heading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Content</h5>
                                    <textarea name="sections[8][content]" rows="8"
                                              placeholder="Use paragraphs to tell the commitment story.">{{ $sections['commitment_section']->content ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="section-divider mb-4">
                            <h4 class="section-title">About Page SEO</h4>
                            <input type="hidden" name="sections[9][section_key]" value="page_meta">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Meta Title</h5>
                                    <input name="sections[9][meta_title]" type="text"
                                           value="{{ $sections['page_meta']->meta_title ?? '' }}"
                                           placeholder="Optional about page SEO title">
                                </div>
                                <div class="col-md-12">
                                    <h5>Meta Description</h5>
                                    <textarea name="sections[9][meta_description]" rows="4"
                                              placeholder="Optional about page SEO meta description">{{ $sections['page_meta']->meta_description ?? '' }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <h5>Meta Keywords</h5>
                                    <textarea name="sections[9][meta_keywords]" rows="2"
                                              placeholder="keyword 1, keyword 2, keyword 3">{{ $sections['page_meta']->meta_keywords ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <h5>Canonical URL</h5>
                                    <input name="sections[9][canonical_url]" type="text"
                                           value="{{ $sections['page_meta']->canonical_url ?? url('about-us') }}"
                                           placeholder="https://example.com/about-us">
                                </div>
                                <div class="col-md-6">
                                    <h5>OG Image Path</h5>
                                    <input name="sections[9][og_image]" type="text"
                                           value="{{ $sections['page_meta']->og_image ?? '' }}"
                                           placeholder="img/site/seo-about.webp">
                                </div>
                                <div class="col-md-3">
                                    <h5>Robots Index</h5>
                                    <select name="sections[9][robots_index]">
                                        <option value="1" {{ ($sections['page_meta']->robots_index ?? 1) == 1 ? 'selected' : '' }}>Index</option>
                                        <option value="0" {{ ($sections['page_meta']->robots_index ?? 1) == 0 ? 'selected' : '' }}>No Index</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <h5>Robots Follow</h5>
                                    <select name="sections[9][robots_follow]">
                                        <option value="1" {{ ($sections['page_meta']->robots_follow ?? 1) == 1 ? 'selected' : '' }}>Follow</option>
                                        <option value="0" {{ ($sections['page_meta']->robots_follow ?? 1) == 0 ? 'selected' : '' }}>No Follow</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <h5>Schema JSON-LD</h5>
                                    <textarea name="sections[9][schema_json_ld]" rows="6"
                                              placeholder='{"@context":"https://schema.org"}'>{{ $sections['page_meta']->schema_json_ld ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit">Update About Page Content</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('admin.adminFooter')

    <script>
        // Add syntax highlighting for HTML tags in input fields
        document.addEventListener('DOMContentLoaded', function() {
            const htmlInputs = document.querySelectorAll('.html-input');

            htmlInputs.forEach(input => {
                // Add a visual indicator on focus
                input.addEventListener('focus', function() {
                    highlightHTMLTags(this);
                });

                input.addEventListener('blur', function() {
                    removeHighlight(this);
                });
            });

            function highlightHTMLTags(input) {
                const value = input.value;
                // Create a tooltip showing the HTML tags highlighted
                const existingTooltip = input.nextElementSibling;
                if (existingTooltip && existingTooltip.classList.contains('html-preview')) {
                    existingTooltip.remove();
                }

                if (value.includes('<') || value.includes('>')) {
                    const preview = document.createElement('div');
                    preview.className = 'html-preview';
                    preview.style.cssText = 'margin-top: 5px; padding: 8px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; font-family: monospace; font-size: 13px;';

                    // Highlight HTML tags
                    const highlighted = value.replace(/(<[^>]+>)/g, '<strong style="color: #e74c3c; background: rgba(231,76,60,0.1); font-weight: bold;">$1</strong>');
                    preview.innerHTML = '<small><strong>Preview:</strong> ' + highlighted + '</small>';

                    input.parentNode.insertBefore(preview, input.nextElementSibling);
                }
            }

            function removeHighlight(input) {
                const preview = input.nextElementSibling;
                if (preview && preview.classList.contains('html-preview')) {
                    setTimeout(() => preview.remove(), 200);
                }
            }
        });
    </script>
</body>

</html>
