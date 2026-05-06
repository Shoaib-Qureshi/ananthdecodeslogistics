@php($isExisting = !empty($faq?->id))
<div class="event-admin-row">
    @if($isExisting)
        <input type="hidden" name="faqs[{{ $index }}][id]" value="{{ $faq->id }}">
        <input type="hidden" data-delete-input name="faqs[{{ $index }}][_delete]" value="0">
    @endif
    <div class="event-admin-row-head">
        <strong>FAQ</strong>
        <div class="event-admin-actions">
            <label class="visible-toggle"><input type="checkbox" name="faqs[{{ $index }}][visible]" value="1" {{ (!$faq || $faq->visible) ? 'checked' : '' }}> Visible</label>
            <button type="button" class="event-admin-btn danger" data-remove-row>Remove</button>
        </div>
    </div>
    <div class="event-admin-grid">
        <label>Question <input name="faqs[{{ $index }}][question]" value="{{ $faq->question ?? '' }}"></label>
        <label>Sort Order <input type="number" name="faqs[{{ $index }}][sort_order]" value="{{ $faq->sort_order ?? 0 }}"></label>
    </div>
    <label>Answer <textarea name="faqs[{{ $index }}][answer]">{{ $faq->answer ?? '' }}</textarea></label>
</div>
