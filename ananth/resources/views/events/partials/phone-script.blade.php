<script>
(function () {
    const COUNTRIES = [
        {code:'IN',dial:'+91',name:'India'},
        {code:'AU',dial:'+61',name:'Australia'},
        {code:'BH',dial:'+973',name:'Bahrain'},
        {code:'BD',dial:'+880',name:'Bangladesh'},
        {code:'BE',dial:'+32',name:'Belgium'},
        {code:'BR',dial:'+55',name:'Brazil'},
        {code:'CA',dial:'+1',name:'Canada'},
        {code:'CN',dial:'+86',name:'China'},
        {code:'DK',dial:'+45',name:'Denmark'},
        {code:'EG',dial:'+20',name:'Egypt'},
        {code:'FI',dial:'+358',name:'Finland'},
        {code:'FR',dial:'+33',name:'France'},
        {code:'DE',dial:'+49',name:'Germany'},
        {code:'HK',dial:'+852',name:'Hong Kong'},
        {code:'ID',dial:'+62',name:'Indonesia'},
        {code:'IE',dial:'+353',name:'Ireland'},
        {code:'IT',dial:'+39',name:'Italy'},
        {code:'JP',dial:'+81',name:'Japan'},
        {code:'KE',dial:'+254',name:'Kenya'},
        {code:'KW',dial:'+965',name:'Kuwait'},
        {code:'MY',dial:'+60',name:'Malaysia'},
        {code:'MX',dial:'+52',name:'Mexico'},
        {code:'NP',dial:'+977',name:'Nepal'},
        {code:'NL',dial:'+31',name:'Netherlands'},
        {code:'NZ',dial:'+64',name:'New Zealand'},
        {code:'NO',dial:'+47',name:'Norway'},
        {code:'OM',dial:'+968',name:'Oman'},
        {code:'PH',dial:'+63',name:'Philippines'},
        {code:'QA',dial:'+974',name:'Qatar'},
        {code:'SA',dial:'+966',name:'Saudi Arabia'},
        {code:'SG',dial:'+65',name:'Singapore'},
        {code:'ZA',dial:'+27',name:'South Africa'},
        {code:'KR',dial:'+82',name:'South Korea'},
        {code:'ES',dial:'+34',name:'Spain'},
        {code:'LK',dial:'+94',name:'Sri Lanka'},
        {code:'SE',dial:'+46',name:'Sweden'},
        {code:'CH',dial:'+41',name:'Switzerland'},
        {code:'TH',dial:'+66',name:'Thailand'},
        {code:'AE',dial:'+971',name:'United Arab Emirates'},
        {code:'GB',dial:'+44',name:'United Kingdom'},
        {code:'US',dial:'+1',name:'United States'},
        {code:'VN',dial:'+84',name:'Vietnam'},
    ].sort((a, b) => {
        if (a.code === 'IN') return -1;
        if (b.code === 'IN') return 1;
        return a.name.localeCompare(b.name);
    });

    function setupPhonePicker(root) {
        let selected = COUNTRIES.find(c => c.dial === root.dataset.defaultCode) || COUNTRIES[0];
        const trigger = root.querySelector('.country-trigger');
        const dropdown = root.querySelector('.country-dropdown');
        const searchEl = root.querySelector('.country-search');
        const listEl = root.querySelector('.country-list');
        const flagEl = root.querySelector('.country-flag');
        const codeEl = root.querySelector('.country-code');
        const hiddenCode = root.querySelector('.phone-country-code');

        function renderList(filter) {
            const q = (filter || '').toLowerCase();
            const filtered = q
                ? COUNTRIES.filter(c => c.name.toLowerCase().includes(q) || c.dial.includes(q) || c.code.toLowerCase().includes(q))
                : COUNTRIES;

            listEl.innerHTML = '';
            if (!filtered.length) {
                listEl.innerHTML = '<li class="country-no-results">No countries found</li>';
                return;
            }

            filtered.forEach(c => {
                const li = document.createElement('li');
                li.className = 'country-item' + (c.code === selected.code ? ' is-active' : '');
                li.setAttribute('role', 'option');
                li.setAttribute('aria-selected', c.code === selected.code ? 'true' : 'false');
                li.innerHTML = '<span class="country-item-flag">' + c.code + '</span><span class="country-item-name">' + c.name + '</span><span class="country-item-dial">' + c.dial + '</span>';
                li.addEventListener('click', function () { select(c); });
                listEl.appendChild(li);
            });
        }

        function select(country) {
            selected = country;
            flagEl.textContent = country.code;
            codeEl.textContent = country.dial;
            hiddenCode.value = country.dial;
            validatePhone();
            close();
        }

        function open() {
            dropdown.hidden = false;
            trigger.setAttribute('aria-expanded', 'true');
            searchEl.value = '';
            renderList('');
            searchEl.focus();
        }

        function close() {
            dropdown.hidden = true;
            trigger.setAttribute('aria-expanded', 'false');
        }

        trigger.addEventListener('click', function (event) {
            event.stopPropagation();
            dropdown.hidden ? open() : close();
        });

        searchEl.addEventListener('input', function () { renderList(this.value); });
        searchEl.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                close();
                trigger.focus();
            }
        });

        document.addEventListener('click', function (event) {
            if (!root.contains(event.target)) close();
        });

        const numberInput = root.querySelector('.phone-number-input');
        const errEl = root.parentElement.querySelector('.js-phone-error');

        function phoneLengthMessage() {
            return hiddenCode.value === '+91'
                ? 'Indian mobile numbers must be exactly 10 digits.'
                : 'Please enter a valid phone number (6–15 digits).';
        }

        function validatePhone() {
            if (!numberInput) return;
            const digits = numberInput.value.replace(/\D/g, '');
            let ok = true;
            if (numberInput.value) {
                if (!/^[\d\s()+-]+$/.test(numberInput.value)) ok = false;
                else if (hiddenCode.value === '+91') ok = digits.length === 10;
                else ok = digits.length >= 6 && digits.length <= 15;
            }
            numberInput.setCustomValidity(ok ? '' : 'invalid-phone');
        }

        if (numberInput && errEl) {
            numberInput.addEventListener('invalid', function (event) {
                event.preventDefault();
                root.classList.add('is-invalid');
                errEl.textContent = numberInput.validity.valueMissing
                    ? 'Phone number is required.'
                    : phoneLengthMessage();
                errEl.hidden = false;
            });
            numberInput.addEventListener('input', function () {
                validatePhone();
                root.classList.remove('is-invalid');
                errEl.hidden = true;
            });
        }

        select(selected);
        renderList('');
    }

    document.querySelectorAll('.js-country-phone').forEach(setupPhonePicker);
})();
</script>
