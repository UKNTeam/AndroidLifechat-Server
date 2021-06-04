-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 03, 2021 lúc 02:31 PM
-- Phiên bản máy phục vụ: 10.4.14-MariaDB
-- Phiên bản PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lifechat`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_accounts`
--

CREATE TABLE `table_accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `table_accounts`
--

INSERT INTO `table_accounts` (`id`, `username`, `email`, `fullname`, `password`, `api_key`, `create_date`) VALUES
(6, 'Ily1606', 'khuonmatdangthuong45@gmail.com', 'Nguyễn Tường Nguyên', '6d590d0d8702e8132a77913bf707de45', 'EAAq2TEm4zYO3vrvgDPrIkon6I2w', '2021-05-17 07:45:13'),
(7, 'Ily1606-test', 'no1.ily1606@gmail.com', 'Tường Nguyên', '6d590d0d8702e8132a77913bf707de45', 'EAApBGFdgl7ouRn1WW7XBakllFjh', '2021-05-27 13:52:00'),
(8, 'HuyMagic', 'duchuy.12012001@gmail.com', 'Đức Huy', '6d590d0d8702e8132a77913bf707de45', 'EAAYAtnXTekRMEK9qk3BUWdnnKh8', '2021-06-02 14:55:28'),
(9, 'tester', 'tester@lifechat.com', 'Tester Lifechat', '25f9e794323b453885f5181f1b624d0b', 'EAAWs5ufBQFOxSXS2nl69412Udpv', '2021-06-03 04:04:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_attachments`
--

CREATE TABLE `table_attachments` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filetype` varchar(30) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `urlfile` varchar(255) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `table_attachments`
--

INSERT INTO `table_attachments` (`id`, `filename`, `filetype`, `owner`, `urlfile`, `create_time`) VALUES
(10, 'IMG_UPLOAD_20210528_173703.jpg', 'image', 6, '/storage/public/fileupload_1622383861.jpg', '2021-05-30 14:11:01'),
(11, 'IMG_UPLOAD_20210528_173742.jpg', 'image', 6, '/storage/public/fileupload_1622383962.jpg', '2021-05-30 14:12:42'),
(12, 'Screenshot_2021-05-30-14-22-07-191_com.vanced.android.youtube.jpg', 'image', 6, '/storage/public/fileupload_1622387967.jpg', '2021-05-30 15:19:27'),
(13, 'Screenshot_2021-05-24-11-40-58-213_com.lilithgame.roc.gp.jpg', 'image', 6, '/storage/public/fileupload_1622387998.jpg', '2021-05-30 15:19:58'),
(14, 'Snaptik_6956853169993321729_hoanhtinh38.mp4', 'video', 6, '/storage/public/fileupload_1622389229.mp4', '2021-05-30 15:40:29'),
(15, 'FB_IMG_1600507410124.jpg', 'image', 6, '/storage/public/fileupload_1622389283.jpg', '2021-05-30 15:41:23'),
(16, 'Snaptik_6956853169993321729_hoanhtinh38.mp4', 'video', 6, '/storage/public/fileupload_1622392349.mp4', '2021-05-30 16:32:29'),
(17, 'Nhóm máu.mp4', 'video', 6, '/storage/public/fileupload_1622425871.mp4', '2021-05-31 01:51:11'),
(18, 'Nhóm máu.mp4', 'video', 6, '/storage/public/fileupload_1622425945.mp4', '2021-05-31 01:52:25'),
(31, 'IMG_UPLOAD_20210528_173742.jpg', 'image', 6, '/storage/public/fileupload_1622429684.jpg', '2021-05-31 02:54:44'),
(32, 'Một Mình Có Buồn Không', 'file', 6, '/storage/public/fileupload_1622429854.unknow', '2021-05-31 02:57:34'),
(33, 'Kho Ve Nu Cuoi', 'file', 6, '/storage/public/fileupload_1622430588.unknow', '2021-05-31 03:09:48'),
(34, '62.0.1592821355237.v3.mp4', 'video', 6, '/storage/public/fileupload_1622433544.mp4', '2021-05-31 03:59:04'),
(35, 'Screenshot_2021-06-02-12-15-49-806_com.example.lifechat.jpg', 'image', 6, '/storage/public/fileupload_1622714884.jpg', '2021-06-03 10:08:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_messages`
--

