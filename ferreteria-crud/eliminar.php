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
    // Papelera lógica: conserva el registro y permite restaurarlo.
    $consulta = $pdo->prepare("UPDATE $tabla SET eliminado_en = NOW() WHERE id = ? AND eliminado_en IS NULL");
    $consulta->execute([$id]);
    if ($consulta->rowCount()) {
        $log = $pdo->prepare("INSERT INTO movimientos (tipo, tabla_afectada, registro_id, descripcion) VALUES ('Papelera', ?, ?, ?)");
        $log->execute([$tabla, $id, "Se envió un registro de $tabla a la papelera"]);
    }
    header("Location: modulo.php?tabla=$tabla&papelera=1");
} catch (PDOException $error) {
    header("Location: modulo.php?tabla=$tabla&error=1");
}
exit;
