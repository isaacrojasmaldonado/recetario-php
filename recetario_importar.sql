-- Script para importar manualmente a MySQL
-- Base de datos: recetario

CREATE DATABASE IF NOT EXISTS recetario;
USE recetario;

-- 1. Crear tabla de Tipos de Recetas
CREATE TABLE IF NOT EXISTS tiporecetas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_tiporeceta VARCHAR(255) NOT NULL,
    color_hex VARCHAR(7) DEFAULT '#000000',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- 2. Crear tabla de Recetas
CREATE TABLE IF NOT EXISTS recetas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_recetas VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    id_tiporeceta BIGINT UNSIGNED NOT NULL,
    dificultad ENUM('fácil', 'media', 'difícil') NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (id_tiporeceta) REFERENCES tiporecetas(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. Insertar algunos tipos de ejemplo
INSERT INTO tiporecetas (nombre_tiporeceta, color_hex, created_at, updated_at) VALUES 
('Postres', '#FF69B4', NOW(), NOW()),
('Comida Rápida', '#FFA500', NOW(), NOW()),
('Saludable', '#32CD32', NOW(), NOW()),
('Bebidas', '#1E90FF', NOW(), NOW());

-- 4. Insertar algunas recetas de ejemplo
INSERT INTO recetas (nombre_recetas, email, id_tiporeceta, dificultad, created_at, updated_at) VALUES 
('Tarta de Chocolate', 'cocina@ejemplo.com', 1, 'media', NOW(), NOW()),
('Hamburguesa Clásica', 'chef@burgers.com', 2, 'fácil', NOW(), NOW()),
('Ensalada César', 'healthy@life.com', 3, 'fácil', NOW(), NOW()),
('Pasta al Pesto', 'italy@food.com', 3, 'media', NOW(), NOW());
