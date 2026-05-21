<?php
require_once 'config.php';
require_once 'funciones.php';
require_once 'assets/logo_b64.php';
require_once 'helpers.php';
$titulo = "Dashboard";
$paginaActiva = 'dashboard';

$resumen  = getResumen($pdo);
$pedHoy   = getPedidosHoy($pdo);
$topProds = getTopProductos($pdo, 5);
$platafs  = getVentasPorPlataforma($pdo);
$mensual  = getIngresosMensuales($pdo);

include 'layout.php';
?>

<?php if (!empty($alertas)): ?>
<div class="alert alert-warning">
  ⚠️ <strong>Stock bajo en <?= count($alertas) ?> ingrediente(s):</strong>
  <?= implode(', ', array_column($alertas,'nombre')) ?> —
  <a href="inventario.php">Ver inventario →</a>
</div>
<?php endif; ?>

<!-- HERO -->
<div class="hero">
  <div class="hero-text">
    <div class="hero-badge">🍲 Ensenada, B.C. · Desde $60</div>
    <h2>Deliciosos<br><span>Chilaquiles</span><br>para llevar</h2>
    <p>Sistema de gestión de pedidos, ventas e inventario.<br>Didi Food · Rappi · WhatsApp · Presencial</p>
    <a href="nuevo_pedido.php" class="btn btn-yellow">+ Registrar pedido</a>
    &nbsp;
    <a href="reportes.php" class="btn btn-ghost btn-sm">Ver reportes →</a>
  </div>
  <div class="hero-emoji"><img src="<?= LOGO_B64 ?>" alt="Benders Chilaquiles" style="width:120px;height:120px;border-radius:20px;object-fit:contain;background:#fff;padding:10px;box-shadow:0 10px 40px rgba(233,30,140,.3)"></div>
</div>

<!-- STAT CARDS -->
<div class="stats-grid">
  <div class="card stat-card" style="--c:var(--pink)">
    <div class="stat-icon">💰</div>
    <div class="stat-label">Ingresos totales</div>
    <div class="stat-value" style="color:var(--pink)">$<?= number_format($resumen['ingresos_totales']??0,0) ?></div>
    <div class="stat-sub">pedidos entregados</div>
  </div>
  <div class="card stat-card" style="--c:#3B82F6">
    <div class="stat-icon">📦</div>
    <div class="stat-label">Pedidos totales</div>
    <div class="stat-value"><?= $resumen['pedidos_totales']??0 ?></div>
    <div class="stat-sub">entregados</div>
  </div>
  <div class="card stat-card" style="--c:#22C55E">
    <div class="stat-icon">👥</div>
    <div class="stat-label">Clientes únicos</div>
    <div class="stat-value"><?= $resumen['clientes_unicos']??0 ?></div>
    <div class="stat-sub">registrados</div>
  </div>
  <div class="card stat-card" style="--c:var(--yellow)">
    <div class="stat-icon">🧾</div>
    <div class="stat-label">Ticket promedio</div>
    <div class="stat-value" style="color:var(--yellow)">$<?= number_format($resumen['ticket_promedio']??0,0) ?></div>
    <div class="stat-sub">por pedido</div>
  </div>
</div>

<!-- CHARTS -->
<div class="grid-2">
  <div class="card chart-wrap">
    <div class="chart-title">📈 Ingresos por mes</div>
    <canvas id="chartMes" height="200"></canvas>
  </div>
  <div class="card chart-wrap">
    <div class="chart-title">🍕 Ventas por plataforma (neto)</div>
    <canvas id="chartPlat" height="200"></canvas>
  </div>
</div>

<!-- TOP PRODUCTOS + PEDIDOS HOY -->
<div class="grid-top">
  <div class="card">
    <div class="card-header">
      <h3>🏆 Top productos</h3>
      <a href="reportes.php" class="link-pink">Ver más →</a>
    </div>
    <div class="top-list">
      <?php foreach ($topProds as $i => $p): ?>
      <div class="top-item">
        <span class="top-num" style="background:<?= $i===0?'var(--pink)':($i===1?'var(--yellow)':'rgba(255,255,255,.1)') ?>;color:<?= $i<2?($i===0?'#fff':'#000'):'rgba(255,255,255,.5)' ?>"><?= $i+1 ?></span>
        <div class="top-info">
          <div class="top-name"><?= htmlspecialchars($p['producto']) ?></div>
          <div class="top-sub"><?= $p['porciones'] ?> porciones</div>
        </div>
        <span class="top-ingreso">$<?= number_format($p['ingreso'],0) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3>📋 Pedidos de hoy</h3>
      <a href="nuevo_pedido.php" class="btn btn-pink btn-sm">+ Nuevo</a>
    </div>
    <?php if (empty($pedHoy)): ?>
      <div class="empty"><span>🍲</span><p>Sin pedidos hoy todavía</p></div>
    <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead><tr><th>#</th><th>Cliente</th><th>Plataforma</th><th>Total</th><th>Estado</th><th></th></tr></thead>
        <tbody>
          <?php foreach ($pedHoy as $p): ?>
          <tr>
            <td class="mono" style="color:var(--muted)">#<?= $p['id_pedido'] ?></td>
            <td><strong><?= htmlspecialchars($p['cliente']) ?></strong></td>
            <td><?= platBadge($p['plataforma']) ?></td>
            <td><strong style="color:var(--yellow)">$<?= number_format($p['total'],2) ?></strong></td>
            <td><?= statusBadge($p['estado']) ?></td>
            <td><a href="pedido_detalle.php?id=<?= $p['id_pedido'] ?>" class="btn btn-ghost btn-sm">Ver</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>

<script>
const mesData  = <?= json_encode(array_values($mensual)) ?>;
const platData = <?= json_encode(array_values($platafs)) ?>;

Chart.defaults.color = 'rgba(240,238,232,.5)';
Chart.defaults.borderColor = 'rgba(255,255,255,.06)';

new Chart(document.getElementById('chartMes'), {
  type:'line',
  data:{
    labels: mesData.map(d=>d.mes),
    datasets:[{
      label:'Ingresos', data: mesData.map(d=>parseFloat(d.ingresos)),
      borderColor:'#E91E8C', backgroundColor:'rgba(233,30,140,.1)',
      fill:true, tension:0.4, pointBackgroundColor:'#E91E8C', pointRadius:4, pointBorderColor:'#0D0D0D'
    }]
  },
  options:{plugins:{legend:{display:false}},
    scales:{y:{beginAtZero:true,ticks:{callback:v=>'$'+v.toLocaleString(),color:'rgba(240,238,232,.4)'},grid:{color:'rgba(255,255,255,.05)'}},
            x:{ticks:{color:'rgba(240,238,232,.4)'},grid:{display:false}}}}
});

new Chart(document.getElementById('chartPlat'), {
  type:'doughnut',
  data:{
    labels: platData.map(d=>d.plataforma),
    datasets:[{
      data: platData.map(d=>parseFloat(d.neto)),
      backgroundColor:['#E91E8C','#F9C61F','#22C55E','#3B82F6'],
      borderWidth:3, borderColor:'#1E1E1E'
    }]
  },
  options:{cutout:'65%',
    plugins:{legend:{position:'bottom',labels:{padding:16,usePointStyle:true,color:'rgba(240,238,232,.6)'}},
      tooltip:{callbacks:{label:ctx=>' $'+ctx.raw.toLocaleString()+' neto'}}}}
});
</script>

<?php include 'layout_end.php'; ?>
