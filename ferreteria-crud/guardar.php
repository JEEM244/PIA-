<?php
require_once __DIR__ . '/config/conexion.php';

$config = [
 'clientes'=>['nombre','telefono','correo','direccion'],
 'proveedores'=>['nombre','telefono','correo','direccion'],
 'articulos'=>['nombre','descripcion','precio','existencia','proveedor_id'],
 'facturas'=>['cliente_id','articulo_id','fecha','cantidad','precio_unitario']
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
        $sql = "UPDATE $tabla SET $asignaciones WHERE id = ?";
        $valores[] = $id;
    } else {
        $marcadores = implode(', ', array_fill(0, count($campos), '?'));
        $sql = "INSERT INTO $tabla (" . implode(', ', $campos) . ") VALUES ($marcadores)";
    }
    $consulta = $pdo->prepare($sql);
    $consulta->execute($valores);
    header("Location: modulo.php?tabla=$tabla&ok=1");
    exit;
} catch (PDOException $error) {
    header("Location: modulo.php?tabla=$tabla&error=1");
    exit;
}
