-- Datos de ejemplo para Ferreteria
-- Ejecutar despues de database/ferreteria.sql.
-- Este archivo esta pensado para una base de datos recien creada.
-- Importarlo una sola vez para evitar registros duplicados.

USE ferreteria;

START TRANSACTION;

-- 10 clientes
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

-- 10 proveedores
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

-- 10 articulos (proveedor_id corresponde a los 10 proveedores insertados arriba)
INSERT INTO articulos (nombre, descripcion, precio, existencia, proveedor_id) VALUES
('Martillo de uña', 'Martillo de acero con mango antiderrapante', 185.00, 25, 1),
('Desarmador plano', 'Desarmador de 6 pulgadas', 45.00, 40, 3),
('Pinzas de electricista', 'Pinzas aisladas de uso general', 129.50, 18, 6),
('Juego de llaves', 'Juego de llaves combinadas de 8 piezas', 320.00, 12, 3),
('Cinta teflon', 'Cinta selladora para conexiones', 18.00, 60, 7),
('Pintura blanca', 'Pintura vinilica, cubeta de 4 litros', 410.00, 14, 5),
('Cable electrico', 'Cable de cobre calibre 12, rollo', 690.00, 8, 6),
('Tornillos', 'Caja con 100 tornillos multiusos', 75.00, 35, 4),
('Tabla de pino', 'Tabla de pino de 2 metros', 115.00, 20, 8),
('Casco de seguridad', 'Casco de proteccion ajustable', 160.00, 16, 9);

-- 10 facturas (total se calcula automaticamente en la base de datos)
INSERT INTO facturas (cliente_id, articulo_id, fecha, cantidad, precio_unitario) VALUES
(1, 1, '2026-11-01', 2, 185.00),
(2, 2, '2026-11-02', 3, 45.00),
(3, 3, '2026-11-03', 1, 129.50),
(4, 4, '2026-11-04', 1, 320.00),
(5, 5, '2026-11-05', 5, 18.00),
(6, 6, '2026-11-06', 2, 410.00),
(7, 7, '2026-11-07', 1, 690.00),
(8, 8, '2026-11-08', 4, 75.00),
(9, 9, '2026-11-09', 3, 115.00),
(10, 10, '2026-11-10', 2, 160.00);

COMMIT;
