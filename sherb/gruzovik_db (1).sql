-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Июн 04 2025 г., 00:02
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gruzovik_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `cargo_type` enum('хрупкое','скоропортящееся','требуется рефрижератор','животные','жидкость','мебель','мусор') NOT NULL,
  `cargo_weight` decimal(10,2) NOT NULL,
  `dimensions` varchar(100) NOT NULL,
  `from_address` text NOT NULL,
  `to_address` text NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('Новая','В работе','Отменена') DEFAULT 'Новая'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `cargo_type`, `cargo_weight`, `dimensions`, `from_address`, `to_address`, `datetime`, `status`) VALUES
(1, 2, 'жидкость', '5.00', '5', '5', '5', '2025-05-31 04:33:00', 'В работе'),
(2, 6, 'скоропортящееся', '4.00', '2', '2', '2', '2025-05-31 06:22:00', 'Новая'),
(3, 7, 'мусор', '11.00', '11', '11', '11', '2025-06-08 08:26:00', 'Новая'),
(4, 1, 'хрупкое', '12.00', '14', 'дом', 'дом2', '2025-05-23 08:32:00', 'Новая'),
(5, 1, 'скоропортящееся', '2.00', '5', '3', '11', '2025-05-02 08:40:00', 'В работе');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fio` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fio`, `phone`, `email`, `login`, `password`) VALUES
(1, 'Щербаков Данил Александрович', '+7(961)-445-71-71', 'mrice7771@gmail.com', 'Данил5', '$2y$10$X1QMNdzdq0Tl5GhKVtRij.wrOss92nXOKv.vzvMAzuCbeZSlNUqge'),
(2, 'Щербаков Данил Александрович', '+7(961)-445-71-74', 'mrice7773@gmail.com', 'Данил435', '$2y$10$jLA7LDQNstlghIzsC4Twn.ECPoC9lt9LHkFuL9Sf1I5cdESwKvE0C'),
(5, 'Щербаков Данил Александрович', '+7(961)-445-71-71', 'mrice7771@gmail.com', 'Данил43', '$2y$10$86uNlixUGu9h1AuLSA/Pzuq6HGzM7bE85KIQW1UzjfQKB.BP.DFey'),
(6, 'Щербаков Данил Александрович', '+7(961)-445-71-71', 'mrice7770@gmail.com', 'Данил431231321', '$2y$10$RKh2gRIWOqoIBdhn5kaZCOd.TfWqSGJeRHupZ6xuTLgwxlu6Bj/dG'),
(7, 'Щербаков Данил Александрович', '+7(961)-445-71-71', 'mrice77741@gmail.com', 'Данил555', '$2y$10$z6Hz5ae7cJXa6/R6ycsz3e1VDKMrYUg8QKb8W/ZI8ZMZWqJnjOb9W');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
