<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form.event-form[novalidate]').forEach(function (form) {
        var btn = form.querySelector('button[type="submit"]');

        function errorEl(el) { return document.getElementById('err_' + el.name); }

        function message(el) {
            if (el.validity.valueMissing) {
                if (el.type === 'checkbox') return 'Please tick this box to continue.';
                var label = el.closest('label');
                var text = label && label.firstChild ? label.firstChild.textContent.trim() : '';
                return (text || 'This field') + ' is required.';
            }
            if (el.validity.typeMismatch && el.type === 'email') return 'Please enter a valid email address.';
            return el.validationMessage;
        }

        form.addEventListener('invalid', function (event) {
            var el = event.target;
            if (el.closest('.phone-field-wrap')) return;
            event.preventDefault();
            var err = errorEl(el);
            if (!err) return;
            err.textContent = message(el);
            err.hidden = false;
            el.classList.add('is-invalid');
        }, true);

        ['input', 'change'].forEach(function (type) {
            form.addEventListener(type, function (event) {
                var el = event.target;
                var err = errorEl(el);
                if (!err) return;
                err.hidden = true;
                el.classList.remove('is-invalid');
            });
        });

        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                var first = form.querySelector(':invalid');
                if (first) {
                    first.focus({ preventScroll: true });
                    first.scrollIntoView({ block: 'center', behavior: 'smooth' });
                }
                return;
            }
            if (btn) {
                btn.classList.add('event-btn--loading');
                btn.textContent = '';
                btn.disabled = true;
            }
        });
    });
});
</script>
