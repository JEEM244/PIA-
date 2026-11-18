<?php
$paginaActiva = 'contacto';
$tituloPagina = 'Ferretería | Contacto';

require __DIR__ . '/includes/cabecera.php';
?>

<main class="pagina-interior">
    <section class="pagina-titulo contenedor">
        <p class="sobrelinea">INFORMACIÓN</p>
        <h1>Información de la ferretería</h1>
        <p>Consulta los artículos y los datos disponibles.</p>
    </section>

    <section class="contacto-contenido contenedor">
        <div>
            <p class="sobrelinea">FERRETERÍA</p>
            <h2>¿Buscas una herramienta o material?</h2>
            <p>
                En el catálogo puedes revisar los artículos, consultar sus
                precios y ver las existencias registradas.
            </p>
            <a class="boton" href="catalogo.php">Ver catálogo →</a>
        </div>

        <div class="contacto-panel">
            <strong>Consulta del catálogo</strong>
            <p>La información disponible está organizada en estas secciones:</p>
            <span>Catálogo de productos</span>
            <span>Consulta de existencias</span>
            <span>Registros internos</span>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/pie.php'; ?>
