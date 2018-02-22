-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 22, 2018 alle 18:30
-- Versione del server: 10.1.29-MariaDB
-- Versione PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iper`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `dictionary`
--

CREATE TABLE `dictionary` (
  `id` int(10) NOT NULL,
  `dic_key` varchar(64) NOT NULL,
  `EN` text NOT NULL,
  `IT` text NOT NULL,
  `DE` text NOT NULL,
  `FR` text NOT NULL,
  `creationdate` datetime NOT NULL,
  `last_modify` datetime NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `dictionary`
--

INSERT INTO `dictionary` (`id`, `dic_key`, `EN`, `IT`, `DE`, `FR`, `creationdate`, `last_modify`, `user`) VALUES
(1, 'SITE_TITLE', 'IperSex', 'IperSex', 'IperSex', 'IperSex', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(2, 'TITLE_SITE_HOME', 'Home  IperSex', 'Home  IperSex', 'Home  IperSex', 'Home  IperSex', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `sys_param_ref_page`
--

CREATE TABLE `sys_param_ref_page` (
  `id` int(10) NOT NULL,
  `id_ref` int(10) NOT NULL,
  `name` varchar(256) NOT NULL,
  `value` text NOT NULL,
  `creationdate` datetime NOT NULL,
  `last_modify` datetime NOT NULL,
  `user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Trigger `sys_param_ref_page`
--
DELIMITER $$
CREATE TRIGGER `sys_param_ref_page_created` BEFORE INSERT ON `sys_param_ref_page` FOR EACH ROW BEGIN
SET new.last_modify := now();
SET new.creationdate := now();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sys_param_ref_page_updated` BEFORE UPDATE ON `sys_param_ref_page` FOR EACH ROW BEGIN
SET new.last_modify := now();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `sys_ref_page`
--

CREATE TABLE `sys_ref_page` (
  `id` int(10) NOT NULL,
  `page_key` varchar(256) NOT NULL,
  `position` varchar(16) NOT NULL,
  `rel` varchar(64) NOT NULL,
  `url` text NOT NULL,
  `creationdate` datetime NOT NULL,
  `last_modify` datetime NOT NULL,
  `user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sys_ref_page`
--

INSERT INTO `sys_ref_page` (`id`, `page_key`, `position`, `rel`, `url`, `creationdate`, `last_modify`, `user`) VALUES
(1, 'home', 'header', 'stylesheet', 'www/include/css/bootstrap.min.css', '2018-02-22 18:24:58', '2018-02-22 18:28:18', 1),
(2, 'home', 'header', 'stylesheet', 'www/include/css/font-awesome.min.css', '2018-02-22 18:24:58', '2018-02-22 18:28:26', 1),
(3, 'home', 'header', 'stylesheet', 'www/include/css/pe-icons.css', '2018-02-22 18:25:36', '2018-02-22 18:28:35', 1),
(4, 'home', 'header', 'stylesheet', 'www/include/css/prettyPhoto.css', '2018-02-22 18:25:36', '2018-02-22 18:28:44', 1),
(5, 'home', 'header', 'stylesheet', 'www/include/css/animate.css', '2018-02-22 18:26:06', '2018-02-22 18:28:52', 1),
(6, 'home', 'header', 'stylesheet', 'www/include/css/style.css', '2018-02-22 18:26:06', '2018-02-22 18:29:01', 1);

--
-- Trigger `sys_ref_page`
--
DELIMITER $$
CREATE TRIGGER `sys_ref_page_created` BEFORE INSERT ON `sys_ref_page` FOR EACH ROW BEGIN
SET new.last_modify := now();
SET new.creationdate := now();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sys_ref_page_updated` BEFORE UPDATE ON `sys_ref_page` FOR EACH ROW BEGIN
SET new.last_modify := now();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `user` varchar(512) NOT NULL,
  `pwd` varchar(512) NOT NULL,
  `name` varchar(512) NOT NULL,
  `surname` varchar(512) NOT NULL,
  `creationdate` datetime NOT NULL,
  `last_modify` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `user`, `pwd`, `name`, `surname`, `creationdate`, `last_modify`) VALUES
(1, 'admin', 'admin', 'Administrator', 'Administrator', '2018-02-06 10:00:00', '2018-02-06 10:00:00');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `dictionary`
--
ALTER TABLE `dictionary`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sys_param_ref_page`
--
ALTER TABLE `sys_param_ref_page`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sys_ref_page`
--
ALTER TABLE `sys_ref_page`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `dictionary`
--
ALTER TABLE `dictionary`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `sys_param_ref_page`
--
ALTER TABLE `sys_param_ref_page`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `sys_ref_page`
--
ALTER TABLE `sys_ref_page`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
