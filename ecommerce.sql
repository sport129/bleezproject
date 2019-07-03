-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 03-Jul-2019 às 17:33
-- Versão do servidor: 10.1.38-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.3.4-1+ubuntu18.04.1+deb.sury.org+3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_imgproduct`
--

CREATE TABLE `tb_imgproduct` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `linkimg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_imgproduct`
--

INSERT INTO `tb_imgproduct` (`id`, `id_produto`, `linkimg`, `status`, `created_at`) VALUES
(7, 12, 'IndicationDiscount.jpeg', 0, '2019-07-03 16:27:01'),
(8, 12, 'logo.jpg', 1, '2019-07-03 16:27:01'),
(9, 12, 'logo.png', 1, '2019-07-03 16:27:02'),
(10, 12, 'IndicationDiscount.jpeg', 1, '2019-07-03 16:39:29'),
(11, 12, 'logo.jpg', 1, '2019-07-03 16:39:29'),
(12, 12, 'logo.png', 1, '2019-07-03 16:39:29'),
(13, 13, 'photo4951838714238183487.jpg', 0, '2019-07-03 16:39:45'),
(14, 13, 'photo4951838714238183488.jpg', 1, '2019-07-03 16:39:45'),
(15, 13, 'photo4951838714238183489.jpg', 1, '2019-07-03 16:39:45'),
(16, 13, 'photo4951838714238183490.jpg', 1, '2019-07-03 16:39:45'),
(17, 12, 'photo4951838714238183490.jpg', 1, '2019-07-03 16:58:53'),
(18, 20, 'photo4951838714238183487.jpg', 0, '2019-07-03 17:01:10'),
(19, 20, 'photo4951838714238183488.jpg', 0, '2019-07-03 17:01:10'),
(20, 20, 'photo4951838714238183489.jpg', 0, '2019-07-03 17:01:10'),
(21, 20, 'photo4951838714238183490.jpg', 0, '2019-07-03 17:01:10'),
(22, 19, 'photo4951838714238183487.jpg', 1, '2019-07-03 17:01:46'),
(23, 19, 'photo4951838714238183488.jpg', 1, '2019-07-03 17:01:46'),
(24, 19, 'photo4951838714238183489.jpg', 1, '2019-07-03 17:01:46'),
(25, 19, 'photo4951838714238183490.jpg', 1, '2019-07-03 17:01:46'),
(26, 14, 'd49f6de3-0912-4613-a2e8-42dec24dea55.jpeg', 1, '2019-07-03 17:02:02'),
(27, 15, 'glyphicons-halflings.png', 1, '2019-07-03 17:07:59'),
(28, 20, 'glyphicons-halflings-white.png', 0, '2019-07-03 17:21:38'),
(29, 18, 'glyphicons-halflings.png', 0, '2019-07-03 17:27:43'),
(30, 18, 'glyphicons-halflings-white.png', 0, '2019-07-03 17:27:44'),
(31, 16, 'IndicationDiscount.jpeg', 1, '2019-07-03 17:28:25'),
(32, 16, 'logo.jpg', 1, '2019-07-03 17:28:25'),
(33, 16, 'logo.png', 1, '2019-07-03 17:28:33'),
(34, 23, 'IndicationDiscount.jpeg', 0, '2019-07-03 17:45:43'),
(35, 23, 'logo.jpg', 0, '2019-07-03 17:45:43'),
(36, 23, 'logo.png', 0, '2019-07-03 17:45:43'),
(37, 16, 'photo4951838714238183488.jpg', 1, '2019-07-03 18:19:37');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produtos`
--

CREATE TABLE `tb_produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_produtos`
--

