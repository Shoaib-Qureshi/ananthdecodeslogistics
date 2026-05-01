@php
    $bannerImage = $banner?->image
        ? (Str::startsWith($banner->image, ['img/', 'media/']) ? asset($banner->image) : asset('storage/' . $banner->image))
        : asset('img/site-banner.jpg');
@endphp

<section class="adl-page-banner">
    <div class="adl-page-banner__image" style="background-image:url('{{ $bannerImage }}')"></div>
    <div class="adl-page-banner__overlay"></div>
    <div class="adl-page-banner__inner">
        <div class="adl-page-banner__copy">
            @if($banner?->eyebrow)<p class="adl-page-banner__eyebrow">{{ $banner->eyebrow }}</p>@endif
            <h1>{{ $banner?->heading ?? $fallbackHeading }}</h1>
            @if($banner?->subheading || !empty($fallbackSubheading))
                <p class="adl-page-banner__subheading">{{ $banner?->subheading ?? $fallbackSubheading }}</p>
            @endif
            @if($banner?->cta_label && $banner?->cta_link)
                <a class="adl-page-banner__cta" href="{{ $banner->cta_link }}">{{ $banner->cta_label }}</a>
            @endif
        </div>
    </div>
</section>
