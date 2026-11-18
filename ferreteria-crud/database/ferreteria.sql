-- Estructura de la base de datos Ferreteria.
-- Cada tabla tiene exactamente cinco campos contando el ID.
-- Este archivo reconstruye las tablas: respalda tu base de datos antes de importarlo.

CREATE DATABASE IF NOT EXISTS ferreteria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ferreteria;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS facturas;
DROP TABLE IF EXISTS articulos;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS proveedores;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  telefono VARCHAR(20),
  correo VARCHAR(120),
  direccion VARCHAR(180)
) ENGINE=InnoDB;

CREATE TABLE proveedores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  telefono VARCHAR(20),
  correo VARCHAR(120),
  direccion VARCHAR(180)
) ENGINE=InnoDB;

CREATE TABLE articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  descripcion VARCHAR(255),
  precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  existencia INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE facturas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_id INT NOT NULL,
  articulo_id INT NOT NULL,
  fecha DATE NOT NULL,
  total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  CONSTRAINT fk_factura_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_factura_articulo FOREIGN KEY (articulo_id) REFERENCES articulos(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;
