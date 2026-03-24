CREATE DATABASE IF NOT EXISTS alimentos_db;
USE alimentos_db;

CREATE TABLE proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    company VARCHAR(100) NOT NULL,
    phone VARCHAR(20)
);

CREATE TABLE alimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    proveedor_id INT,
    
    FOREIGN KEY (proveedor_id) 
    REFERENCES proveedores(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

-- Insertar proveedores primero
INSERT INTO proveedores (name, company, phone) VALUES
('Juan Perez', 'Nestle', '3001234567'),
('Maria Lopez', 'Alpina', '3019876543'),
('Carlos Ruiz', 'Colanta', '3025558899'),
('Ana Torres', 'Postobon', '3104567890'),
('Luis Gomez', 'Bavaria', '3201112233');

-- Luego alimentos
INSERT INTO alimentos (name, type, price, proveedor_id) VALUES
('Leche', 'Lacteo', 3500, 2),
('Queso', 'Lacteo', 8000, 3),
('Yogurt', 'Lacteo', 2500, 2),
('Pan', 'Grano', 2000, NULL),
('Manzana', 'Fruta', 1500, NULL),
('Jugo', 'Bebida', 3000, 4),
('Cerveza', 'Bebida', 5000, 5),
('Chocolate', 'Dulce', 4000, 1);

CREATE USER 'usuario_alimentos'@'%'
IDENTIFIED BY '123456';

GRANT ALL PRIVILEGES 
ON alimentos_db.* 
TO 'usuario_alimentos'@'%';

FLUSH PRIVILEGES;