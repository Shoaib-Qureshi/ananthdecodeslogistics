@php($isExisting = !empty($item?->id))
<div class="event-admin-row">
    @if($isExisting)
        <input type="hidden" name="agenda[{{ $index }}][id]" value="{{ $item->id }}">
        <input type="hidden" data-delete-input name="agenda[{{ $index }}][_delete]" value="0">
    @endif
    <div class="event-admin-row-head">
        <strong>Agenda Item</strong>
        <div class="event-admin-actions">
            <label class="visible-toggle"><input type="checkbox" name="agenda[{{ $index }}][visible]" value="1" {{ (!$item || $item->visible) ? 'checked' : '' }}> Visible</label>
            <button type="button" class="event-admin-btn danger" data-remove-row>Remove</button>
        </div>
    </div>
    <div class="event-admin-grid-3">
        <label>Start Time <input name="agenda[{{ $index }}][start_time]" value="{{ $item->start_time ?? '' }}"></label>
        <label>End Time <input name="agenda[{{ $index }}][end_time]" value="{{ $item->end_time ?? '' }}"></label>
        <label>Duration <input name="agenda[{{ $index }}][duration]" value="{{ $item->duration ?? '' }}"></label>
        <label>Type <input name="agenda[{{ $index }}][session_type]" value="{{ $item->session_type ?? '' }}"></label>
        <label>Sort Order <input type="number" name="agenda[{{ $index }}][sort_order]" value="{{ $item->sort_order ?? 0 }}"></label>
    </div>
    <label>Title <input name="agenda[{{ $index }}][title]" value="{{ $item->title ?? '' }}"></label>
    <label>Description <textarea name="agenda[{{ $index }}][description]">{{ $item->description ?? '' }}</textarea></label>
</div>
