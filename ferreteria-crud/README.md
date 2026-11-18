# CRUD de ferretería

Sistema web hecho con PHP y MySQL para administrar clientes, proveedores, artículos y facturas. También incluye un catálogo público, reportes y una papelera para recuperar registros.

## Tecnologías

- PHP 8 o superior.
- MySQL o MariaDB.
- PDO para las consultas a la base de datos.
- HTML y CSS.
- Apache (XAMPP funciona para trabajar en local).

## Instalación en XAMPP

1. Copia la carpeta `ferreteria-crud` dentro de `C:\\xampp\\htdocs\\`.
2. Inicia Apache y MySQL desde el panel de XAMPP.
3. Abre phpMyAdmin.
4. Selecciona la pestaña de importar y carga `database/ferreteria.sql`.
   - **Importante:** este archivo elimina y vuelve a crear las cuatro tablas. Si ya tienes información, haz un respaldo antes.
5. Importa `database/datos_ejemplo.sql` para agregar diez registros a cada tabla.
6. Importa `database/mejoras_gestion.sql` una sola vez para agregar la papelera y el historial de movimientos.
   - Si la base de datos ya estaba creada y contiene información, importa únicamente este archivo de mejoras.
   - No lo importes dos veces: las columnas `eliminado_en` ya existirían.
7. Revisa los datos de conexión en `config/conexion.php`. En XAMPP normalmente el usuario es `root` y la contraseña está vacía.
8. Abre `http://localhost:8080/PIA-/ferreteria-crud/` si Apache está configurado en el puerto 8080.

## Organización de carpetas

```text
ferreteria-crud/
├── assets/
│   ├── estilos.css             # Estilos del sitio y del panel
│   └── img/                    # Imagen principal y fotos de artículos
├── config/
│   └── conexion.php            # Conexión PDO con MySQL
├── database/
│   ├── ferreteria.sql          # Crea las tablas principales
│   ├── datos_ejemplo.sql       # Inserta datos de prueba
│   └── mejoras_gestion.sql     # Agrega papelera e historial
├── includes/
│   ├── cabecera.php            # Menú y encabezado compartidos
│   └── pie.php                 # Pie de las páginas públicas
├── index.php                   # Página de inicio
├── catalogo.php                # Catálogo y buscador
├── historia.php                # Información de la ferretería
├── ventajas.php                # Información del catálogo
├── contacto.php                # Página de información
├── administracion.php          # Panel principal
├── modulo.php                  # Formularios y tablas del CRUD
├── guardar.php                 # Altas y modificaciones
├── eliminar.php                # Envío de registros a papelera
├── papelera.php                # Lista de registros eliminados
├── restaurar.php               # Recupera registros
└── reportes.php                # Resumen de ventas e inventario
```

## Tablas de la base de datos

Cada tabla principal tiene cinco campos contando el ID:

| Tabla | Campos |
|---|---|
| clientes | id, nombre, telefono, correo, direccion |
| proveedores | id, nombre, telefono, correo, direccion |
| articulos | id, nombre, descripcion, precio, existencia |
| facturas | id, cliente_id, articulo_id, fecha, total |

Las facturas tienen llaves foráneas hacia clientes y artículos.

## Funciones

- Agregar, consultar y editar registros.
- Enviar registros a la papelera sin borrarlos físicamente.
- Restaurar registros desde la papelera.
- Consultar el historial de movimientos.
- Revisar ventas acumuladas, facturas, promedio e inventario.
- Buscar artículos por nombre o descripción.
- Consultar precios y existencias desde el catálogo público.
- Ver artículos destacados en el carrusel de inicio.

## Notas

- El total de cada factura se captura desde el formulario.
- Los registros enviados a la papelera no aparecen en los listados normales.
- Las consultas que reciben datos del usuario utilizan parámetros preparados de PDO.
