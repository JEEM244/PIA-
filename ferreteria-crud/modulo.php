<?php
require_once __DIR__ . '/config/conexion.php';

// Esta lista blanca evita que el nombre de una tabla venga directamente de la URL.
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
   'precio'=>['Precio','number',true], 'existencia'=>['Existencia','number',true],
   'proveedor_id'=>['Proveedor','proveedor',false]
 ]],
 'facturas' => ['titulo'=>'Facturas','campos'=>[
   'cliente_id'=>['Cliente','cliente',true], 'articulo_id'=>['Artículo','articulo',true],
   'fecha'=>['Fecha','date',true], 'cantidad'=>['Cantidad','number',true],
   'precio_unitario'=>['Precio unitario','number',true]
 ]]
];
$tabla = $_GET['tabla'] ?? 'clientes';
if (!isset($config[$tabla])) { http_response_code(404); exit('Módulo no encontrado.'); }
$actual = $config[$tabla];
$columnas = array_keys($actual['campos']);
$relaciones = [
 'proveedor'=>['proveedores','nombre'], 'cliente'=>['clientes','nombre'], 'articulo'=>['articulos','nombre']
];
$opciones = [];
foreach ($relaciones as $tipo=>$rel) {
  $opciones[$tipo] = $pdo->query("SELECT id, {$rel[1]} AS nombre FROM {$rel[0]} ORDER BY nombre")->fetchAll();
}
$editar = null;
if (isset($_GET['editar'])) {
  $consulta = $pdo->prepare("SELECT * FROM $tabla WHERE id = ?");
  $consulta->execute([(int)$_GET['editar']]);
  $editar = $consulta->fetch();
}
$registros = $pdo->query("SELECT * FROM $tabla ORDER BY id DESC")->fetchAll();
function h($valor) { return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h($actual['titulo']) ?> | Ferretería</title><link rel="stylesheet" href="assets/estilos.css"></head>
<body>
<header class="topbar"><a class="marca" href="index.php">FERRETERÍA <span>· Sistema de gestión</span></a><a class="volver" href="index.php">← Panel</a></header>
<main class="contenedor">
  <div class="encabezado-modulo"><div><p class="sobrelinea">ADMINISTRACIÓN</p><h1><?= h($actual['titulo']) ?></h1></div><span class="contador"><?= count($registros) ?> registros</span></div>
  <?php if (!empty($_GET['ok'])): ?><div class="aviso">El registro se guardó correctamente.</div><?php endif; ?>
  <?php if (!empty($_GET['error'])): ?><div class="aviso error">No se pudo realizar la operación. Revisa los datos y las relaciones existentes.</div><?php endif; ?>
  <section class="panel">
    <h2><?= $editar ? 'Editar registro' : 'Agregar registro' ?></h2>
    <form action="guardar.php" method="POST" class="formulario">
      <input type="hidden" name="tabla" value="<?= h($tabla) ?>">
      <input type="hidden" name="id" value="<?= h($editar['id'] ?? '') ?>">
      <?php foreach ($actual['campos'] as $campo=>$def): ?>
        <label><?= h($def[0]) ?>
          <?php if ($def[1] === 'proveedor' || $def[1] === 'cliente' || $def[1] === 'articulo'): ?>
            <select name="<?= h($campo) ?>" <?= $def[2] ? 'required' : '' ?>>
              <option value="">Selecciona una opción</option>
              <?php foreach ($opciones[$def[1]] as $op): ?>
                <option value="<?= $op['id'] ?>" <?= (string)($editar[$campo] ?? '') === (string)$op['id'] ? 'selected' : '' ?>><?= h($op['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          <?php else: ?>
            <input type="<?= h($def[1]) ?>" name="<?= h($campo) ?>" value="<?= h($editar[$campo] ?? '') ?>"
              <?= $def[2] ? 'required' : '' ?> <?= $def[1] === 'number' ? 'min="0" step="'.($campo === 'precio' || $campo === 'precio_unitario' ? '0.01' : '1').'"' : '' ?>>
          <?php endif; ?>
        </label>
      <?php endforeach; ?>
      <div class="acciones"><button class="boton" type="submit"><?= $editar ? 'Actualizar' : 'Guardar' ?></button>
      <?php if ($editar): ?><a class="boton secundario" href="modulo.php?tabla=<?= h($tabla) ?>">Cancelar</a><?php endif; ?></div>
    </form>
  </section>
  <section class="panel tabla-panel"><h2>Registros</h2>
    <div class="tabla-scroll"><table><thead><tr><th>ID</th>
      <?php foreach ($columnas as $campo): ?><th><?= h($actual['campos'][$campo][0]) ?></th><?php endforeach; ?>
      <?php if ($tabla === 'facturas'): ?><th>Total</th><?php endif; ?><th>Acciones</th></tr></thead><tbody>
      <?php if (!$registros): ?><tr><td colspan="<?= count($columnas)+2 ?>">Todavía no hay registros.</td></tr><?php endif; ?>
      <?php foreach ($registros as $fila): ?><tr><td><?= $fila['id'] ?></td>
        <?php foreach ($columnas as $campo): ?><td><?= h($fila[$campo] ?? '') ?></td><?php endforeach; ?>
        <?php if ($tabla === 'facturas'): ?><td>$<?= number_format((float)$fila['total'],2) ?></td><?php endif; ?>
        <td class="acciones-tabla"><a href="modulo.php?tabla=<?= h($tabla) ?>&editar=<?= $fila['id'] ?>">Editar</a>
        <form action="eliminar.php" method="POST" onsubmit="return confirm('¿Eliminar este registro?')">
          <input type="hidden" name="tabla" value="<?= h($tabla) ?>"><input type="hidden" name="id" value="<?= $fila['id'] ?>">
          <button class="enlace-borrar" type="submit">Eliminar</button></form></td></tr><?php endforeach; ?>
    </tbody></table></div>
  </section>
</main><footer>Proyecto CRUD · PHP y MySQL</footer></body></html>