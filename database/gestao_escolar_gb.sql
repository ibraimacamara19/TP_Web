CREATE DATABASE IF NOT EXISTS gestao_escolar_gb
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE gestao_escolar_gb;

CREATE TABLE IF NOT EXISTS alunos (
    id_aluno INT AUTO_INCREMENT PRIMARY KEY,
    numero_estudante VARCHAR(30) NOT NULL UNIQUE,
    nome VARCHAR(120) NOT NULL,
    data_nascimento DATE NOT NULL,
    genero ENUM('masculino', 'feminino', 'outro') NOT NULL,
    contacto VARCHAR(30),
    email VARCHAR(120),
    turma VARCHAR(50) NOT NULL,
    morada VARCHAR(200),
    encarregado_nome VARCHAR(120),
    encarregado_contacto VARCHAR(30),
    observacao TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);