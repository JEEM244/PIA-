# CRUD Ferretería (PHP + MySQL)

Sistema de gestión para **clientes, proveedores, artículos y facturación**, con catálogo público e información comercial.

## Requisitos
- PHP 8 o superior con PDO MySQL habilitado.
- MySQL o MariaDB (XAMPP funciona).
- Apache.

## Instalación en XAMPP
1. Copia la carpeta `ferreteria-crud` dentro de `C:\\xampp\\htdocs\\`.
2. Inicia Apache y MySQL desde el panel de XAMPP.
3. Abre phpMyAdmin.
4. Importa `database/ferreteria.sql`. **Este archivo elimina y vuelve a crear las cuatro tablas**, por lo que debes respaldar los datos anteriores antes de importarlo.
5. Importa `database/datos_ejemplo.sql` para agregar 10 registros a cada tabla.
6. Revisa `config/conexion.php`. En XAMPP normalmente el usuario es `root` y la contraseña está vacía.
7. Abre `http://localhost:8080/PIA-/ferreteria-crud/` si Apache está configurado en el puerto 8080.

## Estructura de las tablas
Cada tabla tiene exactamente cinco campos contando el ID:
- **clientes:** id, nombre, telefono, correo, direccion.
- **proveedores:** id, nombre, telefono, correo, direccion.
- **articulos:** id, nombre, descripcion, precio, existencia.
- **facturas:** id, cliente_id, articulo_id, fecha, total.

Las facturas se relacionan con clientes y artículos mediante llaves foráneas.

## Funciones
- Agregar, consultar, editar y eliminar registros en las cuatro tablas.
- Catálogo público conectado a MySQL con buscador.
- Carrusel horizontal de productos destacados e historia de la ferretería.
- Total de factura capturado directamente en el formulario.

## Estructura del proyecto
```
ferreteria-crud/
├── assets/
│   ├── estilos.css
│   └── img/
├── config/conexion.php
├── database/
│   ├── datos_ejemplo.sql
│   └── ferreteria.sql
├── eliminar.php
├── guardar.php
├── index.php
└── modulo.php
```
