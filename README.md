# Ferretería

Sistema web de una ferretería con catálogo público y un panel para administrar la información del negocio.

## ¿Qué incluye?

- **Catálogo:** consulta de artículos, precios y existencias.
- **Clientes:** registro y edición de datos de clientes.
- **Proveedores:** control de los datos de proveedores.
- **Artículos:** administración del inventario.
- **Facturación:** registro de facturas relacionadas con clientes y artículos.
- **Papelera:** recuperación de registros enviados a eliminación.
- **Reportes:** consulta de ventas, facturas e inventario.
- **Historial:** registro de las operaciones realizadas en el panel.

## Tecnologías

- PHP
- MySQL
- HTML y CSS
- PDO para la conexión y las consultas a la base de datos
- Apache

## Para ejecutar el sistema

Este proyecto utiliza PHP y MySQL, por lo que necesita un servidor web. **GitHub no ejecuta PHP directamente.**

1. Instala e inicia Apache y MySQL desde XAMPP.
2. Copia la carpeta `ferreteria-crud` en `C:\\xampp\\htdocs\\`.
3. Abre phpMyAdmin e importa `ferreteria-crud/database/ferreteria.sql`.
4. Importa `ferreteria-crud/database/datos_ejemplo.sql` para cargar los registros de prueba.
5. Importa `ferreteria-crud/database/mejoras_gestion.sql` una sola vez para habilitar la papelera y el historial.
6. Revisa la conexión en `ferreteria-crud/config/conexion.php`.
7. Abre la dirección local de tu servidor. Si Apache usa el puerto 8080:

   `http://localhost:8080/PIA-/ferreteria-crud/`

> **Atención:** `ferreteria.sql` vuelve a crear las tablas y puede borrar los datos existentes. Si ya tienes la base de datos funcionando, no lo importes otra vez. En ese caso, importa solamente `mejoras_gestion.sql` si todavía no has aplicado esas mejoras.

## Base de datos

El sistema trabaja con cuatro tablas principales:

| Tabla | Información |
|---|---|
| clientes | Nombre, teléfono, correo y dirección |
| proveedores | Nombre, teléfono, correo y dirección |
| articulos | Nombre, descripción, precio y existencia |
| facturas | Cliente, artículo, fecha y total |

Cada tabla tiene un identificador `id`. Las facturas se relacionan con clientes y artículos.

## Código del proyecto

La aplicación y sus archivos están en la carpeta **[ferreteria-crud](./ferreteria-crud/)**. Ahí también se encuentra el [instructivo de instalación](./ferreteria-crud/README.md).
