<?php
require_once __DIR__ . '/config/conexion.php';

$config = [
 'clientes'=>['nombre','telefono','correo','direccion'],
 'proveedores'=>['nombre','telefono','correo','direccion'],
 'articulos'=>['nombre','descripcion','precio','existencia'],
 'facturas'=>['cliente_id','articulo_id','fecha','total']
];
$tabla = $_POST['tabla'] ?? '';
if (!isset($config[$tabla])) { http_response_code(400); exit('Módulo inválido.'); }

$campos = $config[$tabla];
$valores = [];
foreach ($campos as $campo) {
    $valor = $_POST[$campo] ?? null;
    $valores[] = ($valor === '') ? null : $valor;
}

try {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $asignaciones = implode(', ', array_map(fn($campo) => "$campo = ?", $campos));
        $sql = "UPDATE $tabla SET $asignaciones WHERE id = ? AND eliminado_en IS NULL";
        $valores[] = $id;
        $accion = 'Actualización';
        $detalle = "Se actualizó un registro de $tabla";
    } else {
        $marcadores = implode(', ', array_fill(0, count($campos), '?'));
        $sql = "INSERT INTO $tabla (" . implode(', ', $campos) . ") VALUES ($marcadores)";
        $accion = 'Alta';
        $detalle = "Se agregó un registro a $tabla";
    }
    $consulta = $pdo->prepare($sql);
    $consulta->execute($valores);
    $registroId = $id > 0 ? $id : (int)$pdo->lastInsertId();
    $log = $pdo->prepare("INSERT INTO movimientos (tipo, tabla_afectada, registro_id, descripcion) VALUES (?, ?, ?, ?)");
    $log->execute([$accion, $tabla, $registroId, $detalle]);
    header("Location: modulo.php?tabla=$tabla&ok=1");
    exit;
} catch (PDOException $error) {
    header("Location: modulo.php?tabla=$tabla&error=1");
    exit;
}
