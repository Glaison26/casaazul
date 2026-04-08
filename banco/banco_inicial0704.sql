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

-- Copiando estrutura para tabela casaazul.atividades
CREATE TABLE IF NOT EXISTS `atividades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) DEFAULT NULL,
  `observacao` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.atividades: ~2 rows (aproximadamente)
INSERT INTO `atividades` (`id`, `descricao`, `observacao`) VALUES
	(1, 'Entraga de Cestas Básicas', _binary 0x4365737461206d656e73616c20652073656d616e616c),
	(2, 'Passeio Cultural', _binary 0x436f6d204f6e6962757320696e636c7569646f);

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
  `socio` char(1) DEFAULT NULL,
  `datasocio` date DEFAULT NULL,
  `observacao` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.cadastro: ~1 rows (aproximadamente)
INSERT INTO `cadastro` (`id`, `nome`, `datanasc`, `identidade`, `cpf`, `cep`, `endereco`, `bairro`, `cidade`, `nomepai`, `nomemae`, `fone1`, `fone2`, `fone3`, `niss`, `email`, `data_cadastro`, `numerofilhos`, `sexo`, `socio`, `datasocio`, `observacao`) VALUES
	(4, 'Glaison Queiroz', '1968-10-26', '4662097', '69551022653', '34505480', 'Rua da Intendencia 316', 'Centro', 'Sabará', 'Valdir Queiroz', 'Emilia Pereira Queiroz', '(31) 98426-2508', '(31) 3672-7688', '', '45465465', 'glaison26.queiroz@gmail.com', '2026-04-01', 0, 'M', NULL, NULL, _binary '');

-- Copiando estrutura para tabela casaazul.cursos
CREATE TABLE IF NOT EXISTS `cursos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `OBSERVACAO` blob,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.cursos: ~4 rows (aproximadamente)
INSERT INTO `cursos` (`ID`, `DESCRICAO`, `OBSERVACAO`) VALUES
	(1, 'Informática Básica I', _binary 0x77696e646f7773206520646967697461c3a7c3a36f),
	(2, 'Informática Microsoft office', _binary 0x776f72642c20657863656c6c2c20706f77657220706f696e74),
	(3, 'Balé', _binary 0x436c61737369636f206520636f6e7465706f72616e696f),
	(4, 'OfficeBoy', _binary 0x436f6d20486162696c697461c3a7c3a36f204d6f746f),
	(5, 'Eletricista', _binary 0x42617369636f);

-- Copiando estrutura para tabela casaazul.instrutores
CREATE TABLE IF NOT EXISTS `instrutores` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(150) NOT NULL,
  `CEP` char(12) NOT NULL,
  `ENDERECO` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `BAIRRO` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ESCOLARIDADE` varchar(40) DEFAULT NULL,
  `FONE1` varchar(20) DEFAULT NULL,
  `FONE2` varchar(20) DEFAULT NULL,
  `FONE3` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(150) DEFAULT NULL,
  `ID_CURSO` int NOT NULL DEFAULT '0',
  `DATANASC` date DEFAULT NULL,
  `UF` char(2) NOT NULL,
  `CPF` char(11) NOT NULL,
  `IDENTIDADE` varchar(20) NOT NULL,
  `CIDADE` varchar(100) NOT NULL,
  `OBSERVACAO` blob,
  `BANCO` char(5) DEFAULT NULL,
  `AGENCIA` char(6) DEFAULT NULL,
  `CONTA` char(15) DEFAULT NULL,
  `TITULAR` varchar(90) DEFAULT NULL,
  `SEXO` char(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela casaazul.instrutores: ~0 rows (aproximadamente)

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
