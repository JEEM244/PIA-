<?php
// Valores por defecto para las páginas que incluyen esta cabecera.
$paginaActiva = $paginaActiva ?? 'inicio';
$busqueda = $busqueda ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Herramientas, materiales y artículos para reparación, mantenimiento y construcción.">
    <title><?= htmlspecialchars($tituloPagina ?? 'Ferretería', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
    <div class="franja-superior">
        FERRETERÍA <span>·</span> Herramientas y materiales
    </div>

    <header class="encabezado">
        <a class="marca" href="index.php">FERRETERÍA</a>

        <!-- El buscador envía el texto a la página del catálogo por GET. -->
        <form class="buscador" action="catalogo.php" method="get" role="search">
            <input
                type="search"
                name="buscar"
                placeholder="Buscar artículo..."
                value="<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>"
                aria-label="Buscar productos por nombre o descripción"
            >
            <button type="submit">Buscar</button>
        </form>

        <a class="enlace-contacto" href="contacto.php">
            Datos <span>↗</span>
        </a>
    </header>

    <!-- El enlace activo se marca según la página que se está mostrando. -->
    <nav class="navegacion">
        <div class="navegacion-interior">
            <a class="<?= $paginaActiva === 'inicio' ? 'activo' : '' ?>" href="index.php">Inicio</a>
            <a class="<?= $paginaActiva === 'catalogo' ? 'activo' : '' ?>" href="catalogo.php">Catálogo</a>
            <a class="<?= $paginaActiva === 'historia' ? 'activo' : '' ?>" href="historia.php">Nuestra historia</a>
            <a class="<?= $paginaActiva === 'ventajas' ? 'activo' : '' ?>" href="ventajas.php">¿Por qué elegirnos?</a>
            <a class="<?= $paginaActiva === 'contacto' ? 'activo' : '' ?>" href="contacto.php">Contacto</a>
            <a class="nav-administracion" href="administracion.php">Administración <span>↗</span></a>
        </div>
    </nav>
