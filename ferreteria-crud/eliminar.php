<?php
require_once __DIR__ . '/config/conexion.php';

// Solo se aceptan estas tablas para evitar nombres de tabla enviados libremente.
$tablasPermitidas = ['clientes', 'proveedores', 'articulos', 'facturas'];
$tabla = $_POST['tabla'] ?? '';
$id = (int) ($_POST['id'] ?? 0);

if (!in_array($tabla, $tablasPermitidas, true) || $id < 1) {
    http_response_code(400);
    exit('Solicitud inválida.');
}

try {
    // Eliminación lógica: el registro se conserva y puede restaurarse después.
    $consulta = $pdo->prepare(
        "UPDATE $tabla
         SET eliminado_en = NOW()
         WHERE id = ? AND eliminado_en IS NULL"
    );
    $consulta->execute([$id]);

    // Solo se registra el movimiento si el registro sí fue enviado a papelera.
    if ($consulta->rowCount()) {
        $log = $pdo->prepare(
            "INSERT INTO movimientos (tipo, tabla_afectada, registro_id, descripcion)
             VALUES ('Papelera', ?, ?, ?)"
        );
        $log->execute([
            $tabla,
            $id,
            "Se envió un registro de $tabla a la papelera"
        ]);
    }

    header("Location: modulo.php?tabla=$tabla&papelera=1");
} catch (PDOException $error) {
    header("Location: modulo.php?tabla=$tabla&error=1");
}

exit;
