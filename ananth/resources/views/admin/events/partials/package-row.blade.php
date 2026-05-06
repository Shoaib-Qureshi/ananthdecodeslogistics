@php($isExisting = !empty($package?->id))
<div class="event-admin-card">
    @if($isExisting)
        <input type="hidden" name="packages[{{ $index }}][id]" value="{{ $package->id }}">
        <input type="hidden" data-delete-input name="packages[{{ $index }}][_delete]" value="0">
    @endif
    <div class="event-admin-row-head">
        <h3>{{ $package->name ?? 'New Sponsor Package' }}</h3>
        <div class="event-admin-actions">
            <label class="visible-toggle"><input type="checkbox" name="packages[{{ $index }}][visible]" value="1" {{ (!$package || $package->visible) ? 'checked' : '' }}> Visible</label>
            <button type="button" class="event-admin-btn danger" data-remove-row>Remove</button>
        </div>
    </div>
    <div class="event-admin-grid-3">
        <label>Name <input name="packages[{{ $index }}][name]" value="{{ $package->name ?? '' }}"></label>
        <label>Slots <input type="number" min="0" name="packages[{{ $index }}][slot_count]" value="{{ $package->slot_count ?? 1 }}"></label>
        <label>Sort Order <input type="number" name="packages[{{ $index }}][sort_order]" value="{{ $package->sort_order ?? 0 }}"></label>
        <label>INR Price <input type="number" step="0.01" min="0" name="packages[{{ $index }}][price_inr]" value="{{ $package->price_inr ?? 0 }}"></label>
        <label>USD Price <input type="number" step="0.01" min="0" name="packages[{{ $index }}][price_usd]" value="{{ $package->price_usd ?? 0 }}"></label>
        <label>Included Passes <input type="number" min="0" name="packages[{{ $index }}][included_passes]" value="{{ $package->included_passes ?? 0 }}"></label>
    </div>
    <label>Description <textarea name="packages[{{ $index }}][description]">{{ $package->description ?? '' }}</textarea></label>
    <label>Benefits, one per line <textarea name="packages[{{ $index }}][benefits_text]">{{ implode("\n", $package->benefits ?? []) }}</textarea></label>
</div>
