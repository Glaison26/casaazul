-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
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


-- Copiando estrutura do banco de dados para casaazul
CREATE DATABASE IF NOT EXISTS `casaazul` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `casaazul`;

-- Copiando estrutura para tabela casaazul.acoes
CREATE TABLE IF NOT EXISTS `acoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `id_tipo_atividade` int DEFAULT NULL,
  `participantes` int DEFAULT NULL,
  `observacao` blob,
  PRIMARY KEY (`id`),
  KEY `FK_acoes_atividades` (`id_tipo_atividade`),
  CONSTRAINT `FK_acoes_atividades` FOREIGN KEY (`id_tipo_atividade`) REFERENCES `atividades` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.acoes: ~0 rows (aproximadamente)
INSERT INTO `acoes` (`id`, `data`, `descricao`, `id_tipo_atividade`, `participantes`, `observacao`) VALUES
	(1, '2026-04-23', 'Passeio ao Museu do Ouro', 2, 2, _binary 0x4f6e696275732063656469646f2070656c612070726566656974757261);

-- Copiando estrutura para tabela casaazul.atividades
CREATE TABLE IF NOT EXISTS `atividades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) DEFAULT NULL,
  `observacao` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.atividades: ~3 rows (aproximadamente)
INSERT INTO `atividades` (`id`, `descricao`, `observacao`) VALUES
	(1, 'Entrega de Cestas Básicas', _binary 0x4365737461206d656e73616c20652073656d616e616c),
	(2, 'Passeio Cultural', _binary 0x436f6d204f6e6962757320696e636c7569646f),
	(3, 'Bailes', _binary 0x7465737465);

-- Copiando estrutura para tabela casaazul.atividades_realizadas
CREATE TABLE IF NOT EXISTS `atividades_realizadas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_curso` int DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_final` date DEFAULT NULL,
  `id_instrutor` int DEFAULT NULL,
  `num_vagas` int DEFAULT NULL,
  `carga_horaria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `observacao` blob,
  PRIMARY KEY (`id`),
  KEY `FK_atividades_realizadas_cursos` (`id_curso`),
  KEY `FK_atividades_realizadas_instrutores` (`id_instrutor`),
  CONSTRAINT `FK_atividades_realizadas_cursos` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`ID`),
  CONSTRAINT `FK_atividades_realizadas_instrutores` FOREIGN KEY (`id_instrutor`) REFERENCES `instrutores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.atividades_realizadas: ~4 rows (aproximadamente)
INSERT INTO `atividades_realizadas` (`id`, `id_curso`, `data_inicio`, `data_final`, `id_instrutor`, `num_vagas`, `carga_horaria`, `observacao`) VALUES
	(1, 3, '2026-04-11', '2026-04-11', 1, 7, '34 hoas semanais', _binary 0x7465737465),
	(2, 5, '2026-04-11', '2026-04-17', 1, 30, '48 horas Semanais', _binary 0x746573746520646520),
	(3, 5, '2026-04-20', '2026-04-30', 1, 5, '80 horas', _binary 0x7465737465),
	(5, 1, '2026-04-21', '2026-04-29', 2, 2, '80 horas', _binary '');

-- Copiando estrutura para tabela casaazul.cadastro
CREATE TABLE IF NOT EXISTS `cadastro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) DEFAULT NULL,
  `datanasc` date DEFAULT NULL,
  `identidade` varchar(9) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `cep` varchar(12) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `bairro` varchar(120) DEFAULT NULL,
  `cidade` varchar(120) DEFAULT NULL,
  `nomepai` varchar(200) DEFAULT NULL,
  `nomemae` varchar(200) DEFAULT NULL,
  `fone1` varchar(20) DEFAULT NULL,
  `fone2` varchar(20) DEFAULT NULL,
  `fone3` varchar(20) DEFAULT NULL,
  `niss` varchar(11) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `numerofilhos` int DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `genero` char(1) DEFAULT NULL,
  `socio` char(1) DEFAULT NULL,
  `datasocio` date DEFAULT NULL,
  `observacao` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.cadastro: ~1 rows (aproximadamente)
INSERT INTO `cadastro` (`id`, `nome`, `datanasc`, `identidade`, `cpf`, `cep`, `endereco`, `bairro`, `cidade`, `nomepai`, `nomemae`, `fone1`, `fone2`, `fone3`, `niss`, `email`, `data_cadastro`, `numerofilhos`, `sexo`, `genero`, `socio`, `datasocio`, `observacao`) VALUES
	(4, 'Glaison Queiroz', '1968-10-26', '4662097', '69551022653', '34505480', 'Rua da Intendencia 316', 'Centro', 'Sabará', 'Valdir Queiroz', 'Emilia Pereira Queiroz', '(31) 98426-2508', '(31) 3672-7688', '', '45465465', 'glaison26.queiroz@gmail.com', '2026-04-18', 2, 'M', 'M', NULL, NULL, _binary ''),
	(5, 'Renan Marcos Vinicius Assis', '1957-02-16', '301479161', '21877170704', '60851070', 'Travessa Particular,100', 'Alto da Balança', 'Fortaleza', '', '', '(85) 20039-9999', '', '', '', 'renan_assis@yahool.com.br', '2026-04-20', 2, 'M', 'M', NULL, NULL, _binary '');

