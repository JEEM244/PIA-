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

// El catálogo público obtiene los artículos directamente de MySQL.
$articulos = $pdo->query(
    "SELECT nombre, descripcion, precio, existencia
     FROM articulos
     ORDER BY nombre ASC"
)->fetchAll();

function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

// Normaliza nombres para comparar los nombres de artículos con sus imágenes.
function slug_imagen($texto) {
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', (string)$texto);
    $texto = strtolower($texto);
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
    return trim($texto, '-');
}

// Busca la imagen del producto dentro de la carpeta del catálogo.
function buscar_imagen_producto($nombre) {
    $carpeta = __DIR__ . '/assets/img/productos/';
    $archivos = glob($carpeta . '*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);
    $nombreBuscado = slug_imagen($nombre);

    foreach ($archivos as $archivo) {
        $nombreArchivo = pathinfo($archivo, PATHINFO_FILENAME);

        if (slug_imagen($nombreArchivo) === $nombreBuscado) {
            return 'assets/img/productos/' . rawurlencode(basename($archivo));
        }
    }

    return null;
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
  <nav class="menu-publico">
    <a href="#productos">Productos</a>
    <a href="#modulos">Administración</a>
  </nav>
  <span class="topbar-frase">HERRAMIENTAS PARA HACERLO REALIDAD</span>
</header>

<main>
  <section class="portada">
    <img class="portada-imagen" src="assets/img/ferreteria.jpg" alt="" aria-hidden="true">
    <div class="portada-contenido">
      <p class="portada-etiqueta">FERRETERÍA · SUMINISTROS · HERRAMIENTAS</p>
      <h1>Todo para construir tus ideas.</h1>
      <p>Encuentra herramientas, materiales y soluciones para tus proyectos. En FORJA, cada trabajo comienza con lo necesario.</p>
      <a class="boton-portada" href="#productos">Ver productos <span>→</span></a>
    </div>
    <span class="portada-numero">01 / FORJA</span>
  </section>

  <section class="catalogo contenedor" id="productos">
    <div class="catalogo-encabezado">
      <div>
        <p class="sobrelinea">CATÁLOGO FORJA</p>
        <h2>Productos disponibles</h2>
        <p>Conoce algunos de los artículos que tenemos para tus proyectos.</p>
      </div>
      <span class="catalogo-total"><?= count($articulos) ?> artículos</span>
    </div>

    <?php if (!$articulos): ?>
      <div class="catalogo-vacio">
        <h3>Próximamente tendremos productos.</h3>
        <p>Estamos preparando nuestro catálogo. Vuelve pronto.</p>
      </div>
    <?php else: ?>
      <div class="productos-grid">
        <?php foreach ($articulos as $articulo): ?>
          <?php $imagenProducto = buscar_imagen_producto($articulo['nombre']); ?>
          <article class="producto">
            <div class="producto-imagen">
              <?php if ($imagenProducto): ?>
                <img src="<?= h($imagenProducto) ?>" alt="<?= h($articulo['nombre']) ?>" loading="lazy">
              <?php else: ?>
                <span>Imagen pendiente</span>
              <?php endif; ?>
            </div>
            <div class="producto-info">
              <h3><?= h($articulo['nombre']) ?></h3>
              <p class="producto-descripcion"><?= h($articulo['descripcion'] ?: 'Artículo de ferretería.') ?></p>
              <div class="producto-pie">
                <strong>$<?= number_format((float)$articulo['precio'], 2) ?></strong>
                <?php if ((int)$articulo['existencia'] > 0): ?>
                  <span class="disponible">Disponible · <?= (int)$articulo['existencia'] ?></span>
                <?php else: ?>
                  <span class="agotado">Agotado</span>
                <?php endif; ?>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>

  <div class="contenedor administracion" id="modulos">
    <section class="bienvenida">
      <p class="sobrelinea">ÁREA INTERNA</p>
      <h2>Panel de administración</h2>
      <p>Gestiona los clientes, proveedores, artículos y facturas de la ferretería.</p>
    </section>

    <section class="tarjetas">
      <?php foreach ($modulos as $tabla => $datos): ?>
        <a class="tarjeta" href="modulo.php?tabla=<?= h($tabla) ?>">
          <span class="tarjeta-etiqueta"><?= h($datos[0]) ?></span>
          <strong><?= $conteos[$tabla] ?></strong>
          <small><?= h($datos[1]) ?></small>
          <span class="ir">Abrir módulo →</span>
        </a>
      <?php endforeach; ?>
    </section>
    <p class="nota">Los registros se guardan directamente en la base de datos MySQL <b>ferreteria</b>.</p>
  </div>
</main>

<footer>FORJA · Ferretería</footer>
</body>
</html>
