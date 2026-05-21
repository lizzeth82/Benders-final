<?php
require_once 'config.php';
require_once 'funciones.php';
$titulo = 'Reportes';
$paginaActiva = 'reportes';

$platafs   = getVentasPorPlataforma($pdo);
$topProds  = getTopProductos($pdo,10);
$porDia    = getVentasPorDia($pdo);
$mensual   = getIngresosMensuales($pdo);
$utilidad  = getCostoUtilidad($pdo);
$tipoEnt   = getTipoEntrega($pdo);
$ticketP   = getTicketPromedio($pdo);
$leales    = getClientesLeales($pdo);

include 'layout.php';
?>

<div class="page-header"><h2>Reportes y Análisis</h2><p>Datos reales del negocio</p></div>

<!-- CHARTS -->
<div class="grid-2">
  <div class="card chart-wrap">
    <div class="chart-title">Ingresos por mes</div>
    <canvas id="chartMes" height="210"></canvas>
  </div>
  <div class="card chart-wrap">
    <div class="chart-title">Ingresos brutos vs netos por plataforma</div>
    <canvas id="chartPlat" height="210"></canvas>
  </div>
</div>

<div class="grid-2">
  <div class="card chart-wrap">
    <div class="chart-title">Pedidos por día de la semana</div>
    <canvas id="chartDia" height="210"></canvas>
  </div>
  <div class="card chart-wrap">
    <div class="chart-title">Domicilio vs Recoger</div>
    <canvas id="chartEntrega" height="210"></canvas>
  </div>
</div>

<!-- TABLA PLATAFORMAS -->
<div class="card" style="margin-bottom:16px">
  <div class="card-header"><h3>Ventas por plataforma (Q1)</h3></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Plataforma</th><th>Pedidos</th><th>Ingresos brutos</th><th>Comisión</th><th>Ingresos netos</th></tr></thead>
      <tbody>
        <?php foreach($platafs as $p): ?>
        <tr>
          <td><strong><?= htmlspecialchars($p['plataforma']) ?></strong></td>
          <td><?= $p['pedidos'] ?></td>
          <td>$<?= number_format($p['bruto'],2) ?></td>
          <td style="color:var(--red)">-<?= $p['comision_pct'] ?>%</td>
          <td><strong style="color:var(--green)">$<?= number_format($p['neto'],2) ?></strong></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- UTILIDAD POR PRODUCTO -->
<div class="card" style="margin-bottom:16px">
  <div class="card-header"><h3>Costo y utilidad por producto (Q7)</h3></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Producto</th><th>Precio venta</th><th>Costo ingredientes</th><th>Utilidad bruta</th><th>Margen</th></tr></thead>
      <tbody>
        <?php foreach($utilidad as $u):
          $margen = $u['venta']>0 ? round($u['utilidad']/$u['venta']*100,1) : 0; ?>
        <tr>
          <td><?= htmlspecialchars($u['producto']) ?></td>
          <td>$<?= number_format($u['venta'],2) ?></td>
          <td>$<?= number_format($u['costo'],2) ?></td>
          <td style="color:var(--green);font-weight:600">$<?= number_format($u['utilidad'],2) ?></td>
          <td><?= $margen ?>%</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- CLIENTES LEALES -->
<div class="card" style="margin-bottom:16px">
  <div class="card-header"><h3>Clientes leales — 3 o más pedidos (Q14)</h3></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Cliente</th><th>Teléfono</th><th>Pedidos</th><th>Gasto total</th></tr></thead>
      <tbody>
        <?php foreach($leales as $c): ?>
        <tr>
          <td><strong><?= htmlspecialchars($c['nombre']) ?></strong></td>
          <td><?= $c['telefono']??'—' ?></td>
          <td><?= $c['pedidos'] ?></td>
          <td style="color:var(--pink);font-weight:700">$<?= number_format($c['gasto'],2) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
const mesData  = <?= json_encode(array_values($mensual)) ?>;
const platData = <?= json_encode(array_values($platafs)) ?>;
const diaData  = <?= json_encode(array_values($porDia)) ?>;
const entData  = <?= json_encode(array_values($tipoEnt)) ?>;

new Chart(document.getElementById('chartMes'),{type:'line',data:{
  labels:mesData.map(d=>d.mes),
  datasets:[{label:'Ingresos',data:mesData.map(d=>parseFloat(d.ingresos)),
    borderColor:'#E91E8C',backgroundColor:'rgba(233,30,140,.08)',fill:true,tension:0.4,pointBackgroundColor:'#E91E8C',pointRadius:4}]
},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{callback:v=>'$'+v.toLocaleString()}}}}});

new Chart(document.getElementById('chartPlat'),{type:'bar',data:{
  labels:platData.map(d=>d.plataforma),
  datasets:[
    {label:'Bruto',data:platData.map(d=>parseFloat(d.bruto)),backgroundColor:'#FBCFE8',borderRadius:4},
    {label:'Neto', data:platData.map(d=>parseFloat(d.neto)), backgroundColor:'#E91E8C',borderRadius:4},
  ]
},options:{plugins:{legend:{position:'bottom'}},scales:{y:{beginAtZero:true}}}});

new Chart(document.getElementById('chartDia'),{type:'bar',data:{
  labels:diaData.map(d=>d.dia),
  datasets:[{label:'Pedidos',data:diaData.map(d=>parseInt(d.pedidos)),backgroundColor:'#F9C61F',borderRadius:6}]
},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{stepSize:1}}}}});

new Chart(document.getElementById('chartEntrega'),{type:'pie',data:{
  labels:entData.map(d=>d.tipo_entrega.charAt(0).toUpperCase()+d.tipo_entrega.slice(1)),
  datasets:[{data:entData.map(d=>parseInt(d.pedidos)),backgroundColor:['#E91E8C','#F9C61F']}]
},options:{plugins:{legend:{position:'bottom'}}}});
});
</script>

<?php include 'layout_end.php'; ?>
