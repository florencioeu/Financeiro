-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/01/2026 às 14:31
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `financeiro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `forma_pagamentos`
--

CREATE TABLE `forma_pagamentos` (
  `id_forma_pagto` int(11) NOT NULL,
  `descricao_forma` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `forma_pagamentos`
--

INSERT INTO `forma_pagamentos` (`id_forma_pagto`, `descricao_forma`) VALUES
(1, 'Pix'),
(2, 'Dinheiro'),
(3, 'Cartão de Débito'),
(4, 'Cartão de Crédito'),
(5, 'Bit Coins');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id_fornecedor` int(11) NOT NULL,
  `nome_fornecedor` varchar(80) NOT NULL,
  `cpf_cnpj` varchar(25) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `logradouro` varchar(60) NOT NULL,
  `numero` varchar(15) NOT NULL,
  `complemento` varchar(15) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `contato` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id_fornecedor`, `nome_fornecedor`, `cpf_cnpj`, `celular`, `email`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `contato`) VALUES
(1, 'Kabum Informatica Ltda', '11.111.111/0001-11', '(11) 99999-9999', 'kabum@kabum.com.br', '03050-000', 'Rua sei la', '1725', 'sala 2', 'Vila num sei', 'São Paulo', 'SP', 'José Manoel'),
(3, 'Carrefour Ltda', '11.222.222/0001-11', '(11) 99999-8888', 'carrefour@carrefour.com.br', '04050-000', 'Rua sobe desce', '222', 'sala 1', 'Vila Velhai', 'São Paulo', 'SP', 'Dr. Ricardo'),
(4, 'diversos', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id_pagamento` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL DEFAULT 0,
  `data_vcto` date NOT NULL,
  `valor` decimal(10,0) NOT NULL DEFAULT 0,
  `data_pagto` date NOT NULL,
  `valor_pago` decimal(10,0) NOT NULL DEFAULT 0,
  `descricao` varchar(80) NOT NULL,
  `id_tipo_pagto` int(11) NOT NULL DEFAULT 0,
  `id_forma_pagto` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id_pagamento`, `id_fornecedor`, `data_vcto`, `valor`, `data_pagto`, `valor_pago`, `descricao`, `id_tipo_pagto`, `id_forma_pagto`) VALUES
(1, 1, '2025-02-05', 2500, '2025-02-05', 2500, 'Compra de um notebook', 4, 4),
(2, 3, '2025-02-06', 30, '2025-02-06', 30, 'Compra de café', 1, 1),
(3, 3, '2025-02-05', 100, '2025-02-05', 100, 'Compra de papel A4', 4, 2),
(4, 4, '2025-02-07', 650, '2025-02-07', 650, 'Conserto do carro', 2, 2),
(5, 4, '2025-02-07', 200, '2025-02-07', 200, 'Gasolina', 2, 2),
(6, 4, '2025-02-07', 200, '2025-02-07', 200, 'Pagamento conta de luz', 5, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoas`
--

