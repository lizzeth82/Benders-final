<?php
require_once 'config.php';
require_once 'funciones.php';
$titulo = 'Productos';
$paginaActiva = 'productos';
$productos = getProductos($pdo);
$categorias = [];
foreach($productos as $p) $categorias[$p['categoria']][] = $p;
include 'layout.php';
?>
<div class="page-header"><h2>Productos</h2><p><?= count($productos) ?> producto(s) en el menú</p></div>

<?php foreach($categorias as $cat=>$prods): ?>
<div class="card" style="margin-bottom:16px">
  <div class="card-header"><h3><?= htmlspecialchars($cat) ?></h3></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Disponible</th></tr></thead>
      <tbody>
        <?php foreach($prods as $p): ?>
        <tr>
          <td class="mono"><?= $p['id_producto'] ?></td>
          <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
          <td class="text-muted"><?= htmlspecialchars($p['descripcion']??'') ?></td>
          <td><strong style="color:var(--pink)">$<?= number_format($p['precio'],2) ?></strong></td>
          <td><?= $p['disponible'] ? '<span style="color:var(--green)">✅ Sí</span>' : '<span style="color:var(--red)">❌ No</span>' ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endforeach; ?>
<?php include 'layout_end.php'; ?>
