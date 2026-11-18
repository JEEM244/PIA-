<?php
require_once __DIR__ . '/config/conexion.php';
$config = [
 'clientes' => ['titulo'=>'Clientes','campos'=>[
   'nombre'=>['Nombre','text',true], 'telefono'=>['Teléfono','text',false],
   'correo'=>['Correo','email',false], 'direccion'=>['Dirección','text',false]
 ]],
 'proveedores' => ['titulo'=>'Proveedores','campos'=>[
   'nombre'=>['Nombre','text',true], 'telefono'=>['Teléfono','text',false],
   'correo'=>['Correo','email',false], 'direccion'=>['Dirección','text',false]
 ]],
 'articulos' => ['titulo'=>'Artículos','campos'=>[
   'nombre'=>['Nombre','text',true], 'descripcion'=>['Descripción','text',false],
   'precio'=>['Precio','number',true], 'existencia'=>['Existencia','number',true]
 ]],
 'facturas' => ['titulo'=>'Facturación','campos'=>[
   'cliente_id'=>['Cliente','cliente',true], 'articulo_id'=>['Artículo','articulo',true],
   'fecha'=>['Fecha','date',true], 'total'=>['Total de factura','number',true]
 ]]
];
$tabla = $_GET['tabla'] ?? 'clientes';
if (!isset($config[$tabla])) { http_response_code(404); exit('Módulo no encontrado.'); }
$actual = $config[$tabla]; $columnas = array_keys($actual['campos']);
$opciones = [
 'cliente' => $pdo->query("SELECT id, nombre FROM clientes WHERE eliminado_en IS NULL ORDER BY nombre")->fetchAll(),
 'articulo' => $pdo->query("SELECT id, nombre FROM articulos WHERE eliminado_en IS NULL ORDER BY nombre")->fetchAll()
];
$editar = null;
if (isset($_GET['editar'])) {
  $consulta = $pdo->prepare("SELECT * FROM $tabla WHERE id = ? AND eliminado_en IS NULL");
  $consulta->execute([(int)$_GET['editar']]); $editar = $consulta->fetch();
}
$registros = $pdo->query("SELECT * FROM $tabla WHERE eliminado_en IS NULL ORDER BY id DESC")->fetchAll();
$totalPapelera = (int)$pdo->query("SELECT
 (SELECT COUNT(*) FROM clientes WHERE eliminado_en IS NOT NULL) +
 (SELECT COUNT(*) FROM proveedores WHERE eliminado_en IS NOT NULL) +
 (SELECT COUNT(*) FROM articulos WHERE eliminado_en IS NOT NULL) +
 (SELECT COUNT(*) FROM facturas WHERE eliminado_en IS NOT NULL)")->fetchColumn();
function h($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?= h($actual['titulo']) ?> | Gestión</title><link rel="stylesheet" href="assets/estilos.css"></head><body class="admin-body">
<header class="admin-top"><a class="marca" href="administracion.php">FERRETERÍA <span> / GESTIÓN</span></a><div><a href="reportes.php">Reportes</a><a href="papelera.php">Papelera (<?= $totalPapelera ?>)</a><a href="administracion.php">Panel principal</a></div></header>
<main class="admin-layout"><aside class="admin-sidebar"><p class="sobrelinea">MÓDULOS</p><?php foreach($config as $key=>$item): ?><a class="<?= $tabla===$key?'seleccionado':'' ?>" href="modulo.php?tabla=<?= h($key) ?>"><?= h($item['titulo']) ?><span>→</span></a><?php endforeach; ?><a href="reportes.php">Reportes <span>↗</span></a><a href="papelera.php">Papelera <span>↗</span></a><a href="index.php">Ver sitio público <span>↗</span></a></aside>
<section class="admin-contenido"><div class="admin-page-heading"><div><p class="sobrelinea">GESTIÓN DE DATOS / <?= strtoupper(h($tabla)) ?></p><h1><?= h($actual['titulo']) ?></h1><p>Administra los registros activos de este módulo.</p></div><span class="admin-count"><?= count($registros) ?> ACTIVOS</span></div>
<?php if(isset($_GET['ok'])):?><div class="aviso">Cambios guardados correctamente.</div><?php endif;?>
<?php if(isset($_GET['papelera'])):?><div class="aviso">Registro enviado a la papelera. Puedes restaurarlo cuando quieras.</div><?php endif;?>
<?php if(isset($_GET['error'])):?><div class="aviso error">No se pudo completar la operación.</div><?php endif;?>
<div class="admin-two-col"><section class="admin-card"><div class="admin-card-head"><div><p class="sobrelinea"><?= $editar?'MODIFICAR':'NUEVO REGISTRO' ?></p><h2><?= $editar?'Editar información':'Agregar '.$actual['titulo'] ?></h2></div><span class="admin-card-index">01</span></div>
<form action="guardar.php" method="POST" class="admin-form"><input type="hidden" name="tabla" value="<?= h($tabla) ?>"><input type="hidden" name="id" value="<?= h($editar['id']??'') ?>">
<?php foreach($actual['campos'] as $campo=>$def): ?><label><?= h($def[0]) ?><?php if($def[1]==='cliente'||$def[1]==='articulo'):?><select name="<?= h($campo) ?>" required><option value="">Selecciona</option><?php foreach($opciones[$def[1]] as $op):?><option value="<?= $op['id'] ?>" <?= (string)($editar[$campo]??'')===(string)$op['id']?'selected':'' ?>><?= h($op['nombre']) ?></option><?php endforeach;?></select><?php else:?><input type="<?= h($def[1]) ?>" name="<?= h($campo) ?>" value="<?= h($editar[$campo]??'') ?>" <?= $def[2]?'required':'' ?> <?= $def[1]==='number'?'min="0" step="'.($campo==='total'?'0.01':'1').'"':'' ?>><?php endif;?></label><?php endforeach;?>
<div class="acciones"><button class="boton" type="submit"><?= $editar?'Guardar cambios':'Crear registro' ?></button><?php if($editar):?><a class="boton secundario" href="modulo.php?tabla=<?= h($tabla) ?>">Cancelar</a><?php endif;?></div></form></section>
<section class="admin-card admin-note"><p class="sobrelinea">CONTROL DE REGISTROS</p><h2>Una gestión más clara.</h2><p>Los registros eliminados no desaparecen: se guardan en la papelera para poder recuperarlos.</p><a class="admin-inline-link" href="papelera.php">Abrir papelera (<?= $totalPapelera ?>) →</a><div class="admin-note-bottom"><strong><?= count($registros) ?></strong><span>registros activos en <?= h(strtolower($actual['titulo'])) ?></span></div></section></div>
<section class="admin-card admin-table-card"><div class="admin-card-head"><div><p class="sobrelinea">BASE DE DATOS</p><h2>Registros activos</h2></div><span class="admin-card-index">02</span></div><div class="tabla-scroll"><table><thead><tr><th>ID</th><?php foreach($columnas as $campo):?><th><?= h($actual['campos'][$campo][0]) ?></th><?php endforeach;?><th>Acciones</th></tr></thead><tbody><?php if(!$registros):?><tr><td colspan="<?= count($columnas)+2 ?>">No hay registros activos todavía.</td></tr><?php endif;?>
<?php foreach($registros as $fila):?><tr><td>#<?= $fila['id'] ?></td><?php foreach($columnas as $campo):?><td><?php if($campo==='cliente_id'||$campo==='articulo_id'){$tipo=$campo==='cliente_id'?'cliente':'articulo';$idx=array_search($fila[$campo],array_column($opciones[$tipo],'id'));echo h($opciones[$tipo][$idx]['nombre']??'Registro relacionado');}elseif($campo==='total'){?>$<?= number_format((float)$fila[$campo],2) ?><?php }else{?><?= h($fila[$campo]??'') ?><?php } ?></td><?php endforeach;?><td class="acciones-tabla"><a href="modulo.php?tabla=<?= h($tabla) ?>&editar=<?= $fila['id'] ?>">Editar</a><form action="eliminar.php" method="POST" onsubmit="return confirm('¿Enviar este registro a la papelera?')"><input type="hidden" name="tabla" value="<?= h($tabla) ?>"><input type="hidden" name="id" value="<?= $fila['id'] ?>"><button class="enlace-borrar" type="submit">A papelera</button></form></td></tr><?php endforeach;?></tbody></table></div></section>
</section></main></body></html>