-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 10, 2022 lúc 01:07 PM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `project`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activated` bit(1) DEFAULT b'0',
  `role` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `activated`, `role`, `name`, `gender`, `phone`, `mail`, `position`, `department`, `avatar`) VALUES
(1, 'admin', '$2y$10$rqEbk41xz4WVGMKZ224rxusVZaeUnnRoZ6bWk2ytCOTzKLUMKgGOO', b'1', 3, 'Nguyen Huu Huy', 'Nam', '0869719487', 'huuhuy@gmail.com', 'Giám đốc', '', 'image_dc6c4fc3a2.png'),
(2, 'sangsinh', '$2y$10$M.2/NcMue6QZD0TsgCEciuErQdYnP6eMFIGN2cB8Q5V4sI7PiyDRG', b'1', 2, 'Sang Sinh', 'Nữ', '0214885821', 'SangSinh@gmail.com', 'Trưởng phòng', 'Nhân sự', 'samsung-galaxy-a22-6gb-128gb-tim-1.jpg'),
(3, 'tommy', '$2y$10$/GsrhUpjbbNofQbItUW8CuaRawMxOTvPJGGKWbcmLhhMeJbO92arW', b'0', 2, 'Tommy Thach', 'Nam', '0869719487', 'conchimnonbietbay@gmail.com', 'Trưởng phòng', 'Kế toán', 'avatar.jpg'),
(4, 'tommy2', '$2y$10$qVLJJ1emdp7cRKW5XC2tFOiUzH0Rfrnjx6zcTTwPfwwMh6aXmuVTe', b'0', 1, 'Tommy The', 'Nam', '0869719487', 'conchimnonbietbay@gmail.com', 'Nhân viên', 'Công nghệ thông tin', 'avatar.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `departmentName` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room` int(11) DEFAULT NULL,
  `manager` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `department`
--

INSERT INTO `department` (`id`, `departmentName`, `description`, `room`, `manager`) VALUES
(1, 'Phát triển phần mềm', 'Phòng có chức năng phát triển, quản lý sửa chữa bảo trì các phần mềm', 6, 'sangsinh'),
(2, 'Kinh doanh', 'bbbbbb', 5, 'tommy');

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deadline` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deadtime` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `describ` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `process` varchar(28) COLLATE utf8_unicode_ci NOT NULL,
  `feedback` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_submit` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `employee`, `deadline`, `deadtime`, `describ`, `file`, `process`, `feedback`, `file_submit`, `rating`) VALUES
(1, 'Tác vụ 5', 'Nguyễn Sang Sinh', '2022-03-12', '11:59', 'Từ chối tá', 'Công nhân, tư sản, tiểu tư sản.docx//CHƯƠNG II - Nguyễn Sang Sinh.docx//Untitled.png', 'task-rejected', NULL, NULL, 'Good'),
(2, 'Làm chức năng thêm', 'Nguyễn Sang Sinh', '2022-01-08', '11:59', '', 'undefined', 'task-rejected', NULL, NULL, NULL),
(3, 'Một tác vụ nào đó', 'Nguyễn Sang Sinh', '2022-01-08', '11:59', '', '', 'task-waiting', NULL, NULL, NULL),
(4, 'Test', 'Nguyễn Sang Sinh', '2022-01-08', '11:59', '', '', 'task-canceled', NULL, NULL, NULL),
(5, 'Tác vụ 5', 'Nguyễn Sang Sinh', '2022-01-08', '11:59', '', '', 'task-canceled', NULL, NULL, NULL),
(6, 'Thử', 'Nguyễn Sang Sinh', '2022-01-08', '11:59', '', '', 'task-complete', NULL, NULL, 'Bad'),
(7, 'a', 'Nguyễn Sang Sinh', '2022-01-08', '11:59', '', '', 'task-canceled', NULL, NULL, NULL),
(8, 'Học tập và làm việc', 'Nguyễn Sang Sinh', '2022-01-22', '11:59', 'Một nội du', '', 'task-new', NULL, NULL, NULL),
(9, 'Thử thay đổi', 'Nguyễn Sang Sinh', '2022-01-08', '11:59', '', '', 'task-canceled', NULL, NULL, NULL),
(10, 'Một tác vụ nào đó 2', 'Thạch Thanh Hữu', '2024-06-08', '04:59', '', '191536412_1449087188774301_903634921363629977_n.jpg//182613654_238583281363756_4383219904183266255_n.jpg', 'task-rejected', NULL, NULL, 'Good'),
(11, 'Một tác vụ nào đó', 'Thạch Thanh Hữu', '2024-07-06', '17:00', '', '191536412_1449087188774301_903634921363629977_n.jpg//182613654_238583281363756_4383219904183266255_n.jpg', 'task-rejected', NULL, NULL, 'Good'),
(12, 'Tên ', 'Nguyễn Hữu Huy', '2022-01-11', '11:59', '', '', 'task-canceled', NULL, NULL, NULL),
(13, 'Tên ', 'Nguyễn Hữu Huy', '2022-01-11', '11:59', '', '', 'task-canceled', NULL, NULL, NULL),
(14, 'Tạo', 'Nguyễn Sang Sinh', '2022-01-11', '11:59', '', '', 'task-canceled', NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

