<?php
require_once 'config.php';
require_once 'funciones.php';
require_once 'helpers.php';
$titulo = 'Pedidos';
$paginaActiva = 'pedidos';

// Cambiar estado (AJAX)
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id_pedido'],$_POST['estado'])) {
    $ok = actualizarEstado($pdo,(int)$_POST['id_pedido'],$_POST['estado']);
    if (isset($_POST['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode(['ok'=>$ok]); exit;
    }
    header('Location: pedidos.php'); exit;
}

$fe = $_GET['estado'] ?? '';
$fp = $_GET['plat']   ?? '';
$fq = trim($_GET['q'] ?? '');
$pedidos     = getTodosPedidos($pdo,$fe,$fp,$fq);
$plataformas = getPlataformas($pdo);

include 'layout.php';
?>

<div class="page-header">
  <div><h2>Pedidos</h2><p><?= count($pedidos) ?> pedido(s) encontrado(s)</p></div>
  <a href="nuevo_pedido.php" class="btn btn-pink">➕ Nuevo pedido</a>
</div>

<!-- FILTROS -->
<form method="GET" class="filtros-form">
  <div class="filtro-grupo">
    <input type="text" name="q" value="<?= htmlspecialchars($fq) ?>" placeholder="🔍 Buscar cliente...">
    <select name="estado">
      <option value="">Todos los estados</option>
      <?php foreach(['recibido','preparando','listo','entregado','cancelado'] as $e): ?>
      <option value="<?=$e?>" <?=$fe===$e?'selected':''?>><?= ucfirst($e) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="plat">
      <option value="">Todas las plataformas</option>
      <?php foreach($plataformas as $pl): ?>
      <option value="<?=$pl['id_plataforma']?>" <?=$fp==$pl['id_plataforma']?'selected':''?>><?= $pl['nombre'] ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-pink">Filtrar</button>
    <a href="pedidos.php" class="btn btn-ghost">Limpiar</a>
  </div>
</form>

<div class="card">
  <?php if (empty($pedidos)): ?>
    <div class="empty"><span>📭</span><p>No se encontraron pedidos</p></div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>#</th><th>Cliente</th><th>Plataforma</th><th>Fecha</th><th>Entrega</th><th>Total</th><th>Estado</th><th>Cambiar estado</th></tr>
      </thead>
      <tbody>
        <?php foreach($pedidos as $p): ?>
        <tr id="row-<?=$p['id_pedido']?>">
          <td class="mono">#<?=$p['id_pedido']?></td>
          <td><strong><?= htmlspecialchars($p['cliente']) ?></strong></td>
          <td><?= platBadge($p['plataforma']) ?></td>
          <td class="text-muted"><?= date('d/m/Y H:i',strtotime($p['fecha_pedido'])) ?></td>
          <td><?= ucfirst($p['tipo_entrega']) ?></td>
          <td><strong>$<?= number_format($p['total'],2) ?></strong></td>
          <td id="status-<?=$p['id_pedido']?>"><?= statusBadge($p['estado']) ?></td>
          <td>
            <div class="estado-ctrl">
              <select onchange="cambiarEstado(<?=$p['id_pedido']?>,this.value)">
                <?php foreach(['recibido','preparando','listo','entregado','cancelado'] as $e): ?>
                <option value="<?=$e?>" <?=$p['estado']===$e?'selected':''?>><?= ucfirst($e) ?></option>
                <?php endforeach; ?>
              </select>
              <a href="pedido_detalle.php?id=<?=$p['id_pedido']?>" class="btn btn-ghost btn-sm">Ver</a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<script>
async function cambiarEstado(id, estado) {
  const res  = await fetch('pedidos.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:`id_pedido=${id}&estado=${estado}&ajax=1`});
  const data = await res.json();
  if (data.ok) {
    const el = document.getElementById('status-'+id);
    const clases = {recibido:'recibido',preparando:'preparando',listo:'listo',entregado:'entregado',cancelado:'cancelado'};
    el.innerHTML = `<span class="status ${estado}">${estado.charAt(0).toUpperCase()+estado.slice(1)}</span>`;
    const row = document.getElementById('row-'+id);
    row.style.background='#F0FDF4';
    setTimeout(()=>row.style.background='',1200);
  }
}
</script>

<?php include 'layout_end.php'; ?>
