<?php
// layout.php — Incluir al inicio de cada página
require_once __DIR__ . '/assets/logo_b64.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['usuario'])) { header('Location: login.php'); exit; }
$usuarioActual = $_SESSION['usuario'];
// Requiere: $titulo, $paginaActiva, $pdo ya definidos
$alertas = getAlertasStock($pdo);
$dias = ['Sunday'=>'Domingo','Monday'=>'Lunes','Tuesday'=>'Martes',
         'Wednesday'=>'Miércoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sábado'];
$meses = [1=>'enero',2=>'febrero',3=>'marzo',4=>'abril',5=>'mayo',6=>'junio',7=>'julio',8=>'agosto',9=>'septiembre',10=>'octubre',11=>'noviembre',12=>'diciembre'];
$hoy = $dias[date('l')].', '.date('j').' de '.$meses[(int)date('n')].' de '.date('Y');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?= htmlspecialchars($titulo ?? "Bender's Chilaquiles") ?></title>
  <link rel="stylesheet" href="estilo.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>

<nav class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon"><img src="<?= LOGO_B64 ?>" alt="Benders" style="width:40px;height:40px;border-radius:10px;object-fit:contain;background:#fff;padding:3px"></div>
    <div class="logo-text">
      <strong>Bender's</strong>
      <small>Chilaquiles · Ensenada</small>
    </div>
  </div>

  <div class="sidebar-nav">
    <div class="nav-label">Principal</div>
    <a href="index.php"        class="<?= ($paginaActiva??'')==='dashboard' ?'active':'' ?>"><span>📊</span> Dashboard</a>

    <div class="nav-label">Operación</div>
    <a href="pedidos.php"      class="<?= ($paginaActiva??'')==='pedidos'?'active':'' ?>">
      <span>📦</span> Pedidos
      <?php if (!empty($alertas)): ?>
        <em class="badge-alert"><?= count($alertas) ?></em>
      <?php endif; ?>
    </a>
    <a href="nuevo_pedido.php" class="<?= ($paginaActiva??'')==='nuevo_pedido'?'active':'' ?>"><span>➕</span> Nuevo Pedido</a>
    <a href="cobro.php"       class="<?= ($paginaActiva??'')==='cobro'?'active':'' ?>"><span>💳</span> Cobro / POS</a>
    <a href="clientes.php"     class="<?= ($paginaActiva??'')==='clientes'?'active':'' ?>"><span>👥</span> Clientes</a>

    <div class="nav-label">Negocio</div>
    <a href="productos.php"    class="<?= ($paginaActiva??'')==='productos'?'active':'' ?>"><span>🌮</span> Productos</a>
    <a href="inventario.php"   class="<?= ($paginaActiva??'')==='inventario'?'active':'' ?>">
      <span>📋</span> Inventario
      <?php if (!empty($alertas)): ?><em class="badge-alert">!</em><?php endif; ?>
    </a>
    <a href="reportes.php"     class="<?= ($paginaActiva??'')==='reportes'?'active':'' ?>"><span>📈</span> Reportes</a>
  </div>

  <div class="sidebar-footer">v1.0 · ISC 5SS · Equipo 4</div>
</nav>

<div class="main">
  <header class="topbar">
    <div class="topbar-left">
      <button class="menu-btn" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
      <h1><?= htmlspecialchars($titulo ?? 'Dashboard') ?></h1>
    </div>
    <div class="topbar-right">
      <?php if (!empty($alertas)): ?>
      <a href="inventario.php" class="btn btn-warn btn-sm">⚠️ <?= count($alertas) ?> stock bajo</a>
      <?php endif; ?>
      <span class="topbar-fecha"><?= $hoy ?></span>
      <div class="topbar-user">
        <span class="user-rol user-rol-<?= $usuarioActual['rol'] ?>"><?= ucfirst($usuarioActual['rol']) ?></span>
        <span class="user-nombre"><?= htmlspecialchars($usuarioActual['nombre']) ?></span>
        <a href="logout.php" class="btn-logout-top" title="Cerrar sesión">↩</a>
      </div>
    </div>
  </header>
  <div class="content">
