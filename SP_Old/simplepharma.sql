-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/10/2023 às 15:46
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `simplepharma`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `contador` int(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `local` varchar(255) NOT NULL,
  `datahora` varchar(150) NOT NULL,
  `tecnico` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `servico` varchar(600) DEFAULT NULL,
  `serviexecu` varchar(200) NOT NULL,
  `datahoraaber` varchar(20) NOT NULL,
  `datahorafim` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `chamados`
--

INSERT INTO `chamados` (`contador`, `usuario`, `local`, `datahora`, `tecnico`, `status`, `servico`, `serviexecu`, `datahoraaber`, `datahorafim`) VALUES
(12, '', 'Simple Pharma (São Paulo)', '11/10/2023 16:17', 'Batman', 'Feito', 'Teste 5', 'Resolvido', '11/10/2023 17:02', '11/10/2023 18:02'),
(11, '', 'Simple Pharma (São Paulo)', '11/10/2023 16:14', 'Batman', 'Feito', 'Teste 4', 'Resolvido', '11/10/2023 16:14', '11/10/2023 17:14'),
(10, '', 'Simple Pharma (São Paulo)', '11/10/2023 16:13', 'Batman', 'Feito', 'Teste3', 'Resolvido', '', ''),
(8, '', 'Simple Pharma (São Paulo)', '11/10/2023 16:08', 'Batman', 'Feito', 'Teste', 'Resolvido', '', ''),
(9, '', 'Simple Pharma (São Paulo)', '11/10/2023 16:12', 'Batman', 'Feito', 'Teste2', 'Resolvido', '', ''),
(7, '', 'Simple Pharma (São Paulo)', '11/10/2023 15:58', 'Batman', 'Feito', 'hger0hjaeinrbhoneaboaemboineabonafbdfblmdaofbniodabfjdfbadfbadfbdfabfhfhadb', 'hwrthwrsthrswbtsgfhbntykjetyj', '', ''),
(21, 'AndersonCB96', 'Simple Pharma (São Paulo)', '13/10/2023 16:08', 'Batman', 'Aberto', 'Teste 14', '', '', ''),
(15, 'AndersonCB96dateFrom', 'Simple Pharma (São Paulo)', '11/10/2023 17:24', 'Batman', 'Feito', 'Teste 8', 'Resolvido', '16/10/2023 09:50', '16/10/2023 10:50'),
(16, 'AndersonCB96', 'Simple Pharma (São Paulo)', '11/10/2023 17:25', 'Batman', 'Aberto', 'Teste 9', '', '', ''),
(17, 'Anderson', 'Simple Pharma (São Paulo)', '11/10/2023 09:32', 'Batman', 'Aberto', 'Teste 10', '', '', ''),
(19, 'Anderson', 'Simple Pharma (São Paulo)', '13/10/2023 11:46', 'Batman', 'Aberto', 'Teste 12', '', '', ''),
(20, 'Anderson', 'Simple Pharma (São Paulo)', '13/10/2023 11:49', 'Batman', 'Aberto', 'Teste 13', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tecnicos`
--

CREATE TABLE `tecnicos` (
  `nome` varchar(50) NOT NULL,
  `nomecompleto` varchar(300) NOT NULL,
  `id` int(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tecnicos`
--

INSERT INTO `tecnicos` (`nome`, `nomecompleto`, `id`) VALUES
('Batman', 'Bruce Wayne', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `username`, `password`, `role`) VALUES
(2, 'Anderson', 'anderson.cavalcante@madrugaosuplementos.com.br', '123', 'admin'),
(3, 'AndersonCB96', 'andersoncavalcantr96@hotmail.com', '123', 'subadmin'),
(5, 'Bruce Wayne', 'Batman', '123', 'tecnico');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`contador`);

--
-- Índices de tabela `tecnicos`
--
ALTER TABLE `tecnicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Nome` (`nome`),
  ADD UNIQUE KEY `NomeCompleto` (`nomecompleto`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`username`),
  ADD KEY `nivel` (`role`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `contador` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `tecnicos`
--
ALTER TABLE `tecnicos`
  MODIFY `id` int(80) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
