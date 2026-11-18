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
// El buscador filtra el catálogo por nombre o descripción.
$busqueda = trim($_GET['buscar'] ?? '');

if ($busqueda !== '') {
    $consulta = $pdo->prepare(
        "SELECT nombre, descripcion, precio, existencia
         FROM articulos
         WHERE nombre LIKE :buscar OR descripcion LIKE :buscar
         ORDER BY nombre ASC"
    );
    $consulta->execute(['buscar' => '%' . $busqueda . '%']);
    $articulos = $consulta->fetchAll();
} else {
    $articulos = $pdo->query(
        "SELECT nombre, descripcion, precio, existencia
         FROM articulos
         ORDER BY nombre ASC"
    )->fetchAll();
}

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
<meta name="description" content="FORJA Ferretería: herramientas, materiales y artículos para construcción y reparación.">
<title>FORJA | Ferretería y materiales</title>
<link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
<div class="franja-superior">FERRETERÍA FORJA <span>·</span> Lo que necesitas para cada proyecto</div>

<header class="encabezado">
  <a class="marca" href="index.php" aria-label="FORJA, ir al inicio">
    <span class="marca-simbolo">F</span>
    <span class="marca-texto">FORJA<small>FERRETERÍA</small></span>
  </a>
  <form class="buscador" action="index.php" method="get" role="search">
    <input type="search" name="buscar" placeholder="¿Qué herramienta o material buscas?" value="<?= h($busqueda) ?>" aria-label="Buscar productos">
    <button type="submit">Buscar</button>
  </form>
  <a class="enlace-contacto" href="#informacion">Información <span>↗</span></a>
</header>

<nav class="navegacion">
  <div class="navegacion-interior">
    <a class="activo" href="index.php">Inicio</a>
    <a href="#productos">Catálogo</a>
    <a href="#ventajas">¿Por qué FORJA?</a>
    <a href="#informacion">Contacto</a>
  </div>
</nav>

<main>
  <section class="portada">
    <img class="portada-imagen" src="assets/img/ferreteria.jpg" alt="Interior de una ferretería con herramientas y materiales">
    <div class="portada-sombra"></div>
    <div class="portada-contenido">
      <p class="portada-etiqueta">HERRAMIENTAS · MATERIALES · SOLUCIONES</p>
      <h1>Todo empieza con las herramientas correctas.</h1>
      <p>Encuentra lo necesario para reparar, construir y darle forma a tus proyectos.</p>
      <a class="boton-principal" href="#productos">Explorar productos <span>→</span></a>
    </div>
    <span class="portada-indice">FORJA / 001</span>
  </section>

  <section class="ventajas" id="ventajas">
    <article><span class="ventaja-icono">01</span><div><strong>Para cada proyecto</strong><small>Herramientas y materiales</small></div></article>
    <article><span class="ventaja-icono">02</span><div><strong>Catálogo actualizado</strong><small>Productos desde inventario</small></div></article>
    <article><span class="ventaja-icono">03</span><div><strong>Atención directa</strong><small>Información clara y sencilla</small></div></article>
  </section>

  <section class="catalogo contenedor" id="productos">
    <div class="catalogo-cabecera">
      <div>
        <p class="sobrelinea">ENCUENTRA LO QUE NECESITAS</p>
        <h2>Catálogo de productos</h2>
        <p>Consulta los artículos registrados en nuestra ferretería.</p>
      </div>
      <span class="contador-productos"><?= count($articulos) ?> <?= count($articulos) === 1 ? 'producto' : 'productos' ?></span>
    </div>

    <?php if ($busqueda !== ''): ?>
      <div class="resultado-busqueda">
        Resultados para <strong>“<?= h($busqueda) ?>”</strong>
        <a href="index.php">Limpiar búsqueda ×</a>
      </div>
    <?php endif; ?>

    <?php if (!$articulos): ?>
      <div class="catalogo-vacio">
        <strong><?= $busqueda !== '' ? 'No encontramos ese producto.' : 'El catálogo todavía está vacío.' ?></strong>
        <p><?= $busqueda !== '' ? 'Prueba con otro nombre o palabra.' : 'Pronto agregaremos productos a esta sección.' ?></p>
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
                <span class="sin-imagen">Imagen no disponible</span>
              <?php endif; ?>
              <span class="etiqueta-producto">FORJA</span>
            </div>
            <div class="producto-info">
              <h3><?= h($articulo['nombre']) ?></h3>
              <p class="producto-descripcion"><?= h($articulo['descripcion'] ?: 'Artículo disponible en nuestra ferretería.') ?></p>
              <div class="producto-pie">
                <strong class="precio">$<?= number_format((float)$articulo['precio'], 2) ?></strong>
                <?php if ((int)$articulo['existencia'] > 0): ?>
                  <span class="estado disponible"><i></i> Disponible</span>
                <?php else: ?>
                  <span class="estado agotado"><i></i> Agotado</span>
                <?php endif; ?>
              </div>
              <div class="existencia">Existencia: <?= (int)$articulo['existencia'] ?> unidades</div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>

  <section class="llamada">
    <div>
      <p class="sobrelinea">MANOS A LA OBRA</p>
      <h2>Tu próximo proyecto comienza aquí.</h2>
      <p>Revisa nuestro catálogo y encuentra los artículos que necesitas.</p>
    </div>
    <a href="#productos" class="boton-secundario">Ver catálogo <span>→</span></a>
  </section>
</main>

<section class="administracion contenedor" id="administracion">
  <div class="administracion-cabecera">
    <div><p class="sobrelinea">ACCESO INTERNO</p><h2>Administración de la ferretería</h2><p>Área de gestión de registros e inventario.</p></div>
  </div>
  <div class="tarjetas">
    <?php foreach ($modulos as $tabla => $datos): ?>
      <a class="tarjeta" href="modulo.php?tabla=<?= h($tabla) ?>">
        <span class="tarjeta-etiqueta"><?= h($datos[0]) ?></span>
        <strong><?= $conteos[$tabla] ?></strong>
        <small><?= h($datos[1]) ?></small>
        <span class="ir">Gestionar →</span>
      </a>
    <?php endforeach; ?>
  </div>
  <p class="nota">Los datos se almacenan en la base de datos MySQL <b>ferreteria</b>.</p>
</section>

<footer id="informacion">
  <div class="footer-principal">
    <div class="footer-marca">
      <a class="marca marca-footer" href="index.php"><span class="marca-simbolo">F</span><span class="marca-texto">FORJA<small>FERRETERÍA</small></span></a>
      <p>Herramientas y materiales para construir, reparar y crear.</p>
    </div>
    <div class="footer-columna"><strong>Explora</strong><a href="index.php">Inicio</a><a href="#productos">Productos</a><a href="#ventajas">Ventajas</a></div>
    <div class="footer-columna"><strong>Información</strong><span>Catálogo de artículos</span><span>Consulta de existencias</span><span>Precios en pesos mexicanos</span></div>
    <div class="footer-columna footer-admin"><strong>Personal</strong><a href="#administracion">Administración →</a></div>
  </div>
  <div class="footer-final"><span>© <?= date('Y') ?> FORJA Ferretería. Proyecto académico.</span><span>Construido para cada proyecto.</span></div>
</footer>
</body>
</html>