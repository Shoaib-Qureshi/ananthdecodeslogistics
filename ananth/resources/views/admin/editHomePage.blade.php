<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Edit Home Page Content</title>
    <style>
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
                    <h3>Edit Home Page Content</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ route('updateHomePage') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Hero Banner Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title" style="font-size:1.15rem;color:#0f6bdc;">Hero Banner Section</h4>
                            <input type="hidden" name="sections[0][section_key]" value="hero_banner">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[0][heading]" type="text"
                                           value="{{ $sections['hero_banner']->heading ?? 'Your journey in logistics made simpler.' }}"
                                           placeholder="Enter heading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Subheading</h5>
                                    <input name="sections[0][subheading]" type="text"
                                           value="{{ $sections['hero_banner']->subheading ?? 'Your daily route to supply chain intelligence.' }}"
                                           placeholder="Enter subheading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Background Image</h5>
                                    @if(isset($sections['hero_banner']->image))
                                        <img src="{{ asset($sections['hero_banner']->image) }}" alt="Current Image" style="max-width: 200px; margin-bottom: 10px;">
                                    @endif
                                    <input name="image_hero_banner" type="file" accept="image/*">
                                    <small class="d-block text-muted">Leave empty to keep current image</small>
                                    <small class="d-block mt-1" style="color: #0f6bdc; font-weight: 500;">📐 Recommended: 1920×1080px (Full HD) or 1600×900px | Max size: 2MB | Format: JPG, PNG, WebP</small>
                                </div>
                            </div>
                        </div>

                        <!-- About Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">About Section</h4>
                            <input type="hidden" name="sections[1][section_key]" value="about_section">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[1][heading]" type="text"
                                           value="{{ $sections['about_section']->heading ?? 'Ananthakrishnan J' }}"
                                           placeholder="Enter heading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Content</h5>
                                    <textarea name="sections[1][content]" rows="5"
                                              placeholder="Enter about content">{{ $sections['about_section']->content ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <h5>Button Text</h5>
                                    <input name="sections[1][button_text]" type="text"
                                           value="{{ $sections['about_section']->button_text ?? 'Know More' }}"
                                           placeholder="Enter button text">
                                </div>
                                <div class="col-md-6">
                                    <h5>Button Link</h5>
                                    <input name="sections[1][button_link]" type="text"
                                           value="{{ $sections['about_section']->button_link ?? '/about-us/' }}"
                                           placeholder="Enter button link">
                                </div>
                                <div class="col-md-12">
                                    <h5>About Image</h5>
                                    @if(isset($sections['about_section']->image))
                                        <img src="{{ asset($sections['about_section']->image) }}" alt="Current Image" style="max-width: 200px; margin-bottom: 10px;">
                                    @endif
                                    <input name="image_about_section" type="file" accept="image/*">
                                    <small class="d-block text-muted">Leave empty to keep current image</small>
                                    <small class="d-block mt-1" style="color: #0f6bdc; font-weight: 500;">📐 Recommended: 800×800px (Square) or 600×600px | Max size: 1MB | Format: JPG, PNG</small>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Featured Section</h4>
                            <input type="hidden" name="sections[2][section_key]" value="featured_section">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Heading</h5>
                                    <input name="sections[2][heading]" type="text"
                                           value="{{ $sections['featured_section']->heading ?? 'Logistics Insights Backed by 25 Years of Experience' }}"
                                           placeholder="Enter heading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Content</h5>
                                    <textarea name="sections[2][content]" rows="5"
                                              placeholder="Enter content">{{ $sections['featured_section']->content ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <h5>Statistic Number</h5>
                                    <input name="sections[2][stat_number]" type="text"
                                           value="{{ $sections['featured_section']->stat_number ?? '97%' }}"
                                           placeholder="Enter statistic number">
                                </div>
                                <div class="col-md-6">
                                    <h5>Statistic Label</h5>
                                    <input name="sections[2][stat_label]" type="text"
                                           value="{{ $sections['featured_section']->stat_label ?? 'Customer Retention Rate' }}"
                                           placeholder="Enter statistic label">
                                </div>
                                <div class="col-md-12">
                                    <h5>Featured Image</h5>
                                    @if(isset($sections['featured_section']->image))
                                        <img src="{{ asset($sections['featured_section']->image) }}" alt="Current Image" style="max-width: 200px; margin-bottom: 10px;">
                                    @endif
                                    <input name="image_featured_section" type="file" accept="image/*">
                                    <small class="d-block text-muted">Leave empty to keep current image</small>
                                    <small class="d-block mt-1" style="color: #0f6bdc; font-weight: 500;">📐 Recommended: 1200×800px (3:2 ratio) or 1000×667px | Max size: 1.5MB | Format: JPG, PNG</small>
                                </div>
                            </div>
                        </div>

                        <!-- Latest Blogs Section -->
                        <div class="section-divider mb-4">
                            <h4 class="section-title">Latest Blogs Section</h4>
                            <input type="hidden" name="sections[3][section_key]" value="latest_blogs_section">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Section Heading</h5>
                                    <input name="sections[3][heading]" type="text"
                                           value="{{ $sections['latest_blogs_section']->heading ?? 'Latest Blogs' }}"
                                           placeholder="Enter section heading">
                                </div>
                                <div class="col-md-12">
                                    <h5>Background Image</h5>
                                    @if(isset($sections['latest_blogs_section']->image))
                                        <img src="{{ asset($sections['latest_blogs_section']->image) }}" alt="Current Image" style="max-width: 200px; margin-bottom: 10px;">
                                    @endif
                                    <input name="image_latest_blogs_section" type="file" accept="image/*">
                                    <small class="d-block text-muted">Leave empty to keep current image</small>
                                    <small class="d-block mt-1" style="color: #0f6bdc; font-weight: 500;">📐 Recommended: 1920×600px (Wide banner) or 1600×500px | Max size: 2MB | Format: JPG, PNG, WebP</small>
                                </div>
                            </div>
                        </div>

                        <button type="submit">Update Home Page Content</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('admin.adminFooter')
</body>

</html>
