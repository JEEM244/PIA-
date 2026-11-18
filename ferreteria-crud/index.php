<?php
// Datos que usa la cabecera para marcar la sección actual.
$paginaActiva = 'inicio';
$tituloPagina = 'Ferretería | Inicio';

require __DIR__ . '/includes/cabecera.php';
?>

<main>
    <!-- Imagen principal y acceso directo al catálogo. -->
    <section class="portada">
        <img
            class="portada-imagen"
            src="assets/img/ferreteria.jpg"
            alt="Interior de una ferretería con herramientas y materiales"
        >
        <div class="portada-sombra"></div>

        <div class="portada-contenido">
            <p class="portada-etiqueta">HERRAMIENTAS Y MATERIALES</p>
            <h1>Lo que te hace falta para seguir trabajando.</h1>
            <p>Herramientas y materiales para reparaciones, mantenimiento y trabajos de construcción.</p>
            <a class="boton-principal" href="catalogo.php">
                Ver artículos <span>→</span>
            </a>
        </div>

        <span class="portada-indice">FERRETERÍA</span>
    </section>

    <!-- Carrusel de artículos destacados. El segundo grupo repite al primero
         para que la animación pueda avanzar en un ciclo continuo. -->
    <section class="carrusel-seccion contenedor" aria-label="Artículos de la ferretería">
        <div class="catalogo-cabecera">
            <div>
                <p class="sobrelinea">DEL MOSTRADOR AL TALLER</p>
                <h2>Artículos de la ferretería</h2>
                <p>Estos son algunos de los artículos que manejamos.</p>
            </div>
            <span class="contador-productos">ARTÍCULOS</span>
        </div>

        <div class="carrusel-contenedor">
            <div class="carrusel-cinta" id="carrusel-productos">
                <div class="carrusel-grupo">
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Martillo%20de%20u%C3%B1a.jpg" alt="Martillo de uña">
                        <div><strong>Martillo de uña</strong><span>Herramientas manuales</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Desarmador%20plano.jpg" alt="Desarmador plano">
                        <div><strong>Desarmador plano</strong><span>Herramientas manuales</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Pinzas%20de%20electricista.jpg" alt="Pinzas de electricista">
                        <div><strong>Pinzas de electricista</strong><span>Instalación y reparación</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Juego%20de%20llaves.jpg" alt="Juego de llaves">
                        <div><strong>Juego de llaves</strong><span>Herramientas manuales</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Pintura%20blanca.jpg" alt="Pintura blanca">
                        <div><strong>Pintura blanca</strong><span>Pinturas y acabados</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Casco%20de%20seguridad.jpg" alt="Casco de seguridad">
                        <div><strong>Casco de seguridad</strong><span>Equipo de protección</span></div>
                    </article>
                </div>

                <!-- Copia visual para mantener el movimiento sin un salto al inicio. -->
                <div class="carrusel-grupo" aria-hidden="true">
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Martillo%20de%20u%C3%B1a.jpg" alt="">
                        <div><strong>Martillo de uña</strong><span>Herramientas manuales</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Desarmador%20plano.jpg" alt="">
                        <div><strong>Desarmador plano</strong><span>Herramientas manuales</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Pinzas%20de%20electricista.jpg" alt="">
                        <div><strong>Pinzas de electricista</strong><span>Instalación y reparación</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Juego%20de%20llaves.jpg" alt="">
                        <div><strong>Juego de llaves</strong><span>Herramientas manuales</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Pintura%20blanca.jpg" alt="">
                        <div><strong>Pintura blanca</strong><span>Pinturas y acabados</span></div>
                    </article>
                    <article class="carrusel-tarjeta">
                        <img src="assets/img/productos/Casco%20de%20seguridad.jpg" alt="">
                        <div><strong>Casco de seguridad</strong><span>Equipo de protección</span></div>
                    </article>
                </div>
            </div>
        </div>

        <p class="carrusel-ayuda">Algunos artículos del catálogo.</p>
    </section>

    <!-- Cierre de la página con otro enlace al catálogo. -->
    <section class="llamada">
        <div>
            <p class="sobrelinea">¿QUÉ NECESITAS?</p>
            <h2>Encuentra lo que buscas.</h2>
            <p>Consulta los artículos, precios y existencias.</p>
        </div>
        <a href="catalogo.php" class="boton-secundario">
            Ver catálogo <span>→</span>
        </a>
    </section>
</main>

<script>
// Activa el movimiento del carrusel, excepto si el usuario
// ha indicado en su sistema que prefiere menos animaciones.
const cinta = document.getElementById('carrusel-productos');

if (cinta && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    cinta.classList.add('carrusel-animado');
}
</script>

<?php require __DIR__ . '/includes/pie.php'; ?>
