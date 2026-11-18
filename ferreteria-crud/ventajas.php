<?php
$paginaActiva = 'ventajas';
$tituloPagina = 'Ferretería | ¿Qué puedes consultar aquí?';

require __DIR__ . '/includes/cabecera.php';
?>

<main class="pagina-interior">
    <section class="pagina-titulo contenedor">
        <p class="sobrelinea">ENCUENTRA LO QUE BUSCAS</p>
        <h1>¿Qué puedes consultar aquí?</h1>
        <p>Información de artículos, precios y existencias.</p>
    </section>

    <!-- Resumen de las secciones disponibles. -->
    <section class="ventajas" id="ventajas">
        <article>
            <span class="ventaja-icono">01</span>
            <div>
                <strong>Para distintos trabajos</strong>
                <small>Reparación y construcción</small>
            </div>
        </article>
        <article>
            <span class="ventaja-icono">02</span>
            <div>
                <strong>Artículos registrados</strong>
                <small>Precios y existencias</small>
            </div>
        </article>
        <article>
            <span class="ventaja-icono">03</span>
            <div>
                <strong>Consulta de información</strong>
                <small>Datos del catálogo</small>
            </div>
        </article>
    </section>

    <section class="beneficios-detalle contenedor">
        <article>
            <span>01</span>
            <h2>Reparación y construcción</h2>
            <p>Artículos para reparaciones, mantenimiento y trabajos de construcción.</p>
        </article>
        <article>
            <span>02</span>
            <h2>Precios y existencias</h2>
            <p>Cada artículo muestra su precio y las piezas registradas en inventario.</p>
        </article>
        <article>
            <span>03</span>
            <h2>Datos a la vista</h2>
            <p>El catálogo y las secciones de información están separados para que encuentres cada cosa sin dar vueltas.</p>
        </article>
    </section>
</main>

<?php require __DIR__ . '/includes/pie.php'; ?>
