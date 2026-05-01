<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Page Banners</title>
    <style>
        .banner-box{background:#fff;border:1px solid #d8e3f0;border-radius:10px;padding:18px;margin-bottom:18px}
        .banner-box:nth-child(even){background:#f8fafc}
        .banner-title{font-size:1.1rem;color:#0369a1;margin:0 0 14px;font-weight:700}
        .grid-2{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
        .thumb{max-width:220px;border-radius:8px;border:1px solid #d8e3f0;margin-bottom:8px}
        @media(max-width:900px){.grid-2{grid-template-columns:1fr}}
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
            <div class="wrapper_head"><h3>Page Banners</h3></div>
            <div class="wrapper_body">
                <form class="form_input" action="{{ route('admin.page-banners.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @foreach($bannerKeys as $key => $label)
                        @php($banner = $banners->get($key) ?? new \App\Models\PageBanner(['key' => $key, 'is_active' => true]))
                        <div class="banner-box">
                            <h4 class="banner-title">{{ $label }}</h4>
                            <input type="hidden" name="banners[{{ $loop->index }}][key]" value="{{ $key }}">
                            <div class="grid-2">
                                <label>Eyebrow<input name="banners[{{ $loop->index }}][eyebrow]" value="{{ old("banners.$loop->index.eyebrow", $banner->eyebrow) }}"></label>
                                <label>Heading<input name="banners[{{ $loop->index }}][heading]" value="{{ old("banners.$loop->index.heading", $banner->heading) }}"></label>
                                <label>CTA Label<input name="banners[{{ $loop->index }}][cta_label]" value="{{ old("banners.$loop->index.cta_label", $banner->cta_label) }}"></label>
                                <label>CTA Link<input name="banners[{{ $loop->index }}][cta_link]" value="{{ old("banners.$loop->index.cta_link", $banner->cta_link) }}"></label>
                                <label>Banner Image
                                    @if($banner->image)<img class="thumb d-block" src="{{ Storage::url($banner->image) }}" alt="{{ $label }}">@endif
                                    <input name="banners[{{ $loop->index }}][image]" type="file" accept="image/*">
                                </label>
                                <label style="padding-top:28px"><input type="hidden" name="banners[{{ $loop->index }}][is_active]" value="0"><input type="checkbox" name="banners[{{ $loop->index }}][is_active]" value="1" {{ old("banners.$loop->index.is_active", $banner->is_active ?? true) ? 'checked' : '' }}> Active</label>
                            </div>
                            <label>Subheading<textarea name="banners[{{ $loop->index }}][subheading]" rows="3">{{ old("banners.$loop->index.subheading", $banner->subheading) }}</textarea></label>
                        </div>
                    @endforeach
                    <button type="submit">Update Page Banners</button>
                </form>
            </div>
        </div>
    </div>
</section>
@include('admin.adminFooter')
</body>
</html>
