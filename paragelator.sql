-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1:3306
-- Χρόνος δημιουργίας: 28 Μάη 2019 στις 01:50:35
-- Έκδοση διακομιστή: 5.7.21
-- Έκδοση PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `paragelator`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `cashreg`
--

DROP TABLE IF EXISTS `cashreg`;
CREATE TABLE IF NOT EXISTS `cashreg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cash` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `cashreg`
--

INSERT INTO `cashreg` (`id`, `cash`) VALUES
(1, 5);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `categ_id` int(11) NOT NULL AUTO_INCREMENT,
  `categ_name` varchar(250) NOT NULL,
  PRIMARY KEY (`categ_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `category`
--

INSERT INTO `category` (`categ_id`, `categ_name`) VALUES
(2, 'Elies'),
(3, 'patates'),
(4, 'anapsiktika');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `orddetails`
--

DROP TABLE IF EXISTS `orddetails`;
CREATE TABLE IF NOT EXISTS `orddetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `units` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prod_id` (`prod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `orddetails`
--

INSERT INTO `orddetails` (`id`, `order_id`, `prod_id`, `units`, `price`, `comment`) VALUES
(16, 33890, 3, 1, 5, 'Sde'),
(17, 79167, 3, 1, 5, ''),
(18, 45112, 3, 1, 5, 'Asd'),
(19, 8292, 3, 2, 10, '11'),
(20, 43654, 4, 2, 12, '1');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `ordhead`
--

DROP TABLE IF EXISTS `ordhead`;
CREATE TABLE IF NOT EXISTS `ordhead` (
  `order_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` float NOT NULL,
  `status` int(11) NOT NULL,
  `regtime` datetime NOT NULL,
  `comptime` datetime DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `table_id` (`table_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `ordhead`
--

INSERT INTO `ordhead` (`order_id`, `table_id`, `date`, `user_id`, `total`, `status`, `regtime`, `comptime`) VALUES
(8292, 1, '2019-05-28', 25, 10, 3, '2019-05-28 02:53:56', NULL),
(33890, 1, '2019-05-24', 25, 5, 3, '2019-05-24 14:01:23', NULL),
(43654, 1, '2019-05-28', 29, 12, 0, '2019-05-28 03:21:11', NULL),
(45112, 1, '2019-05-27', 25, 5, 3, '2019-05-27 22:57:44', NULL),
(79167, 1, '2019-05-24', 25, 5, 3, '2019-05-24 14:02:28', NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_name` varchar(250) NOT NULL,
  `categ_id` int(11) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`prod_id`),
  KEY `categ_id` (`categ_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `products`
--

INSERT INTO `products` (`prod_id`, `prod_name`, `categ_id`, `price`) VALUES
(3, 'BOBA BOLA', 4, 5),
(4, 'Bepis', 4, 6);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(250) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(0, 'Owner'),
(1, 'Waiter'),
(2, 'Kitchen'),
(3, 'Mark');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `sectors`
--

DROP TABLE IF EXISTS `sectors`;
CREATE TABLE IF NOT EXISTS `sectors` (
  `sect_id` int(11) NOT NULL AUTO_INCREMENT,
  `sect_name` varchar(250) NOT NULL,
  PRIMARY KEY (`sect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `sectors`
--

INSERT INTO `sectors` (`sect_id`, `sect_name`) VALUES
(1, 'Balconer'),
(2, 'salas');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(250) NOT NULL,
  `sect_id` int(11) NOT NULL,
  PRIMARY KEY (`table_id`),
  KEY `sect_id` (`sect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `tables`
--

INSERT INTO `tables` (`table_id`, `table_name`, `sect_id`) VALUES
(1, 'B1', 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role_id` int(11) NOT NULL,
  `balance` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`user_id`, `surname`, `name`, `username`, `password`, `role_id`, `balance`) VALUES
(24, 'Kehagias', 'Bill', 'bkeh97', '$2y$10$9DQOoZm/7B9jj1RCG90tReVP/Qnw6sLQvXx6XKM0YsH1cnkhG2QQK', 0, 4315),
(25, 'lolll', 'lololo', 'jumalauta', '$2y$10$85pvAm4TYWd9qre1r2mN2edextUXxw0ae8UgiKO4W2.JHK6WutFPO', 1, 0),
(27, 'Saatana', 'Perkele', 'perkele', '$2y$10$NvneS82JTceTpx5bw54Fbu6Tivz9VJf7.WqGykpPeDgOY1M9Ql1Ve', 2, 0),
(28, 'Borger', 'Gloria', 'berger', '$2y$10$cQDWQc1cdOuBc50zREtl8eU31Csdgae3L6HjDSjn9gJBc7D7gJe7q', 3, 0),
(29, 'Lautas', 'Juma', 'jumalauta2', '$2y$10$rv8t.YbTKdPUWGqemnfVqu4L1OZKJ6EUkTL0uHt31OdAqj2sCTUjS', 1, 0);

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `orddetails`
--
ALTER TABLE `orddetails`
  ADD CONSTRAINT `prod_id` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`);

--
-- Περιορισμοί για πίνακα `ordhead`
--
ALTER TABLE `ordhead`
  ADD CONSTRAINT `table_id` FOREIGN KEY (`table_id`) REFERENCES `tables` (`table_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Περιορισμοί για πίνακα `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `categ_id` FOREIGN KEY (`categ_id`) REFERENCES `category` (`categ_id`);

--
-- Περιορισμοί για πίνακα `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `sect_id` FOREIGN KEY (`sect_id`) REFERENCES `sectors` (`sect_id`);

--
-- Περιορισμοί για πίνακα `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
