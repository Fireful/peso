CREATE TABLE objetivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo VARCHAR(50) NOT NULL,         -- Ej: 'peso', 'imc', 'pasos', 'calorías'
    valor_objetivo DECIMAL(6,2) NOT NULL,
    unidad VARCHAR(20) NOT NULL,       -- Ej: 'kg', 'IMC', 'pasos', 'kcal'
    fecha_limite DATE DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'cumplido', 'vencido') DEFAULT 'pendiente',

    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
