-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 25-12-13 11:36
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `studymate_db`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `board`
--

CREATE TABLE `board` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `regdate` datetime DEFAULT current_timestamp(),
  `views` int(11) NOT NULL DEFAULT 0,
  `filename` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `is_hidden` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board`
--

INSERT INTO `board` (`id`, `username`, `title`, `content`, `regdate`, `views`, `filename`, `filepath`, `is_hidden`) VALUES
(3, 'sjosjo', '박정원', '귀엽네', '2025-12-12 14:29:06', 10, NULL, NULL, 0),
(4, 'sjosjo', '1', '도깨비', '2025-12-12 15:17:17', 9, NULL, NULL, 0),
(5, 'sjosjo', '2', '보는 중인데', '2025-12-12 15:17:33', 2, NULL, NULL, 0),
(6, 'sjosjo', '3', '이거 은근 재밌네', '2025-12-12 15:17:46', 0, NULL, NULL, 0),
(7, 'sjosjo', '5', '이거 칼 뽑힐 뻔 한 장면이네\r\n', '2025-12-12 15:18:06', 2, NULL, NULL, 0),
(8, 'sjosjo', '6', '이제 가슴 아파한다', '2025-12-12 15:18:18', 8, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `regdate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `comments`
--

INSERT INTO `comments` (`id`, `board_id`, `username`, `content`, `regdate`) VALUES
(3, 3, 'sjo5', '선 넘지 마라', '2025-12-12 14:56:16'),
(4, 4, 'sjosjo', '됐나', '2025-12-12 15:49:48');

-- --------------------------------------------------------

--
-- 테이블 구조 `guestbook`
--

CREATE TABLE `guestbook` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `regdate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `guestbook`
--

INSERT INTO `guestbook` (`id`, `username`, `message`, `regdate`) VALUES
(3, 'sjo2', '안녕', '2025-12-11 13:48:47'),
(6, 'sjo2', '이제 안 뜬다 아이디 바꾸면', '2025-12-11 13:54:10'),
(7, 'sjosjo', '어렵다', '2025-12-12 10:54:51'),
(8, 'sjo2', '😊', '2025-12-13 16:14:38');

-- --------------------------------------------------------

--
-- 테이블 구조 `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `regdate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `likes`
--

INSERT INTO `likes` (`id`, `board_id`, `username`, `regdate`) VALUES
(2, 8, 'sjosjo', '2025-12-12 23:41:30'),
(3, 7, 'sjo2', '2025-12-13 06:23:48');

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` varchar(10) DEFAULT 'user',
  `regdate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `regdate`) VALUES
(1, 'sjo', '$2y$10$gP7iZ0tolXARKab8n5VcW.yXBdoKSTwH77gehSWsqCFYSf/IcN0pa', 'sjo@hanmail.net', 'admin', '2025-12-11 12:02:00'),
(3, 'sjo2', '$2y$10$piJWp8Rs6slSN2eXXNWMq.i3l9fHUEP0e/T2rxbYBouA/xXWFAIoO', 'sjo2@gmail.com', 'admin', '2025-12-11 12:03:10'),
(4, 'sjo5', '$2y$10$ElFiaLNWO2njB1Fn71IIyujmCo.UENYbYjyKpbBRAjJ8hJMS8PbgG', 'sjo5@naver.com', 'admin', '2025-12-11 13:51:18'),
(5, 'sjosjo', '$2y$10$gP/.3Q4KBy5UK7Y6Af7G1eLxPAYqxa38clcg/7sUy64WT0Jp539Au', 'sjosjo@gogo.com', 'admin', '2025-12-12 10:54:01');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `guestbook`
--
ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `board_id` (`board_id`,`username`);

--
-- 테이블의 인덱스 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `board`
--
ALTER TABLE `board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 테이블의 AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 테이블의 AUTO_INCREMENT `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
