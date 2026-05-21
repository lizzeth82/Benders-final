<?php
require_once 'config.php';
require_once 'funciones.php';
$titulo = 'Nuevo Pedido';
$paginaActiva = 'nuevo_pedido';
$error = '';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $items = [];
    if (!empty($_POST['prod']) && is_array($_POST['prod'])) {
        foreach($_POST['prod'] as $i=>$id) {
            $c = (int)($_POST['cant'][$i]??0);
            if ($id && $c>0) $items[] = ['id_producto'=>(int)$id,'cantidad'=>$c];
        }
    }
    if (empty($items))              $error = 'Agrega al menos un producto.';
    elseif (empty($_POST['id_cliente'])) $error = 'Selecciona un cliente.';
    else {
        $idCli = (int)$_POST['id_cliente'];
        if ($idCli===-1 && !empty($_POST['nuevo_nombre'])) {
            $idCli = guardarCliente($pdo,[
                'nombre'   =>trim($_POST['nuevo_nombre']),
                'telefono' =>trim($_POST['nuevo_tel']??''),
                'email'    =>trim($_POST['nuevo_email']??''),
                'direccion'=>trim($_POST['nuevo_dir']??''),
            ]) ?: 0;
        }
        if (!$idCli) $error = 'Error al guardar el cliente.';
        else {
            $nuevo = guardarPedido($pdo,[
                'id_cliente'   =>$idCli,
                'id_plataforma'=>(int)$_POST['id_plataforma'],
                'tipo_entrega' =>$_POST['tipo_entrega'],
                'notas'        =>trim($_POST['notas']??''),
                'items'        =>$items,
            ]);
            if ($nuevo) { header("Location: pedido_detalle.php?id=$nuevo&nuevo=1"); exit; }
            else $error = 'Error al guardar el pedido.';
        }
    }
}

$clientes    = getClientes($pdo);
$plataformas = getPlataformas($pdo);
$productos   = getProductosDisponibles($pdo);
$categorias  = [];
foreach ($productos as $pr) $categorias[$pr['categoria']][] = $pr;

include 'layout.php';
?>

<?php if ($error): ?>
<div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="page-header"><h2>Nuevo Pedido</h2><p>Registra un pedido de cualquier canal</p></div>

