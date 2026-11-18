<?php
require_once __DIR__ . '/config/conexion.php';

// Los campos mostrados coinciden con las columnas editables de cada tabla.
// El ID es la llave primaria y también cuenta como campo de la tabla.
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
$actual = $config[$tabla];
$columnas = array_keys($actual['campos']);

$opciones = [
 'cliente' => $pdo->query("SELECT id, nombre FROM clientes ORDER BY nombre")->fetchAll(),
 'articulo' => $pdo->query("SELECT id, nombre FROM articulos ORDER BY nombre")->fetchAll()
];

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
<header class="topbar"><a class="marca" href="index.php">FERRETERÍA <span>· Sistema de gestión</span></a><a class="volver" href="index.php#administracion">← Panel</a></header>
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
          <?php if ($def[1] === 'cliente' || $def[1] === 'articulo'): ?>
            <select name="<?= h($campo) ?>" required>
              <option value="">Selecciona una opción</option>
              <?php foreach ($opciones[$def[1]] as $op): ?>
                <option value="<?= $op['id'] ?>" <?= (string)($editar[$campo] ?? '') === (string)$op['id'] ? 'selected' : '' ?>><?= h($op['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          <?php else: ?>
            <input type="<?= h($def[1]) ?>" name="<?= h($campo) ?>" value="<?= h($editar[$campo] ?? '') ?>" <?= $def[2] ? 'required' : '' ?> <?= $def[1] === 'number' ? 'min="0" step="'.($campo === 'total' ? '0.01' : '1').'"' : '' ?>>
          <?php endif; ?>
        </label>
      <?php endforeach; ?>
      <div class="acciones"><button class="boton" type="submit"><?= $editar ? 'Actualizar' : 'Agregar' ?></button>
      <?php if ($editar): ?><a class="boton secundario" href="modulo.php?tabla=<?= h($tabla) ?>">Cancelar</a><?php endif; ?></div>
    </form>
  </section>
  <section class="panel tabla-panel"><h2>Registros</h2>
    <div class="tabla-scroll"><table><thead><tr><th>ID</th>
      <?php foreach ($columnas as $campo): ?><th><?= h($actual['campos'][$campo][0]) ?></th><?php endforeach; ?><th>Acciones</th></tr></thead><tbody>
      <?php if (!$registros): ?><tr><td colspan="<?= count($columnas)+2 ?>">Todavía no hay registros.</td></tr><?php endif; ?>
      <?php foreach ($registros as $fila): ?><tr><td><?= $fila['id'] ?></td>
        <?php foreach ($columnas as $campo): ?>
          <td><?php if ($campo === 'cliente_id'): ?><?= h($opciones['cliente'][array_search($fila[$campo], array_column($opciones['cliente'], 'id'))]['nombre'] ?? $fila[$campo]) ?>
          <?php elseif ($campo === 'articulo_id'): ?><?= h($opciones['articulo'][array_search($fila[$campo], array_column($opciones['articulo'], 'id'))]['nombre'] ?? $fila[$campo]) ?>
          <?php elseif ($campo === 'total'): ?>$<?= number_format((float)$fila[$campo], 2) ?>
          <?php else: ?><?= h($fila[$campo] ?? '') ?><?php endif; ?></td>
        <?php endforeach; ?>
        <td class="acciones-tabla"><a href="modulo.php?tabla=<?= h($tabla) ?>&editar=<?= $fila['id'] ?>">Editar</a>
        <form action="eliminar.php" method="POST" onsubmit="return confirm('¿Eliminar este registro?')">
          <input type="hidden" name="tabla" value="<?= h($tabla) ?>"><input type="hidden" name="id" value="<?= $fila['id'] ?>">
          <button class="enlace-borrar" type="submit">Eliminar</button></form></td></tr><?php endforeach; ?>
    </tbody></table></div>
  </section>
</main><footer>Proyecto CRUD · PHP y MySQL</footer></body></html>