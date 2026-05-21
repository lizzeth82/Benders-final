<?php
// api/pedido_cliente.php — Recibe pedidos desde menu.php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
    echo json_encode(['ok'=>false,'msg'=>'No autorizado']); exit;
}

require_once '../config.php';
require_once '../funciones.php';

$items_raw = json_decode($_POST['items'] ?? '[]', true);
$items = [];
foreach ((array)$items_raw as $item) {
    if (!empty($item['id_producto']) && !empty($item['cantidad'])) {
        $items[] = ['id_producto'=>(int)$item['id_producto'],'cantidad'=>(int)$item['cantidad']];
    }
}

if (empty($items)) { echo json_encode(['ok'=>false,'msg'=>'Sin productos']); exit; }

// Buscar id_cliente del usuario logueado
$st = $pdo->prepare("SELECT id_cliente FROM clientes WHERE nombre = :n LIMIT 1");
$st->execute([':n' => $_SESSION['usuario']['nombre']]);
$cli = $st->fetchColumn();

// Si no existe como cliente, crear uno
if (!$cli) {
    $cli = guardarCliente($pdo, ['nombre'=>$_SESSION['usuario']['nombre']]);
}

$idPedido = guardarPedido($pdo, [
    'id_cliente'    => $cli,
    'id_plataforma' => (int)($_POST['id_plataforma'] ?? 3),
    'tipo_entrega'  => $_POST['tipo_entrega'] ?? 'recoger',
    'notas'         => trim($_POST['notas'] ?? ''),
    'items'         => $items,
]);

echo json_encode(['ok' => (bool)$idPedido, 'id_pedido' => $idPedido]);
