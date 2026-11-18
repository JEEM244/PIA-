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
    <div class="carrusel-contenedor">
      <div class="carrusel" id="carrusel-productos">
        <article class="carrusel-tarjeta"><img src="assets/img/productos/Martillo%20de%20u%C3%B1a.jpg" alt="Martillo de uña"><div><strong>Martillo de uña</strong><span>Herramientas manuales</span></div></article>
        <article class="carrusel-tarjeta"><img src="assets/img/productos/Desarmador%20plano.jpg" alt="Desarmador plano"><div><strong>Desarmador plano</strong><span>Herramientas manuales</span></div></article>
        <article class="carrusel-tarjeta"><img src="assets/img/productos/Pinzas%20de%20electricista.jpg" alt="Pinzas de electricista"><div><strong>Pinzas de electricista</strong><span>Instalación y reparación</span></div></article>
        <article class="carrusel-tarjeta"><img src="assets/img/productos/Juego%20de%20llaves.jpg" alt="Juego de llaves"><div><strong>Juego de llaves</strong><span>Herramientas manuales</span></div></article>
        <article class="carrusel-tarjeta"><img src="assets/img/productos/Pintura%20blanca.jpg" alt="Pintura blanca"><div><strong>Pintura blanca</strong><span>Pinturas y acabados</span></div></article>
        <article class="carrusel-tarjeta"><img src="assets/img/productos/Casco%20de%20seguridad.jpg" alt="Casco de seguridad"><div><strong>Casco de seguridad</strong><span>Equipo de protección</span></div></article>
      </div>
    </div>
    <p class="carrusel-ayuda">Los productos avanzan automáticamente. También puedes deslizar para verlos.</p>
  </section><section class="llamada"><div><p class="sobrelinea">MANOS A LA OBRA</p><h2>Tu próximo proyecto comienza aquí.</h2><p>Revisa nuestro catálogo y encuentra los artículos que necesitas.</p></div><a href="catalogo.php" class="boton-secundario">Ver catálogo <span>→</span></a></section></main><script>
// El carrusel avanza una tarjeta cada pocos segundos.
const carrusel = document.getElementById('carrusel-productos');

if (carrusel && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  let pausa = false;

  const avanzarCarrusel = () => {
    if (pausa) return;

    const tarjeta = carrusel.querySelector('.carrusel-tarjeta');
    if (!tarjeta) return;

    const estilos = window.getComputedStyle(carrusel);
    const espacio = tarjeta.getBoundingClientRect().width + parseFloat(estilos.columnGap || 0);
    const final = carrusel.scrollLeft + carrusel.clientWidth >= carrusel.scrollWidth - 5;

    carrusel.scrollTo({
      left: final ? 0 : carrusel.scrollLeft + espacio,
      behavior: 'smooth'
    });
  };

  // Se detiene mientras alguien apunta o navega con el teclado por el carrusel.
  carrusel.addEventListener('mouseenter', () => pausa = true);
  carrusel.addEventListener('mouseleave', () => pausa = false);
  carrusel.addEventListener('focusin', () => pausa = true);
  carrusel.addEventListener('focusout', () => pausa = false);

  window.setInterval(avanzarCarrusel, 3200);
}
</script><?php require __DIR__.'/includes/pie.php'; ?>