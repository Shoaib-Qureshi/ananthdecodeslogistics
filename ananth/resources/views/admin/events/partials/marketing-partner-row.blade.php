@php
    $partner = is_array($partner ?? null) ? $partner : [];
    $partnerLogo = \App\Models\Event::normalizePublicAssetUrl($partner['logo'] ?? '');
@endphp
<div class="marketing-partner-admin-row" data-marketing-partner-row>
    <div class="marketing-partner-admin-preview">
        <img
            src="{{ $partnerLogo }}"
            alt=""
            data-marketing-partner-preview
            @if($partnerLogo === '') hidden @endif>
        <span data-marketing-partner-placeholder @if($partnerLogo !== '') hidden @endif>Logo preview</span>
    </div>
    <div class="marketing-partner-admin-fields">
        <input type="hidden" name="marketing_partners[{{ $index }}][logo]" value="{{ $partnerLogo }}">
        <label>Company name
            <input name="marketing_partners[{{ $index }}][name]" value="{{ $partner['name'] ?? '' }}" placeholder="e.g. NeuWork Solutions" required>
        </label>
        <label>Partner role
            <input name="marketing_partners[{{ $index }}][role]" value="{{ $partner['role'] ?? '' }}" placeholder="e.g. Marketing &amp; Execution Partners" required>
        </label>
        <label>Logo image
            <input type="file" name="marketing_partners[{{ $index }}][logo_file]" accept="image/jpeg,image/png,image/webp" data-marketing-partner-file {{ $partnerLogo === '' ? 'required' : '' }}>
            <span class="field-help">{{ $partnerLogo === '' ? 'Required for a new partner.' : 'Optional. Choose a file only to replace the current logo.' }}</span>
        </label>
    </div>
    <button type="button" class="event-admin-btn danger marketing-partner-remove" data-remove-marketing-partner>Remove</button>
</div>
