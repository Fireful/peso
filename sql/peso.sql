CREATE TABLE peso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,              -- usuario asociado (no el dueño de la sesión)
    fecha DATE NOT NULL,
    peso DECIMAL(5,2) NOT NULL,
    altura DECIMAL(4,2) NOT NULL,
    imc DECIMAL(5,2),
    grasa_corporal  DECIMAL(5,2),
    musculo_masa DECIMAL(5,2),
    notas TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