INSERT INTO `tb_produtos` (`id`, `nome`, `preco`, `descricao`, `status`, `created_at`) VALUES
(13, 'Carteira de Trabalho 123', '200.20', 'OIE TUDO BEM', 1, '2019-06-27 16:45:39'),
(14, 'Carteira de Trabalho 123', '200.20', 'OIE TUDO BEM', 1, '2019-06-27 16:45:39'),
(15, 'Carteira de Trabalho 123', '200.20', 'OIE TUDO BEM', 1, '2019-06-27 16:45:40'),
(16, 'Carteira de Trabalho 123', '200.20', 'OIE TUDO BEM', 1, '2019-06-27 16:45:40'),
(18, 'Carteira de Trabalho 123', '200.20', 'OIE TUDO BEM', 0, '2019-06-27 16:45:41'),
(19, 'Carteira de Trabalho 123', '200.20', 'OIE TUDO BEM', 0, '2019-06-27 19:25:47'),
(20, 'TESTE', '10.20', 'TESTE', 0, '2019-07-03 14:00:59'),
(21, 'teste', '10.20', 'ADICIONANDO DESCRIÃ‡ÃƒO', 0, '2019-07-03 14:05:01'),
(22, 'testando cadastrar sem produto', '10.20', 'teste', 0, '2019-07-03 14:15:49'),
(23, 'Daniel Rosendo', '100.00', 'Testeeeeee', 0, '2019-07-03 14:41:59'),
(24, 'Teste', '100.00', 'Teste', 1, '2019-07-03 15:20:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'sport129', '$2y$12$XOD6OHREfdUG7JwXIgmYBOfF4oGXztLvp6Nw/Xr.rQxpWX8TNGWMW', 'daniel.rosendos@hotmail.com', '2019-06-27 16:13:53'),
(2, 'sport129213', '$2y$12$G61FMGBO4LyIB4bQdk28mOPqsqTHUhv5XPxk5NB609CZoAIFqJJF2', 'daniel.rosendo321s@hotmail.com', '2019-06-27 17:13:53'),
(3, 'sport129213213', '$2y$12$6MVroL0.G7GLCVP32LyrxO2z/ohnA.1sOCtk.jSwBKR.g9.SFuOUi', 'danie321l.rosendo321s@hotmail.com', '2019-06-27 17:14:31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userToken`
--

CREATE TABLE `userToken` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `token` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_expired` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `userToken`
--

INSERT INTO `userToken` (`id`, `userId`, `token`, `time_expired`, `created_at`) VALUES
(19, 3, 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjMiLCJ1c2VybmFtZSI6InNwb3J0MTI5MjEzMjEzIiwicGFzc3dvcmQiOiIkMnkkMTIkNk1Wcm9MMC5HN0dMQ1ZQMzJMeXJ4TzJ6XC9vaG5BLjFzT0N0ay5qU3dCS1IuZzkuU0Z1T1VpIiwiZW1haWwiOiJkYW5pZTMyMWwucm9zZW5kbzMyMXNAaG90bWFpbC5jb20iLCJjcmVhdGVkX2F0IjoiMjAxOS0wNi0yNyAxNDoxNDozMSJ9.8e3HqLNDcEtmmSwvQHlOxPLlyhGNAZMdspCMgrB0lOg=', '2020-06-27 15:49:40', '2019-06-27 18:49:40'),
(20, 1, 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjEiLCJ1c2VybmFtZSI6InNwb3J0MTI5IiwicGFzc3dvcmQiOiIkMnkkMTIkWE9ENk9IUkVmZFVHN0p3WElnbVlCT2ZGNG9HWHp0THZwNk53XC9Yci5yUXhwV1g4VE5HV01XIiwiZW1haWwiOiJkYW5pZWwucm9zZW5kb3NAaG90bWFpbC5jb20iLCJjcmVhdGVkX2F0IjoiMjAxOS0wNi0yNyAxMzoxMzo1MyJ9.LG0NAS9k8RAvqwl+UnYYY+StcAZImMFnkqMZPESvfno=', '2020-06-27 19:53:53', '2019-06-27 22:53:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_imgproduct`
--
ALTER TABLE `tb_imgproduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_produtos`
--
ALTER TABLE `tb_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `userToken`
--
ALTER TABLE `userToken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_imgproduct`
--
ALTER TABLE `tb_imgproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `tb_produtos`
--
ALTER TABLE `tb_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `userToken`
--
ALTER TABLE `userToken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `userToken`
--
ALTER TABLE `userToken`
  ADD CONSTRAINT `userToken_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
