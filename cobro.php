/* ============================================================
   BENDER'S CHILAQUILES — estilo.css  (Dark Food Theme)
   Paleta: Rosa #E91E8C · Amarillo #F9C61F · Oscuro #0D0D0D
============================================================ */
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap');

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

:root{
  --pink:#E91E8C; --pink-d:#B5116A; --pink-l:#FCE4EC;
  --yellow:#F9C61F; --yellow-d:#C49B00;
  --dark:#0D0D0D; --dark2:#161616; --dark3:#1E1E1E; --dark4:#2A2A2A;
  --white:#FFFFFF; --gray:#F7F7F7; --gray2:#EFEFEF;
  --border:rgba(255,255,255,.10); --border2:rgba(255,255,255,.06);
  --text:#F0EEE8; --muted:rgba(240,238,232,.45);
  --green:#22C55E; --red:#EF4444; --orange:#F97316;
  --sidebar:240px;
  --radius:12px;
  --shadow:0 2px 12px rgba(0,0,0,.35);
}

html{font-size:14px}
body{font-family:'DM Sans',sans-serif;background:var(--dark);color:var(--text);display:flex;min-height:100vh}

::-webkit-scrollbar{width:5px;height:5px}
::-webkit-scrollbar-thumb{background:#333;border-radius:3px}

/* ══ SIDEBAR ══════════════════════════════════════════════════ */
.sidebar{width:var(--sidebar);background:var(--dark2);min-height:100vh;position:fixed;top:0;left:0;display:flex;flex-direction:column;z-index:100;transition:transform .25s;border-right:1px solid var(--border2)}

.sidebar-logo{padding:20px 18px 16px;border-bottom:1px solid var(--border2);display:flex;align-items:center;gap:12px}
.logo-icon{width:40px;height:40px;background:var(--pink);border-radius:10px;display:grid;place-items:center;font-size:20px;flex-shrink:0}
.logo-text strong{display:block;color:var(--white);font-size:15px;font-weight:700;line-height:1.2}
.logo-text small{color:var(--muted);font-size:11px}

.sidebar-nav{flex:1;padding:10px;overflow-y:auto}
.nav-label{font-size:10px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.2);padding:14px 10px 5px}
.sidebar-nav a{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;color:rgba(255,255,255,.45);text-decoration:none;font-size:13.5px;font-weight:500;transition:all .15s;margin-bottom:2px;border-left:3px solid transparent}
.sidebar-nav a:hover{background:rgba(255,255,255,.05);color:rgba(255,255,255,.8)}
.sidebar-nav a.active{background:rgba(233,30,140,.12);color:var(--pink);border-left-color:var(--pink);font-weight:600}
.badge-alert{margin-left:auto;background:var(--red);color:#fff;font-size:10px;font-style:normal;padding:1px 6px;border-radius:10px;font-weight:700}
.sidebar-footer{padding:14px 18px;border-top:1px solid var(--border2);color:rgba(255,255,255,.2);font-size:11px}

/* ══ MAIN ══════════════════════════════════════════════════════ */
.main{margin-left:var(--sidebar);flex:1;min-height:100vh;display:flex;flex-direction:column}

.topbar{background:var(--dark2);border-bottom:1px solid var(--border2);padding:0 28px;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
.topbar-left{display:flex;align-items:center;gap:12px}
.topbar h1{font-size:18px;font-weight:700;letter-spacing:-.3px;color:var(--white)}
.topbar-fecha{color:var(--muted);font-size:12px}
.topbar-right{display:flex;align-items:center;gap:10px}
.menu-btn{display:none;background:none;border:none;font-size:22px;cursor:pointer;color:var(--text)}

.content{padding:24px 28px 48px;flex:1}

/* ══ HERO (solo en dashboard) ══════════════════════════════════ */
.hero{
  background:var(--dark3);
  border:1px solid var(--border);
  border-radius:16px;
  padding:40px 48px;
  margin-bottom:24px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:24px;
  overflow:hidden;
  position:relative;
}
.hero::before{
  content:'';
  position:absolute;
  top:-60px; right:-60px;
  width:300px; height:300px;
  border-radius:50%;
  background:rgba(233,30,140,.08);
}
.hero-text h2{
  font-family:'Playfair Display',serif;
  font-size:36px;
  font-weight:800;
  color:var(--white);
  line-height:1.15;
  margin-bottom:10px;
}
.hero-text h2 span{color:var(--yellow)}
.hero-text p{color:var(--muted);font-size:14px;margin-bottom:20px;max-width:380px}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(249,198,31,.12);border:1px solid rgba(249,198,31,.25);color:var(--yellow);padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;margin-bottom:20px}
.hero-emoji{font-size:100px;filter:drop-shadow(0 10px 30px rgba(233,30,140,.3))}

/* ══ CARDS ══════════════════════════════════════════════════════ */
.card{background:var(--dark3);border-radius:var(--radius);border:1px solid var(--border);box-shadow:var(--shadow);margin-bottom:16px}
.card-pad{padding:20px}
.card-dark{background:var(--dark);border-color:var(--border2)}
.card-header{display:flex;align-items:center;justify-content:space-between;padding:18px 20px 0;margin-bottom:14px}
.card-header h3{font-size:14px;font-weight:600;color:var(--white)}

/* STAT CARDS */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
.stat-card{padding:20px;overflow:hidden;position:relative;border-left:3px solid var(--c,var(--pink))}
.stat-icon{font-size:22px;margin-bottom:10px;display:block}
.stat-label{font-size:11px;color:var(--muted);font-weight:500;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px}
.stat-value{font-size:28px;font-weight:700;letter-spacing:-1px;line-height:1;color:var(--white)}
.stat-sub{font-size:11px;color:var(--muted);margin-top:4px}

/* ══ GRIDS ══════════════════════════════════════════════════════ */
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
.grid-top{display:grid;grid-template-columns:1fr 1.8fr;gap:16px;margin-bottom:16px}
.chart-wrap{padding:20px}
.chart-title{font-size:13.5px;font-weight:600;margin-bottom:14px;color:var(--white)}

/* TOP PRODUCTOS */
.top-list{padding:0 20px 16px}
.top-item{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.top-num{width:22px;height:22px;border-radius:50%;font-size:11px;font-weight:700;display:grid;place-items:center;flex-shrink:0}
.top-info{flex:1;min-width:0}
.top-name{font-size:13px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text)}
.top-sub{font-size:11px;color:var(--muted)}
.top-ingreso{font-weight:700;font-size:13px;color:var(--yellow)}

/* ══ TABLES ══════════════════════════════════════════════════════ */
.table-wrap{overflow-x:auto}
table{width:100%;border-collapse:collapse}
thead th{background:rgba(255,255,255,.04);padding:10px 16px;text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap}
tbody td{padding:12px 16px;border-bottom:1px solid var(--border2);font-size:13.5px;vertical-align:middle;color:var(--text)}
tbody tr:last-child td{border-bottom:none}
tbody tr{transition:background .1s}
tbody tr:hover{background:rgba(255,255,255,.03)}
.table-info{width:100%;border-collapse:collapse}
.table-info td{padding:8px 12px;border-bottom:1px solid var(--border2);font-size:13.5px;color:var(--text)}
.table-info tr:last-child td{border-bottom:none}

/* ══ BADGES ══════════════════════════════════════════════════════ */
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap}
.badge-didi      {background:rgba(230,81,0,.18);color:#FF9800}
.badge-didifood  {background:rgba(230,81,0,.18);color:#FF9800}
.badge-rappi     {background:rgba(233,30,140,.18);color:var(--pink)}
.badge-whatsapp  {background:rgba(34,197,94,.18);color:#4ADE80}
.badge-presencial{background:rgba(59,130,246,.18);color:#60A5FA}

.status{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600}
.status::before{content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0}
.status.recibido  {background:rgba(59,130,246,.15);color:#60A5FA}.status.recibido::before  {background:#3B82F6}
.status.preparando{background:rgba(245,158,11,.15);color:#FCD34D}.status.preparando::before{background:#F59E0B}
.status.listo     {background:rgba(34,197,94,.15);color:#4ADE80}.status.listo::before      {background:#22C55E}
.status.entregado {background:rgba(34,197,94,.15);color:#86EFAC}.status.entregado::before  {background:#16A34A}
.status.cancelado {background:rgba(239,68,68,.15);color:#FCA5A5}.status.cancelado::before  {background:#EF4444}

/* ══ BUTTONS ══════════════════════════════════════════════════════ */
.btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:13.5px;font-weight:600;font-family:inherit;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
.btn-pink   {background:var(--pink);color:#fff}
.btn-pink:hover{background:var(--pink-d);transform:translateY(-1px);box-shadow:0 4px 20px rgba(233,30,140,.4)}
.btn-yellow {background:var(--yellow);color:var(--dark)}
.btn-yellow:hover{background:var(--yellow-d)}
.btn-ghost  {background:rgba(255,255,255,.07);color:var(--text);border:1px solid var(--border)}
.btn-ghost:hover{background:rgba(255,255,255,.12)}
.btn-warn   {background:rgba(249,198,31,.15);color:var(--yellow);border:1px solid rgba(249,198,31,.3)}
.btn-sm{padding:5px 12px;font-size:12px}
.btn-quitar{width:36px;height:40px;background:rgba(239,68,68,.15);color:#FCA5A5;border:none;border-radius:8px;cursor:pointer;font-size:16px;flex-shrink:0;margin-top:22px}
.link-pink{color:var(--pink);text-decoration:none;font-size:12px;font-weight:500}

/* ══ FORMS ══════════════════════════════════════════════════════ */
.form-group{margin-bottom:14px}
.form-row  {display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px}
label{display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:var(--muted);margin-bottom:5px}
input[type=text],input[type=email],input[type=number],input[type=date],select,textarea{
  width:100%;padding:10px 12px;
  border:1.5px solid rgba(255,255,255,.12);
  border-radius:8px;font-size:14px;font-family:inherit;
  color:var(--text);background:rgba(255,255,255,.05);outline:none;
  transition:border-color .15s,box-shadow .15s
}
input:focus,select:focus,textarea:focus{border-color:var(--pink);box-shadow:0 0 0 3px rgba(233,30,140,.12)}
select option{background:var(--dark3);color:var(--text)}
textarea{resize:vertical;min-height:70px}

/* ══ FILTROS ══════════════════════════════════════════════════════ */
.filtros-form{margin-bottom:16px}
.filtro-grupo{display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end}
.filtro-grupo input[type=text],.filtro-grupo select{flex:1;min-width:140px;width:auto}

/* ══ ESTADO CONTROL ══════════════════════════════════════════════ */
.estado-ctrl{display:flex;gap:6px;align-items:center}
.estado-ctrl select{padding:4px 8px;border-radius:6px;border:1px solid var(--border);font-size:12px;font-family:inherit;cursor:pointer;width:auto;background:var(--dark3);color:var(--text)}

/* ══ FORM PEDIDO ══════════════════════════════════════════════════ */
.form-pedido-grid{display:grid;grid-template-columns:1.1fr 1fr;gap:20px;align-items:start}
.item-row{display:flex;gap:10px;margin-bottom:10px;align-items:flex-end}
.total-wrap{display:flex;justify-content:space-between;align-items:center}
.total-label{color:rgba(255,255,255,.4);font-size:13px;font-weight:500}
.total-valor{color:var(--yellow);font-size:32px;font-weight:700;letter-spacing:-1px}

/* ══ ALERTS ══════════════════════════════════════════════════════ */
.alert{padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;display:flex;align-items:flex-start;gap:8px;cursor:pointer}
.alert a{color:var(--yellow);font-weight:600}
.alert-warning{background:rgba(249,198,31,.1);border:1px solid rgba(249,198,31,.25);color:var(--yellow)}
.alert-error  {background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#FCA5A5}
.alert-success{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#4ADE80}

/* ══ INVENTARIO ══════════════════════════════════════════════════ */
.nivel-ok    {color:#4ADE80;font-weight:600}
.nivel-alerta{color:var(--yellow);font-weight:600}
.nivel-bajo  {color:#FCA5A5;font-weight:600}
.stock-bar{height:5px;border-radius:3px;background:rgba(255,255,255,.08);overflow:hidden;margin-top:4px;width:80px}
.stock-fill{height:100%;border-radius:3px;transition:width .3s}
.stock-fill.ok    {background:#22C55E}
.stock-fill.alerta{background:var(--yellow)}
.stock-fill.bajo  {background:var(--red)}

/* ══ MISC ══════════════════════════════════════════════════════════ */
.empty{text-align:center;padding:48px 20px;color:var(--muted)}
.empty span{font-size:40px;display:block;margin-bottom:12px}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px}
.page-header h2{font-size:20px;font-weight:700;letter-spacing:-.3px;color:var(--white)}
.page-header p{color:var(--muted);font-size:13px;margin-top:2px}
.text-muted{color:var(--muted)}
.text-pink {color:var(--pink)}
.text-green{color:#4ADE80}
.text-red  {color:#FCA5A5}
.mono{font-family:'Courier New',monospace;font-size:12.5px}

/* ══ RESPONSIVE ══════════════════════════════════════════════════ */
@media(max-width:1100px){
  .stats-grid{grid-template-columns:1fr 1fr}
  .grid-top  {grid-template-columns:1fr}
  .form-pedido-grid{grid-template-columns:1fr}
}
@media(max-width:768px){
  .sidebar{transform:translateX(-100%);width:240px}
  .sidebar.open{transform:translateX(0)}
  .main{margin-left:0}
  .content{padding:16px}
  .topbar{padding:0 16px}
  .menu-btn{display:block}
  .stats-grid,.grid-2{grid-template-columns:1fr 1fr}
  .form-row,.form-row-3{grid-template-columns:1fr}
  .hero{padding:28px 24px}
  .hero-text h2{font-size:26px}
  .hero-emoji{font-size:60px}
}
@media(max-width:480px){
  .stats-grid,.grid-2{grid-template-columns:1fr}
}

/* ── TOPBAR USER ─────────────────────────────────────────── */
.topbar-user{display:flex;align-items:center;gap:8px}
.user-nombre{font-size:13px;color:rgba(240,238,232,.55);font-weight:500}
.user-rol{font-size:10px;font-weight:700;padding:3px 8px;border-radius:20px;text-transform:uppercase;letter-spacing:.5px}
.user-rol-admin   {background:rgba(233,30,140,.15);color:#E91E8C}
.user-rol-empleado{background:rgba(249,198,31,.15);color:#F9C61F}
.user-rol-cliente {background:rgba(34,197,94,.15);color:#4ADE80}
.btn-logout-top{background:rgba(255,255,255,.07);color:rgba(240,238,232,.5);border:1px solid rgba(255,255,255,.1);padding:5px 10px;border-radius:7px;font-size:14px;text-decoration:none;transition:all .15s}
.btn-logout-top:hover{background:rgba(239,68,68,.15);color:#FCA5A5;border-color:rgba(239,68,68,.3)}
