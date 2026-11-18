<?php
require_once __DIR__.'/config/conexion.php';
$paginaActiva='catalogo'; $tituloPagina='Ferretería | Catálogo'; $busqueda=trim($_GET['buscar']??'');
if($busqueda!==''){$consulta=$pdo->prepare("SELECT nombre,descripcion,precio,existencia FROM articulos WHERE nombre LIKE :buscar OR descripcion LIKE :buscar ORDER BY nombre ASC");$consulta->execute(['buscar'=>'%'.$busqueda.'%']);$articulos=$consulta->fetchAll();}else{$articulos=$pdo->query("SELECT nombre,descripcion,precio,existencia FROM articulos ORDER BY nombre ASC")->fetchAll();}
function h($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function slug_imagen($v){$v=iconv('UTF-8','ASCII//TRANSLIT//IGNORE',(string)$v);return trim(preg_replace('/[^a-z0-9]+/','-',strtolower($v)),'-');}
function buscar_imagen_producto($n){$dir=__DIR__.'/assets/img/productos/';$files=glob($dir.'*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}',GLOB_BRACE);foreach($files as $f)if(slug_imagen(pathinfo($f,PATHINFO_FILENAME))===slug_imagen($n))return 'assets/img/productos/'.rawurlencode(basename($f));return null;}
require __DIR__.'/includes/cabecera.php'; ?><main class="pagina-interior"><section class="carrusel-seccion contenedor" aria-label="Productos destacados">
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
  </section></main><?php require __DIR__.'/includes/pie.php'; ?>