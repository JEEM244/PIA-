<?php
require_once __DIR__ . '/config/conexion.php';

$paginaActiva = 'catalogo';
$tituloPagina = 'Ferretería | Catálogo';
$busqueda = trim($_GET['buscar'] ?? '');

if ($busqueda !== '') {
    $consulta = $pdo->prepare(
        "SELECT id, nombre, descripcion, precio, existencia
         FROM articulos
         WHERE nombre LIKE :buscar OR descripcion LIKE :buscar
         ORDER BY nombre ASC"
    );
    $consulta->execute(['buscar' => '%' . $busqueda . '%']);
    $articulos = $consulta->fetchAll();
} else {
    $articulos = $pdo->query(
        "SELECT id, nombre, descripcion, precio, existencia
         FROM articulos
         ORDER BY nombre ASC"
    )->fetchAll();
}

// Convierte el nombre del artículo en un formato comparable con el archivo de imagen.
function slug_imagen_catalogo($texto) {
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', (string)$texto);
    return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($texto)), '-');
}

// Busca una imagen cuyo nombre coincida con el artículo.
function imagen_catalogo($nombre) {
    $directorio = __DIR__ . '/assets/img/productos/';
    $archivos = glob($directorio . '*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);

    foreach ($archivos as $archivo) {
        if (slug_imagen_catalogo(pathinfo($archivo, PATHINFO_FILENAME)) === slug_imagen_catalogo($nombre)) {
            return 'assets/img/productos/' . rawurlencode(basename($archivo));
        }
    }

    return null;
}

function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

require __DIR__ . '/includes/cabecera.php';
?>
<main class="pagina-interior">
  <section class="catalogo contenedor">
    <div class="catalogo-cabecera">
      <div>
        <p class="sobrelinea">PRODUCTOS DISPONIBLES</p>
        <h2>Catálogo de productos</h2>
        <p>Consulta herramientas, materiales, precios y existencias.</p>
      </div>
      <span class="contador-productos"><?= count($articulos) ?> artículos</span>
    </div>

    <?php if ($busqueda !== ''): ?>
      <div class="resultado-busqueda">
        <span>Resultados para: <strong><?= h($busqueda) ?></strong></span>
        <a href="catalogo.php">Limpiar búsqueda</a>
      </div>
    <?php endif; ?>

    <?php if (!$articulos): ?>
      <div class="catalogo-vacio">
        <strong>No encontramos productos.</strong>
        <p>Prueba con otro nombre o palabra de búsqueda.</p>
      </div>
    <?php else: ?>
      <div class="productos-grid">
        <?php foreach ($articulos as $articulo): ?>
          <?php $imagen = imagen_catalogo($articulo['nombre']); ?>
          <article class="producto">
            <div class="producto-imagen">
              <?php if ($imagen): ?>
                <img src="<?= h($imagen) ?>" alt="<?= h($articulo['nombre']) ?>">
              <?php else: ?>
                <span class="sin-imagen">Imagen no disponible</span>
              <?php endif; ?>
            </div>
            <div class="producto-info">
              <h3><?= h($articulo['nombre']) ?></h3>
              <p class="producto-descripcion"><?= h($articulo['descripcion']) ?></p>
              <div class="producto-pie">
                <strong class="precio">$<?= number_format((float)$articulo['precio'], 2) ?> MXN</strong>
                <span class="estado <?= (int)$articulo['existencia'] > 0 ? '' : 'agotado' ?>">
                  <i></i><?= (int)$articulo['existencia'] > 0 ? 'Disponible' : 'Agotado' ?>
                </span>
              </div>
              <p class="existencia">Existencias: <?= (int)$articulo['existencia'] ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</main>
<?php require __DIR__ . '/includes/pie.php'; ?>
