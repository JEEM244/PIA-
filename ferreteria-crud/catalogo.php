<?php
require_once __DIR__ . '/config/conexion.php';

$paginaActiva = 'catalogo';
$tituloPagina = 'Ferretería | Catálogo';
$busqueda = trim(preg_replace('/\\s+/', ' ', $_GET['buscar'] ?? ''));

if ($busqueda !== '') {
    // Cada palabra debe aparecer en el nombre o en la descripción.
    // Así también funcionan búsquedas como "martillo acero".
    $terminos = preg_split('/\\s+/', $busqueda, -1, PREG_SPLIT_NO_EMPTY);
    $condiciones = [];
    $parametros = [];

    foreach ($terminos as $indice => $termino) {
        // PDO necesita marcadores distintos para cada aparición del valor.
        $marcadorNombre = ':nombre' . $indice;
        $marcadorDescripcion = ':descripcion' . $indice;
        $condiciones[] = "(nombre LIKE $marcadorNombre OR descripcion LIKE $marcadorDescripcion)";
        $valor = '%' . $termino . '%';
        $parametros['nombre' . $indice] = $valor;
        $parametros['descripcion' . $indice] = $valor;
    }

    $sql = "SELECT id, nombre, descripcion, precio, existencia
            FROM articulos
            WHERE " . implode(' AND ', $condiciones) . "
            ORDER BY nombre ASC";

    $consulta = $pdo->prepare($sql);
    $consulta->execute($parametros);
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
        <p class="sobrelinea">CATÁLOGO</p>
        <h2>Herramientas y materiales</h2>
        <p>Revisa los precios y la disponibilidad de cada artículo.</p>
      </div>
      <span class="contador-productos"><?= count($articulos) ?> artículos</span>
    </div>

    <?php if ($busqueda !== ''): ?>
      <div class="resultado-busqueda">
        <span>Resultados para: <strong><?= h($busqueda) ?></strong></span>
        <a href="catalogo.php">Ver todo el catálogo</a>
      </div>
    <?php endif; ?>

    <?php if (!$articulos): ?>
      <div class="catalogo-vacio">
        <strong>No hay artículos con esa búsqueda.</strong>
        <p>Intenta con otro nombre o una palabra más corta.</p>
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
                <span class="sin-imagen">Sin fotografía</span>
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
