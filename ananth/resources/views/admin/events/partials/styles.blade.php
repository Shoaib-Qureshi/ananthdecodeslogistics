<style>
    .event-editor-shell{max-width:1280px;margin:0 auto;padding-bottom:20px}
    .event-admin-hero{position:relative;overflow:hidden;display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin:18px 0 14px;padding:22px 24px;border:1px solid #d8e3f0;border-radius:16px;background:linear-gradient(135deg,#ffffff 0%,#f8fbff 58%,#eff6ff 100%);box-shadow:0 16px 44px rgba(15,23,42,.07)}
    .event-admin-hero:before{content:"";position:absolute;inset:0 0 auto;height:4px;background:linear-gradient(90deg,#2562E9,#0f766e,#f59e0b)}
    .event-admin-hero h2{margin:0;color:#0f172a;font-size:1.65rem;font-weight:850;letter-spacing:-.02em}
    .event-admin-hero p{margin:8px 0 0;color:#526070;line-height:1.6}
    .event-admin-actions{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .event-admin-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border:1px solid #d8e3f0;border-radius:10px;background:#fff;color:#475569;padding:10px 14px;font-size:.84rem;font-weight:800;text-decoration:none;cursor:pointer;transition:background .18s ease,border-color .18s ease,color .18s ease,box-shadow .18s ease}
    .event-admin-btn:hover{border-color:#b8c8dd;background:#f8fbff;color:#0f172a;text-decoration:none}
    .event-admin-btn.primary{border-color:#2562E9;background:#2562E9;color:#fff}
    .event-admin-btn.primary:hover{border-color:#1d4ed8;background:#1d4ed8;color:#fff}
    .event-admin-btn.danger{color:#dc2626}
    .event-admin-stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px;margin:0 0 16px}
    .event-admin-stat{border:1px solid #d8e3f0;border-radius:14px;background:rgba(255,255,255,.92);padding:13px 14px;box-shadow:0 10px 26px rgba(15,23,42,.04)}
    .event-admin-stat span{display:block;margin-bottom:4px;color:#64748b;font-size:.72rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
    .event-admin-stat strong{display:block;overflow:hidden;color:#0f172a;font-size:.96rem;font-weight:850;text-overflow:ellipsis;white-space:nowrap}
    .event-editor-tools{position:sticky;top:0;z-index:4;display:flex;align-items:center;justify-content:space-between;gap:14px;margin:0 0 16px;padding:12px;border:1px solid #d8e3f0;border-radius:16px;background:rgba(255,255,255,.96);box-shadow:0 16px 38px rgba(15,23,42,.08);backdrop-filter:blur(10px)}
    .event-editor-tools__actions{display:flex;flex-wrap:wrap;gap:8px}
    .event-page-nav{display:flex;flex-wrap:wrap;gap:8px;margin:0}
    .event-page-nav a{display:flex;align-items:center;justify-content:space-between;gap:10px;border:1px solid #d8e3f0;border-radius:10px;background:#fff;padding:10px 12px;color:#0f172a;text-decoration:none;font-weight:900;box-shadow:none;transition:background .18s ease,border-color .18s ease,color .18s ease,transform .18s ease}
    .event-page-nav a:hover{border-color:#b8c8dd;background:#eff6ff;color:#0f172a;text-decoration:none;transform:translateY(-1px)}
    .event-page-nav a span{display:block;color:#64748b;font-size:.76rem;font-weight:700;margin-top:3px}
    .event-page-nav a strong{display:block}
    .event-page-nav a:after{content:"Edit";border-radius:999px;background:#eff6ff;color:#2562E9;padding:4px 8px;font-size:.68rem}
    .event-page-block{overflow:hidden;border:1px solid #c7d8ee;border-radius:16px;background:#fff;margin-bottom:16px;box-shadow:0 14px 36px rgba(15,23,42,.06);scroll-margin-top:96px}
    .event-page-block__head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;padding:18px 20px;background:linear-gradient(135deg,#07111f,#0f172a);color:#fff}
    .event-page-block__head.blue{background:linear-gradient(135deg,#123b88,#2562E9)}
    .event-page-block__head.green{background:linear-gradient(135deg,#065f46,#0f766e)}
    .event-page-block__head h3{margin:0 0 6px;color:#fff;font-size:1.25rem;font-weight:900}
    .event-page-block__head p{margin:0;max-width:720px;color:rgba(255,255,255,.72);line-height:1.6}
    .event-section-kicker{display:inline-flex;align-items:center;margin-bottom:7px;border:1px solid rgba(255,255,255,.22);border-radius:999px;background:rgba(255,255,255,.12);padding:4px 8px;color:rgba(255,255,255,.82);font-size:.68rem;font-weight:900;letter-spacing:.1em;text-transform:uppercase}
    .event-page-block__body{padding:18px}
    .event-page-link{white-space:nowrap;border:1px solid rgba(255,255,255,.24);border-radius:8px;color:#fff!important;text-decoration:none;padding:9px 12px;font-size:.78rem;font-weight:900}
    .event-page-block__tools{display:flex;flex-wrap:wrap;gap:8px;align-items:center;justify-content:flex-end}
    .event-section-toggle{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border:1px solid rgba(255,255,255,.28);border-radius:10px;background:rgba(255,255,255,.08);color:#fff;cursor:pointer;transition:background .18s ease,border-color .18s ease,transform .18s ease}
    .event-section-toggle:hover{transform:translateY(-1px)}
    .event-section-toggle:hover,.event-section-toggle:focus{background:rgba(255,255,255,.16);border-color:rgba(255,255,255,.5);outline:0}
    .event-section-toggle:before{content:"";width:10px;height:10px;border-right:2px solid currentColor;border-bottom:2px solid currentColor;transform:rotate(45deg) translateY(-2px);transition:transform .2s ease}
    .is-collapsed>.event-page-block__head .event-section-toggle:before,.is-collapsed>.event-admin-row-head .event-section-toggle:before{transform:rotate(-45deg)}
    .field-help{display:block;margin:4px 0 0;color:#64748b;font-size:.78rem;font-weight:500;line-height:1.5}
    .event-admin-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
    .event-admin-grid-3{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}
    .event-admin-card{border:1px solid #d8e3f0;border-radius:16px;background:#fff;padding:18px;margin-bottom:16px;box-shadow:0 12px 32px rgba(15,23,42,.05);scroll-margin-top:96px}
    .event-admin-card h3{margin:0 0 16px;color:#0f172a;font-size:1.1rem;font-weight:800}
    .event-admin-card>.event-admin-row-head h3{margin:0}
    .event-admin-card .event-section-toggle{color:#475569;border-color:#d8e3f0;background:#fff}
    .event-admin-card .event-section-toggle:hover{background:#eff6ff;border-color:#b8c8dd;color:#0f172a}
    .event-admin-card .event-section-toggle:before{border-color:currentColor}
    .event-admin-divider{display:flex;align-items:center;gap:14px;margin:24px 0 14px;color:#2562E9;font-size:.78rem;font-weight:900;letter-spacing:.14em;text-transform:uppercase}
    .event-admin-divider:before,.event-admin-divider:after{content:"";height:1px;flex:1;background:#d8e3f0}
    .event-admin-divider span{display:inline-flex;align-items:center;gap:8px;border:1px solid #d8e3f0;border-radius:999px;background:#fff;padding:8px 12px;box-shadow:0 10px 28px rgba(15,23,42,.05)}
    .event-admin-card label{display:block;margin-bottom:12px;color:#0f172a;font-weight:700}
    .event-admin-card input,.event-admin-card select,.event-admin-card textarea,.event-page-block input,.event-page-block select,.event-page-block textarea{width:100%;box-sizing:border-box;border:1px solid #d8e3f0;border-radius:11px;padding:10px 12px;margin-top:6px;background:#fff;color:#0f172a}
    .event-admin-card input[readonly],.event-page-block input[readonly]{background:#f8fafc;color:#64748b}
    .event-admin-card input:focus,.event-admin-card select:focus,.event-admin-card textarea:focus,.event-page-block input:focus,.event-page-block select:focus,.event-page-block textarea:focus{border-color:#2562E9;box-shadow:0 0 0 3px rgba(37,98,233,.12);outline:0}
    .event-admin-card textarea{min-height:110px;resize:vertical}
    .currency-choice{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-top:8px}
    .currency-choice input{position:absolute;opacity:0;pointer-events:none}
    .currency-choice span{display:flex;align-items:center;justify-content:center;border:1px solid #d8e3f0;border-radius:40px;background:#fff;padding:12px 14px;color:#475569;font-weight:900}
    .currency-choice input:checked+span{border-color:#2562E9;background:#2562E9;color:#fff;box-shadow:0 10px 24px rgba(37,98,233,.2)}
    .payment-note{margin:8px 0 0;color:#64748b;font-size:.82rem;line-height:1.55}
    .event-admin-row{position:relative;border:1px solid #e2e8f0;border-radius:12px;background:#f8fbff;padding:16px;margin-bottom:12px}
    .event-admin-row-head{display:flex;justify-content:space-between;gap:10px;align-items:center;margin-bottom:12px}
    .event-admin-row-head strong{color:#0f172a}
    .event-admin-table{width:100%;border-collapse:collapse;background:#fff}
    .event-admin-table th,.event-admin-table td{padding:12px;border-bottom:1px solid #e5edf7;text-align:left;vertical-align:top}
    .event-admin-table th{font-size:.76rem;color:#64748b;text-transform:uppercase;letter-spacing:.08em}
    .save-bar{position:sticky;bottom:0;z-index:5;display:flex;align-items:center;justify-content:flex-end;gap:12px;padding:14px 0;background:linear-gradient(180deg,rgba(255,255,255,0),#fff 35%)}
    .save-bar span{color:#64748b;font-size:.84rem;font-weight:700}
    .save-bar button{border:0;border-radius:10px;background:#2562E9;color:#fff;padding:12px 24px;font-weight:800;cursor:pointer;box-shadow:0 12px 26px rgba(37,98,233,.22)}
    .save-bar button:disabled{cursor:wait;opacity:.78}
    .visible-toggle{display:inline-flex!important;align-items:center;gap:8px;margin:0!important;white-space:nowrap}
    .visible-toggle input{width:auto;margin:0}
    .registration-status{border:1px solid #d8e3f0;border-radius:14px;padding:16px 18px;margin-bottom:18px;background:#f8fafc}
    .registration-status.is-open{border-color:#a7f3d0;background:#f0fdf9}
    .registration-status.is-closed{border-color:#fecaca;background:#fef6f6}
    .registration-status strong{color:#0f172a;font-size:.95rem}
    .registration-status .field-help{margin-top:8px}
    .switch-row{display:inline-flex!important;align-items:center;gap:12px;margin:0!important;cursor:pointer;user-select:none}
    .switch-row .switch-input{position:absolute;opacity:0;width:1px;height:1px;margin:0;pointer-events:none}
    .switch-track{position:relative;flex:0 0 auto;width:46px;height:26px;border-radius:999px;background:#cbd5e1;transition:background .18s ease}
    .switch-knob{position:absolute;top:3px;left:3px;width:20px;height:20px;border-radius:50%;background:#fff;box-shadow:0 2px 5px rgba(15,23,42,.28);transition:transform .18s ease}
    .switch-row .switch-input:checked ~ .switch-track{background:#059669}
    .switch-row .switch-input:checked ~ .switch-track .switch-knob{transform:translateX(20px)}
    .switch-row .switch-input:focus-visible ~ .switch-track{outline:2px solid #2562E9;outline-offset:2px}
    .delegate-logo-admin-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px;margin-top:14px}
    .delegate-logo-admin-card{position:relative;border:1px solid #d8e3f0;border-radius:12px;background:#fff;padding:8px;box-shadow:0 8px 18px rgba(15,23,42,.05)}
    .delegate-logo-admin-card img{display:block;width:100%;aspect-ratio:2/1;object-fit:contain;border-radius:8px;background:#f8fafc}
    .delegate-logo-admin-card button{position:absolute;top:4px;right:4px;width:25px;height:25px;border:1px solid #fecaca;border-radius:50%;background:#fff;color:#dc2626;font-size:1rem;line-height:1;cursor:pointer}
    .delegate-logo-admin-card button:hover{background:#fef2f2}
    .delegate-logo-admin-empty{padding:22px;border:1px dashed #cbd5e1;border-radius:12px;background:#f8fbff;color:#64748b;text-align:center;font-size:.86rem}
    .marketing-partner-admin-list{display:grid;gap:12px;margin-bottom:14px}
    .marketing-partner-admin-row{display:grid;grid-template-columns:180px minmax(0,1fr) auto;gap:16px;align-items:center;border:1px solid #d8e3f0;border-radius:14px;background:#f8fbff;padding:14px}
    .marketing-partner-admin-preview{display:flex;align-items:center;justify-content:center;aspect-ratio:2/1;overflow:hidden;border:1px solid #e2e8f0;border-radius:10px;background:#fff;color:#94a3b8;font-size:.76rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em}
    .marketing-partner-admin-preview img{display:block;width:100%;height:100%;object-fit:contain}
    .marketing-partner-admin-fields{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
    .marketing-partner-admin-fields label{margin:0}
    .marketing-partner-remove{align-self:start}
    @media(prefers-reduced-motion:reduce){.event-admin-btn,.event-page-nav a,.event-section-toggle,.event-section-toggle:before{transition:none}}
    @media(max-width:1100px){.event-admin-stats{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:900px){.event-admin-grid,.event-admin-grid-3,.marketing-partner-admin-fields{grid-template-columns:1fr}.event-editor-tools{position:static;display:block}.event-editor-tools__actions,.event-page-nav{margin-top:10px}.event-admin-hero,.event-page-block__head{display:block}.event-admin-actions{margin-top:14px}.event-page-block__tools{justify-content:flex-start;margin-top:14px}.event-page-link{display:inline-flex}}
    @media(max-width:700px){.marketing-partner-admin-row{grid-template-columns:1fr}.marketing-partner-admin-preview{max-width:260px}.marketing-partner-remove{justify-self:start}}
    @media(max-width:560px){.event-admin-stats{grid-template-columns:1fr}.event-admin-hero{padding:20px 18px}.event-page-nav a{width:100%}.save-bar{display:block}.save-bar span{display:block;margin-bottom:8px}.save-bar button{width:100%}}
</style>
