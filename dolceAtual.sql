-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Jun-2021 às 22:02
-- Versão do servidor: 10.4.13-MariaDB
-- versão do PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dolce`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixa`
--

CREATE TABLE `caixa` (
  `idcaixa` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `saldo_inicial` float NOT NULL,
  `saldo_atual` float NOT NULL,
  `datahora_fechamento` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `caixa`
--

INSERT INTO `caixa` (`idcaixa`, `data`, `usuario_id`, `saldo_inicial`, `saldo_atual`, `datahora_fechamento`) VALUES
(28, '2021-06-04', 1, 100, 396, '2021-06-04 21:25:51'),
(29, '2021-06-04', 1, 500, 550, '2021-06-05 18:05:32'),
(35, '2021-06-05', 33, 100, 220, '2021-06-06 18:05:48'),
(36, '2021-06-07', 1, 100, 100, '2021-06-08 18:05:58'),
(37, '2021-06-20', 1, 500, 500, '2021-06-20 18:17:11'),
(44, '2021-06-20', 1, 500, 500, '2021-06-21 19:11:39'),
(47, '2021-06-21', 1, 100, 313.5, '2021-06-21 23:48:01'),
(48, '2021-06-21', 1, 500, 842, '2021-06-21 23:48:01'),
(49, '2021-06-22', 1, 100, 100, '2021-06-23 02:25:50'),
(50, '2021-06-22', 1, 100, 215, '2021-06-23 02:25:50'),
(54, '2021-06-22', 1, 500, 500, '2021-06-23 02:25:50'),
(55, '0000-00-00', 1, 500, 500, '2021-06-23 01:21:30'),
(71, '2021-06-23', 1, 250, 315, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `cpf` char(15) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A = Ativo | = Inativo',
  `endereco` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `complemento` varchar(100) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `numero` int(11) NOT NULL,
  `cep` char(15) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `telefone` char(20) DEFAULT NULL,
  `celular` char(45) NOT NULL,
  `datanascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `cpf`, `status`, `endereco`, `email`, `complemento`, `bairro`, `numero`, `cep`, `cidade`, `uf`, `telefone`, `celular`, `datanascimento`) VALUES
(6, 'mario prohman', '878.335.150-78', 'A', 'Avenida Pirapó', 'mario1996prohman@gmail.com', 'casa', 'Zona I-A', 9812, '87502-140', 'Umuarama', 'PR', '(43) 9960-3824', '(44) 9 9907-5296', '1996-07-19'),
(8, 'ayslan purunga', '868.627.560-52', 'A', 'Rua Marialva', 'ayslan@gamil.com', 'casa', 'Zona III', 2547, '87502100', 'Umuarama', 'PR', '(44) 3622-8283', '(44) 9 9832-0608', '1996-07-20'),
(15, 'marcio', '188.932.990-89', 'I', 'Rua Fortaleza', 'marcio@gmail.com', 'casa', 'Jardim América', 5383, '87502300', 'Umuarama', 'PR', '(44) 3622-8280', '(44) 9 9907-5296', '1995-07-19'),
(16, 'mayana hellstron', '087.640.199-00', 'A', 'Avenida Pirapó', 'mario@gmail.com', 'casa', 'Zona I-A', 5383, '87502-140', 'Umuarama', 'PR', '', '(44) 9 9866-7715', '1998-07-19'),
(17, 'antonio', '336.695.390-00', 'A', 'Avenida Pirapó', 'teste@gmail.com', 'casa', 'Zona I-A', 4458, '87502-140', 'Umuarama', 'PR', '(44) 3622-8280', '(44) 9 9995-9565', '1978-05-19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelo`
--

CREATE TABLE `modelo` (
  `id` int(11) NOT NULL,
  `modelo` varchar(45) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A = Ativo | = Inativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `modelo`
--

INSERT INTO `modelo` (`id`, `modelo`, `status`) VALUES
(1, 'Botao', 'A'),
(2, 'Botao em Tela', 'A'),
(3, 'Gerbera', 'A'),
(4, 'Camelia', 'A'),
(5, 'Estrela', 'A'),
(6, 'Rosa', 'A'),
(7, 'Flor de Cetim', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimento_caixa`
--

CREATE TABLE `movimento_caixa` (
  `idmovimento` int(11) NOT NULL,
  `idcaixa` int(11) NOT NULL,
  `valor` float NOT NULL,
  `datahora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `tipo_movimento` int(11) NOT NULL COMMENT '1 = entrada | 2 = saida',
  `idoperacao` int(11) NOT NULL,
  `motivo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `movimento_caixa`
--

INSERT INTO `movimento_caixa` (`idmovimento`, `idcaixa`, `valor`, `datahora`, `usuario_id`, `tipo_movimento`, `idoperacao`, `motivo`) VALUES
(43, 28, 113.5, '2021-06-04 19:41:32', 1, 1, 1, ''),
(44, 28, 62.5, '2021-06-04 19:43:21', 1, 1, 1, ''),
(45, 28, 120, '2021-06-04 19:47:53', 1, 1, 2, 'venda manual'),
(46, 28, 115, '2021-06-04 19:49:04', 1, 1, 1, ''),
(47, 28, 105, '2021-06-04 21:12:25', 1, 1, 1, ''),
(48, 28, 113.5, '2021-06-04 21:23:41', 33, 1, 1, ''),
(49, 28, 168.5, '2021-06-04 21:24:53', 1, 1, 1, ''),
(50, 29, 80, '2021-06-04 21:26:29', 1, 1, 1, ''),
(51, 29, 20, '2021-06-04 21:38:09', 1, 1, 2, 'venda'),
(52, 29, 50, '2021-06-04 21:38:30', 1, 2, 3, 'conta'),
(67, 35, 62.5, '2021-06-05 17:20:53', 33, 1, 1, ''),
(68, 35, 120, '2021-06-05 18:10:26', 33, 1, 2, 's'),
(69, 35, 52.5, '2021-06-07 14:11:53', 1, 1, 1, ''),
(75, 44, 52.5, '2021-06-21 01:25:36', 1, 1, 1, ''),
(97, 47, 250, '2021-06-21 20:23:16', 1, 1, 1, ''),
(98, 47, 200, '2021-06-21 20:23:40', 1, 2, 3, 'pagar conta'),
(99, 47, 0, '2021-06-21 20:24:26', 1, 1, 1, ''),
(100, 47, 113.5, '2021-06-21 20:25:18', 1, 1, 1, ''),
(101, 47, 50, '2021-06-21 20:53:45', 33, 1, 2, 'comida'),
(102, 48, 62.5, '2021-06-21 21:22:54', 1, 1, 1, ''),
(103, 48, 52.5, '2021-06-21 21:57:10', 1, 1, 1, ''),
(104, 48, 227, '2021-06-21 23:45:55', 1, 1, 1, ''),
(105, 48, 500, '2021-06-21 23:46:40', 1, 2, 3, 'vale mario'),
(106, 48, 500, '2021-06-21 23:47:23', 1, 1, 2, 'devolução vale mario'),
(114, 71, 65, '2021-06-23 19:55:36', 1, 1, 1, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `operacao`
--

CREATE TABLE `operacao` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `operacao`
--

INSERT INTO `operacao` (`id`, `nome`) VALUES
(1, 'venda'),
(2, 'Entrada'),
(3, 'Retirada');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `pagamento_id` int(11) NOT NULL,
  `forma` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pagamento`
--

INSERT INTO `pagamento` (`pagamento_id`, `forma`) VALUES
(1, 'Dinheiro'),
(2, 'Cartão'),
(3, 'PIX');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `pedido_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pagamento_id` int(11) DEFAULT NULL,
  `data_hora` date DEFAULT NULL,
  `datahora_baixa` date DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'F' COMMENT 'F = FECHADO | B = BAIXADO ',
  `total_liquido` float NOT NULL,
  `total_bruto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`pedido_id`, `cliente_id`, `usuario_id`, `pagamento_id`, `data_hora`, `datahora_baixa`, `status`, `total_liquido`, `total_bruto`) VALUES
(1, 6, 1, 1, '2021-05-19', '2021-05-19', 'B', 275, 275),
(2, 8, 30, 1, '2021-05-20', '2021-05-26', 'B', 500, 500),
(7, 16, 1, 1, '2021-05-26', '2021-06-04', 'B', 115, 115),
(8, 8, 1, 3, '2021-05-26', '2021-06-04', 'B', 105, 105),
(9, 999, 1, 3, '2021-05-26', '2021-06-04', 'B', 62.5, 62.5),
(22, 999, 33, 1, '2021-06-02', '2021-06-04', 'B', 113.5, 113.5),
(52, 6, 1, 1, '2021-06-21', '2021-06-21', 'B', 52.5, 52.5),
(53, 6, 1, 1, '2021-06-21', '2021-06-21', 'B', 250, 250),
(54, 6, 1, 1, '2021-06-21', '2021-06-21', 'B', 10.5, 10.5),
(55, 8, 1, 1, '2021-06-21', '2021-06-21', 'B', 26.25, 26.25),
(56, 6, 1, 1, '2021-06-21', '2021-06-21', 'B', 191.25, 191.25),
(57, 6, 1, 1, '2021-06-21', '2021-06-21', 'B', 250, 250),
(61, 8, 1, 1, '2021-06-21', '2021-06-21', 'B', 250, 250),
(62, 999, 1, 1, '2021-06-21', '2021-06-21', 'B', 0, 0),
(63, 17, 1, 3, '2021-06-21', '2021-06-21', 'B', 113.5, 113.5),
(64, 8, 1, 3, '2021-06-21', '2021-06-21', 'B', 62.5, 62.5),
(65, 8, 1, 3, '2021-06-21', '2021-06-21', 'B', 52.5, 52.5),
(66, 17, 1, 1, '2021-06-21', '2021-06-22', 'B', 220, 220),
(67, 6, 1, 1, '2021-06-21', '2021-06-21', 'B', 227, 227),
(68, 6, 33, 2, '2021-06-22', '2021-06-22', 'B', 115, 115),
(71, 6, 1, 1, '2021-06-22', '2021-06-23', 'B', 52.5, 52.5),
(72, 6, 1, 3, '2021-06-22', '2021-06-23', 'B', 52.5, 52.5),
(73, 8, 1, 2, '2021-06-23', '2021-06-23', 'B', 112.5, 112.5),
(74, 8, 1, 1, '2021-06-23', '2021-06-23', 'B', 65, 65);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data` date NOT NULL,
  `foto` varchar(20) NOT NULL,
  `descricao` text NOT NULL,
  `valor` float NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A = Ativo | = Inativo',
  `tipo_id` int(11) NOT NULL,
  `modelo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `titulo`, `quantidade`, `data`, `foto`, `descricao`, `valor`, `status`, `tipo_id`, `modelo_id`) VALUES
(1, 'Estrela pink', 300, '2020-10-25', '1606505414-1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc malesuada et lacus blandit auctor. Vestibulum bibendum ante eu urna feugiat consequat. Curabitur dictum vestibulum urna, quis scelerisque mauris laoreet eget. Praesent suscipit ligula eu nibh malesuada condimentum. Nunc quam nunc, aliquam vel lorem quis, accumsan volutpat ligula. Donec dictum mattis nibh, ut lobortis nisl tempor sit amet. Morbi lobortis pharetra ipsum, et pellentesque turpis egestas at. Pellentesque id aliquet libero. Suspendisse varius magna sed mauris consequat lacinia. Nunc at semper mauris. Aliquam erat volutpat. Vestibulum at sapien in orci scelerisque bibendum vitae eu eros. Nunc ac accumsan ante.', 1.05, 'A', 2, 5),
(2, 'Botão Verde Claro', 400, '2020-09-20', '1606840741-1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare eros quis porttitor sollicitudin. Donec vulputate sed eros nec auctor. Aliquam accumsan venenatis erat quis aliquet. Quisque sit amet rutrum velit. Maecenas vel dolor vitae ipsum viverra egestas quis sit amet eros. Nulla ac aliquet lectus. Ut scelerisque massa quis consequat rhoncus. In tincidunt lectus ut quam rhoncus consectetur. Sed eu viverra nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus sit amet eleifend justo. Nunc laoreet felis nulla, ac pulvinar turpis consequat sit amet. Pellentesque ut eros diam. Duis imperdiet lobortis tellus, ultrices convallis enim pellentesque eget. Sed tincidunt aliquet congue.', 1.25, 'A', 1, 1),
(9, 'flor de cetim rosa', 400, '2020-10-15', '1606840533-1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare eros quis porttitor sollicitudin. Donec vulputate sed eros nec auctor. Aliquam accumsan venenatis erat quis aliquet. Quisque sit amet rutrum velit. Maecenas vel dolor vitae ipsum viverra egestas quis sit amet eros. Nulla ac aliquet lectus. Ut scelerisque massa quis consequat rhoncus. In tincidunt lectus ut quam rhoncus consectetur. Sed eu viverra nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus sit amet eleifend justo. Nunc laoreet felis nulla, ac pulvinar turpis consequat sit amet. Pellentesque ut eros diam. Duis imperdiet lobortis tellus, ultrices convallis enim pellentesque eget. Sed tincidunt aliquet congue.', 1.22, 'A', 1, 7),
(10, 'Guardanapo com Flor rosa', 500, '2020-11-27', '1606504694-1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare eros quis porttitor sollicitudin. Donec vulputate sed eros nec auctor. Aliquam accumsan venenatis erat quis aliquet. Quisque sit amet rutrum velit. Maecenas vel dolor vitae ipsum viverra egestas quis sit amet eros. Nulla ac aliquet lectus. Ut scelerisque massa quis consequat rhoncus. In tincidunt lectus ut quam rhoncus consectetur. Sed eu viverra nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus sit amet eleifend justo. Nunc laoreet felis nulla, ac pulvinar turpis consequat sit amet. Pellentesque ut eros diam. Duis imperdiet lobortis tellus, ultrices convallis enim pellentesque eget. Sed tincidunt aliquet congue.', 0.55, 'A', 2, 3),
(13, 'gerbera', 100, '2021-05-17', '1624211703-1', '<p>muito bonito</p>', 3.2, 'I', 1, 3),
(14, 'Rosas', 1000, '2021-05-17', '1624301949-1', '<p>Rosa</p>', 2.25, 'A', 1, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_pedido`
--

CREATE TABLE `produto_pedido` (
  `item_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `qtde` int(11) NOT NULL,
  `valor_unitario` float NOT NULL,
  `valor_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produto_pedido`
--

INSERT INTO `produto_pedido` (`item_id`, `produto_id`, `pedido_id`, `qtde`, `valor_unitario`, `valor_total`) VALUES
(1, 1, 1, 100, 2, 200),
(2, 2, 1, 50, 1.5, 75),
(3, 2, 2, 500, 1, 500),
(9, 1, 6, 50, 1, 53),
(10, 1, 7, 50, 1, 53),
(11, 2, 7, 50, 1, 63),
(12, 1, 8, 100, 1, 105),
(13, 2, 9, 50, 1, 63),
(14, 2, 10, 30, 1, 38),
(15, 1, 11, 25, 1.05, 26.25),
(16, 9, 11, 25, 1.22, 30.5),
(18, 1, 22, 50, 1.05, 52.5),
(19, 9, 22, 50, 1.22, 61),
(32, 2, 31, 50, 1.25, 62.5),
(33, 1, 32, 50, 1.05, 52.5),
(34, 2, 33, 50, 1.25, 62.5),
(35, 9, 33, 50, 1.22, 61),
(36, 1, 39, 50, 1.05, 52.5),
(37, 10, 39, 50, 0.55, 27.5),
(38, 1, 40, 50, 1.05, 52.5),
(39, 1, 41, 50, 1.05, 52.5),
(40, 1, 42, 50, 1.05, 52.5),
(41, 1, 43, 50, 1.05, 52.5),
(42, 2, 44, 100, 1.25, 125),
(43, 2, 45, 50, 1.25, 62.5),
(44, 14, 46, 50, 2.25, 112.5),
(45, 2, 47, 200, 1.25, 250),
(46, 2, 48, 200, 1.25, 250),
(47, 2, 49, 200, 1.25, 250),
(48, 2, 50, 200, 1.25, 250),
(49, 2, 51, 200, 1.25, 250),
(50, 1, 52, 50, 1.05, 52.5),
(51, 2, 53, 200, 1.25, 250),
(52, 1, 54, 10, 1.05, 10.5),
(53, 1, 55, 25, 1.05, 26.25),
(54, 14, 56, 85, 2.25, 191.25),
(55, 2, 57, 200, 1.25, 250),
(56, 1, 58, 100, 1.05, 105),
(57, 1, 59, 50, 1.05, 52.5),
(58, 2, 60, 200, 1.25, 250),
(59, 2, 61, 200, 1.25, 250),
(60, 1, 63, 50, 1.05, 52.5),
(61, 9, 63, 50, 1.22, 61),
(62, 2, 64, 50, 1.25, 62.5),
(63, 1, 65, 50, 1.05, 52.5),
(64, 1, 66, 50, 1.05, 52.5),
(65, 10, 66, 100, 0.55, 55),
(66, 14, 66, 50, 2.25, 112.5),
(67, 9, 67, 100, 1.22, 122),
(68, 1, 67, 100, 1.05, 105),
(69, 1, 68, 50, 1.05, 52.5),
(70, 2, 68, 50, 1.25, 62.5),
(74, 10, 70, 50, 0.55, 27.5),
(75, 1, 71, 50, 1.05, 52.5),
(76, 1, 72, 50, 1.05, 52.5),
(77, 14, 73, 50, 2.25, 112.5),
(78, 1, 74, 20, 1.05, 21),
(79, 10, 74, 80, 0.55, 44);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo`
--

CREATE TABLE `tipo` (
  `id` int(11) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A = Ativo | = Inativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipo`
--

INSERT INTO `tipo` (`id`, `tipo`, `status`) VALUES
(1, 'forminhas', 'A'),
(2, 'Porta Guardanapos', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `idtipousuario` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`idtipousuario`, `nome`) VALUES
(1, 'Administrador'),
(2, 'Funcionario');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `celular` varchar(45) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A = Ativo | = Inativo',
  `login` varchar(30) NOT NULL,
  `idtipousuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `celular`, `status`, `login`, `idtipousuario`) VALUES
(1, 'Administrador', 'admin@gmail.com', '$2y$10$BcCuZldtZno1tOxWgpqKj.dZwA2Dntg9iSYqy1EH3AOXQsalOiG6G', '(43) 9 9603-8205', 'A', 'admin', 1),
(30, 'ayslan', 'ayslan@gmail.com', '$2y$10$7pWP2RpDrGfPR6817qBCJOC/W2adluWFsCoRPe3k7rSl4U847YDGm', '(44) 9 9995-9565', 'A', 'ayslan', 2),
(33, 'mario', 'mario@gmail.com', '$2y$10$FwqwQtQH9u1BtA99QVuflOGUQ0aVliWzzVJ.VbRmLw3U12h5qmZFi', '(44) 9 8568-5585', 'A', 'mario', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`idcaixa`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `movimento_caixa`
--
ALTER TABLE `movimento_caixa`
  ADD PRIMARY KEY (`idmovimento`),
  ADD KEY `idcaixa` (`idcaixa`) USING BTREE,
  ADD KEY `idoperacao` (`idoperacao`);

--
-- Índices para tabela `operacao`
--
ALTER TABLE `operacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`pagamento_id`);

--
-- Índices para tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `pagamento_id` (`pagamento_id`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produto_pedido`
--
ALTER TABLE `produto_pedido`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices para tabela `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`idtipousuario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtipoususario` (`idtipousuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `idcaixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT de tabela `modelo`
--
ALTER TABLE `modelo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `movimento_caixa`
--
ALTER TABLE `movimento_caixa`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de tabela `operacao`
--
ALTER TABLE `operacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `produto_pedido`
--
ALTER TABLE `produto_pedido`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de tabela `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `movimento_caixa`
--
ALTER TABLE `movimento_caixa`
  ADD CONSTRAINT `movimento_caixa_ibfk_1` FOREIGN KEY (`idcaixa`) REFERENCES `caixa` (`idcaixa`),
  ADD CONSTRAINT `movimento_caixa_ibfk_2` FOREIGN KEY (`idoperacao`) REFERENCES `operacao` (`id`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idtipousuario`) REFERENCES `tipo_usuario` (`idtipousuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
