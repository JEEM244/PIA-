<?php
require_once __DIR__ . '/config/conexion.php';

// Totales generales. Las facturas en papelera no se toman en cuenta.
$totalVentas = (float) $pdo->query(
    "SELECT COALESCE(SUM(total), 0)
     FROM facturas
     WHERE eliminado_en IS NULL"
)->fetchColumn();

$numVentas = (int) $pdo->query(
    "SELECT COUNT(*)
     FROM facturas
     WHERE eliminado_en IS NULL"
)->fetchColumn();

// Evita dividir entre cero cuando todavía no hay facturas.
$promedio = $numVentas ? $totalVentas / $numVentas : 0;

// Suma las piezas disponibles de todos los artículos activos.
$inventario = (int) $pdo->query(
    "SELECT COALESCE(SUM(existencia), 0)
     FROM articulos
     WHERE eliminado_en IS NULL"
)->fetchColumn();

// Agrupa las facturas por mes y muestra los ocho meses más recientes con datos.
$porMes = $pdo->query(
    "SELECT
        DATE_FORMAT(fecha, '%Y-%m') AS mes,
        COUNT(*) AS operaciones,
        SUM(total) AS total
     FROM facturas
     WHERE eliminado_en IS NULL
     GROUP BY DATE_FORMAT(fecha, '%Y-%m')
     ORDER BY mes DESC
     LIMIT 8"
)->fetchAll();

// Cuenta las facturas asociadas a cada artículo y ordena los cinco primeros.
$top = $pdo->query(
    "SELECT
        a.nombre,
        COUNT(f.id) AS ventas,
        COALESCE(SUM(f.total), 0) AS importe
     FROM facturas f
     INNER JOIN articulos a ON a.id = f.articulo_id
     WHERE f.eliminado_en IS NULL
       AND a.eliminado_en IS NULL
     GROUP BY a.id, a.nombre
     ORDER BY ventas DESC, importe DESC
     LIMIT 5"
)->fetchAll();

// Últimos doce movimientos registrados en el sistema.
$movimientos = $pdo->query(
    "SELECT tipo, tabla_afectada, descripcion, fecha
     FROM movimientos
     ORDER BY fecha DESC, id DESC
     LIMIT 12"
)->fetchAll();

// Escapa valores antes de imprimirlos en el HTML.
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
    <title>Reportes | Ferretería</title>
    <link rel="stylesheet" href="assets/estilos.css">
</head>
<body class="admin-body">
    <header class="admin-top">
        <a class="marca" href="administracion.php">
            FERRETERÍA <span>/ REPORTES</span>
        </a>

        <div>
            <a href="papelera.php">Papelera</a>
            <a href="administracion.php">Panel principal</a>
        </div>
    </header>

    <main class="admin-layout">
        <aside class="admin-sidebar">
            <p class="sobrelinea">HERRAMIENTAS</p>
            <a href="administracion.php">Resumen <span>→</span></a>
            <a class="seleccionado" href="reportes.php">Reportes <span>01</span></a>
            <a href="papelera.php">Papelera <span>↗</span></a>
            <a href="index.php">Ver sitio público <span>↗</span></a>
        </aside>

        <section class="admin-contenido">
            <div class="admin-page-heading">
                <div>
                    <p class="sobrelinea">RESUMEN</p>
                    <h1>Reportes</h1>
                    <p>Cifras obtenidas de las facturas y existencias actuales.</p>
                </div>
                <span class="admin-count">TOTALES</span>
            </div>

            <!-- Indicadores calculados a partir de los registros actuales. -->
            <div class="report-kpis">
                <article>
                    <span>VENTAS TOTALES</span>
                    <strong>$<?= number_format($totalVentas, 2) ?></strong>
                    <small>MXN · facturas activas</small>
                </article>
                <article>
                    <span>FACTURAS</span>
                    <strong><?= $numVentas ?></strong>
                    <small>Facturas vigentes</small>
                </article>
                <article>
                    <span>PROMEDIO DE VENTA</span>
                    <strong>$<?= number_format($promedio, 2) ?></strong>
                    <small>MXN por factura</small>
                </article>
                <article>
                    <span>EXISTENCIAS</span>
                    <strong><?= $inventario ?></strong>
                    <small>Existencias actuales</small>
                </article>
            </div>

            <div class="report-grid">
                <section class="admin-card">
                    <div class="admin-card-head">
                        <div>
                            <p class="sobrelinea">VENTAS</p>
                            <h2>Ventas por mes</h2>
                        </div>
                    </div>

                    <div class="tabla-scroll">
                        <table>
                            <thead>
                                <tr><th>Mes</th><th>Facturas</th><th>Total</th></tr>
                            </thead>
                            <tbody>
                                <?php if (!$porMes): ?>
                                    <tr><td colspan="3">Aún no hay facturas para mostrar.</td></tr>
                                <?php endif; ?>

                                <?php foreach ($porMes as $registro): ?>
                                    <tr>
                                        <td><?= h($registro['mes']) ?></td>
                                        <td><?= (int) $registro['operaciones'] ?></td>
                                        <td>$<?= number_format((float) $registro['total'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="admin-card">
                    <div class="admin-card-head">
                        <div>
                            <p class="sobrelinea">ARTÍCULOS</p>
                            <h2>Artículos con más facturas</h2>
                        </div>
                    </div>

                    <div class="tabla-scroll">
                        <table>
                            <thead>
                                <tr><th>Artículo</th><th>Facturas</th><th>Importe</th></tr>
                            </thead>
                            <tbody>
                                <?php if (!$top): ?>
                                    <tr><td colspan="3">Todavía no hay artículos en las facturas.</td></tr>
                                <?php endif; ?>

                                <?php foreach ($top as $registro): ?>
                                    <tr>
                                        <td><?= h($registro['nombre']) ?></td>
                                        <td><?= (int) $registro['ventas'] ?></td>
                                        <td>$<?= number_format((float) $registro['importe'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <!-- Historial de altas, modificaciones, papelera y restauraciones. -->
            <section class="admin-card admin-table-card">
                <div class="admin-card-head">
                    <div>
                        <p class="sobrelinea">HISTORIAL</p>
                        <h2>Últimos cambios</h2>
                    </div>
                    <span class="admin-card-index">12</span>
                </div>

                <div class="tabla-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Movimiento</th>
                                <th>Módulo</th>
                                <th>Detalle</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$movimientos): ?>
                                <tr><td colspan="4">Aún no hay movimientos que mostrar.</td></tr>
                            <?php endif; ?>

                            <?php foreach ($movimientos as $movimiento): ?>
                                <tr>
                                    <td><?= h($movimiento['tipo']) ?></td>
                                    <td><?= h($movimiento['tabla_afectada']) ?></td>
                                    <td><?= h($movimiento['descripcion']) ?></td>
                                    <td><?= h($movimiento['fecha']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </main>
</body>
</html>
