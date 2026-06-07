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
CREATE TABLE IF NOT EXISTS professores (
    id_professor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    contacto VARCHAR(30),
    especialidade VARCHAR(100) NOT NULL,
    estado ENUM('ativo', 'inativo') DEFAULT 'ativo',
    observacao TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS turmas (
    id_turma INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    nivel_ensino ENUM('basico', 'secundario', 'tecnico') NOT NULL,
    classe VARCHAR(30) NOT NULL,
    turno ENUM('manha', 'tarde', 'noite') NOT NULL,
    sala VARCHAR(30),
    ano_letivo VARCHAR(20) NOT NULL,
    estado ENUM('ativa', 'inativa') DEFAULT 'ativa',
    observacao TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS disciplinas (
    id_disciplina INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    carga_horaria INT NOT NULL,
    nivel_ensino ENUM('basico', 'secundario', 'tecnico') NOT NULL,
    professor_responsavel VARCHAR(120),
    estado ENUM('ativa', 'inativa') DEFAULT 'ativa',
    descricao TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS notas (
    id_nota INT AUTO_INCREMENT PRIMARY KEY,
    aluno VARCHAR(120) NOT NULL,
    turma VARCHAR(50) NOT NULL,
    disciplina VARCHAR(100) NOT NULL,
    professor VARCHAR(120) NOT NULL,
    periodo ENUM('1_periodo', '2_periodo', '3_periodo', 'final') NOT NULL,
    nota DECIMAL(5,2) NOT NULL,
    observacao TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS pagamentos (
    id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
    aluno VARCHAR(120) NOT NULL,
    tipo_pagamento ENUM('matricula', 'propina', 'exame', 'outro') NOT NULL,
    mes_referencia VARCHAR(20),
    valor DECIMAL(10,2) NOT NULL,
    data_pagamento DATE NOT NULL,
    metodo_pagamento ENUM('dinheiro', 'transferencia', 'outro') NOT NULL,
    estado ENUM('pago', 'pendente', 'atrasado') DEFAULT 'pendente',
    observacao TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS mensagens_contacto (
    id_mensagem INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL,
    assunto VARCHAR(150) NOT NULL,
    mensagem TEXT NOT NULL,
    estado ENUM('nova', 'lida', 'respondida') DEFAULT 'nova',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);