<?php
require_once 'config.php';
require_once 'funciones.php';
$titulo = 'Inventario';
$paginaActiva = 'inventario';
$msg = '';

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id_ingrediente'])) {
    $ok = actualizarStock($pdo,
        (int)$_POST['id_ingrediente'],
        (float)$_POST['cantidad'],
        (float)$_POST['costo_total'],
        trim($_POST['proveedor']??'')
    );
    $msg = $ok ? 'success|Stock actualizado correctamente.' : 'error|Error al actualizar el stock.';
    header('Location: inventario.php?msg='.urlencode($msg)); exit;
}
if (isset($_GET['msg'])) {
    [$tipo,$texto] = explode('|',urldecode($_GET['msg']),2);
    echo '<div class="alert alert-'.$tipo.'">'.htmlspecialchars($texto).'</div>';
}

$inventario  = getInventario($pdo);
$ingredientes = $inventario; // para el select
include 'layout.php';
?>
<div class="page-header"><h2>Inventario de Ingredientes</h2></div>

<?php if (!empty($alertas)): ?>
<div class="alert alert-warning">⚠️ <strong><?= count($alertas) ?> ingrediente(s) con stock bajo:</strong> <?= implode(', ',array_column($alertas,'nombre')) ?></div>
<?php endif; ?>

<!-- FORM AGREGAR STOCK -->
<div class="card card-pad" style="margin-bottom:20px">
  <h3 style="font-size:14px;font-weight:600;margin-bottom:14px">📦 Registrar compra / entrada de stock</h3>
  <form method="POST">
    <div class="form-row-3">
      <div class="form-group">
        <label>Ingrediente</label>
        <select name="id_ingrediente" required>
          <option value="">— Seleccionar —</option>
          <?php foreach($ingredientes as $i): ?>
          <option value="<?=$i['id_ingrediente']?>"><?= htmlspecialchars($i['nombre']) ?> (<?= $i['stock_actual'].' '.$i['unidad'] ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Cantidad a agregar</label>
        <input type="number" name="cantidad" step="0.001" min="0.001" placeholder="ej: 5.000" required>
      </div>
      <div class="form-group">
        <label>Costo total ($)</label>
        <input type="number" name="costo_total" step="0.01" min="0" placeholder="ej: 450.00" required>
      </div>
    </div>
    <div class="form-group" style="max-width:300px">
      <label>Proveedor</label>
      <input type="text" name="proveedor" placeholder="Nombre del proveedor">
    </div>
    <button type="submit" class="btn btn-pink">+ Agregar al stock</button>
  </form>
</div>

<!-- TABLA INVENTARIO -->
<div class="card">
  <div class="card-header"><h3>Stock actual</h3></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Ingrediente</th><th>Stock actual</th><th>Stock mínimo</th><th>Unidad</th><th>Costo unitario</th><th>Estado</th></tr></thead>
      <tbody>
        <?php foreach($inventario as $i): ?>
        <tr>
          <td><strong><?= htmlspecialchars($i['nombre']) ?></strong></td>
          <td><?= $i['stock_actual'] ?></td>
          <td><?= $i['stock_minimo'] ?></td>
          <td><?= $i['unidad'] ?></td>
          <td>$<?= number_format($i['costo_unitario'],2) ?></td>
          <td>
            <?php
              $pct = $i['stock_minimo']>0 ? min(100,round($i['stock_actual']/$i['stock_minimo']*100)) : 100;
              $cls = $i['nivel'];
              $label = ['ok'=>'🟢 OK','alerta'=>'🟡 Alerta','bajo'=>'🔴 Bajo'][$cls];
            ?>
            <span class="nivel-<?= $cls ?>"><?= $label ?></span>
            <div class="stock-bar"><div class="stock-fill <?=$cls?>" style="width:<?=$pct?>%"></div></div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include 'layout_end.php'; ?>
