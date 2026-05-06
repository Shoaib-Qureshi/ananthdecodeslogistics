<style>
    .event-admin-hero{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin:18px 0 22px;padding:22px 24px;border:1px solid #d8e3f0;border-radius:18px;background:linear-gradient(135deg,#fff,#f8fbff);box-shadow:0 18px 50px rgba(15,23,42,.06)}
    .event-admin-hero h2{margin:0;color:#0f172a;font-size:1.65rem;font-weight:800}
    .event-admin-hero p{margin:8px 0 0;color:#64748b;line-height:1.6}
    .event-admin-actions{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .event-admin-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border:1px solid #d8e3f0;border-radius:40px;background:#fff;color:#475569;padding:10px 14px;font-size:.84rem;font-weight:800;text-decoration:none}
    .event-admin-btn.primary{border-color:#2562E9;background:#2562E9;color:#fff}
    .event-admin-btn.danger{color:#dc2626}
    .event-page-nav{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin:0 0 22px}
    .event-page-nav a{display:flex;align-items:center;justify-content:space-between;gap:12px;border:1px solid #d8e3f0;border-radius:18px;background:#fff;padding:14px 16px;color:#0f172a;text-decoration:none;font-weight:900;box-shadow:0 12px 32px rgba(15,23,42,.05)}
    .event-page-nav a span{display:block;color:#64748b;font-size:.76rem;font-weight:700;margin-top:3px}
    .event-page-nav a strong{display:block}
    .event-page-nav a:after{content:"Edit";border-radius:999px;background:#eff6ff;color:#2562E9;padding:6px 10px;font-size:.72rem}
    .event-page-block{overflow:hidden;border:1px solid #c7d8ee;border-radius:22px;background:#fff;margin-bottom:22px;box-shadow:0 18px 52px rgba(15,23,42,.07)}
    .event-page-block__head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;padding:22px 24px;background:linear-gradient(135deg,#07111f,#0f172a);color:#fff}
    .event-page-block__head.blue{background:linear-gradient(135deg,#0f3c91,#2562E9)}
    .event-page-block__head.green{background:linear-gradient(135deg,#064e3b,#0f766e)}
    .event-page-block__head h3{margin:0 0 6px;color:#fff;font-size:1.25rem;font-weight:900}
    .event-page-block__head p{margin:0;max-width:720px;color:rgba(255,255,255,.72);line-height:1.6}
    .event-page-block__body{padding:22px}
    .event-page-link{white-space:nowrap;border:1px solid rgba(255,255,255,.24);border-radius:999px;color:#fff!important;text-decoration:none;padding:9px 12px;font-size:.78rem;font-weight:900}
    .field-help{display:block;margin:4px 0 0;color:#64748b;font-size:.78rem;font-weight:500;line-height:1.5}
    .event-admin-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
    .event-admin-grid-3{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}
    .event-admin-card{border:1px solid #d8e3f0;border-radius:18px;background:#fff;padding:20px;margin-bottom:18px;box-shadow:0 14px 40px rgba(15,23,42,.05)}
    .event-admin-card h3{margin:0 0 16px;color:#0f172a;font-size:1.1rem;font-weight:800}
    .event-admin-divider{display:flex;align-items:center;gap:14px;margin:26px 0 16px;color:#2562E9;font-size:.78rem;font-weight:900;letter-spacing:.14em;text-transform:uppercase}
    .event-admin-divider:before,.event-admin-divider:after{content:"";height:1px;flex:1;background:#d8e3f0}
    .event-admin-divider span{display:inline-flex;align-items:center;gap:8px;border:1px solid #d8e3f0;border-radius:999px;background:#fff;padding:8px 12px;box-shadow:0 10px 28px rgba(15,23,42,.05)}
    .event-admin-card label{display:block;margin-bottom:12px;color:#0f172a;font-weight:700}
    .event-admin-card input,.event-admin-card select,.event-admin-card textarea{width:100%;box-sizing:border-box;border:1px solid #d8e3f0;border-radius:14px;padding:11px 13px;margin-top:6px}
    .event-admin-card textarea{min-height:110px;resize:vertical}
    .currency-choice{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-top:8px}
    .currency-choice input{position:absolute;opacity:0;pointer-events:none}
    .currency-choice span{display:flex;align-items:center;justify-content:center;border:1px solid #d8e3f0;border-radius:40px;background:#fff;padding:12px 14px;color:#475569;font-weight:900}
    .currency-choice input:checked+span{border-color:#2562E9;background:#2562E9;color:#fff;box-shadow:0 10px 24px rgba(37,98,233,.2)}
    .payment-note{margin:8px 0 0;color:#64748b;font-size:.82rem;line-height:1.55}
    .event-admin-row{position:relative;border:1px solid #e2e8f0;border-radius:16px;background:#f8fbff;padding:16px;margin-bottom:12px}
    .event-admin-row-head{display:flex;justify-content:space-between;gap:10px;align-items:center;margin-bottom:12px}
    .event-admin-row-head strong{color:#0f172a}
    .event-admin-table{width:100%;border-collapse:collapse;background:#fff}
    .event-admin-table th,.event-admin-table td{padding:12px;border-bottom:1px solid #e5edf7;text-align:left;vertical-align:top}
    .event-admin-table th{font-size:.76rem;color:#64748b;text-transform:uppercase;letter-spacing:.08em}
    .save-bar{position:sticky;bottom:0;z-index:5;display:flex;justify-content:flex-end;padding:14px 0;background:linear-gradient(180deg,rgba(255,255,255,0),#fff 35%)}
    .save-bar button{border:0;border-radius:40px;background:#2562E9;color:#fff;padding:12px 24px;font-weight:800}
    .visible-toggle{display:inline-flex!important;align-items:center;gap:8px;margin:0!important;white-space:nowrap}
    .visible-toggle input{width:auto;margin:0}
    @media(max-width:900px){.event-admin-grid,.event-admin-grid-3,.event-page-nav{grid-template-columns:1fr}.event-admin-hero,.event-page-block__head{display:block}.event-admin-actions{margin-top:14px}.event-page-link{display:inline-flex;margin-top:14px}}
</style>
