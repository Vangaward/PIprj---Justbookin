-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql306.infinityfree.com
-- Tempo de geração: 05/09/2024 às 23:56
-- Versão do servidor: 10.6.19-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `if0_34867037_jbi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `capituloLit`
--

CREATE TABLE `capituloLit` (
  `idLit` int(11) NOT NULL,
  `numCapitulo` int(11) NOT NULL,
  `nomeCapitulo` varchar(100) NOT NULL,
  `paginaInicial` int(11) NOT NULL,
  `dataCapitulo` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `capituloLit`
--

INSERT INTO `capituloLit` (`idLit`, `numCapitulo`, `nomeCapitulo`, `paginaInicial`, `dataCapitulo`) VALUES
(30, 2, 'Capítulo 2', 2, '2023-11-28 15:12:27'),
(30, 1, 'Capítulo 1', 1, '2023-11-28 15:12:27'),
(41, 2, 'pão', 3, '2024-06-19 15:33:05'),
(41, 1, 'Bolo', 1, '2024-06-19 15:33:05'),
(49, 2, 'teste 2', 1, '2024-08-23 13:42:03'),
(49, 1, 'teste 1', 1, '2024-08-23 13:42:03'),
(39, 8, 'O Futuro...', 7, '2024-08-13 12:58:08'),
(46, 1, 'HAHA, HIHI', 1, '2024-08-19 17:35:10'),
(39, 7, 'A cíclica angustia da espera', 7, '2024-08-13 12:58:08'),
(39, 6, 'Um presente inesperado', 7, '2024-08-13 12:58:08'),
(39, 5, 'Uma esperança distante', 6, '2024-08-13 12:58:08'),
(39, 4, 'O Silêncio Inquietante', 5, '2024-08-13 12:58:08'),
(39, 3, 'Percepção', 4, '2024-08-13 12:58:08'),
(39, 2, 'A então felicidade', 3, '2024-08-13 12:58:08'),
(39, 1, 'Prefácio', 2, '2024-08-13 12:58:08'),
(38, 5, 'Que notícia maravilhosa!', 10, '2024-08-27 12:22:42'),
(38, 4, 'A minha Mãe', 8, '2024-08-27 12:22:42'),
(38, 3, 'Use a Janela', 7, '2024-08-27 12:22:42'),
(38, 2, 'Que horror! ', 6, '2024-08-27 12:22:42'),
(38, 1, 'Perigoso e desconhecido', 4, '2024-08-27 12:22:42'),
(54, 1, '--\'', 3, '2024-08-30 15:13:50');

-- --------------------------------------------------------

--
-- Estrutura para tabela `capituloLitAntiga`
--

CREATE TABLE `capituloLitAntiga` (
  `idCL` int(11) NOT NULL,
  `idLit` int(11) NOT NULL,
  `txtCapitulo` varchar(2000) NOT NULL,
  `numCapitulo` int(5) NOT NULL,
  `nomeCapitulo` varchar(70) NOT NULL,
  `urlImagem` varchar(255) NOT NULL,
  `numPagina` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Categoria`
--

CREATE TABLE `Categoria` (
  `idCategoria` int(11) NOT NULL,
  `nomeCategoria` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `Categoria`
--

INSERT INTO `Categoria` (`idCategoria`, `nomeCategoria`) VALUES
(1, 'Aventura'),
(2, 'Ação'),
(3, 'Comédia'),
(4, 'Romance'),
(5, 'Investigação'),
(6, 'Horror'),
(7, 'Terror'),
(8, 'Lovecraft'),
(9, 'Política'),
(10, 'Social'),
(11, 'ARG'),
(12, 'Narrativa'),
(13, 'Ficção científica'),
(14, 'Educacional'),
(15, 'Fantasía'),
(16, 'Suspense'),
(17, 'Drama'),
(18, 'Poesia'),
(19, 'Biografia'),
(20, 'História em quadrinhos'),
(21, 'Graphic novel'),
(22, 'Infantil'),
(23, 'Culinária'),
(24, 'Aprendizado'),
(25, 'Auto-ajuda'),
(26, 'Ecônomia'),
(27, 'Entretenimento'),
(28, 'J1407b (Astrônomia)'),
(29, 'Filosofia'),
(30, 'Teologia');

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `idComentario` int(11) NOT NULL,
  `idLit` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `txtComentario` varchar(100) NOT NULL,
  `dataCom` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`idComentario`, `idLit`, `idUsuario`, `txtComentario`, `dataCom`) VALUES
