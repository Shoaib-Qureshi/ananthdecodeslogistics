@php
    $fieldName = $fieldName ?? 'phone';
    $codeName = $codeName ?? 'phone_country_code';
    $idPrefix = $idPrefix ?? 'event_phone';
    $label = $label ?? 'Phone Number';
    $value = $value ?? old($fieldName);
    $codeValue = old($codeName, '+91');
@endphp

<div class="event-field event-phone-field">
    <label class="event-field-label" for="{{ $idPrefix }}_number">{{ $label }}</label>
    <div class="phone-field-wrap @error($fieldName) is-invalid @enderror js-country-phone" data-default-code="{{ $codeValue }}">
        <div class="country-select">
            <button type="button" class="country-trigger" aria-haspopup="listbox" aria-expanded="false" aria-label="Select country code">
                <span class="country-flag">IN</span>
                <span class="country-code">+91</span>
                <svg class="country-chevron" width="11" height="11" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>
            </button>
            <div class="country-dropdown" hidden role="listbox" aria-label="Country codes">
                <div class="country-search-wrap">
                    <input type="text" class="country-search" placeholder="Search country..." autocomplete="off" aria-label="Search countries">
                </div>
                <ul class="country-list"></ul>
            </div>
        </div>
        <input type="hidden" name="{{ $codeName }}" class="phone-country-code" value="{{ $codeValue }}">
        <input type="tel" id="{{ $idPrefix }}_number" name="{{ $fieldName }}" class="phone-number-input" value="{{ $value }}" placeholder="98765 43210" inputmode="tel" autocomplete="tel-national">
    </div>
    @error($fieldName)<div class="field-error">{{ $message }}</div>@enderror
</div>
