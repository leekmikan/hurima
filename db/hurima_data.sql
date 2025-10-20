-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-10-20 06:09:56
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `hurima_data`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `forget`
--

CREATE TABLE `forget` (
  `f_id` int(11) NOT NULL,
  `id` int(12) NOT NULL,
  `pass` char(12) NOT NULL,
  `tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(12) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `price` int(7) NOT NULL,
  `src0` varchar(256) NOT NULL,
  `src1` varchar(256) NOT NULL,
  `src2` varchar(256) NOT NULL,
  `src3` varchar(256) NOT NULL,
  `src4` varchar(256) NOT NULL,
  `exp` varchar(1200) NOT NULL,
  `genre` int(2) DEFAULT NULL,
  `stat` int(2) DEFAULT NULL,
  `hsend` int(2) DEFAULT NULL,
  `user_id` int(12) DEFAULT NULL,
  `buy_id` int(12) DEFAULT NULL,
  `judge` int(1) DEFAULT NULL,
  `reason` varchar(400) DEFAULT NULL,
  `buy_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `msg`
--

CREATE TABLE `msg` (
  `id` int(12) NOT NULL,
  `buy_id` int(12) NOT NULL,
  `item_id` int(12) NOT NULL,
  `send_id` int(12) NOT NULL,
  `txt` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `rd` tinyint(1) NOT NULL,
  `tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `opinion`
--

CREATE TABLE `opinion` (
  `id` int(12) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `opinion` varchar(400) NOT NULL,
  `tm` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `opinion`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `report`
--

CREATE TABLE `report` (
  `id` int(12) NOT NULL,
  `who` int(12) NOT NULL,
  `item_id` int(12) NOT NULL,
  `reason` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `user_name` char(32) NOT NULL,
  `sei` char(10) NOT NULL,
  `mei` char(10) NOT NULL,
  `mail` char(64) NOT NULL,
  `pass` char(12) NOT NULL,
  `history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `adress_num` char(8) NOT NULL,
  `adress` varchar(1024) NOT NULL,
  `birth` char(10) NOT NULL,
  `msg` varchar(1600) DEFAULT NULL,
  `cart` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `points` int(7) DEFAULT 0,
  `hidden_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `s_id` varchar(32) DEFAULT NULL,
  `tmp` varchar(48) DEFAULT NULL,
  `frag` smallint(5) NOT NULL,
  `sub` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `forget`
--
ALTER TABLE `forget`
  ADD PRIMARY KEY (`f_id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `opinion`
--
ALTER TABLE `opinion`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `forget`
--
ALTER TABLE `forget`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- テーブルの AUTO_INCREMENT `msg`
--
ALTER TABLE `msg`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- テーブルの AUTO_INCREMENT `opinion`
--
ALTER TABLE `opinion`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- テーブルの AUTO_INCREMENT `report`
--
ALTER TABLE `report`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