(1, 35, 7, 'jacarta é a capital a indonesia', '2024-04-03 17:06:50'),
(3, 30, 10, 'Comentário', '2023-11-28 15:13:34'),
(6, 36, 1, 'Bão', '2024-04-10 16:45:51'),
(5, 35, 1, 'Teste 2', '2024-04-10 16:08:44'),
(20, 38, 1, 'testeComent ₢', '2024-08-27 08:37:52'),
(12, 28, 1, 'Este é um comentário', '2024-04-23 22:37:25'),
(19, 49, 7, 'misericórdia', '2024-08-23 13:09:10'),
(28, 52, 1, 'Emocionante e ao mesmo tempo muito assustador!', '2024-09-03 08:06:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `curtidasLit`
--

CREATE TABLE `curtidasLit` (
  `curtida` int(2) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idLit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `curtidasLit`
--

INSERT INTO `curtidasLit` (`curtida`, `idUsuario`, `idLit`) VALUES
(0, 1, 46),
(0, 1, 34),
(1, 1, 40),
(0, 9, 28),
(1, 1, 38),
(1, 42, 38),
(1, 3, 28),
(0, 1, 32),
(1, 1, 39),
(1, 5, 28),
(0, 1, 28),
(1, 1, 35),
(1, 7, 36),
(1, 7, 38),
(1, 7, 28),
(0, 1, 36),
(1, 5, 38),
(1, 0, 0),
(1, 0, 0),
(1, 0, 0),
(1, 0, 0),
(1, 0, 0),
(1, 7, 35),
(0, 1, 52);

-- --------------------------------------------------------

--
-- Estrutura para tabela `favorito`
--

CREATE TABLE `favorito` (
  `idLit` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `favorito`
--

INSERT INTO `favorito` (`idLit`, `idUsuario`) VALUES
(38, 1),
(28, 7),
(36, 7),
(35, 1),
(38, 5),
(35, 7),
(38, 7),
(38, 42),
(39, 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `histLogin`
--

CREATE TABLE `histLogin` (
  `idHistLogin` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itemCategoria`
--

CREATE TABLE `itemCategoria` (
  `idLit` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `itemCategoria`
--

INSERT INTO `itemCategoria` (`idLit`, `idCategoria`) VALUES
(28, 2),
(28, 3),
(28, 4),
(28, 12),
(30, 2),
(30, 16),
(34, 27),
(34, 28),
(35, 3),
(35, 24),
(35, 27),
(35, 28),
(36, 7),
(36, 17),
(36, 23),
(36, 30),
(38, 2),
(38, 3),
(38, 23),
(38, 27),
(39, 12),
(39, 16),
(39, 17),
(39, 19),
(40, 3),
(40, 14),
(40, 22),
(41, 9),
(41, 10),
(41, 11),
(41, 12),
(41, 13),
(41, 14),
(41, 15),
(41, 17),
(41, 30),
(46, 1),
(49, 18),
(50, 1),
(52, 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Literatura`
--

CREATE TABLE `Literatura` (
  `idLit` int(11) NOT NULL,
  `urlCapa` varchar(75) NOT NULL,
  `dataEdit` datetime NOT NULL,
  `dataLanc` datetime NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` varchar(300) NOT NULL,
  `views` int(255) NOT NULL,
  `status` int(2) NOT NULL,
  `urlPdf` varchar(75) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `Literatura`
--

INSERT INTO `Literatura` (`idLit`, `urlCapa`, `dataEdit`, `dataLanc`, `idUsuario`, `titulo`, `descricao`, `views`, `status`, `urlPdf`) VALUES
(46, '2a6e21b17a385f64ec6599edfd1dee11_618865014-silvio-santos1.png', '2024-08-19 17:44:37', '2024-08-19 17:34:25', 1, 'HAHA, HIHI', 'HAHA, HIHI', 2, 0, 'b7ecd97cf36ba8fcbb75ebd604b69e41_Custo de armazenagem e movimentação.pdf'),
(40, '285c819b9e789cac091da4625dea2e14_Inserir um título (2).png', '2024-06-19 01:06:05', '2024-06-19 01:06:05', 1, 'Como  NÃO fazer um piquenique', 'Este não é um livro real, o intuito deste é ser um livro meramente ilustrativo para demostrar as funcionalidades do sistema JustBookIn.', 0, 0, '285c819b9e789cac091da4625dea2e14_pqnq.pdf'),
(34, '69ed9780481d3b0649aecfcaa3cf2d9d_3d785f94189dddf11ea9c087f89e8318.jpg', '2024-06-28 00:12:14', '2024-02-19 14:34:04', 1, 'EasterEgg já disponível', 'Leia-me para mais informações!', 1, 0, 'b6f1876e89ee1005488893a0cf19048e_EasterEgg.pdf.pdf'),
(41, '', '2024-06-19 15:33:05', '2024-06-19 15:33:05', 5, 'Receitas', 'Caseiras', 2, 0, '9654d26cbdcbf0d0036a95799ab26074_Receitas Caseiras.pdf'),
(28, '12e5f0a5ef198948cd4cb4f426fdecf2_Alvorada na colina - capa.png', '2023-11-28 00:23:55', '2023-11-28 00:23:55', 1, 'Alvorada na Colina', 'Este não é um livro real, o intuito deste é ser um livro meramente ilustrativo para demostrar as funcionalidades do sistema JustBookIn.', 6, 0, 'cd83c792069fbdcb1cdc24973092c69f_Alvorada.pdf'),
(39, '89980304d70247e5d85d6c43b718a953_Inserir um título.png', '2024-08-13 12:58:08', '2024-06-19 00:28:40', 1, 'Chuva Silenciosa', 'Este não é um livro real, o intuito deste é ser um livro meramente ilustrativo para demostrar as funcionalidades do sistema JustBookIn.', 2, 0, '89980304d70247e5d85d6c43b718a953_chuva.pdf'),
(35, '9795ffbd3976cb8d11912cf6c011af53_J1407b.png', '2024-02-23 01:47:54', '2024-02-23 01:47:54', 1, 'J1407b - Hipertraduzido 120 vezes', 'J1407b - Hipertraduzido 120 vezes.\r\nO texto apresentando J1407b foi hipertraduzido por 119 vezes e depois voltou ao português, totalizado 120 traduções.\r\nAqui você pode ler a versão original e a hipertraduzida!', 5, 0, '9795ffbd3976cb8d11912cf6c011af53_Versão Original.pdf'),
(36, 'b54422a3d80974c42f5bdc29d378f985_CARRINHO DO CARINHO.png', '2024-08-20 16:10:01', '2024-04-10 16:45:11', 7, 'carinho', 'vruvrum', 0, 1, '0a63dd144068f361fdcaabd911f75379_PROTOTIPO.pdf'),
(38, 'c67bd213e88dedc4307d135c317cd8d9_Carlos.jpeg', '2024-08-30 01:15:26', '2024-05-27 07:15:51', 1, 'Carlos, a panela está no fogo!', '“Carlos, a panela está no fogo”, trata-se de uma conversa feita com o ChatGPT, passando a ele a ideia de que o autor realmente estava vivendo uma situação fictícia, de forma que ele acreditasse na história como que se fosse real e fizesse interações para tentar ajudá-lo.\r\nO enredo descreve o persona', 22, 0, '23c74f4d635243be604ee62640d23a4d_Carlos, a panela está no fogo.pdf'),
(49, 'fbb1f044ed9e1fbc6083e0d790ba1bba_Obra do Vinínícius 11 08 2022.png', '2024-08-23 13:42:03', '2024-08-20 09:02:25', 1, 'Um teste qualquer 3', 'Descrição de um teste qualquer 3', 1, 0, 'fbb1f044ed9e1fbc6083e0d790ba1bba_CÂNTICO 151.pdf'),
(50, '2917d4a403785de11db21ffebd569f74_estampaR.png', '2024-08-27 13:00:47', '2024-08-27 13:00:47', 1, 'Questo2', 'ewfweff', 0, 0, '2917d4a403785de11db21ffebd569f74_CÂNTICO 151.pdf'),
(52, '2bf59fa120f230cd8f8713af4712256f_Imagem.jpg', '2024-08-29 20:13:35', '2024-08-29 20:13:35', 5, 'Teste', 'Teste sadasdadada', 2, 0, '2bf59fa120f230cd8f8713af4712256f_Gestão de Projetos _ Trello lista.pdf'),
(53, '', '2024-08-30 14:57:30', '2024-08-30 14:57:30', 1, '--\'', '--\'', 0, 0, 'd307d0a47a6f34c5aaca3508bada015b_resumo_taruga.pdf'),
(54, '', '2024-08-30 15:13:50', '2024-08-30 15:13:50', 1, '--\'', '--\'', 0, 0, '9eb54253a2180e24d480b1b960d44626_resumo_taruga.pdf');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `idNotif` int(11) NOT NULL,
  `visualizado` int(1) NOT NULL,
  `texto` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `seguidos`
--

CREATE TABLE `seguidos` (
  `idUsuario` int(11) NOT NULL,
  `idUsuarioSeguido` int(11) NOT NULL,
  `habNotif` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `seguidos`
--

INSERT INTO `seguidos` (`idUsuario`, `idUsuarioSeguido`, `habNotif`) VALUES
(7, 5, 0),
(3, 5, 0),
(1, 9, 0),
(1, 5, 0),
(5, 7, 0),
(9, 7, 0),
(10, 1, 0),
(1, 10, 0),
(5, 1, 0),
(7, 9, 0),
(1, 7, 0),
(7, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `token`
--

CREATE TABLE `token` (
  `idUsuarioToken` int(11) NOT NULL,
  `token` varchar(64) DEFAULT NULL,
  `criacao` datetime DEFAULT NULL,
  `expiracao` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `token`
--

INSERT INTO `token` (`idUsuarioToken`, `token`, `criacao`, `expiracao`) VALUES
(41, 'b0b9cb17d8284f46a16cead5337c48a1e6dab2e65e166605c3125f11d3179c99', '2024-07-15 11:18:44', '2024-07-15 11:33:44'),
(1, 'd72d5b7fc4074b903cd55ce9729c5818fe428eef75b70d0f7522ca6783fe243c', '2024-08-27 10:43:59', '2024-08-27 10:58:59'),
(3, NULL, NULL, NULL),
(5, 'de72f5969efdf603d30b3bd000717541977d75e1738320453a37b149aa06b9b9', '2024-07-13 18:26:56', '2024-07-13 18:41:56'),
(7, NULL, NULL, NULL),
(9, NULL, NULL, NULL),
(44, '5f18cabd8e276b8ea9c9e4274e13459ea2aacc553905594ef30141409777c871', '2024-08-26 16:23:31', '2024-08-26 16:38:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `nomeUsuario` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `dataNascimento` date NOT NULL,
  `statusConta` int(11) NOT NULL,
  `tipoConta` int(11) NOT NULL,
  `urlFotoPerfil` varchar(82) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nome`, `sobrenome`, `nomeUsuario`, `email`, `senha`, `dataNascimento`, `statusConta`, `tipoConta`, `urlFotoPerfil`) VALUES
(1, 'Juan', 'Cardoso', 'Juan2019', 'juan.cardosograv@gmail.com', '8c93ce1d07259934298ea47da504510529a423a4', '2004-11-30', 1, 3, '511a835b96bd7929412dab5b27aa181f8e3736cb_376471267107cc5167850ae03a1611b0.png'),
(3, 'Juan2', 'O segundo', 'user3', 'juan2', '8c93ce1d07259934298ea47da504510529a423a4', '2023-09-05', 1, 3, ''),
(5, 'jooj', 'gaag', 'user4', 'joaogabrielarruda55@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2005-04-05', 1, 3, '4564b3eac2cbb88256f7dc9c173f14db7057f908_Persona_5.png'),
(7, 'cruzera', 'cruzera', 'cruzerblade', 'cruzera', '526ccf56098442c46fa589058039a2b451ef02d2', '0909-09-09', 1, 3, 'd3ffd64f63bca60cdaa35aea5ae05173c887b414_imagem_2024-06-19_001038935.png'),
(9, 'Felipe', 'Chellton', 'user6', 'felipe@gmail.com', '4eadf75bea39642323e6f8d67b1137fc1653c1b7', '2023-11-23', 1, 3, ''),
(42, 'adm', 'adm', 'adm', 'adm', 'e5e0b68adfacb66979505bedf6d424070c536eb6', '2024-08-20', 1, 1, NULL),
(41, 'Teste', 'TEsteSobre', 'umTeste', 'tbalacobacos@gmail.com', '53dbfcef3798ca9f6e26960f84f1bac85f2b1cce', '2004-11-30', 1, 3, ''),
(44, 'simpson', 'gamer', 'esecanalehbomdms', 'vicrulei@gmail.com', '92a47a0308243f87a042ea831f59761e8af953dd', '0666-09-06', 1, 3, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `verificacao`
--

CREATE TABLE `verificacao` (
  `idVerif` int(11) NOT NULL,
  `idLit` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `capituloLit`
--
ALTER TABLE `capituloLit`
  ADD PRIMARY KEY (`idLit`,`numCapitulo`),
  ADD UNIQUE KEY `idLit` (`idLit`,`numCapitulo`),
  ADD UNIQUE KEY `idLit_2` (`idLit`,`numCapitulo`);

--
-- Índices de tabela `capituloLitAntiga`
--
ALTER TABLE `capituloLitAntiga`
  ADD PRIMARY KEY (`idCL`);

--
-- Índices de tabela `Categoria`
--
ALTER TABLE `Categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idComentario`);

--
-- Índices de tabela `histLogin`
--
ALTER TABLE `histLogin`
  ADD PRIMARY KEY (`idHistLogin`);

--
-- Índices de tabela `itemCategoria`
--
ALTER TABLE `itemCategoria`
  ADD PRIMARY KEY (`idLit`,`idCategoria`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Índices de tabela `Literatura`
--
ALTER TABLE `Literatura`
  ADD PRIMARY KEY (`idLit`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`idNotif`);

--
-- Índices de tabela `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`idUsuarioToken`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Índices de tabela `verificacao`
--
ALTER TABLE `verificacao`
  ADD PRIMARY KEY (`idVerif`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `capituloLitAntiga`
--
ALTER TABLE `capituloLitAntiga`
  MODIFY `idCL` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Categoria`
--
ALTER TABLE `Categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `histLogin`
--
ALTER TABLE `histLogin`
  MODIFY `idHistLogin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Literatura`
--
ALTER TABLE `Literatura`
  MODIFY `idLit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `idNotif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `verificacao`
--
ALTER TABLE `verificacao`
  MODIFY `idVerif` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
