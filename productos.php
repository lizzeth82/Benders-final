<?php
// pedido_detalle.php
require_once 'config.php';
require_once 'funciones.php';
require_once 'helpers.php';
$id = (int)($_GET['id']??0);
if (!$id) { header('Location: pedidos.php'); exit; }
$pedido  = getPedidoById($pdo,$id);
$detalle = getDetallePedido($pdo,$id);
$nuevo   = isset($_GET['nuevo']);
$titulo  = "Pedido #$id";
$paginaActiva = 'pedidos';
include 'layout.php';
?>
<?php if ($nuevo): ?>
<div class="alert alert-success">✅ Pedido #<?=$id?> registrado correctamente.</div>
<?php endif; ?>

<div class="page-header">
  <div><h2>Pedido #<?=$id?></h2><p><?= date('d/m/Y H:i',strtotime($pedido['fecha_pedido'])) ?></p></div>
  <a href="pedidos.php" class="btn btn-ghost">← Volver</a>
</div>

<div class="grid-2">
  <div class="card card-pad">
    <h3 style="margin-bottom:14px;font-size:14px;font-weight:600">📋 Datos del pedido</h3>
    <table class="table-info">
      <tr><td><strong>Cliente</strong></td><td><?= htmlspecialchars($pedido['cliente']) ?></td></tr>
      <tr><td><strong>Teléfono</strong></td><td><?= $pedido['telefono']??'—' ?></td></tr>
      <tr><td><strong>Plataforma</strong></td><td><?= platBadge($pedido['plataforma']) ?></td></tr>
      <tr><td><strong>Entrega</strong></td><td><?= ucfirst($pedido['tipo_entrega']) ?></td></tr>
      <tr><td><strong>Estado</strong></td><td><?= statusBadge($pedido['estado']) ?></td></tr>
      <tr><td><strong>Total</strong></td><td><strong style="font-size:18px;color:var(--pink)">$<?= number_format($pedido['total'],2) ?></strong></td></tr>
      <?php if($pedido['notas']): ?><tr><td><strong>Notas</strong></td><td><?= htmlspecialchars($pedido['notas']) ?></td></tr><?php endif; ?>
    </table>
  </div>
  <div class="card card-pad">
    <h3 style="margin-bottom:14px;font-size:14px;font-weight:600">🌮 Productos</h3>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Producto</th><th>Cant.</th><th>Precio u.</th><th>Subtotal</th></tr></thead>
        <tbody>
          <?php foreach($detalle as $d): ?>
          <tr>
            <td><?= htmlspecialchars($d['producto']) ?></td>
            <td><?= $d['cantidad'] ?></td>
            <td>$<?= number_format($d['precio_unitario'],2) ?></td>
            <td><strong>$<?= number_format($d['subtotal'],2) ?></strong></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div style="text-align:right;padding:12px 16px 4px;font-size:18px;font-weight:700;color:var(--pink)">
      Total: $<?= number_format($pedido['total'],2) ?>
    </div>
  </div>
</div>
<?php include 'layout_end.php'; ?>
