<?php
require_once __DIR__.'/config/conexion.php';
$tablas=['clientes'=>'Clientes','proveedores'=>'Proveedores','articulos'=>'Artículos','facturas'=>'Facturas'];
$items=[];
foreach($tablas as $tabla=>$nombre){
 $q=$pdo->query("SELECT id, eliminado_en FROM $tabla WHERE eliminado_en IS NOT NULL ORDER BY eliminado_en DESC");
 foreach($q->fetchAll() as $fila){$fila['tabla']=$tabla;$fila['nombre_tabla']=$nombre;$items[]=$fila;}
}
usort($items,fn($a,$b)=>strcmp($b['eliminado_en'],$a['eliminado_en']));
function h($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Papelera | Ferretería</title><link rel="stylesheet" href="assets/estilos.css"></head><body class="admin-body">
<header class="admin-top"><a class="marca" href="administracion.php">FERRETERÍA <span> / PAPELERA</span></a><div><a href="reportes.php">Reportes</a><a href="administracion.php">Panel principal</a></div></header>
<main class="admin-layout"><aside class="admin-sidebar"><p class="sobrelinea">HERRAMIENTAS</p><a href="administracion.php">Resumen <span>→</span></a><a href="reportes.php">Reportes <span>→</span></a><a class="seleccionado" href="papelera.php">Papelera <span><?= count($items) ?></span></a><a href="index.php">Ver sitio público <span>↗</span></a></aside>
<section class="admin-contenido"><div class="admin-page-heading"><div><p class="sobrelinea">REGISTROS RETIRADOS</p><h1>Papelera</h1><p>Los registros permanecen aquí hasta que decidas restaurarlos.</p></div><span class="admin-count"><?= count($items) ?> ELEMENTOS</span></div>
<?php if(isset($_GET['restaurado'])):?><div class="aviso">Registro restaurado correctamente.</div><?php endif;?>
<section class="admin-card admin-table-card"><div class="admin-card-head"><div><p class="sobrelinea">RECUPERACIÓN</p><h2>Elementos eliminados</h2></div><span class="admin-card-index">01</span></div><div class="tabla-scroll"><table><thead><tr><th>Tipo</th><th>ID</th><th>Fecha de eliminación</th><th>Acción</th></tr></thead><tbody>
<?php if(!$items):?><tr><td colspan="4">La papelera está vacía.</td></tr><?php endif;?>
<?php foreach($items as $item):?><tr><td><?= h($item['nombre_tabla']) ?></td><td>#<?= (int)$item['id'] ?></td><td><?= h($item['eliminado_en']) ?></td><td><form action="restaurar.php" method="POST" onsubmit="return confirm('¿Restaurar este registro?')"><input type="hidden" name="tabla" value="<?= h($item['tabla']) ?>"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button class="boton boton-mini" type="submit">Restaurar</button></form></td></tr><?php endforeach;?>
</tbody></table></div></section></section></main></body></html>