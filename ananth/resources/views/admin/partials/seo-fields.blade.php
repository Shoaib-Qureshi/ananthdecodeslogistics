@php
    $seoModel = $seoModel ?? null;
@endphp

<div class="col-md-12">
    <hr>
    <h4>SEO Meta Title</h4>
    <input name="meta_title" value="{{ old('meta_title', $seoModel->meta_title ?? '') }}" type="text" placeholder="Optional SEO title">
</div>
<div class="col-md-12">
    <h4>SEO Meta Description</h4>
    <textarea name="meta_description" rows="3" placeholder="Optional SEO meta description">{{ old('meta_description', $seoModel->meta_description ?? '') }}</textarea>
</div>
<div class="col-md-12">
    <h4>SEO Keywords</h4>
    <textarea name="meta_keywords" rows="2" placeholder="keyword 1, keyword 2, keyword 3">{{ old('meta_keywords', $seoModel->meta_keywords ?? '') }}</textarea>
</div>
<div class="col-md-4">
    <h4>Canonical URL</h4>
    <input name="canonical_url" value="{{ old('canonical_url', $seoModel->canonical_url ?? '') }}" type="text" placeholder="https://example.com/page">
</div>
<div class="col-md-4">
    <h4>OG Image Path</h4>
    <input name="og_image" value="{{ old('og_image', $seoModel->og_image ?? '') }}" type="text" placeholder="media/custom-og-image.webp">
</div>
<div class="col-md-2">
    <h4>Robots Index</h4>
    <select name="robots_index">
        <option value="1" {{ old('robots_index', $seoModel->robots_index ?? 1) == 1 ? 'selected' : '' }}>Index</option>
        <option value="0" {{ old('robots_index', $seoModel->robots_index ?? 1) == 0 ? 'selected' : '' }}>No Index</option>
    </select>
</div>
<div class="col-md-2">
    <h4>Robots Follow</h4>
    <select name="robots_follow">
        <option value="1" {{ old('robots_follow', $seoModel->robots_follow ?? 1) == 1 ? 'selected' : '' }}>Follow</option>
        <option value="0" {{ old('robots_follow', $seoModel->robots_follow ?? 1) == 0 ? 'selected' : '' }}>No Follow</option>
    </select>
</div>
<div class="col-md-12">
    <h4>Schema JSON-LD</h4>
    <textarea name="schema_json_ld" rows="6" placeholder='{"@context":"https://schema.org"}'>{{ old('schema_json_ld', $seoModel->schema_json_ld ?? '') }}</textarea>
</div>
