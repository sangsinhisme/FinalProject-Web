-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 13, 2022 lúc 02:47 PM
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
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dayoff` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `activated`, `role`, `name`, `gender`, `phone`, `mail`, `position`, `department`, `avatar`, `dayoff`) VALUES
(1, 'admin', '$2y$10$rqEbk41xz4WVGMKZ224rxusVZaeUnnRoZ6bWk2ytCOTzKLUMKgGOO', b'1', 3, 'Nguyen Huu Huy', 'Nam', '0869719487', 'huuhuy@gmail.com', 'Giám đốc', '', 'samsung-galaxy-a22-6gb-128gb-tim-1.jpg', 0),
(7, 'sangsinh', '$2y$10$qh2R1.ro/QaA8PM56TaaKeGxymjPUtTKz3FRNL2BVpb9e7BrRPn1m', b'1', 2, 'Nguyễn Sang Sinh', 'Nam', '0869719487', 'sangsinh@gmail.com', 'Trưởng phòng', 'Phát triển phần mềm', 'image_dc6c4fc3a2.png', 4),
(12, 'tommy', '$2y$10$TvbNfugd6I0ZRq5gqxcnTu1Wj5aatJRDLEf3mBD2WOWHHrfOxJ7XG', b'1', 1, 'Thạch Thanh Hữu', 'Nam', '0869719487', 'conchimnonbietbay@gmail.com', 'Nhân viên', 'Phát triển phần mềm', 'avatar.jpg', 2),
(13, 'tommy2', '$2y$10$SGANc9V9uP.GWONUqY8egOx5l/OZ/LUeQowA18/STnMJVS0otS5p6', b'0', 1, 'Nguyễn Văn Bé', 'Nam', '0869719487', 'vanbe@gmail.com', 'Nhân viên', 'Phát triển phần mềm', 'avatar.jpg', 0),
(14, 'lethibe', '$2y$10$9s2/2rSVLIscTbkhcfj42uf/UpyTa7BWXxottOjoFKQpxICZg34Ci', b'0', 1, 'Lê Thị Bé', 'Nữ', '0869131245', 'beba@gmail.com', 'Nhân viên', 'Kiểm thử phần mềm', 'avatar.jpg', 0),
(15, 'vandat113', '$2y$10$tX6IPudYMZ1QITm5JpgQVO7xnNjo/N61OrNAx5Ma36hiDg2IdqYKK', b'0', 1, 'Lê Văn Đạt', 'Nam', '086214125', 'vandat11@gmail.com', 'Nhân viên', 'Kiểm thử phần mềm', 'avatar.jpg', 0),
(16, 'tranmy11', '$2y$10$7U7TKjV.VWyEgQyGXhPAF.tOa18eSwumD5e3Swqve1kRFOG7pUlGG', b'0', 1, 'Trần Thị Diễm My', 'Nữ', '086974125', 'diemmy12@gmail.com', 'Nhân viên', 'Triển khai phần mềm', 'avatar.jpg', 0),
(17, 'vanduc86', '$2y$10$9J2IyEgjh5ebmYjwAOc5/Oan91468GR.8psI5FLiXc6xmb4FiIuXy', b'0', 1, 'Trần Văn Đức', 'Nam', '0128215892', 'duccong@gmail.com', 'Nhân viên', 'Triển khai phần mềm', 'avatar.jpg', 0),
(18, 'huudo12', '$2y$10$1MLRDTYyPzptPN1CY7eGV.YAIsIT7pK3fSYFBkaP1C1S1BT04DTZC', b'0', 2, 'Trần Hữu Lượng', 'Nam', '04125215166', 'luong22@gmail.com', 'Trưởng phòng', 'Triển khai phần mềm', 'avatar.jpg', 0),
(19, 'hoxung12', '$2y$10$zqo8E2nMgVlrgEP1kFEMw.zZLcYtOcJ5aVZzErxQgeB9kSUomSqCW', b'0', 1, 'Lệnh Hồ Xung', 'Nam', '07452107527', 'tieungaogiangho@gmail.com', 'Nhân viên', 'Phát triển phần mềm', 'avatar.jpg', 0),
(20, 'voky113', '$2y$10$ZYMjejO3b4Tq9EvbA3yzse6.NHDhPk2QzW7a1/cIfFi3l.NMXPgKO', b'0', 1, 'Trương Vô Kỵ', 'Nam', '02747274027', 'dolongky@gmail.com', 'Nhân viên', 'Kiểm thử phần mềm', 'avatar.jpg', 0),
(25, 'tieubao21', '$2y$10$KZ2XTN94AQdIYmZByzeg9OylhbnqbgTlGXz41abJhM3AiiaJq51wW', b'0', 2, 'Vi Tiểu Bảo', 'Nam', '0249120849', 'tieubao@gmail.com', 'Trưởng phòng', 'Kiểm thử phần mềm', 'avatar.jpg', 17);

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
(1, 'Phát triển phần mềm', 'Phòng có chức năng phát triển, quản lý sửa chữa bảo trì các phần mềm', 7, 'sangsinh'),
(21, 'Kiểm thử phần mềm', 'Phòng có chức năng kiểm thử các phần mềm trước khi đem đi triền khai', 5, 'tieubao21'),
(22, 'Triển khai phần mềm', 'Phòng có chức năng deploy sản phẩm đến khách hàng', 6, 'huudo12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `requestabsence`
--

CREATE TABLE `requestabsence` (
  `id` int(11) NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `dayAbsence` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `expire_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `requestabsence`
--

INSERT INTO `requestabsence` (`id`, `username`, `department`, `role`, `dayAbsence`, `reason`, `file`, `status`, `date`, `expire_on`) VALUES
(1, 'sangsinh', '', 2, 2, 'dasfsaf', '1.1-1.4 (1).docx', 'waiting', '2022-01-13 09:00:10', NULL),
(2, 'sangsinh', 'Phát triển phần mềm', 2, 4, 'saffa', '', 'waiting', '2022-01-13 09:01:07', NULL),
(3, 'tommy', '', 2, 2, 'abc', '', 'approved', '2022-01-13 09:02:03', 1642076917),
(5, 'concac', '', 2, 12, 'thich', 'fsaf', 'approved', '2022-01-13 10:19:42', NULL),
(6, 'cailoz', '', 2, 12, 'thich', 'fsaf', 'refused', '2022-01-13 10:19:45', NULL),
(7, 'tieubao21', '', 2, 12, 'thich', 'fsaf', 'approved', '2022-01-13 10:19:50', NULL),
(8, 'sangsinh', 'Phát triển phần mềm', 1, 2, 'asfasf', 'fasfa', 'approved', '2022-01-13 12:57:25', NULL),
(9, 'voki21', 'Phát triển phần mềm', 1, 2, 'dasfd', 'fsafa', 'refused', '2022-01-13 14:01:07', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task`
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
-- Đang đổ dữ liệu cho bảng `task`
--

INSERT INTO `task` (`id`, `name`, `employee`, `deadline`, `deadtime`, `describ`, `file`, `process`, `feedback`, `file_submit`, `rating`) VALUES
(15, 'dadsa', 'Nguyễn Sang Sinh', '2022-01-12', '11:59', 'fsafa', '1.1-1.4 (1).docx', 'task-new', NULL, NULL, NULL);

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
-- Chỉ mục cho bảng `requestabsence`
--
ALTER TABLE `requestabsence`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `requestabsence`
--
ALTER TABLE `requestabsence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
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

