<?php
require_once __DIR__ . '/config/conexion.php';

$tablas = ['clientes','proveedores','articulos','facturas'];
$tabla = $_POST['tabla'] ?? '';
$id = (int)($_POST['id'] ?? 0);
if (!in_array($tabla, $tablas, true) || $id < 1) {
    http_response_code(400);
    exit('Solicitud inválida.');
}

try {
    $consulta = $pdo->prepare("DELETE FROM $tabla WHERE id = ?");
    $consulta->execute([$id]);
    header("Location: modulo.php?tabla=$tabla&ok=1");
} catch (PDOException $error) {
    // MySQL impedirá borrar clientes o artículos que ya estén ligados a una factura.
    header("Location: modulo.php?tabla=$tabla&error=1");
}
exit;
