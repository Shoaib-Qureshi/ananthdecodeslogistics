@once
<style>
    /* ── Base ───────────────────────────────────────────────── */
    .event-page{--dark-grey:#0f172a;--medium-grey:#475569;--primary-color:#2562E9;font-family:"Public Sans",system-ui,sans-serif;color:#0f172a;background:#fff}
    .event-container{width:min(1200px,calc(100% - 32px));margin:0 auto}

    /* ── Hero ───────────────────────────────────────────────── */
    .event-hero{position:relative;overflow:hidden;background:#020617;color:#fff}
    .event-hero:before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 76% 16%,rgba(37,98,233,.42),transparent 32%),radial-gradient(circle at 18% 84%,rgba(14,165,233,.16),transparent 30%),linear-gradient(105deg,#020617 0%,#07111f 48%,#102941 100%)}
    .event-hero:after{content:var(--hero-watermark,"LOGISPHERE");position:absolute;right:-5vw;bottom:22px;color:rgba(255,255,255,.035);font-size:clamp(5rem,14vw,15rem);font-weight:900;letter-spacing:.02em;line-height:1;pointer-events:none;white-space:nowrap}
    /* Hero image in right grid column */
    .event-hero__image-wrap{display:flex;flex-direction:column;gap:14px;align-self:center}
    .event-hero__image{width:100%;border-radius:20px;object-fit:cover;box-shadow:0 32px 80px rgba(0,0,0,.45);border:1px solid rgba(255,255,255,.12)}
    .event-hero__image-facts{display:flex;gap:0;border:1px solid rgba(255,255,255,.14);border-radius:14px;background:rgba(255,255,255,.07);backdrop-filter:blur(14px);overflow:hidden}
    .event-hero__image-facts div{flex:1;padding:14px 16px;border-right:1px solid rgba(255,255,255,.1)}
    .event-hero__image-facts div:last-child{border-right:0}
    .event-hero__image-facts span{display:block;color:#94a3b8;font-size:.68rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
    .event-hero__image-facts strong{display:block;margin-top:5px;color:#fff;font-size:.9rem;line-height:1.35}
    .event-hero__inner{position:relative;z-index:1;display:grid;grid-template-columns:minmax(0,1fr) 360px;gap:42px;align-items:center;min-height:560px;padding:86px 0 104px}

    /* ── Eyebrow ────────────────────────────────────────────── */
    .event-eyebrow{display:inline-flex;align-items:center;gap:12px;margin:0 0 18px;color:#2562E9;font-size:.76rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase}
    .event-eyebrow:before,.event-eyebrow:after{content:"";width:28px;height:1px;background:#2562E9}
    /* Keep light eyebrow on dark backgrounds */
    .event-hero .event-eyebrow,.event-card--dark .event-eyebrow,.event-section--dark .event-eyebrow{color:#bae6fd}
    .event-hero .event-eyebrow:before,.event-hero .event-eyebrow:after,.event-card--dark .event-eyebrow:before,.event-card--dark .event-eyebrow:after,.event-section--dark .event-eyebrow:before,.event-section--dark .event-eyebrow:after{background:#38bdf8}

    /* ── Typography ─────────────────────────────────────────── */
    .event-hero h1,.event-title{font-family:"Playfair Display",Georgia,serif;font-weight:500;letter-spacing:0;line-height:1.08}
    .event-hero h1{max-width:780px;margin:0;font-size:clamp(2.75rem,6vw,5.7rem)}
    .event-hero p{max-width:650px;margin:22px 0 0;color:rgba(255,255,255,.78);font-size:1.08rem;line-height:1.75}
    .event-title{margin:0 0 18px;font-size:clamp(2rem,4vw,4rem)}
    .event-lead{max-width:780px;color:#475569;font-size:1.04rem;line-height:1.8}

    /* ── Kicker card ────────────────────────────────────────── */
    .event-kicker-card{display:inline-flex;align-items:center;gap:10px;margin-bottom:20px;border:1px solid rgba(255,255,255,.16);border-radius:999px;background:rgba(255,255,255,.07);padding:9px 13px;color:#dbeafe;font-size:.82rem;font-weight:800;backdrop-filter:blur(14px)}
    .event-kicker-dot{width:8px;height:8px;border-radius:50%;background:#38bdf8;box-shadow:0 0 0 6px rgba(56,189,248,.12);animation:event-pulse 2.4s ease-in-out infinite}
    @keyframes event-pulse{0%,100%{box-shadow:0 0 0 6px rgba(56,189,248,.12)}50%{box-shadow:0 0 0 10px rgba(56,189,248,.22)}}

    /* Countdown urgency block */
    .event-countdown{width:min(100%,520px);margin-top:24px;border:1px solid rgba(125,211,252,.26);border-radius:14px;background:rgba(255,255,255,.065);padding:13px 14px;backdrop-filter:blur(14px)}
    .event-countdown__heading{display:flex;align-items:center;gap:8px;margin:0 0 11px;color:#bae6fd;font-size:.68rem;font-weight:900;letter-spacing:.1em;line-height:1;text-transform:uppercase}
    .event-countdown__dot{display:block;flex:0 0 7px;width:7px;height:7px;border-radius:50%;background:#38bdf8;box-shadow:0 0 0 4px rgba(56,189,248,.12)}
    .event-countdown__units{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:6px}
    .event-countdown__units div{min-width:0;border-right:1px solid rgba(255,255,255,.12);text-align:center}
    .event-countdown__units div:last-child{border-right:0}
    .event-countdown__units strong{display:block;color:#fff;font-size:clamp(1.25rem,2.8vw,1.75rem);font-variant-numeric:tabular-nums;line-height:1;font-weight:700;letter-spacing:-.02em}
    .event-countdown__units span{display:block;margin-top:6px;color:rgba(255,255,255,.54);font-size:.62rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase}
    .event-countdown.is-complete{border-color:rgba(56,189,248,.4)}

    /* ── Buttons ────────────────────────────────────────────── */
    .event-actions{display:flex;flex-wrap:wrap;gap:14px;margin-top:30px}
    .event-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:48px;border:1px solid rgba(255,255,255,.24);border-radius:40px;background:transparent;color:#fff!important;padding:0 28px;font-weight:800;font-size:.94rem;text-decoration:none;transition:background .2s,border-color .2s,color .2s,box-shadow .2s;cursor:pointer;position:relative;overflow:hidden}
    .event-btn--primary{border-color:#2562E9;background:#2562E9}
    .event-btn--primary:hover{background:#1a4fc4;border-color:#1a4fc4;box-shadow:0 8px 24px rgba(37,98,233,.35)}
    .event-btn--light{border-color:#d8e3f0;color:#0f172a!important;background:#fff}
    .event-btn--light:hover{background:#f0f7ff;border-color:#2562E9;color:#2562E9!important}
    .event-btn:not(.event-btn--primary):not(.event-btn--light):hover{background:#181A3F;border-color:#181A3F;color:#fff!important}
    .event-btn:focus-visible{outline:2px solid #38bdf8;outline-offset:3px}

    /* Loading spinner on buttons */
    .event-btn--loading{pointer-events:none;opacity:.72}
    .event-btn--loading:after{content:"";width:16px;height:16px;border:2px solid currentColor;border-top-color:transparent;border-radius:50%;animation:event-spin .7s linear infinite}
    @keyframes event-spin{to{transform:rotate(360deg)}}

    /* ── Facts card in hero ─────────────────────────────────── */
    .event-facts{border:1px solid rgba(255,255,255,.18);border-radius:26px;background:linear-gradient(180deg,rgba(255,255,255,.12),rgba(255,255,255,.045));backdrop-filter:blur(20px);padding:28px;box-shadow:0 28px 80px rgba(0,0,0,.28)}
    .event-facts span{display:block;color:#94a3b8;font-size:.72rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase}
    .event-facts strong{display:block;margin-top:8px;color:#fff;font-size:1rem;line-height:1.45}
    .event-facts div+div{margin-top:18px;padding-top:18px;border-top:1px solid rgba(255,255,255,.12)}
    .event-hero-upcoming{align-self:center;border:1px solid rgba(255,255,255,.16);border-radius:16px;background:linear-gradient(180deg,rgba(255,255,255,.12),rgba(255,255,255,.045));backdrop-filter:blur(20px);padding:26px;box-shadow:0 28px 80px rgba(0,0,0,.28)}
    .event-hero-upcoming__label{display:inline-flex;margin-bottom:18px;border:1px solid rgba(56,189,248,.24);border-radius:40px;background:rgba(56,189,248,.1);padding:7px 12px;color:#bae6fd;font-size:.72rem;font-weight:900;letter-spacing:.12em;text-transform:uppercase}
    .event-hero-upcoming h2{margin:0;color:#fff;font-family:"Playfair Display",Georgia,serif;font-size:1.9rem;font-weight:500;line-height:1.1}
    .event-hero-upcoming__chapter{margin:8px 0 0!important;color:rgba(255,255,255,.68)!important;font-size:.94rem!important;line-height:1.5!important}
    .event-hero-upcoming__meta{display:grid;gap:0;margin-top:22px;border-top:1px solid rgba(255,255,255,.12)}
    .event-hero-upcoming__meta div{padding:15px 0;border-bottom:1px solid rgba(255,255,255,.1)}
    .event-hero-upcoming__meta span{display:block;color:#94a3b8;font-size:.68rem;font-weight:900;letter-spacing:.12em;text-transform:uppercase}
    .event-hero-upcoming__meta strong{display:block;margin-top:5px;color:#fff;font-size:.95rem;line-height:1.35}
    .event-hero-upcoming__link{display:inline-flex;margin-top:22px;color:#7dd3fc;font-size:.9rem;font-weight:900;text-decoration:none}
    .event-hero-upcoming__link:hover{color:#fff}

    /* ── Stats bar ──────────────────────────────────────────── */
    .event-stats-bar{background:#f0f7ff;border-bottom:1px solid #d8e3f0}
    .event-stats-bar__inner{display:flex;flex-wrap:wrap;gap:0;padding:0}
    .event-stat{flex:1;min-width:140px;display:flex;flex-direction:column;gap:4px;padding:20px 24px;border-right:1px solid #d8e3f0}
    .event-stat:last-child{border-right:0}
    .event-stat__label{color:#64748b;font-size:.72rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
    .event-stat__value{color:#0f172a;font-size:1rem;font-weight:700;line-height:1.3}

    /* ── Mini nav ───────────────────────────────────────────── */
    .event-mini-nav{position:sticky;top:0;z-index:40;margin-top:0;background:rgba(255,255,255,.95);border-bottom:1px solid #d8e3f0;backdrop-filter:blur(16px)}
    .event-mini-nav__inner{display:flex;gap:4px;overflow-x:auto;padding:10px 0;scrollbar-width:none}
    .event-mini-nav__inner::-webkit-scrollbar{display:none}
    .event-mini-nav a{white-space:nowrap;border-radius:999px;color:#334155;padding:10px 18px;font-size:.84rem;font-weight:700;text-decoration:none;transition:background .18s,color .18s;cursor:pointer}
    .event-mini-nav a:hover{background:#eff6ff;color:#2562E9}
    .event-mini-nav a.is-active,.event-mini-nav a[aria-current="page"]{background:#2562E9;color:#fff}
    .event-mini-nav a:focus-visible{outline:2px solid #2562E9;outline-offset:2px}

    /* ── Sections ───────────────────────────────────────────── */
    .event-section{padding:84px 0}
    .event-section--soft{background:radial-gradient(circle at 12% 10%,rgba(37,98,233,.09),transparent 28%),linear-gradient(180deg,#f8fbff,#fff)}
    .event-section--dark{background:#030712;color:#fff}

    /* ── Grid ───────────────────────────────────────────────── */
    .event-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:28px}
    .event-grid--3{grid-template-columns:repeat(3,minmax(0,1fr))}

    /* ── Cards ──────────────────────────────────────────────── */
    .event-card{position:relative;overflow:hidden;border:1px solid #d8e3f0;border-radius:16px;background:rgba(255,255,255,.92);padding:32px;box-shadow:0 18px 50px rgba(15,23,42,.07);transition:transform .2s ease,box-shadow .2s ease,border-color .2s ease}
    .event-card:hover{transform:translateY(-2px);border-color:rgba(37,98,233,.26);box-shadow:0 24px 64px rgba(15,23,42,.12)}
    .event-card--dark{border-color:rgba(255,255,255,.12);background:linear-gradient(135deg,#050816,#0b1425);color:#fff}
    .event-card--dark .event-eyebrow{color:#7dd3fc}
    .event-card--dark .event-eyebrow:before,.event-card--dark .event-eyebrow:after{background:rgba(56,189,248,.4)}
    .event-card--accent:before{content:"";position:absolute;inset:0 0 auto;height:4px;background:linear-gradient(90deg,#2562E9,#38bdf8)}
    .event-card p,.event-list li{color:#475569;line-height:1.72}
    .event-card--dark p,.event-card--dark li{color:rgba(255,255,255,.75)}

    /* ── List ───────────────────────────────────────────────── */
    .event-list{display:grid;gap:12px;margin:20px 0 0;padding:0;list-style:none}
    .event-list li{position:relative;padding-left:22px}
    .event-list li:before{content:"";position:absolute;left:0;top:.72em;width:8px;height:8px;border-radius:50%;background:#2562E9}

    /* ── Agenda timeline ────────────────────────────────────── */
    .agenda{position:relative;display:grid;gap:0;list-style:none;margin:0;padding:0}
    .agenda:before{content:"";position:absolute;left:84px;top:22px;bottom:22px;width:2px;background:linear-gradient(180deg,#2562E9,rgba(37,98,233,.1));z-index:0}
    .agenda-row{position:relative;display:grid;grid-template-columns:170px minmax(0,1fr);gap:22px;border:none;border-radius:0;background:transparent;padding:0 0 24px;z-index:1}
    .agenda-row:last-child{padding-bottom:0}
    .agenda-row__card{border:1px solid #d8e3f0;border-radius:18px;background:#fff;padding:18px 20px;box-shadow:0 8px 24px rgba(15,23,42,.05);transition:border-color .2s,box-shadow .2s}
    .agenda-row__card:hover{border-color:rgba(37,98,233,.26);box-shadow:0 12px 36px rgba(15,23,42,.1)}
    .agenda-dot{position:absolute;left:80px;top:20px;width:10px;height:10px;border-radius:50%;background:#2562E9;box-shadow:0 0 0 5px rgba(37,98,233,.14);z-index:0}
    .agenda-time{display:flex;justify-content:flex-end;align-items:flex-start;padding-top:16px;padding-right:14px;position:relative;z-index:1}
    .agenda-time-chip{display:inline-flex;align-items:center;background:#eff6ff;border:1px solid rgba(37,98,233,.2);border-radius:999px;padding:5px 12px;color:#0369a1;font-weight:800;font-size:.73rem;white-space:nowrap;line-height:1;box-shadow:0 1px 4px rgba(37,98,233,.08)}
    .agenda-row__card h3{margin:0 0 6px;color:#0f172a;font-size:1.04rem;font-weight:700}
    .agenda-row__card p{margin:0;color:#64748b;line-height:1.6;font-size:.92rem}

    /* ── Package cards ──────────────────────────────────────── */
    .package-card{position:relative;display:flex;flex-direction:column;gap:18px;border:1px solid #d8e3f0;border-radius:16px;background:linear-gradient(180deg,#fff,#f8fbff);padding:28px;box-shadow:0 18px 46px rgba(15,23,42,.06);transition:transform .2s ease,box-shadow .2s ease;cursor:default}
    .package-card:hover{transform:translateY(-4px);box-shadow:0 28px 72px rgba(15,23,42,.14)}
    .package-card--featured{background:linear-gradient(135deg,#07111f,#0f172a);color:#fff;border-color:rgba(255,255,255,.12)}
    .package-card--featured .package-price,.package-card--featured h3{color:#fff}
    .package-card--featured p,.package-card--featured li{color:rgba(255,255,255,.72)}
    .package-card--featured .event-list li:before{background:#38bdf8}
    .package-badge{position:absolute;top:-12px;left:50%;transform:translateX(-50%);display:inline-flex;align-items:center;gap:6px;border-radius:999px;background:linear-gradient(90deg,#2562E9,#38bdf8);padding:5px 14px;color:#fff;font-size:.72rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;box-shadow:0 4px 14px rgba(37,98,233,.4)}
    .package-card h3{margin:0;font-size:1.35rem;font-weight:700}
    .package-price{font-size:2rem;font-weight:900;color:#0f172a}
    .package-meta{display:flex;gap:10px;flex-wrap:wrap;color:#64748b;font-size:.82rem}
    .package-meta span{border:1px solid #d8e3f0;border-radius:40px;padding:6px 10px;background:#f8fafc}
    .package-card--featured .package-meta span{border-color:rgba(255,255,255,.2);background:rgba(255,255,255,.08);color:rgba(255,255,255,.7)}

    /* ── Forms ──────────────────────────────────────────────── */
    .event-form{display:grid;gap:20px}
    .event-form label,.event-field-label{display:grid;gap:7px;color:#64748b;font-weight:700;font-size:.74rem;letter-spacing:.06em;text-transform:uppercase}
    .event-form input,.event-form select,.event-form textarea{width:100%;border:1.5px solid #e2e8f0;border-radius:12px;padding:.75rem .95rem;color:#0f172a;font-size:.92rem;font-family:inherit;background:#fff;transition:border-color .15s,box-shadow .15s;outline:none}
    .event-form input:focus,.event-form select:focus,.event-form textarea:focus{border-color:#2562E9;box-shadow:0 0 0 3px rgba(37,98,233,.15)}
    .event-form input::placeholder,.event-form textarea::placeholder{color:#94a3b8}
    .event-form textarea{min-height:120px;resize:vertical}
    .event-form-checkbox{display:flex;align-items:flex-start;gap:10px;font-weight:500;cursor:pointer}
    .event-form-checkbox input[type="checkbox"]{width:18px;height:18px;flex-shrink:0;margin-top:2px;accent-color:#2562E9;cursor:pointer}
    .event-form-checkbox input[type="checkbox"]:focus-visible{outline:2px solid #2562E9;outline-offset:2px}
    .event-field{display:grid;gap:7px}
    .field-error{font-size:.78rem;color:#ef4444;margin-top:.3rem}
    .phone-field-wrap{display:flex;border:1.5px solid #e2e8f0;border-radius:12px;overflow:visible;transition:.15s;background:#fff;position:relative}
    .phone-field-wrap:focus-within{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
    .phone-field-wrap.is-invalid{border-color:#ef4444}
    .country-select{position:relative;flex-shrink:0}
    .country-trigger{display:flex;align-items:center;gap:.35rem;padding:.75rem .65rem .75rem .85rem;background:transparent;border:none;border-right:1.5px solid #e2e8f0;cursor:pointer;font-size:.85rem;color:#0f172a;white-space:nowrap;border-radius:0;outline:none;transition:.15s}
    .country-trigger:hover{background:#f8fbff}
    .country-flag{display:inline-flex;align-items:center;justify-content:center;width:22px;color:#2562E9;font-size:.72rem;font-weight:900;letter-spacing:.04em;line-height:1}
    .country-code{font-size:.84rem;font-weight:600;color:#334155}
    .country-chevron{color:#94a3b8;transition:transform .2s}
    .country-trigger[aria-expanded="true"] .country-chevron{transform:rotate(180deg)}
    .country-dropdown{position:absolute;top:calc(100% + 6px);left:0;width:270px;background:#fff;border:1.5px solid #e2e8f0;border-radius:14px;box-shadow:0 16px 40px rgba(15,23,42,.12);z-index:500;overflow:hidden}
    .country-search-wrap{padding:.65rem .75rem;border-bottom:1px solid #f1f5f9}
    .country-search{width:100%;border:1.5px solid #e2e8f0!important;border-radius:8px!important;padding:.5rem .75rem!important;font-size:.83rem!important;color:#0f172a;outline:none;background:#f8fbff}
    .country-search:focus{border-color:#3b82f6!important}
    .country-list{list-style:none;padding:.35rem 0;margin:0;max-height:220px;overflow-y:auto}
    .country-list::-webkit-scrollbar{width:4px}
    .country-list::-webkit-scrollbar-thumb{background:#e2e8f0;border-radius:4px}
    .country-item{display:flex;align-items:center;gap:.65rem;padding:.5rem .9rem;cursor:pointer;font-size:.84rem;color:#334155;transition:.1s}
    .country-item:hover,.country-item.is-active{background:#eff6ff;color:#1d4ed8}
    .country-item-flag{width:24px;color:#2562E9;font-size:.72rem;font-weight:900;letter-spacing:.04em;line-height:1;flex-shrink:0}
    .country-item-name{flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .country-item-dial{font-size:.78rem;color:#94a3b8;flex-shrink:0}
    .country-no-results{padding:.75rem .9rem;font-size:.83rem;color:#94a3b8;text-align:center}
    .phone-number-input{flex:1!important;border:none!important;border-radius:0!important;padding:.75rem .95rem!important;font-size:.92rem!important;color:#0f172a;background:transparent!important;outline:none;min-width:0}
    .event-choice-field{position:relative}
    .event-choice-trigger{display:flex;align-items:center;justify-content:space-between;width:100%;min-height:48px;border:1.5px solid #e2e8f0;border-radius:12px;background:#fff;padding:.75rem .95rem;color:#0f172a;font-family:inherit;font-size:.92rem;text-align:left;cursor:pointer;transition:border-color .15s,box-shadow .15s}
    .event-choice-trigger:hover{border-color:#bfdbfe;background:#f8fbff}
    .event-choice-trigger:focus-visible,.event-choice-trigger[aria-expanded="true"]{border-color:#2562E9;box-shadow:0 0 0 3px rgba(37,98,233,.12);outline:none}
    .event-choice-chevron{color:#94a3b8;transition:transform .2s}
    .event-choice-trigger[aria-expanded="true"] .event-choice-chevron{transform:rotate(180deg)}
    .event-choice-menu{position:absolute;z-index:480;top:calc(100% + 6px);left:0;right:0;overflow:hidden;border:1.5px solid #e2e8f0;border-radius:14px;background:#fff;box-shadow:0 16px 40px rgba(15,23,42,.12)}
    .event-choice-option{display:flex;align-items:center;width:100%;border:0;background:#fff;padding:.68rem 1rem;color:#334155;font-family:inherit;font-size:.92rem;text-align:left;cursor:pointer;transition:background .12s,color .12s}
    .event-choice-option:hover,.event-choice-option.is-active{background:#eff6ff;color:#1d4ed8}
    .event-register-section{background:radial-gradient(circle at 12% 0%,rgba(37,98,233,.1),transparent 30%),linear-gradient(180deg,#fff,#f8fbff)}
    .event-register-layout{display:grid;grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);gap:28px;align-items:start}
    .event-register-panel{position:sticky;top:108px;border:1px solid #d8e3f0;border-radius:16px;background:#fff;padding:28px;box-shadow:0 18px 54px rgba(15,23,42,.07)}
    .event-register-panel .event-title{font-size:clamp(1.9rem,3vw,2.8rem)}
    .event-register-steps{display:grid;gap:14px;margin:26px 0 0;padding:0;list-style:none}
    .event-register-steps li{display:grid;grid-template-columns:34px minmax(0,1fr);gap:12px;align-items:start}
    .event-register-step-num{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;min-width:36px;border-radius:50%;background:#eff6ff;color:#2562E9;font-size:.8rem;font-weight:900;line-height:1;text-align:center}
    .event-register-steps strong{display:block;margin-bottom:3px;color:#0f172a;font-size:.96rem}
    .event-register-steps span{display:block;color:#64748b;font-size:.9rem;line-height:1.55}
    .event-register-contact{margin-top:26px;border-top:1px solid #e5edf7;padding-top:20px}
    .event-register-contact span{display:block;margin-bottom:5px;color:#94a3b8;font-size:.74rem;font-weight:900;text-transform:uppercase;letter-spacing:.1em}
    .event-register-contact a{color:#2562E9;font-weight:900;text-decoration:none}
    .event-register-form-card{border-radius:16px;padding:32px}
    .event-register-form-head{display:flex;align-items:center;justify-content:space-between;gap:16px;margin:-32px -32px 24px;padding:24px 28px;background:linear-gradient(135deg,#07111f,#10233a);color:#fff}
    .event-register-form-head h2{margin:0;color:#fff;font-size:1.25rem;font-weight:900}
    .event-register-form-head p{margin:5px 0 0;color:rgba(255,255,255,.68);font-size:.9rem}
    .event-register-badge{border:1px solid rgba(255,255,255,.18);border-radius:999px;background:rgba(255,255,255,.08);padding:8px 10px;color:#dbeafe;font-size:.72rem;font-weight:900;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap}
    .event-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
    .event-form-grid .full{grid-column:1/-1}
    .event-checkout-section{background:linear-gradient(180deg,#f8fbff,#fff)}
    .event-checkout-layout{display:grid;grid-template-columns:minmax(280px,.78fr) minmax(0,1.22fr);gap:28px;align-items:start}
    .event-checkout-summary{position:sticky;top:108px;align-self:start;padding:28px;background:linear-gradient(145deg,#050816,#0b1425 64%,#10233a);box-shadow:0 22px 64px rgba(2,6,23,.22)}
    .event-checkout-summary h2{margin:0 0 10px;color:#fff;font-family:"Playfair Display",Georgia,serif;font-size:1.7rem;font-weight:500;line-height:1.15}
    .event-checkout-summary p{margin:0 0 22px;color:rgba(255,255,255,.72);font-size:.95rem;line-height:1.7}
    .event-checkout-summary .event-table{margin-top:4px}
    .event-checkout-note{margin-top:18px;border:1px solid rgba(255,255,255,.12);border-radius:14px;background:rgba(255,255,255,.055);padding:14px 16px;color:rgba(255,255,255,.68);font-size:.86rem;line-height:1.55}
    .event-checkout-note span{display:block;margin-bottom:4px;color:#7dd3fc;font-size:.7rem;font-weight:900;letter-spacing:.12em;text-transform:uppercase}
    .event-checkout-form-card{padding:34px}
    .event-payment-section{background:linear-gradient(180deg,#f8fbff,#fff)}
    .event-payment-layout{display:grid;grid-template-columns:minmax(280px,.76fr) minmax(0,1.24fr);gap:28px;align-items:start}
    .event-payment-card{min-height:360px;display:flex;flex-direction:column;align-items:center;justify-content:center}
    .event-success-section{min-height:calc(100vh - 92px);display:flex;align-items:center;background:radial-gradient(circle at 50% 0%,rgba(37,98,233,.1),transparent 32%),linear-gradient(180deg,#f8fbff,#fff);padding-top:64px}
    .event-success-card{max-width:820px}
    .event-success-summary{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;margin:26px 0 0}
    .event-success-summary div{border:1px solid #d8e3f0;border-radius:14px;background:#f8fbff;padding:14px 16px;text-align:left}
    .event-success-summary span{display:block;margin-bottom:4px;color:#94a3b8;font-size:.68rem;font-weight:900;letter-spacing:.1em;text-transform:uppercase}
    .event-success-summary strong{display:block;color:#0f172a;font-size:.9rem;line-height:1.35;word-break:break-word}

    /* ── Alerts ─────────────────────────────────────────────── */
    .event-alert{border-radius:14px;padding:14px 18px;margin-bottom:4px;font-weight:500;font-size:.92rem}
    .event-alert--success{background:#ecfdf5;color:#047857;border:1px solid #a7f3d0}
    .event-alert--error{background:#fef2f2;color:#b91c1c;border:1px solid #fecaca}

    /* ── Table ──────────────────────────────────────────────── */
    .event-table{width:100%;border-collapse:separate;border-spacing:0;overflow:hidden;border:1px solid #d8e3f0;border-radius:20px;background:#fff}
    .event-table th,.event-table td{padding:14px 18px;border-bottom:1px solid #e5edf7;text-align:left;vertical-align:top;font-size:.92rem}
    .event-table th{background:#f0f7ff;color:#0369a1;font-size:.82rem;letter-spacing:.08em;text-transform:uppercase;font-weight:800}
    .event-table tr:last-child td{border-bottom:0}
    .event-table td:last-child{font-weight:500;color:#0f172a}
    .event-table--dark{border-color:rgba(255,255,255,.12);background:transparent}
    .event-table--dark th{background:rgba(255,255,255,.06);color:#7dd3fc;border-bottom-color:rgba(255,255,255,.1)}
    .event-table--dark td{border-bottom-color:rgba(255,255,255,.08);color:rgba(255,255,255,.8)}
    .event-table--dark td:last-child{color:#fff!important}
    .event-table--dark td:last-child strong{color:#fff!important}
    .event-table--dark tr:last-child td{color:#fff;font-size:1.04rem}
    .event-table--total td{background:rgba(37,98,233,.08);font-weight:800;color:#0f172a!important;font-size:1rem}
    .event-table--dark .event-table--total td{background:rgba(56,189,248,.1);color:#fff!important}

    /* Comparison table icon cells */
    .event-table__check{color:#059669;font-weight:700}
    .event-table__dash{color:#94a3b8}
    .event-table td:last-child .event-table__check{color:#2562E9}

    /* ── FAQ animated accordion ─────────────────────────────── */
    .event-faq-list{display:grid;gap:10px}
    .event-faq-item{border:1px solid #d8e3f0;border-radius:16px;background:#fff;overflow:hidden;transition:border-color .2s,box-shadow .2s}
    .event-faq-item.is-open{border-color:rgba(37,98,233,.3);box-shadow:0 8px 28px rgba(15,23,42,.08)}
    .event-faq-summary{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:20px 24px;cursor:pointer;color:#0f172a;font-weight:700;font-size:.98rem;line-height:1.45;user-select:none; width: 100%;}
    .event-faq-summary:focus-visible{outline:2px solid #2562E9;outline-offset:-2px;border-radius:14px}
    .event-faq-icon{flex-shrink:0;width:22px;height:22px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;transition:background .2s,transform .3s}
    .event-faq-item.is-open .event-faq-icon{background:#2562E9;transform:rotate(180deg)}
    .event-faq-icon svg{width:14px;height:14px;stroke:#2562E9;transition:stroke .2s}
    .event-faq-item.is-open .event-faq-icon svg{stroke:#fff}
    .event-faq-body{display:grid;grid-template-rows:0fr;transition:grid-template-rows .3s ease}
    .event-faq-item.is-open .event-faq-body{grid-template-rows:1fr}
    .event-faq-body-inner{overflow:hidden}
    .event-faq-answer{padding:0 24px 22px;color:#475569;line-height:1.75;font-size:.95rem}

    /* ── Events accordion (past/upcoming) ───────────────────── */
    .event-date-chip{display:inline-flex;align-items:center;gap:6px;border-radius:999px;background:#f0f7ff;border:1px solid #d8e3f0;padding:5px 12px;color:#0369a1;font-size:.76rem;font-weight:800;letter-spacing:.06em}
    .event-date-chip--past{background:#f1f5f9;color:#64748b;border-color:#e2e8f0}
    .event-date-chip--upcoming{background:#eff6ff;color:#2562E9;border-color:rgba(37,98,233,.2)}
    .event-acc-list{display:grid;gap:10px}
    .event-acc-item{border:1px solid rgba(255,255,255,.14);border-radius:18px;background:rgba(255,255,255,.05);overflow:hidden;transition:border-color .2s,background .2s}
    .event-acc-item.is-open{border-color:rgba(37,98,233,.4);background:rgba(37,98,233,.06)}
    .event-acc-item--light{border-color:#d8e3f0;background:#fff}
    .event-acc-item--light.is-open{border-color:rgba(37,98,233,.3);background:#f8fbff}
    .event-acc-trigger{width:100%;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 24px;cursor:pointer;background:none;border:none;text-align:left}
    .event-acc-trigger:focus-visible{outline:2px solid #2562E9;outline-offset:-2px;border-radius:16px}
    .event-acc-meta{display:flex;flex-wrap:wrap;align-items:center;gap:10px;flex:1;min-width:0}
    .event-acc-name{font-family:"Playfair Display",Georgia,serif;font-size:1.08rem;font-weight:700;color:#fff;line-height:1.3}
    .event-acc-item--light .event-acc-name{color:#0f172a}
    .event-acc-chapter{font-size:.78rem;font-weight:700;color:#7dd3fc;letter-spacing:.04em}
    .event-acc-item--light .event-acc-chapter{color:#2562E9}
    .event-acc-chevron{flex-shrink:0;width:28px;height:28px;border-radius:50%;border:1px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;transition:transform .3s,background .2s,border-color .2s}
    .event-acc-item--light .event-acc-chevron{border-color:#d8e3f0}
    .event-acc-item.is-open .event-acc-chevron{transform:rotate(180deg);background:#2562E9;border-color:#2562E9}
    .event-acc-chevron svg{width:14px;height:14px;stroke:rgba(255,255,255,.7);transition:stroke .2s}
    .event-acc-item--light .event-acc-chevron svg{stroke:#64748b}
    .event-acc-item.is-open .event-acc-chevron svg{stroke:#fff}
    .event-acc-body{display:grid;grid-template-rows:0fr;transition:grid-template-rows .3s ease}
    .event-acc-item.is-open .event-acc-body{grid-template-rows:1fr}
    .event-acc-body-inner{overflow:hidden}
    .event-acc-content{padding:0 24px 24px;display:grid;grid-template-columns:1fr 1fr;gap:20px}
    .event-acc-content p{margin:0;font-size:.92rem;line-height:1.65;color:rgba(255,255,255,.65)}
    .event-acc-item--light .event-acc-content p{color:#64748b}
    .event-acc-detail{display:flex;flex-direction:column;gap:4px}
    .event-acc-detail-label{font-size:.7rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.4)}
    .event-acc-item--light .event-acc-detail-label{color:#94a3b8}
    .event-acc-detail-value{font-size:.92rem;font-weight:500;color:rgba(255,255,255,.85)}
    .event-acc-item--light .event-acc-detail-value{color:#0f172a}
    .event-upcoming-list{display:grid;gap:16px}
    .event-upcoming-card{border:1px solid rgba(37,98,233,.24);border-radius:16px;background:rgba(255,255,255,.92);padding:24px 26px;box-shadow:0 18px 48px rgba(15,23,42,.07)}
    .event-upcoming-card__top{display:flex;align-items:center;gap:12px;flex-wrap:wrap}
    .event-upcoming-card__title{color:#0f172a;font-family:"Playfair Display",Georgia,serif;font-size:1.18rem;font-weight:700;line-height:1.3}
    .event-upcoming-card__chapter{color:#2562E9;font-size:.84rem;font-weight:900;letter-spacing:.04em}
    .event-upcoming-card__copy{margin:14px 0 0;color:#64748b;font-size:1rem;line-height:1.7}
    .event-upcoming-card__details{display:flex;gap:22px;flex-wrap:wrap;margin-top:22px}
    .event-upcoming-card__details div{min-width:150px}
    .event-upcoming-card__details span{display:block;margin-bottom:4px;color:#94a3b8;font-size:.74rem;font-weight:900;text-transform:uppercase;letter-spacing:.08em}
    .event-upcoming-card__details strong{color:#0f172a;font-size:1rem}
    .event-upcoming-card--dark{border-color:rgba(255,255,255,.14);background:rgba(255,255,255,.055);box-shadow:none}
    .event-upcoming-card--dark .event-upcoming-card__title,.event-upcoming-card--dark .event-upcoming-card__details strong{color:#fff}
    .event-upcoming-card--dark .event-upcoming-card__chapter{color:#7dd3fc}
    .event-upcoming-card--dark .event-upcoming-card__copy{color:rgba(255,255,255,.64)}
    .event-upcoming-card--dark .event-upcoming-card__details span{color:rgba(255,255,255,.42)}
    @media(max-width:640px){.event-acc-content{grid-template-columns:1fr}.event-acc-trigger{padding:16px 18px}.event-acc-content{padding:0 18px 18px}}

    /* ── Venue section ───────────────────────────────────────── */
    .event-venue-grid{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start;}
    .event-venue-info{display:flex;flex-direction:column}
    .event-venue-name{font-family:"Playfair Display",Georgia,serif;font-size:clamp(1.5rem,2.5vw,2.1rem);font-weight:500;color:#0f172a;margin:0 0 14px;line-height:1.2}
    .event-venue-address{display:flex;align-items:flex-start;gap:8px;color:#475569;font-size:1rem;line-height:1.65;margin:0 0 8px}
    .event-venue-address svg,.event-venue-city svg{flex-shrink:0;margin-top:3px;color:#2562E9}
    .event-venue-city{display:flex;align-items:center;gap:8px;color:#64748b;font-size:.9rem;margin:0}
    .event-venue-map{border-radius:16px;overflow:hidden;box-shadow:0 24px 64px rgba(15,23,42,.12);border:1px solid #d8e3f0;min-height:340px}
    .event-venue-map iframe{display:block;width:100%;height:100%;min-height:340px;border:0}
    @media(max-width:900px){.event-venue-grid{grid-template-columns:1fr;gap:28px}.event-venue-map{min-height:280px}}

    /* Registration venue map */
    .event-register-venue{padding-top:0;background:#f8fbff}
    .event-register-venue-card{overflow:hidden;border:1px solid #d8e3f0;border-radius:16px;background:#fff;box-shadow:0 20px 60px rgba(15,23,42,.08)}
    .event-register-venue-head{display:flex;align-items:flex-start;justify-content:space-between;gap:24px;padding:24px 28px;border-bottom:1px solid #e5edf7}
    .event-register-venue-head h2{margin:0;color:#0f172a;font-family:"Playfair Display",Georgia,serif;font-size:clamp(1.8rem,3vw,2.6rem);font-weight:600;line-height:1.14}
    .event-register-venue-head p{margin:10px 0 0;color:#64748b;line-height:1.7}
    .event-register-venue-map{height:360px;background:#eaf3fb}
    .event-register-venue-map iframe{width:100%;height:100%;border:0;display:block}
    .event-register-venue-actions{display:flex;gap:12px;flex-wrap:wrap;align-items:center}
    @media(max-width:900px){.event-register-layout,.event-checkout-layout,.event-payment-layout{grid-template-columns:1fr}.event-register-panel,.event-checkout-summary{position:relative;top:auto}.event-register-venue-head{display:block}.event-register-venue-actions{margin-top:18px}.event-register-venue-map{height:320px}.event-success-summary{grid-template-columns:1fr}}
    @media(max-width:640px){.event-form-grid{grid-template-columns:1fr}.event-register-panel{padding:22px}.event-register-form-card,.event-checkout-form-card{padding:22px}.event-register-form-head{display:block;margin:-22px -22px 22px;padding:22px}.event-register-badge{display:inline-flex;margin-top:12px}.event-countdown{margin-top:22px;padding:12px 9px}.event-countdown__units{gap:3px}.event-countdown__units strong{font-size:1.15rem}.event-countdown__units span{font-size:.55rem;letter-spacing:.06em}}

    /* ── Status pages (success / cancel / payment) ───────────── */
    .event-status-card{max-width:640px;margin:0 auto;text-align:center}
    .event-status-icon{display:flex;align-items:center;justify-content:center;width:72px;height:72px;border-radius:50%;margin:0 auto 24px}
    .event-status-icon--success{background:#ecfdf5;color:#059669}
    .event-status-icon--cancel{background:#fef2f2;color:#dc2626}
    .event-status-icon--payment{background:#eff6ff;color:#2562E9}
    .event-status-icon svg{width:36px;height:36px}
    .event-next-steps{display:grid;gap:12px;margin:28px 0 0;text-align:left;background:#f8fbff;border:1px solid #d8e3f0;border-radius:18px;padding:22px 26px}
    .event-next-steps h3{margin:0 0 14px;font-size:1rem;font-weight:800;color:#0f172a}
    .event-next-steps ol{margin:0;padding-left:20px;display:grid;gap:10px;color:#475569;line-height:1.65;font-size:.94rem}

    /* ── Entrance animations ─────────────────────────────────── */
    @keyframes event-fadein{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
    .event-section > .event-container > *{animation:event-fadein .5s ease both}
    .event-section > .event-container > *:nth-child(2){animation-delay:.08s}
    .event-section > .event-container > *:nth-child(3){animation-delay:.16s}
    @media(prefers-reduced-motion:reduce){.event-section > .event-container > *{animation:none}.event-kicker-dot{animation:none}.event-countdown__dot{box-shadow:none}}

    /* ── Responsive ──────────────────────────────────────────── */
    @media(max-width:900px){
        .event-hero__inner,.event-grid,.event-grid--3{grid-template-columns:1fr}
        .event-hero__inner{min-height:auto;padding:72px 0}
        .event-mini-nav__inner{padding:8px 0}
        .agenda:before{left:0;top:10px;bottom:10px}
        .agenda-row{grid-template-columns:1fr}
        .agenda-time{justify-content:flex-start;padding:0}
        .agenda-dot{left:-5px;top:2px}
        .event-stats-bar__inner{gap:0}
        .event-stat{min-width:50%;border-bottom:1px solid #d8e3f0}
        .event-stat:nth-child(even){border-right:0}
    }
    @media(max-width:640px){
        .event-container{width:min(100% - 24px,1200px)}
        .event-section{padding:56px 0}
        .event-card,.package-card{padding:22px}
        .event-hero h1{font-size:2.65rem}
        .event-grid--3{grid-template-columns:1fr}
        .event-stat{min-width:100%;border-right:0}
    }
</style>
@endonce
