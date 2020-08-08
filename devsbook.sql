-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 08-Ago-2020 às 15:25
-- Versão do servidor: 8.0.21-0ubuntu0.20.04.4
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `devsbook`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `postcomments`
--

CREATE TABLE `postcomments` (
  `id` int NOT NULL,
  `id_post` int NOT NULL,
  `id_user` int NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `postlikes`
--

CREATE TABLE `postlikes` (
  `id` int NOT NULL,
  `id_post` int NOT NULL,
  `id_user` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `posts`
--

INSERT INTO `posts` (`id`, `id_user`, `type`, `created_at`, `body`) VALUES
(1, 1, 'text', '2020-06-18 20:03:15', 'Esse é um post de teste'),
(2, 1, 'text', '2020-06-18 20:03:39', 'Esse é um post\r\nde teste com\r\nmultiplas linhas.'),
(3, 3, 'photo', '2020-08-08 15:21:18', '389dc38e28c77ff62dcf9ea88d8a2a09d.jpg'),
(4, 3, 'sharedPhoto', '2020-08-08 15:21:31', '19895f2eed2b2d6fa.jpg'),
(5, 3, 'sharedPhoto', '2020-08-08 15:24:30', '19895f2eed2b2d6fa.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `postshares`
--

CREATE TABLE `postshares` (
  `id` int NOT NULL,
  `id_post` int NOT NULL,
  `id_user` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `postshares`
--

INSERT INTO `postshares` (`id`, `id_post`, `id_user`, `created_at`) VALUES
(1, 4, 3, '2020-08-08 15:24:30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userrelations`
--

CREATE TABLE `userrelations` (
  `id` int NOT NULL,
  `user_from` int NOT NULL,
  `user_to` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `userrelations`
--

INSERT INTO `userrelations` (`id`, `user_from`, `user_to`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `cover` varchar(255) NOT NULL DEFAULT 'cover.jpg',
  `city` varchar(255) DEFAULT NULL,
  `work` varchar(255) DEFAULT NULL,
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `token`, `avatar`, `cover`, `city`, `work`, `birthdate`) VALUES
(1, 'admin', 'admin@admin.com.br', '$2y$10$cHKWwuAuSwEMFUsevgbfG.al4BV.Opp.phYNdLOZSWGPF6DMa/ysm', '3964021035743c2f9d88fab616ee5e9e', 'profile.jpg', 'cover.jpg', '', '', '1996-03-03'),
(2, 'testador', 'testador@hotmail.com', '$2y$10$3W4Pug8TFR6eaKefG1PYW.bW3XkfZvRuY5DIo6u8ACHL0u0sFN90G', '8ec31a208dcb1f8dd8160726bc214c6b', 'default.jpg', 'cover.jpg', '', '', '1111-11-11'),
(3, 'admin', 'admin@admin.com', '$2y$10$XsBdQp3mK49VqWwB4l4cn.AbQ69EfARHgpHBmDnlellndhvadQ/Da', '0df29d38bb7bf3c941ba2b993cef7e22', 'default.jpg', 'cover.jpg', NULL, NULL, '1996-03-03');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `postshares`
--
ALTER TABLE `postshares`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `userrelations`
--
ALTER TABLE `userrelations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `postshares`
--
ALTER TABLE `postshares`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `userrelations`
--
ALTER TABLE `userrelations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
