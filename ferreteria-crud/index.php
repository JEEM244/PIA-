<?php $paginaActiva='inicio'; $tituloPagina='Ferretería | Inicio'; require __DIR__.'/includes/cabecera.php'; ?><main><section class="portada">
    <img class="portada-imagen" src="assets/img/ferreteria.jpg" alt="Interior de una ferretería con herramientas y materiales">
    <div class="portada-sombra"></div>
    <div class="portada-contenido">
      <p class="portada-etiqueta">HERRAMIENTAS · MATERIALES · SOLUCIONES</p>
      <h1>Todo empieza con las herramientas correctas.</h1>
      <p>Encuentra lo necesario para reparar, construir y darle forma a tus proyectos.</p>
      <a class="boton-principal" href="catalogo.php">Explorar productos <span>→</span></a>
    </div>
    <span class="portada-indice">FERRETERÍA</span>
  </section><section class="carrusel-seccion contenedor" aria-label="Productos destacados">
    <div class="catalogo-cabecera">
      <div><p class="sobrelinea">UNA MIRADA AL CATÁLOGO</p><h2>Productos destacados</h2><p>Algunas herramientas y materiales que puedes encontrar.</p></div>
      <span class="contador-productos">SELECCIÓN DE PRODUCTOS</span>
    </div>
    <div class="carrusel-contenedor"><div class="carrusel-cinta" id="carrusel-productos"><div class="carrusel-grupo"><article class="carrusel-tarjeta"><img src="assets/img/productos/Martillo%20de%20u%C3%B1a.jpg" alt="Martillo de uña"><div><strong>Martillo de uña</strong><span>Herramientas manuales</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Desarmador%20plano.jpg" alt="Desarmador plano"><div><strong>Desarmador plano</strong><span>Herramientas manuales</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Pinzas%20de%20electricista.jpg" alt="Pinzas de electricista"><div><strong>Pinzas de electricista</strong><span>Instalación y reparación</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Juego%20de%20llaves.jpg" alt="Juego de llaves"><div><strong>Juego de llaves</strong><span>Herramientas manuales</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Pintura%20blanca.jpg" alt="Pintura blanca"><div><strong>Pintura blanca</strong><span>Pinturas y acabados</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Casco%20de%20seguridad.jpg" alt="Casco de seguridad"><div><strong>Casco de seguridad</strong><span>Equipo de protección</span></div></article></div><div class="carrusel-grupo" aria-hidden="true"><article class="carrusel-tarjeta"><img src="assets/img/productos/Martillo%20de%20u%C3%B1a.jpg" alt=""><div><strong>Martillo de uña</strong><span>Herramientas manuales</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Desarmador%20plano.jpg" alt=""><div><strong>Desarmador plano</strong><span>Herramientas manuales</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Pinzas%20de%20electricista.jpg" alt=""><div><strong>Pinzas de electricista</strong><span>Instalación y reparación</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Juego%20de%20llaves.jpg" alt=""><div><strong>Juego de llaves</strong><span>Herramientas manuales</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Pintura%20blanca.jpg" alt=""><div><strong>Pintura blanca</strong><span>Pinturas y acabados</span></div></article><article class="carrusel-tarjeta"><img src="assets/img/productos/Casco%20de%20seguridad.jpg" alt=""><div><strong>Casco de seguridad</strong><span>Equipo de protección</span></div></article></div></div></div>
    <p class="carrusel-ayuda">Los productos avanzan automáticamente. También puedes deslizar para verlos.</p>
  </section><section class="llamada"><div><p class="sobrelinea">MANOS A LA OBRA</p><h2>Tu próximo proyecto comienza aquí.</h2><p>Revisa nuestro catálogo y encuentra los artículos que necesitas.</p></div><a href="catalogo.php" class="boton-secundario">Ver catálogo <span>→</span></a></section></main><script>
// La cinta avanza siempre hacia la izquierda y repite el recorrido sin regresar.
const cinta = document.getElementById('carrusel-productos');
if (cinta && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  cinta.classList.add('carrusel-animado');
}
</script><?php require __DIR__.'/includes/pie.php'; ?>