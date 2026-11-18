<?php
require_once __DIR__ . '/config/conexion.php';

// Nombre y descripción de cada sección del panel.
$modulos = [
    'clientes' => ['Clientes', 'Clientes'],
    'proveedores' => ['Proveedores', 'Proveedores'],
    'articulos' => ['Artículos', 'Artículos registrados'],
    'facturas' => ['Facturación', 'Facturas capturadas']
];

// Cuenta únicamente los registros que siguen activos.
$conteos = [];

foreach ($modulos as $tabla => $datos) {
    $consulta = $pdo->query(
        "SELECT COUNT(*) FROM $tabla WHERE eliminado_en IS NULL"
    );

    $conteos[$tabla] = (int) $consulta->fetchColumn();
}

// Suma de los importes de las facturas que no están en la papelera.
$totalVentas = (float) $pdo->query(
    "SELECT COALESCE(SUM(total), 0)
     FROM facturas
     WHERE eliminado_en IS NULL"
)->fetchColumn();

// Total de registros enviados a papelera entre las cuatro tablas.
$totalPapelera = (int) $pdo->query(
    "SELECT
        (SELECT COUNT(*) FROM clientes WHERE eliminado_en IS NOT NULL) +
        (SELECT COUNT(*) FROM proveedores WHERE eliminado_en IS NOT NULL) +
        (SELECT COUNT(*) FROM articulos WHERE eliminado_en IS NOT NULL) +
        (SELECT COUNT(*) FROM facturas WHERE eliminado_en IS NOT NULL)"
)->fetchColumn();

// Últimos siete movimientos para mostrarlos en el panel.
$movimientos = $pdo->query(
    "SELECT tipo, tabla_afectada, descripcion, fecha
     FROM movimientos
     ORDER BY fecha DESC, id DESC
     LIMIT 7"
)->fetchAll();

// Escapa texto de la base de datos antes de mostrarlo en HTML.
function h($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de administración | Ferretería</title>
    <link rel="stylesheet" href="assets/estilos.css">
</head>
<body class="admin-body">
    <header class="admin-top">
        <a class="marca" href="administracion.php">
            FERRETERÍA <span>/ ADMINISTRACIÓN</span>
        </a>

        <div>
            <a href="reportes.php">Reportes</a>
            <a href="papelera.php">Papelera (<?= $totalPapelera ?>)</a>
            <a href="index.php">Ver sitio ↗</a>
        </div>
    </header>

    <main class="admin-dashboard">
        <div class="admin-welcome">
            <div>
                <p class="sobrelinea">PANEL DE CONTROL / <?= date('d.m.Y') ?></p>
                <h1>Panel de administración</h1>
                <p>Consulta los registros, actualiza datos y revisa los movimientos.</p>
            </div>

            <a class="admin-primary-link" href="modulo.php?tabla=articulos">
                Ver artículos <span>→</span>
            </a>
        </div>

        <!-- Indicadores generales del negocio. -->
        <div class="dashboard-stats">
            <article>
                <span>VENTAS REGISTRADAS</span>
                <strong>$<?= number_format($totalVentas, 2) ?></strong>
                <small>MXN · acumulado</small>
            </article>

            <?php foreach ($modulos as $tabla => $datos): ?>
                <article>
                    <span><?= strtoupper(h($datos[0])) ?></span>
                    <strong><?= $conteos[$tabla] ?></strong>
                    <small><?= h($datos[1]) ?></small>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Accesos a los cuatro módulos del CRUD. -->
        <div class="dashboard-section-heading">
            <div>
                <p class="sobrelinea">MÓDULOS</p>
                <h2>Registros de la ferretería</h2>
            </div>
            <span>01 / MÓDULOS</span>
        </div>

        <div class="admin-module-grid">
            <?php foreach ($modulos as $tabla => $datos): ?>
                <a href="modulo.php?tabla=<?= h($tabla) ?>" class="admin-module">
                    <span class="module-number">
                        <?= str_pad(
                            (string) (array_search($tabla, array_keys($modulos)) + 1),
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) ?>
                    </span>

                    <div>
                        <h3><?= h($datos[0]) ?></h3>
                        <p><?= h($datos[1]) ?></p>
                    </div>

                    <strong><?= $conteos[$tabla] ?></strong>
                    <span class="module-arrow">↗</span>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="dashboard-lower">
            <section class="admin-card">
                <div class="admin-card-head">
                    <div>
                        <p class="sobrelinea">MOVIMIENTOS</p>
                        <h2>Últimos movimientos</h2>
                    </div>
                    <a class="admin-inline-link" href="reportes.php">Ver reportes →</a>
                </div>

                <?php if (!$movimientos): ?>
                    <p class="admin-empty">Todavía no se han registrado cambios.</p>
                <?php endif; ?>

                <?php foreach ($movimientos as $movimiento): ?>
                    <div class="activity-row">
                        <span class="activity-dot"></span>

                        <div>
                            <strong>
                                <?= h($movimiento['tipo']) ?> ·
                                <?= h($movimiento['tabla_afectada']) ?>
                            </strong>
                            <p><?= h($movimiento['descripcion']) ?></p>
                        </div>

                        <time><?= h($movimiento['fecha']) ?></time>
                    </div>
                <?php endforeach; ?>
            </section>

            <section class="admin-card admin-trash-card">
                <p class="sobrelinea">RECUPERACIÓN</p>
                <h2>Papelera</h2>
                <strong><?= $totalPapelera ?></strong>
                <p>Registros que se pueden restaurar.</p>
                <a class="admin-inline-link" href="papelera.php">Revisar papelera →</a>
            </section>
        </div>

        <footer class="admin-footer">Administración · Ferretería</footer>
    </main>
</body>
</html>
