@php
    $instance = $instance ?? 'faq-editor';
    $faqEnabled = filter_var($faqEnabled ?? false, FILTER_VALIDATE_BOOLEAN);
    $faqCollection = collect($faqItems ?? [])->map(function ($item) {
        return [
            'question' => (string) data_get($item, 'question', ''),
            'answer' => (string) data_get($item, 'answer', ''),
        ];
    });
    $nextFaqIndex = $faqCollection->keys()->reduce(function ($carry, $key) {
        return is_numeric($key) ? max($carry, ((int) $key) + 1) : $carry;
    }, 0);
    $renderFaqItems = $faqCollection->isEmpty() && $faqEnabled
        ? collect([['question' => '', 'answer' => '']])
        : $faqCollection;
@endphp

@once
    <style>
        .faq-editor {
            margin: 1rem 0 0;
            padding: 1.25rem;
            border: 1px solid #dbe7f4;
            border-radius: 18px;
            background: linear-gradient(180deg, #fbfdff 0%, #f6faff 100%);
        }

        .faq-editor__top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .faq-editor__eyebrow {
            margin-bottom: 0.35rem;
            color: #3882fa;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .faq-editor__title {
            margin: 0;
            color: #0f172a;
            font-size: 1.05rem;
            font-weight: 700;
        }

        .faq-editor__copy {
            margin: 0.45rem 0 0;
            color: #475569;
            font-size: 0.88rem;
            line-height: 1.6;
        }

        .faq-editor__switch {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.7rem 0.9rem;
            border: 1px solid #dbeafe;
            border-radius: 999px;
            background: #ffffff;
            color: #1e3a8a;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .faq-editor__switch input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin: 0;
        }

        .faq-editor__panel[hidden] {
            display: none;
        }

        .faq-editor__rows {
            display: grid;
            gap: 0.9rem;
        }

        .faq-editor__item {
            padding: 1rem;
            border: 1px solid #dbe7f4;
            border-radius: 16px;
            background: #ffffff;
        }

        .faq-editor__item-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.85rem;
        }

        .faq-editor__item-label {
            color: #334155;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .faq-editor__remove {
            border: 1px solid #fecaca;
            border-radius: 999px;
            background: #fff1f2;
            color: #be123c;
            padding: 0.35rem 0.8rem;
            font-size: 0.76rem;
            font-weight: 700;
            cursor: pointer;
        }

        .faq-editor__fields {
            display: grid;
            gap: 0.85rem;
        }

        .faq-editor__field label {
            display: block;
            margin-bottom: 0.4rem;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .faq-editor__field input,
        .faq-editor__field textarea {
            width: 100%;
            margin-bottom: 0;
        }

        .faq-editor__field textarea {
            min-height: 110px;
        }

        .faq-editor__actions {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .faq-editor__add {
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 0.7rem 1rem;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
        }

        .faq-editor__hint {
            color: #64748b;
            font-size: 0.8rem;
            line-height: 1.55;
        }

        .faq-editor__error {
            margin-top: 0.9rem;
            color: #b91c1c;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .faq-editor__field-error {
            margin-top: 0.35rem;
            color: #b91c1c;
            font-size: 0.78rem;
        }

        @media (max-width: 767px) {
            .faq-editor {
                padding: 1rem;
            }

            .faq-editor__top,
            .faq-editor__item-top {
                flex-direction: column;
                align-items: flex-start;
            }

            .faq-editor__switch {
                white-space: normal;
            }
        }
    </style>
@endonce

<div class="faq-editor" id="faq-editor-{{ $instance }}" data-next-index="{{ $nextFaqIndex }}">
    <div class="faq-editor__top">
        <div>
            <div class="faq-editor__eyebrow">FAQ Section</div>
            <h4 class="faq-editor__title">Add frequently asked questions</h4>
            <p class="faq-editor__copy">When enabled, these FAQs will appear at the end of the live article.</p>
        </div>
        <label class="faq-editor__switch">
            <input type="hidden" name="has_faqs" value="0">
            <input type="checkbox" name="has_faqs" value="1" data-faq-toggle {{ $faqEnabled ? 'checked' : '' }}>
            <span>Show FAQs on this post</span>
        </label>
    </div>

    <div class="faq-editor__panel" data-faq-panel {{ $faqEnabled ? '' : 'hidden' }}>
        <div class="faq-editor__rows" data-faq-rows>
            @foreach ($renderFaqItems as $index => $faqItem)
                <div class="faq-editor__item" data-faq-item>
                    <div class="faq-editor__item-top">
                        <div class="faq-editor__item-label">FAQ Item</div>
                        <button type="button" class="faq-editor__remove" data-faq-remove>Remove</button>
                    </div>
                    <div class="faq-editor__fields">
                        <div class="faq-editor__field">
                            <label for="faq-question-{{ $instance }}-{{ $index }}">Question</label>
                            <input id="faq-question-{{ $instance }}-{{ $index }}" type="text" name="faq_items[{{ $index }}][question]" value="{{ $faqItem['question'] }}" placeholder="Write the question">
                            @error("faq_items.$index.question")
                                <div class="faq-editor__field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="faq-editor__field">
                            <label for="faq-answer-{{ $instance }}-{{ $index }}">Answer</label>
                            <textarea id="faq-answer-{{ $instance }}-{{ $index }}" name="faq_items[{{ $index }}][answer]" placeholder="Write the answer">{{ $faqItem['answer'] }}</textarea>
                            @error("faq_items.$index.answer")
                                <div class="faq-editor__field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="faq-editor__actions">
            <button type="button" class="faq-editor__add" data-faq-add>Add Another FAQ</button>
            <div class="faq-editor__hint">Tip: keep answers concise and useful. Plain text works best here.</div>
        </div>
    </div>

    @error('faq_items')
        <div class="faq-editor__error">{{ $message }}</div>
    @enderror

    <template data-faq-template>
        <div class="faq-editor__item" data-faq-item>
            <div class="faq-editor__item-top">
                <div class="faq-editor__item-label">FAQ Item</div>
                <button type="button" class="faq-editor__remove" data-faq-remove>Remove</button>
            </div>
            <div class="faq-editor__fields">
                <div class="faq-editor__field">
                    <label>Question</label>
                    <input type="text" name="faq_items[__INDEX__][question]" data-faq-question placeholder="Write the question">
                </div>
                <div class="faq-editor__field">
                    <label>Answer</label>
                    <textarea name="faq_items[__INDEX__][answer]" data-faq-answer placeholder="Write the answer"></textarea>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    (function () {
        var root = document.getElementById('faq-editor-{{ $instance }}');

        if (!root || root.dataset.faqReady === '1') {
            return;
        }

        root.dataset.faqReady = '1';

        var toggle = root.querySelector('[data-faq-toggle]');
        var panel = root.querySelector('[data-faq-panel]');
        var rows = root.querySelector('[data-faq-rows]');
        var addButton = root.querySelector('[data-faq-add]');
        var template = root.querySelector('template[data-faq-template]');
        var nextIndex = Number(root.getAttribute('data-next-index') || 0);

        function addRow() {
            var html = template.innerHTML.replace(/__INDEX__/g, String(nextIndex));
            var wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            rows.appendChild(wrapper.firstElementChild);
            nextIndex += 1;
            root.setAttribute('data-next-index', String(nextIndex));
        }

        function syncPanel() {
            var hasItems = rows.querySelector('[data-faq-item]');
            panel.hidden = !toggle.checked;

            if (toggle.checked && !hasItems) {
                addRow();
            }
        }

        addButton.addEventListener('click', function () {
            addRow();
        });

        rows.addEventListener('click', function (event) {
            var removeButton = event.target.closest('[data-faq-remove]');

            if (!removeButton) {
                return;
            }

            var item = removeButton.closest('[data-faq-item]');
            var items = rows.querySelectorAll('[data-faq-item]');

            if (items.length === 1) {
                item.querySelectorAll('input, textarea').forEach(function (field) {
                    field.value = '';
                });
                return;
            }

            item.remove();
        });

        toggle.addEventListener('change', syncPanel);
        syncPanel();
    })();
</script>
