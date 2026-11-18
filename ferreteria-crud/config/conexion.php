<?php
// Conexion principal a MySQL. Ajusta estos datos si tu instalacion usa otros valores.
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_datos = 'ferreteria';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$base_datos;charset=utf8mb4",
        $usuario,
        $contrasena,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $error) {
    exit('No se pudo conectar con la base de datos. Revisa config/conexion.php y que MySQL esté iniciado.');
}