-- Copiando estrutura para tabela casaazul.cursos
CREATE TABLE IF NOT EXISTS `cursos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `observacao` blob,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.cursos: ~5 rows (aproximadamente)
INSERT INTO `cursos` (`ID`, `descricao`, `observacao`) VALUES
	(1, 'Informática Básica I', _binary 0x77696e646f7773206520646967697461c3a7c3a36f),
	(2, 'Informática Microsoft office', _binary 0x776f72642c20657863656c6c2c20706f77657220706f696e74),
	(3, 'Balé', _binary 0x436c61737369636f206520636f6e7465706f72616e696f),
	(4, 'OfficeBoy', _binary 0x436f6d20486162696c697461c3a7c3a36f204d6f746f),
	(5, 'Eletricista', _binary 0x42617369636f);

-- Copiando estrutura para tabela casaazul.dependentes
CREATE TABLE IF NOT EXISTS `dependentes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `id_pessoa` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_dependentes_cadastro` (`id_pessoa`),
  CONSTRAINT `FK_dependentes_cadastro` FOREIGN KEY (`id_pessoa`) REFERENCES `cadastro` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.dependentes: ~2 rows (aproximadamente)
INSERT INTO `dependentes` (`id`, `nome`, `data_nasc`, `sexo`, `id_pessoa`) VALUES
	(1, 'Glaison Jr.', '1999-08-13', 'M', 4);

-- Copiando estrutura para tabela casaazul.instrutores
CREATE TABLE IF NOT EXISTS `instrutores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cep` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `endereco` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bairro` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `escolaridade` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fone1` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fone2` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fone3` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_curso` int NOT NULL DEFAULT '0',
  `datanasc` date DEFAULT NULL,
  `uf` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cpf` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `identidade` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cidade` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `observacao` blob,
  `banco` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `agencia` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `conta` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `titular` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sexo` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipo_conta` varchar(50) NOT NULL DEFAULT '',
  `chave_pix` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.instrutores: ~1 rows (aproximadamente)
INSERT INTO `instrutores` (`id`, `nome`, `cep`, `endereco`, `bairro`, `escolaridade`, `fone1`, `fone2`, `fone3`, `email`, `id_curso`, `datanasc`, `uf`, `cpf`, `identidade`, `cidade`, `observacao`, `banco`, `agencia`, `conta`, `titular`, `sexo`, `tipo_conta`, `chave_pix`) VALUES
	(1, 'Glaison Queiroz', '34505480', 'Rua da Intendência', 'Centro', 'Ensino Superior Incompleto', '(31) 8383-8888', '', NULL, 'glisia.queiroz.adm@gmail.com', 0, '2026-01-26', 'MG', '69551022653', 'm48848', 'Sabará', _binary '', '', '', '', '', 'M', '', NULL),
	(2, 'José da Silva', '34505480', 'Rua da Intendência, 333', 'Centro', 'Ensino Superior Completo', '(31) 44444-4444', '', NULL, 'teste@gmail.com', 0, '1987-02-01', 'MG', '142442', '44444', 'Sabará', _binary '', '', '', '', '', 'M', '', '');

-- Copiando estrutura para tabela casaazul.participamentes_atividade
CREATE TABLE IF NOT EXISTS `participamentes_atividade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_participante` int DEFAULT NULL,
  `id_atividade` int DEFAULT NULL,
  `observacao` blob,
  PRIMARY KEY (`id`),
  KEY `FK_participamentes_atividade_cadastro` (`id_participante`),
  KEY `FK_participamentes_atividade_atividades_realizadas` (`id_atividade`),
  CONSTRAINT `FK_participamentes_atividade_atividades_realizadas` FOREIGN KEY (`id_atividade`) REFERENCES `atividades_realizadas` (`id`),
  CONSTRAINT `FK_participamentes_atividade_cadastro` FOREIGN KEY (`id_participante`) REFERENCES `cadastro` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.participamentes_atividade: ~2 rows (aproximadamente)
INSERT INTO `participamentes_atividade` (`id`, `id_participante`, `id_atividade`, `observacao`) VALUES
	(1, 4, 2, _binary ''),
	(5, 4, 3, _binary '');

-- Copiando estrutura para tabela casaazul.participantes_acoes
CREATE TABLE IF NOT EXISTS `participantes_acoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_acao` int DEFAULT NULL,
  `id_participante` int DEFAULT NULL,
  `observacao` blob,
  PRIMARY KEY (`id`),
  KEY `FK_participantes_acoes_acoes` (`id_acao`),
  KEY `FK_participantes_acoes_cadastro` (`id_participante`),
  CONSTRAINT `FK_participantes_acoes_acoes` FOREIGN KEY (`id_acao`) REFERENCES `acoes` (`id`),
  CONSTRAINT `FK_participantes_acoes_cadastro` FOREIGN KEY (`id_participante`) REFERENCES `cadastro` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.participantes_acoes: ~0 rows (aproximadamente)
INSERT INTO `participantes_acoes` (`id`, `id_acao`, `id_participante`, `observacao`) VALUES
	(2, 1, 5, _binary ''),
	(3, 1, 4, _binary '');

-- Copiando estrutura para tabela casaazul.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(180) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `senha` varchar(30) DEFAULT NULL,
  `tipo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.usuarios: ~0 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nome`, `login`, `senha`, `tipo`, `ativo`) VALUES
	(1, 'Glaison Queiroz', 'Glaison', 'U2FiYXJhQDIwMjY=', 'Administrador', 'S');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