CREATE TABLE `table_messages` (
  `id` int(11) NOT NULL,
  `id_thread` int(11) DEFAULT NULL,
  `user_send` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachment_id` int(11) NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `create_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `table_messages`
--

INSERT INTO `table_messages` (`id`, `id_thread`, `user_send`, `message`, `attachment_id`, `options`, `create_time`) VALUES
(6, 2, 6, '', 0, '{\"type\":\"like\"}', '2021-05-30 13:49:33'),
(7, 2, 6, NULL, 11, '{\"type\":\"file\"}', '2021-05-30 14:12:42'),
(8, 2, 6, 'kkk', 0, '{\"type\":\"text\"}', '2021-05-30 14:31:09'),
(9, 2, 6, NULL, 12, '{\"type\":\"file\"}', '2021-05-30 15:19:27'),
(10, 2, 6, NULL, 13, '{\"type\":\"file\"}', '2021-05-30 15:19:58'),
(11, 2, 6, NULL, 14, '{\"type\":\"file\"}', '2021-05-30 15:40:29'),
(12, 2, 6, NULL, 15, '{\"type\":\"file\"}', '2021-05-30 15:41:23'),
(13, 2, 6, NULL, 16, '{\"type\":\"file\"}', '2021-05-30 16:32:29'),
(14, 2, 6, NULL, 18, '{\"type\":\"file\"}', '2021-05-31 01:52:25'),
(15, 2, 6, 'kkk', 0, '{\"type\":\"text\"}', '2021-05-31 02:46:25'),
(16, 2, 6, NULL, 31, '{\"type\":\"file\"}', '2021-05-31 02:54:44'),
(17, 2, 6, NULL, 32, '{\"type\":\"file\"}', '2021-05-31 02:57:34'),
(18, 2, 6, NULL, 33, '{\"type\":\"file\"}', '2021-05-31 03:09:48'),
(19, 2, 7, 'good', 0, '{\"type\":\"text\"}', '2021-05-31 03:37:49'),
(20, 2, 6, NULL, 34, '{\"type\":\"file\"}', '2021-05-31 03:59:04'),
(21, 2, 6, '', 0, '{\"type\":\"like\"}', '2021-06-01 12:16:54'),
(22, 2, 6, '', 0, '{\"type\":\"like\"}', '2021-06-01 13:12:36'),
(23, 2, 6, 'hi', 0, '{\"type\":\"text\"}', '2021-06-02 08:53:16'),
(24, 2, 7, '', 0, '{\"type\":\"like\"}', '2021-06-02 08:54:12'),
(25, 2, 6, '', 0, '{\"type\":\"like\"}', '2021-06-02 08:58:34'),
(26, 2, 6, '', 0, '{\"type\":\"like\"}', '2021-06-02 08:59:38'),
(27, 2, 6, '', 0, '{\"type\":\"like\"}', '2021-06-02 09:03:41'),
(28, 2, 7, 'hello', 0, '{\"type\":\"text\"}', '2021-06-02 09:03:53'),
(29, 6, 6, '', 0, '{\"type\":\"like\"}', '2021-06-02 14:57:29'),
(30, 6, 6, '', 0, '{\"type\":\"like\"}', '2021-06-02 15:00:23'),
(31, 6, 8, 'ok', 0, '{\"type\":\"text\"}', '2021-06-02 15:00:56'),
(32, 6, 6, '=))', 0, '{\"type\":\"text\"}', '2021-06-02 15:01:13'),
(33, 6, 6, '', 0, '{\"type\":\"like\"}', '2021-06-02 15:01:19'),
(34, 7, 6, '', 0, '{\"type\":\"like\"}', '2021-06-03 04:38:12'),
(35, 2, 6, '', 0, '{\"type\":\"like\"}', '2021-06-03 04:38:45'),
(36, 6, 8, '', 0, '{\"type\":\"like\"}', '2021-06-03 04:45:39'),
(37, 6, 6, '', 0, '{\"type\":\"like\"}', '2021-06-03 04:46:05'),
(38, 6, 8, '', 0, '{\"type\":\"like\"}', '2021-06-03 04:46:07'),
(39, 6, 6, 'alo', 0, '{\"type\":\"text\"}', '2021-06-03 04:46:13'),
(40, 6, 8, 'nice', 0, '{\"type\":\"text\"}', '2021-06-03 04:46:26'),
(41, 6, 6, '', 0, '{\"type\":\"like\"}', '2021-06-03 09:04:48'),
(42, 6, 6, '', 0, '{\"type\":\"like\"}', '2021-06-03 09:21:01'),
(43, 6, 6, '', 0, '{\"type\":\"like\"}', '2021-06-03 09:31:42'),
(44, 6, 8, 'alo', 0, '{\"type\":\"text\"}', '2021-06-03 10:07:34'),
(45, 6, 6, 'ni hảo', 0, '{\"type\":\"text\"}', '2021-06-03 10:07:42'),
(46, 6, 8, 'XD ', 0, '{\"type\":\"text\"}', '2021-06-03 10:07:56'),
(47, 6, 6, NULL, 35, '{\"type\":\"file\"}', '2021-06-03 10:08:04'),
(48, 6, 8, '', 0, '{\"type\":\"like\"}', '2021-06-03 10:08:11'),
(49, 6, 6, '', 0, '{\"type\":\"like\"}', '2021-06-03 10:08:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_threads`
--

CREATE TABLE `table_threads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_id_invite` int(11) DEFAULT NULL,
  `last_update` bigint(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `table_threads`
--

INSERT INTO `table_threads` (`id`, `user_id`, `user_id_invite`, `last_update`, `create_time`) VALUES
(2, 6, 7, NULL, '2021-05-28 12:02:21'),
(6, 6, 8, NULL, '2021-06-02 14:57:27'),
(7, 6, 9, NULL, '2021-06-03 04:06:17');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `table_accounts`
--
ALTER TABLE `table_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_key_2` (`api_key`),
  ADD KEY `api_key` (`api_key`);

--
-- Chỉ mục cho bảng `table_attachments`
--
ALTER TABLE `table_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_messages`
--
ALTER TABLE `table_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_thread` (`id_thread`,`user_send`),
  ADD KEY `user_send` (`user_send`),
  ADD KEY `attachment_id` (`attachment_id`);

--
-- Chỉ mục cho bảng `table_threads`
--
ALTER TABLE `table_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`user_id_invite`),
  ADD KEY `user_id_invite` (`user_id_invite`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `table_accounts`
--
ALTER TABLE `table_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `table_attachments`
--
ALTER TABLE `table_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `table_messages`
--
ALTER TABLE `table_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `table_threads`
--
ALTER TABLE `table_threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `table_messages`
--
ALTER TABLE `table_messages`
  ADD CONSTRAINT `table_messages_ibfk_1` FOREIGN KEY (`user_send`) REFERENCES `table_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `table_messages_ibfk_2` FOREIGN KEY (`id_thread`) REFERENCES `table_threads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `table_threads`
--
ALTER TABLE `table_threads`
  ADD CONSTRAINT `table_threads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `table_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `table_threads_ibfk_2` FOREIGN KEY (`user_id_invite`) REFERENCES `table_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
