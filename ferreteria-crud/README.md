# CRUD Ferretería (PHP + MySQL)

Sistema básico para administrar **clientes, proveedores, artículos y facturas**.

## Requisitos
- PHP 8 o superior con PDO MySQL habilitado.
- MySQL o MariaDB (XAMPP funciona).
- Apache.

## Instalación en XAMPP
1. Copia la carpeta `ferreteria-crud` dentro de `C:\xampp\htdocs\`.
2. Inicia Apache y MySQL desde el panel de XAMPP.
3. Abre phpMyAdmin en `http://localhost/phpmyadmin`.
4. Importa el archivo `database/ferreteria.sql`. Este crea la base de datos `ferreteria` y sus cuatro tablas.
5. Revisa `config/conexion.php`. En XAMPP normalmente el usuario es `root` y la contraseña está vacía.
6. Abre `http://localhost/ferreteria-crud/`.

## Funciones
- Crear, consultar, editar y eliminar clientes.
- Crear, consultar, editar y eliminar proveedores.
- Administrar artículos, precios, existencias y proveedor.
- Registrar facturas asociadas a un cliente y un artículo.
- Calcular automáticamente el total de cada factura mediante una columna generada de MySQL.

## Estructura
```
ferreteria-crud/
├── assets/estilos.css
├── config/conexion.php
├── database/ferreteria.sql
├── eliminar.php
├── guardar.php
├── index.php
└── modulo.php
```

Las facturas guardan un artículo por registro. Si un cliente o artículo ya está relacionado con una factura, MySQL evita eliminarlo para conservar la integridad de los datos.
