-- Ejecutar después de ferreteria.sql.
-- Agrega diez ejemplos en cada una de las cuatro tablas.
-- Si vuelves a importar este archivo, se insertarán registros duplicados.
USE ferreteria;

START TRANSACTION;

-- Clientes de ejemplo.
INSERT INTO clientes (nombre, telefono, correo, direccion) VALUES
    ('Juan Perez', '8112345670', 'juan.perez@example.com', 'Centro, Monterrey'),
    ('Maria Gonzalez', '8112345671', 'maria.gonzalez@example.com', 'Mitras, Monterrey'),
    ('Carlos Ramirez', '8112345672', 'carlos.ramirez@example.com', 'Guadalupe, Nuevo Leon'),
    ('Ana Hernandez', '8112345673', 'ana.hernandez@example.com', 'San Nicolas, Nuevo Leon'),
    ('Luis Martinez', '8112345674', 'luis.martinez@example.com', 'Apodaca, Nuevo Leon'),
    ('Sofia Torres', '8112345675', 'sofia.torres@example.com', 'Contry, Monterrey'),
    ('Pedro Flores', '8112345676', 'pedro.flores@example.com', 'Linda Vista, Guadalupe'),
    ('Laura Sanchez', '8112345677', 'laura.sanchez@example.com', 'Cumbres, Monterrey'),
    ('Miguel Castro', '8112345678', 'miguel.castro@example.com', 'La Fe, San Nicolas'),
    ('Daniela Ruiz', '8112345679', 'daniela.ruiz@example.com', 'Juarez, Nuevo Leon');

-- Proveedores de ejemplo.
INSERT INTO proveedores (nombre, telefono, correo, direccion) VALUES
    ('Materiales del Norte', '8181001000', 'ventas@materialesnorte.example', 'Monterrey, Nuevo Leon'),
    ('Aceros Regios', '8181001001', 'contacto@acerosregios.example', 'Guadalupe, Nuevo Leon'),
    ('Herramientas del Centro', '8181001002', 'ventas@herramientascentro.example', 'San Nicolas, Nuevo Leon'),
    ('Tornillos y Mas', '8181001003', 'pedidos@tornillosymas.example', 'Apodaca, Nuevo Leon'),
    ('Pinturas del Valle', '8181001004', 'ventas@pinturasvalle.example', 'Monterrey, Nuevo Leon'),
    ('Electricos MTY', '8181001005', 'contacto@electricosmty.example', 'Guadalupe, Nuevo Leon'),
    ('Plomeria Industrial', '8181001006', 'ventas@plomeriaindustrial.example', 'Escobedo, Nuevo Leon'),
    ('Maderas y Tableros', '8181001007', 'pedidos@maderastableros.example', 'Santa Catarina, Nuevo Leon'),
    ('Seguridad y Equipo', '8181001008', 'ventas@seguridadequipo.example', 'San Pedro, Nuevo Leon'),
    ('Construcciones del Bravo', '8181001009', 'contacto@construccionesbravo.example', 'Juarez, Nuevo Leon');

-- Artículos, precios y existencias iniciales.
INSERT INTO articulos (nombre, descripcion, precio, existencia) VALUES
    ('Martillo de uña', 'Martillo de acero con mango antiderrapante', 185.00, 25),
    ('Desarmador plano', 'Desarmador de 6 pulgadas', 45.00, 40),
    ('Pinzas de electricista', 'Pinzas aisladas de uso general', 129.50, 18),
    ('Juego de llaves', 'Juego de llaves combinadas de 8 piezas', 320.00, 12),
    ('Cinta teflon', 'Cinta selladora para conexiones', 18.00, 60),
    ('Pintura blanca', 'Pintura vinilica, cubeta de 4 litros', 410.00, 14),
    ('Cable electrico', 'Cable de cobre calibre 12, rollo', 690.00, 8),
    ('Tornillos', 'Caja con 100 tornillos multiusos', 75.00, 35),
    ('Tabla de pino', 'Tabla de pino de 2 metros', 115.00, 20),
    ('Casco de seguridad', 'Casco de proteccion ajustable', 160.00, 16);

-- Facturas de ejemplo. Los IDs corresponden a los registros insertados arriba.
INSERT INTO facturas (cliente_id, articulo_id, fecha, total) VALUES
    (1, 1, '2026-11-01', 370.00),
    (2, 2, '2026-11-02', 135.00),
    (3, 3, '2026-11-03', 129.50),
    (4, 4, '2026-11-04', 320.00),
    (5, 5, '2026-11-05', 90.00),
    (6, 6, '2026-11-06', 820.00),
    (7, 7, '2026-11-07', 690.00),
    (8, 8, '2026-11-08', 300.00),
    (9, 9, '2026-11-09', 345.00),
    (10, 10, '2026-11-10', 320.00);

-- Confirma los cuarenta registros de ejemplo.
COMMIT;
