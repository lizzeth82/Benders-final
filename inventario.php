<?php
require_once 'config.php';
require_once 'funciones.php';
$titulo = 'Clientes';
$paginaActiva = 'clientes';
$q = trim($_GET['q']??'');
$clientes = getClientes($pdo,$q);
include 'layout.php';
?>
<div class="page-header">
  <div><h2>Clientes</h2><p><?= count($clientes) ?> cliente(s)</p></div>
</div>

<form method="GET" style="margin-bottom:16px">
  <div class="filtro-grupo">
    <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="🔍 Buscar por nombre o teléfono...">
    <button type="submit" class="btn btn-pink">Buscar</button>
    <a href="clientes.php" class="btn btn-ghost">Limpiar</a>
  </div>
</form>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Nombre</th><th>Teléfono</th><th>Email</th><th>Registro</th><th>Pedidos</th><th>Gasto total</th></tr></thead>
      <tbody>
        <?php foreach($clientes as $c): ?>
        <tr>
          <td class="mono"><?= $c['id_cliente'] ?></td>
          <td><strong><?= htmlspecialchars($c['nombre']) ?></strong></td>
          <td><?= $c['telefono']??'—' ?></td>
          <td class="text-muted"><?= $c['email']??'—' ?></td>
          <td class="text-muted"><?= date('d/m/Y',strtotime($c['fecha_registro'])) ?></td>
          <td><?= $c['pedidos'] ?></td>
          <td><strong style="color:var(--pink)">$<?= number_format($c['gasto_total'],2) ?></strong></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include 'layout_end.php'; ?>
