-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para gestao_escolar_gb
CREATE DATABASE IF NOT EXISTS `gestao_escolar_gb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gestao_escolar_gb`;

-- A despejar estrutura para tabela gestao_escolar_gb.alunos
CREATE TABLE IF NOT EXISTS `alunos` (
  `id_aluno` int NOT NULL AUTO_INCREMENT,
  `numero_estudante` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nome` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `genero` enum('masculino','feminino','outro') COLLATE utf8mb4_general_ci NOT NULL,
  `contacto` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `turma` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `morada` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `encarregado_nome` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `encarregado_contacto` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observacao` text COLLATE utf8mb4_general_ci,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_aluno`),
  UNIQUE KEY `numero_estudante` (`numero_estudante`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela gestao_escolar_gb.alunos: ~3 rows (aproximadamente)
INSERT INTO `alunos` (`id_aluno`, `numero_estudante`, `nome`, `data_nascimento`, `genero`, `contacto`, `email`, `turma`, `morada`, `encarregado_nome`, `encarregado_contacto`, `observacao`, `criado_em`) VALUES
	(2, 'alun0001', 'DJAMILA CAMARA', '2001-06-17', 'feminino', '966556509', 'myla@gmail.com', '12.º Ano A', 'Bissau,Quelele', 'Mariama Balde', '956149685', '', '2026-06-03 10:36:49'),
	(3, 'AL2000', 'Ibraima Camara', '2002-05-10', 'masculino', '956149685', 'ibojuniorcamara1@gmail.com', '12.º Ano A', 'Bissau, Bairro Miliitar', 'Mariama Balde', '956149685', '', '2026-06-07 08:27:23'),
	(5, 'al001111', 'Sidia Camara', '2009-08-19', 'masculino', '966556507', 'sidiacamara@gmail.com', '7.º Ano A', 'Bissau,Quelele', 'Aladje Camara', '96666666', '', '2026-06-15 22:18:36');

-- A despejar estrutura para tabela gestao_escolar_gb.disciplinas
CREATE TABLE IF NOT EXISTS `disciplinas` (
  `id_disciplina` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `carga_horaria` int NOT NULL,
  `nivel_ensino` enum('basico','secundario','tecnico') COLLATE utf8mb4_general_ci NOT NULL,
  `professor_responsavel` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` enum('ativa','inativa') COLLATE utf8mb4_general_ci DEFAULT 'ativa',
  `descricao` text COLLATE utf8mb4_general_ci,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_disciplina`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela gestao_escolar_gb.disciplinas: ~1 rows (aproximadamente)
INSERT INTO `disciplinas` (`id_disciplina`, `codigo`, `nome`, `carga_horaria`, `nivel_ensino`, `professor_responsavel`, `estado`, `descricao`, `criado_em`) VALUES
	(2, 'Infor003', 'Informatica', 60, 'basico', 'Ibraima Camara', 'ativa', '', '2026-06-07 07:37:18');

-- A despejar estrutura para tabela gestao_escolar_gb.mensagens_contacto
CREATE TABLE IF NOT EXISTS `mensagens_contacto` (
  `id_mensagem` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `assunto` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `mensagem` text COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('nova','lida','respondida') COLLATE utf8mb4_general_ci DEFAULT 'nova',
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mensagem`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela gestao_escolar_gb.mensagens_contacto: ~1 rows (aproximadamente)
INSERT INTO `mensagens_contacto` (`id_mensagem`, `nome`, `email`, `assunto`, `mensagem`, `estado`, `criado_em`) VALUES
	(2, 'Arnaldo Manuel', 'genilsonmeti@gmail.com', 'alteraçao da carga horaria', 'addaaaaaaaaaaaaaaaaDDD', 'nova', '2026-06-07 08:27:49');

-- A despejar estrutura para tabela gestao_escolar_gb.notas
CREATE TABLE IF NOT EXISTS `notas` (
  `id_nota` int NOT NULL AUTO_INCREMENT,
  `aluno` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `turma` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `disciplina` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `professor` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `periodo` enum('1_periodo','2_periodo','3_periodo','final') COLLATE utf8mb4_general_ci NOT NULL,
  `nota` decimal(5,2) NOT NULL,
  `observacao` text COLLATE utf8mb4_general_ci,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_nota`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela gestao_escolar_gb.notas: ~4 rows (aproximadamente)
INSERT INTO `notas` (`id_nota`, `aluno`, `turma`, `disciplina`, `professor`, `periodo`, `nota`, `observacao`, `criado_em`) VALUES
	(1, 'Djamila Balde', '12º A', 'Informattica', 'Ibraima Camara', '1_periodo', 18.00, 'Muito bom', '2026-06-07 07:45:55'),
	(2, 'Djamila Balde', '12º A', 'Matematica', 'Mussa Camara', '1_periodo', 16.80, 'Bom', '2026-06-07 07:47:03'),
	(3, 'Ibraima Camara', '12º A', 'Matematica', 'Ibraima Camara', '2_periodo', 15.90, '', '2026-06-15 21:30:37'),
	(4, 'Ibraima Camara', '12º A', 'Informattica', 'Ibraima Camara', '1_periodo', 15.90, '', '2026-06-15 21:31:04');

-- A despejar estrutura para tabela gestao_escolar_gb.pagamentos
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id_pagamento` int NOT NULL AUTO_INCREMENT,
  `aluno` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_pagamento` enum('matricula','propina','exame','outro') COLLATE utf8mb4_general_ci NOT NULL,
  `mes_referencia` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_pagamento` date NOT NULL,
  `metodo_pagamento` enum('dinheiro','transferencia','outro') COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('pago','pendente','atrasado') COLLATE utf8mb4_general_ci DEFAULT 'pendente',
  `observacao` text COLLATE utf8mb4_general_ci,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pagamento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela gestao_escolar_gb.pagamentos: ~2 rows (aproximadamente)
INSERT INTO `pagamentos` (`id_pagamento`, `aluno`, `tipo_pagamento`, `mes_referencia`, `valor`, `data_pagamento`, `metodo_pagamento`, `estado`, `observacao`, `criado_em`) VALUES
	(1, 'Djamila Balde', 'matricula', 'agosto', 25000.00, '2025-08-20', 'dinheiro', 'pago', '', '2026-06-07 07:55:33'),
	(2, 'Djamila Balde', 'propina', 'janeiro', 15000.00, '2026-01-20', 'dinheiro', 'pago', '', '2026-06-07 07:56:07');

-- A despejar estrutura para tabela gestao_escolar_gb.professores
CREATE TABLE IF NOT EXISTS `professores` (
  `id_professor` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `contacto` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `especialidade` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('ativo','inativo') COLLATE utf8mb4_general_ci DEFAULT 'ativo',
  `observacao` text COLLATE utf8mb4_general_ci,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_professor`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela gestao_escolar_gb.professores: ~2 rows (aproximadamente)
INSERT INTO `professores` (`id_professor`, `nome`, `email`, `contacto`, `especialidade`, `estado`, `observacao`, `criado_em`) VALUES
	(1, 'Mussa Camara', 'MC@gmail.com', '9555352012', 'Matematica, Fisica', 'ativo', '', '2026-06-07 07:15:16'),
	(3, 'Ibraima Camara', 'ibojuniorcamara1@gmail.com', '955403228', 'informatica', 'inativo', '', '2026-06-07 07:17:48');

-- A despejar estrutura para tabela gestao_escolar_gb.turmas
CREATE TABLE IF NOT EXISTS `turmas` (
  `id_turma` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nivel_ensino` enum('basico','secundario','tecnico') COLLATE utf8mb4_general_ci NOT NULL,
  `classe` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `turno` enum('manha','tarde','noite') COLLATE utf8mb4_general_ci NOT NULL,
  `sala` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ano_letivo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('ativa','inativa') COLLATE utf8mb4_general_ci DEFAULT 'ativa',
  `observacao` text COLLATE utf8mb4_general_ci,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_turma`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela gestao_escolar_gb.turmas: ~2 rows (aproximadamente)
INSERT INTO `turmas` (`id_turma`, `nome`, `nivel_ensino`, `classe`, `turno`, `sala`, `ano_letivo`, `estado`, `observacao`, `criado_em`) VALUES
	(1, '11º A', 'secundario', '11.º Ano', 'manha', '1', '2025/2026', 'ativa', '', '2026-06-07 07:28:48'),
	(2, '10º H5', 'tecnico', '10.º Ano', 'noite', '12', '2025/2026', 'inativa', '', '2026-06-07 07:30:23');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
