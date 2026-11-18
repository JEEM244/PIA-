<?php
require_once __DIR__ . '/config/conexion.php';
$modulos = [
    'clientes' => ['Clientes', 'Personas registradas'],
    'proveedores' => ['Proveedores', 'Contactos de suministro'],
    'articulos' => ['Artículos', 'Catálogo e inventario'],
    'facturas' => ['Facturas', 'Ventas registradas']
];
$conteos = [];
foreach ($modulos as $tabla => $datos) {
    $conteos[$tabla] = (int) $pdo->query("SELECT COUNT(*) FROM $tabla")->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ferretería | Panel de control</title>
<link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
<header class="topbar"><a class="marca" href="index.php">FERRETERÍA <span>· Sistema de gestión</span></a></header>
<main class="contenedor">
  <section class="bienvenida">
    <p class="sobrelinea">PANEL PRINCIPAL</p>
    <h1>Control del negocio</h1>
    <p>Administra clientes, proveedores, artículos y facturas desde un solo lugar.</p>
  </section>
  <section class="tarjetas">
    <?php foreach ($modulos as $tabla => $datos): ?>
      <a class="tarjeta" href="modulo.php?tabla=<?= htmlspecialchars($tabla) ?>">
        <span class="tarjeta-etiqueta"><?= htmlspecialchars($datos[0]) ?></span>
        <strong><?= $conteos[$tabla] ?></strong>
        <small><?= htmlspecialchars($datos[1]) ?></small>
        <span class="ir">Abrir módulo →</span>
      </a>
    <?php endforeach; ?>
  </section>
  <p class="nota">Los registros se guardan directamente en la base de datos MySQL <b>ferreteria</b>.</p>
</main>
<footer>Proyecto CRUD · PHP y MySQL</footer>
</body>
</html>