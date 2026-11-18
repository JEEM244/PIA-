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
<title>FORJA | Ferretería</title>
<link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
<header class="topbar">
  <a class="marca" href="index.php">FORJA <span>· Ferretería</span></a>
  <span class="topbar-frase">HERRAMIENTAS PARA HACERLO REALIDAD</span>
</header>

<main>
  <section class="portada">
    <div class="portada-contenido">
      <p class="portada-etiqueta">FERRETERÍA · SUMINISTROS · HERRAMIENTAS</p>
      <h1>Todo para construir tus ideas.</h1>
      <p>Encuentra herramientas, materiales y soluciones para tus proyectos. En FORJA, cada trabajo comienza con lo necesario.</p>
      <a class="boton-portada" href="#modulos">Explorar catálogo <span>→</span></a>
    </div>
    <span class="portada-numero">01 / FORJA</span>
  </section>

  <div class="contenedor" id="modulos">
    <section class="bienvenida">
      <p class="sobrelinea">ADMINISTRACIÓN DEL NEGOCIO</p>
      <h2>Panel de control</h2>
      <p>Consulta y administra la información de tu ferretería desde un solo lugar.</p>
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
  </div>
</main>

<footer>FORJA · Proyecto CRUD con PHP y MySQL</footer>
</body>
</html>