CREATE TABLE `pessoas` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `data_nascto` date NOT NULL,
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoas`
--

INSERT INTO `pessoas` (`id`, `nome`, `data_nascto`, `email`) VALUES
(1, 'Francisco Correia da Silva', '1998-07-04', 'fcs@hotmail.com'),
(2, 'Maria Fernanda Oliveira', '1995-03-12', 'mfo@gmail.com'),
(3, 'João Pedro Santos', '2000-11-23', 'zemane@yahoo'),
(5, 'Carlos Eduardo Lima', '1988-09-15', 'cel@hotmail.com'),
(6, 'Beatriz Alves', '1997-01-19', 'ba@gmail.com'),
(7, 'Lucas Pereira', '1994-08-22', 'lp@yahoo.com'),
(8, 'Mariana Rocha', '1999-12-05', 'mr@outlook.com'),
(9, 'Gabriel Costa', '1996-04-18', 'gc@hotmail.com'),
(10, 'Larissa Martins', '1993-07-27', 'lm@gmail.com'),
(11, 'Rafael Almeida', '1989-10-10', 'ra@yahoo.com'),
(12, 'Juliana Ribeiro', '1991-02-14', 'jr@outlook.com'),
(13, 'Felipe Barbosa', '2001-06-09', 'fb@hotmail.com'),
(14, 'Camila Silva', '1990-03-25', 'cs@gmail.com'),
(15, 'Thiago Fernandes', '1998-12-30', 'tf@yahoo.com'),
(16, 'Isabela Gomes', '1995-07-11', 'ig@outlook.com'),
(17, 'Bruno Carvalho', '1992-11-03', 'bc@hotmail.com'),
(18, 'Patrícia Lima', '1996-05-21', 'pl@gmail.com'),
(19, 'Rodrigo Souza', '1993-09-08', 'rs@yahoo.com'),
(20, 'Fernanda Costa', '1987-12-19', 'fc@outlook.com'),
(21, 'Gustavo Almeida', '1999-04-02', 'ga@hotmail.com'),
(22, 'Renata Oliveira', '1994-08-15', 'ro@gmail.com'),
(23, 'Vinícius Santos', '1991-01-28', 'vs@yahoo.com'),
(24, 'Letícia Pereira', '1997-06-13', 'lp@outlook.com'),
(25, 'Eduardo Lima', '1989-10-25', 'el@hotmail.com'),
(26, 'Tatiane Rodrigues', '1992-03-07', 'tr@gmail.com'),
(27, 'André Silva', '1995-11-20', 'as@yahoo.com'),
(28, 'Carolina Souza', '1998-05-04', 'cs@outlook.com'),
(29, 'Marcelo Costa', '1990-09-17', 'mc@hotmail.com'),
(30, 'Aline Fernandes', '1993-12-29', 'af@gmail.com'),
(31, 'Pedro Henrique', '1996-04-10', 'ph@yahoo.com'),
(32, 'Vanessa Martins', '1991-07-23', 'vm@outlook.com'),
(33, 'Ricardo Almeida', '1988-11-05', 'ra@hotmail.com'),
(34, 'Sabrina Lima', '1994-02-16', 'sl@gmail.com'),
(35, 'Daniel Souza', '1997-06-28', 'ds@yahoo.com'),
(36, 'Natália Costa', '1992-10-09', 'nc@outlook.com'),
(37, 'Fábio Oliveira', '1989-03-22', 'fo@hotmail.com'),
(38, 'Juliana Pereira', '1995-07-14', 'jp@gmail.com'),
(39, 'Leonardo Santos', '1998-11-27', 'ls@yahoo.com'),
(40, 'Amanda Rocha', '1991-04-08', 'ar@outlook.com'),
(41, 'Rafael Lima', '1993-08-19', 'rl@hotmail.com'),
(42, 'Bianca Fernandes', '1996-12-01', 'bf@gmail.com'),
(43, 'Guilherme Souza', '1990-05-23', 'gs@yahoo.com'),
(44, 'Larissa Costa', '1994-09-06', 'lc@outlook.com'),
(45, 'Matheus Almeida', '1997-01-18', 'ma@hotmail.com'),
(46, 'Paula Oliveira', '1992-06-30', 'po@gmail.com'),
(47, 'Diego Santos', '1989-10-12', 'ds@yahoo.com'),
(48, 'Carla Pereira', '1995-03-26', 'cp@outlook.com'),
(49, 'Lucas Fernandes', '1998-07-09', 'lf@hotmail.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_pagamentos`
--

CREATE TABLE `tipo_pagamentos` (
  `id_tipo_pagto` int(11) NOT NULL,
  `descricao_tipo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipo_pagamentos`
--

INSERT INTO `tipo_pagamentos` (`id_tipo_pagto`, `descricao_tipo`) VALUES
(1, 'Alimentação'),
(2, 'Veículos'),
(3, 'Transporte'),
(4, 'Material de escritório'),
(5, 'Contas de Consumo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(80) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `nome`, `email`, `senha`, `data_cadastro`, `ativo`) VALUES
(1, 'Usuario Geral', '', 'usuariogeral@senac.com', '$2y$10$f7A.PC/ChAqY3f2kiaLx0eE9gTH8jcghn4MeGszpvG0Rl4I0yYtQu', '2026-01-31 10:30:28', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `forma_pagamentos`
--
ALTER TABLE `forma_pagamentos`
  ADD PRIMARY KEY (`id_forma_pagto`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `id_fornecedor` (`id_fornecedor`),
  ADD KEY `id_forma_pagto` (`id_forma_pagto`),
  ADD KEY `id_tipo_pagto` (`id_tipo_pagto`);

--
-- Índices de tabela `pessoas`
--
ALTER TABLE `pessoas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tipo_pagamentos`
--
ALTER TABLE `tipo_pagamentos`
  ADD PRIMARY KEY (`id_tipo_pagto`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `forma_pagamentos`
--
ALTER TABLE `forma_pagamentos`
  MODIFY `id_forma_pagto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `pessoas`
--
ALTER TABLE `pessoas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `tipo_pagamentos`
--
ALTER TABLE `tipo_pagamentos`
  MODIFY `id_tipo_pagto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `id_forma_pagto` FOREIGN KEY (`id_forma_pagto`) REFERENCES `forma_pagamentos` (`id_forma_pagto`),
  ADD CONSTRAINT `id_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`),
  ADD CONSTRAINT `id_tipo_pagto` FOREIGN KEY (`id_tipo_pagto`) REFERENCES `tipo_pagamentos` (`id_tipo_pagto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
