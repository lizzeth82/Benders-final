<?php
// ============================================================
//  config.php — Conexión MySQL para WampServer
//  Ruta: C:\wamp64\www\benders\config.php
// ============================================================
define('DB_HOST',    'localhost');
define('DB_NAME',    'benders_chilaquiles');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');

try {
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die('
    <div style="font-family:Arial;background:#fee;padding:30px;border-left:5px solid red;margin:40px auto;max-width:600px;border-radius:8px">
        <h2 style="color:red;margin:0 0 10px">❌ Error de conexión a MySQL</h2>
        <p style="margin:0 0 8px">'.$e->getMessage().'</p>
        <small>Verifica que WampServer esté corriendo (icono verde) y que la base de datos
        <b>benders_chilaquiles</b> exista.</small>
    </div>');
}
