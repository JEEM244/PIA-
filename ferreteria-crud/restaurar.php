<?php
require_once __DIR__ . '/config/conexion.php';

// La restauración también se limita a las tablas del sistema.
$tablasPermitidas = ['clientes', 'proveedores', 'articulos', 'facturas'];
$tabla = $_POST['tabla'] ?? '';
$id = (int) ($_POST['id'] ?? 0);

if (!in_array($tabla, $tablasPermitidas, true) || $id < 1) {
    http_response_code(400);
    exit('Solicitud inválida.');
}

try {
    // Quitar la fecha de eliminación devuelve el registro a las listas normales.
    $consulta = $pdo->prepare(
        "UPDATE $tabla
         SET eliminado_en = NULL
         WHERE id = ? AND eliminado_en IS NOT NULL"
    );
    $consulta->execute([$id]);

    if ($consulta->rowCount()) {
        // Se conserva un registro de la restauración en el historial.
        $log = $pdo->prepare(
            "INSERT INTO movimientos (tipo, tabla_afectada, registro_id, descripcion)
             VALUES ('Restauración', ?, ?, ?)"
        );
        $log->execute([
            $tabla,
            $id,
            "Se restauró un registro de $tabla"
        ]);
    }

    header('Location: papelera.php?restaurado=1');
    exit;
} catch (PDOException $error) {
    header('Location: papelera.php?error=1');
    exit;
}
