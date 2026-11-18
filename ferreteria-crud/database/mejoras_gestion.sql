-- Ejecutar UNA SOLA VEZ sobre la base de datos ferreteria existente.
USE ferreteria;

ALTER TABLE clientes ADD COLUMN eliminado_en DATETIME NULL DEFAULT NULL;
ALTER TABLE proveedores ADD COLUMN eliminado_en DATETIME NULL DEFAULT NULL;
ALTER TABLE articulos ADD COLUMN eliminado_en DATETIME NULL DEFAULT NULL;
ALTER TABLE facturas ADD COLUMN eliminado_en DATETIME NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS movimientos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tipo VARCHAR(30) NOT NULL,
  tabla_afectada VARCHAR(40) NOT NULL,
  registro_id INT NULL,
  descripcion VARCHAR(255) NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_movimientos_fecha (fecha),
  INDEX idx_movimientos_tabla (tabla_afectada)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
