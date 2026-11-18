<?php
// Datos para conectarse a la base de datos local.
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$baseDatos = 'ferreteria';

try {
    // PDO permite ejecutar consultas preparadas y manejar errores de MySQL.
    $pdo = new PDO(
        "mysql:host=$host;dbname=$baseDatos;charset=utf8mb4",
        $usuario,
        $contrasena,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $error) {
    // No mostramos datos internos de la conexión en pantalla.
    exit('No se pudo conectar con la base de datos. Revisa config/conexion.php y que MySQL esté iniciado.');
}