<form method="POST" id="formPedido">
<div class="form-pedido-grid">

  <!-- PRODUCTOS -->
  <div>
    <div class="card card-pad" style="margin-bottom:16px">
      <h3 style="font-size:14px;font-weight:600;margin-bottom:16px">🌮 Productos del pedido</h3>
      <div id="items-container">
        <div class="item-row">
          <div class="form-group" style="margin:0;flex:1">
            <label>Producto</label>
            <select name="prod[]" required onchange="calcTotal()">
              <option value="">— Elige un producto —</option>
              <?php foreach($categorias as $cat=>$prods): ?>
              <optgroup label="── <?= htmlspecialchars($cat) ?> ──">
                <?php foreach($prods as $pr): ?>
                <option value="<?=$pr['id_producto']?>" data-precio="<?=$pr['precio']?>">
                  <?= htmlspecialchars($pr['nombre']) ?> — $<?= number_format($pr['precio'],2) ?>
                </option>
                <?php endforeach; ?>
              </optgroup>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group" style="margin:0;width:90px">
            <label>Cant.</label>
            <input type="number" name="cant[]" value="1" min="1" max="20" oninput="calcTotal()">
          </div>
          <button type="button" onclick="quitarItem(this)" class="btn-quitar">✕</button>
        </div>
      </div>
      <button type="button" onclick="agregarItem()" class="btn btn-ghost" style="width:100%;justify-content:center;margin-top:10px">+ Agregar producto</button>
    </div>

    <!-- TOTAL EN VIVO -->
    <div class="card card-pad card-dark">
      <div class="total-wrap">
        <span class="total-label">Total estimado</span>
        <span id="totalDisplay" class="total-valor">$0.00</span>
      </div>
      <small style="color:rgba(255,255,255,.35)">Se confirma al guardar</small>
    </div>
  </div>

  <!-- DATOS DEL PEDIDO -->
  <div>
    <div class="card card-pad" style="margin-bottom:16px">
      <h3 style="font-size:14px;font-weight:600;margin-bottom:16px">📋 Datos del pedido</h3>
      <div class="form-group">
        <label>Plataforma / Canal</label>
        <select name="id_plataforma" required>
          <?php foreach($plataformas as $pl): ?>
          <option value="<?=$pl['id_plataforma']?>">
            <?= htmlspecialchars($pl['nombre']) ?>
            <?= $pl['comision_pct']>0 ? " (comisión {$pl['comision_pct']}%)" : " (sin comisión)" ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Tipo de entrega</label>
        <select name="tipo_entrega" required>
          <option value="recoger">Recoger en local</option>
          <option value="domicilio">A domicilio</option>
        </select>
      </div>
      <div class="form-group">
        <label>Notas especiales</label>
        <input type="text" name="notas" placeholder="Sin cebolla, extra crema...">
      </div>
    </div>

    <!-- CLIENTE -->
    <div class="card card-pad">
      <h3 style="font-size:14px;font-weight:600;margin-bottom:16px">👤 Cliente</h3>
      <div class="form-group">
        <label>Seleccionar cliente</label>
        <select name="id_cliente" onchange="toggleNuevo(this.value)" required>
          <option value="">— Seleccionar —</option>
          <option value="-1" style="color:var(--pink);font-weight:600">➕ Nuevo cliente...</option>
          <?php foreach($clientes as $c): ?>
          <option value="<?=$c['id_cliente']?>"><?= htmlspecialchars($c['nombre']) ?> <?= $c['telefono']?"· {$c['telefono']}":'' ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div id="nuevoClienteForm" style="display:none;border-top:1px solid var(--border);padding-top:14px">
        <div class="form-group"><label>Nombre *</label><input type="text" name="nuevo_nombre" placeholder="Nombre completo"></div>
        <div class="form-row">
          <div class="form-group"><label>Teléfono</label><input type="text" name="nuevo_tel" placeholder="646..."></div>
          <div class="form-group"><label>Email</label><input type="email" name="nuevo_email"></div>
        </div>
        <div class="form-group"><label>Dirección</label><input type="text" name="nuevo_dir" placeholder="Para domicilio"></div>
      </div>
    </div>

    <div style="margin-top:16px;display:flex;gap:10px">
      <button type="submit" class="btn btn-pink" style="flex:1;justify-content:center;padding:12px">✓ Registrar Pedido</button>
      <a href="pedidos.php" class="btn btn-ghost">Cancelar</a>
    </div>
  </div>
</div>
</form>

<script>
const selectOpts = `<?php
$opts = '';
foreach($categorias as $cat=>$prods){
    $opts .= '<optgroup label="── '.addslashes(htmlspecialchars($cat)).' ──">';
    foreach($prods as $pr)
        $opts .= '<option value="'.$pr['id_producto'].'" data-precio="'.$pr['precio'].'">'.addslashes(htmlspecialchars($pr['nombre'])).' — $'.number_format($pr['precio'],2).'</option>';
    $opts .= '</optgroup>';
}
echo $opts;
?>`;

function itemHTML() {
  return `<div class="item-row">
    <div class="form-group" style="margin:0;flex:1"><label>Producto</label>
      <select name="prod[]" required onchange="calcTotal()"><option value="">— Elige —</option>${selectOpts}</select></div>
    <div class="form-group" style="margin:0;width:90px"><label>Cant.</label>
      <input type="number" name="cant[]" value="1" min="1" max="20" oninput="calcTotal()"></div>
    <button type="button" onclick="quitarItem(this)" class="btn-quitar">✕</button>
  </div>`;
}
function agregarItem() { document.getElementById('items-container').insertAdjacentHTML('beforeend', itemHTML()); }
function quitarItem(btn) { const rows=document.querySelectorAll('.item-row'); if(rows.length>1) btn.closest('.item-row').remove(), calcTotal(); }
function calcTotal() {
  let t=0;
  document.querySelectorAll('.item-row').forEach(r=>{
    const s=r.querySelector('select'), c=parseInt(r.querySelector('input[type=number]')?.value||0);
    if(s?.selectedOptions[0]?.dataset.precio) t+=parseFloat(s.selectedOptions[0].dataset.precio)*c;
  });
  document.getElementById('totalDisplay').textContent='$'+t.toFixed(2);
}
function toggleNuevo(v) {
  document.getElementById('nuevoClienteForm').style.display=v==='-1'?'block':'none';
}
</script>

<?php include 'layout_end.php'; ?>
