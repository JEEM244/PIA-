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
6. Si ya tienes la base de datos creada, importa `database/mejoras_gestion.sql` **una sola vez**. Agrega la papelera y la bitácora de movimientos sin borrar tus registros. Si acabas de importar `ferreteria.sql`, importa también esta mejora antes de entrar a Administración.
7. Revisa `config/conexion.php`. En XAMPP normalmente el usuario es `root` y la contraseña está vacía.
8. Abre `http://localhost:8080/PIA-/ferreteria-crud/` si Apache está configurado en el puerto 8080.

## Estructura de las tablas
Cada tabla tiene exactamente cinco campos contando el ID:
- **clientes:** id, nombre, telefono, correo, direccion.
- **proveedores:** id, nombre, telefono, correo, direccion.
- **articulos:** id, nombre, descripcion, precio, existencia.
- **facturas:** id, cliente_id, articulo_id, fecha, total.

Las facturas se relacionan con clientes y artículos mediante llaves foráneas.

## Funciones
- Panel de gestión con resumen de datos y actividad reciente.
- Agregar, consultar y editar registros en las cuatro tablas.
- Papelera recuperable: los registros se ocultan sin borrarse físicamente y pueden restaurarse.
- Bitácora de altas, modificaciones, envíos a papelera y restauraciones.
- Reportes de ventas acumuladas, facturas, promedio, inventario, ventas por mes y artículos más facturados.
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
│   ├── ferreteria.sql
│   └── mejoras_gestion.sql
├── eliminar.php
├── guardar.php
├── papelera.php
├── restaurar.php
├── reportes.php
├── index.php
└── modulo.php
```
