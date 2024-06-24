-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 11:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asset_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `asset_id` int(11) NOT NULL,
  `asset_brandname` varchar(50) NOT NULL,
  `asset_type` varchar(50) NOT NULL,
  `barcode_number` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `dp_year` int(11) DEFAULT NULL,
  `depreciation_value` decimal(10,2) DEFAULT NULL,
  `purchase_date` varchar(20) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `archived` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`asset_id`, `asset_brandname`, `asset_type`, `barcode_number`, `description`, `purchase_price`, `dp_year`, `depreciation_value`, `purchase_date`, `location_id`, `status`, `archived`) VALUES
(1, 'HP LaserJet Pro M404dn', 'Printer', '1234567890123', 'A fast, high-quality monochrome laser printer ideal for small to medium-sized businesses.', 15000.00, 3, 13750.00, '2024-05-24', 1, 'Maintenance(In Used)', 'Unarchived'),
(2, 'Canon PIXMA G6020', 'Printer', '2345678901234', 'An all-in-one inkjet printer with refillable ink tanks, perfect for high-volume printing needs.', 12500.00, 3, 12500.00, '2024-05-24', 1, 'Damaged', 'Unarchived'),
(3, 'Logitech', 'Mouse', '12345678901231', 'Wireless optical mouse, ergonomic design', 1200.00, 2, 1100.00, '2024-05-26', 1, 'Maintenance(In Used)', 'Unarchived'),
(4, 'Razer', 'Keyboard', '23456789012345', 'Mechanical gaming keyboard, RGB backlit', 5000.00, 3, 5000.00, '2024-05-26', 1, 'Not Used', 'Unarchived'),
(5, 'Dell', 'Monitor', '3456789012345', '24-inch LED monitor, Full HD resolution', 7500.00, 3, 7500.00, '2024-05-26', 1, 'Not Used', 'Unarchived'),
(6, 'HP', 'System Unit', '4567890123456', 'Desktop computer with Intel i5, 8GB RAM', 35000.00, 3, 35000.00, '2024-05-26', 1, 'Not Used', 'Unarchived'),
(7, 'Canon', 'Printer', '5678901234567', 'All-in-one inkjet printer, WiFi enabled', 6000.00, 3, 6000.00, '2024-05-26', 1, 'Not Used', 'Unarchived');

-- --------------------------------------------------------

--
-- Table structure for table `assets_assignments`
--

CREATE TABLE `assets_assignments` (
  `assets_assign_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `depreciation_value` decimal(10,2) DEFAULT NULL,
  `assign_date` varchar(50) NOT NULL,
  `return_date` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `archived` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets_assignments`
--

INSERT INTO `assets_assignments` (`assets_assign_id`, `asset_id`, `emp_id`, `depreciation_value`, `assign_date`, `return_date`, `status`, `archived`) VALUES
(10, 1, 2, 13750.00, '2024-08-25', NULL, 'Maintenance(In Used)', 'Unarchived'),
(15, 2, 3, 12500.00, '2024-05-26', NULL, 'Damaged', 'Unarchived'),
(16, 3, 2, 1100.00, '2024-05-28', NULL, 'Maintenance(In Used)', 'Unarchived');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(50) NOT NULL,
  `archived` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `dept_name`, `archived`) VALUES
(1, 'Sales Department', NULL),
(2, 'Parts Department', NULL),
(3, 'Service Department', NULL),
(4, 'IT Department', NULL),
(5, 'Accounting Department', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `emp_no` varchar(20) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `contact_no` varchar(30) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `hired_date` varchar(20) DEFAULT NULL,
  `resigned_date` varchar(20) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `archived` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `emp_no`, `fname`, `mname`, `lname`, `gender`, `contact_no`, `location_id`, `position_id`, `dept_id`, `hired_date`, `resigned_date`, `status`, `archived`) VALUES
(1, 'ADMIN', 'admin', NULL, 'admin', 'none', '123', 1, 7, NULL, NULL, NULL, NULL, NULL),
(2, 'EMP-001', 'Sean Grey', 'B', 'Lapiceros', 'Male', '09942167592', 1, 1, 4, '2024-05-24', NULL, 'Employed', 'Unarchived'),
(3, 'EMP-002', 'Mark Anthony', '', 'Del Sol', 'Male', '0981238213', 1, 1, 4, '2024-05-24', NULL, 'Employed', 'Unarchived');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `address`) VALUES
(1, 'Mitsubishi General Santos City'),
(2, 'Mitsubishi Kidapawan City'),
(3, 'Hyundai General Santos City'),
(4, 'Changan General Santos City');

-- --------------------------------------------------------

--
-- Table structure for table `log_maintenance`
--

CREATE TABLE `log_maintenance` (
  `log_m` int(11) NOT NULL,
  `asset_brandname` varchar(50) DEFAULT NULL,
  `asset_type` varchar(50) DEFAULT NULL,
  `barcode_number` varchar(255) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_maintenance`
--

INSERT INTO `log_maintenance` (`log_m`, `asset_brandname`, `asset_type`, `barcode_number`, `value`, `status`, `datetime`) VALUES
(24, 'Canon PIXMA G6020', 'Printer', '2345678901234', 12500.00, 'Maintenance', '2024-05-25 17:22:46'),
(25, 'Canon PIXMA G6020', 'Printer', '2345678901234', 0.00, 'Maintenance', '2024-05-25 17:22:56'),
(26, 'Canon PIXMA G6020', 'Printer', '2345678901234', 0.00, 'Repaired', '2024-05-25 17:23:09'),
(27, 'Canon PIXMA G6020', 'Printer', '2345678901234', 0.00, 'Repaired', '2024-05-25 17:26:29'),
(28, 'Canon PIXMA G6020', 'Printer', '2345678901234', 0.00, 'Damaged', '2024-05-25 17:28:05'),
(29, 'Canon PIXMA G6020', 'Printer', '2345678901234', 0.00, 'Maintenance', '2024-05-25 17:31:30'),
(30, 'Canon PIXMA G6020', 'Printer', '2345678901234', 0.00, 'Maintenance', '2024-05-25 17:35:13'),
(31, 'Canon PIXMA G6020', 'Printer', '2345678901234', 0.00, 'Maintenance', '2024-05-25 17:50:39'),
(32, 'Canon PIXMA G6020', 'Printer', '2345678901234', 0.00, 'Maintenance', '2024-05-25 17:53:02'),
(33, 'Canon PIXMA G6020', 'Printer', '2345678901234', 12500.00, 'Maintenance', '2024-05-25 17:53:38'),
(34, 'Canon PIXMA G6020', 'Printer', '2345678901234', 12500.00, 'Damaged', '2024-05-25 06:59:55'),
(35, 'HP LaserJet Pro M404dn', 'Printer', '1234567890123', 15000.00, 'Maintenance', '2024-05-25 07:20:24'),
(36, 'Logitech', 'Mouse', '12345678901231', 1200.00, 'Maintenance', '2024-07-28 09:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `maintenance_id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `maintenance_date` varchar(20) NOT NULL,
  `repaired_date` varchar(20) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `archived` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`maintenance_id`, `asset_id`, `maintenance_date`, `repaired_date`, `status`, `archived`) VALUES
(13, 2, '2024-05-26', '2024-05-27', 'Damaged', 'Unarchived'),
(14, 1, '2024-05-25', NULL, 'Maintenance', 'Unarchived'),
(15, 3, '2024-07-28', NULL, 'Maintenance', 'Unarchived');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `position_name`) VALUES
(1, 'Intern'),
(2, 'Supervisor'),
(3, 'SA'),
(4, 'Agent'),
(5, 'IT'),
(7, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `emp_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `emp_id`) VALUES
(3, 'administrator', '$2y$10$4s0Q8YVahce0o7AQf1XM1O/fwYY9qLDWO8b099HEQuAJzyJs4d4m.', 1),
(4, 'sean', '$2y$10$rJVpZNmCBJUhZB.K0d85jekxMH4YteQ7NVUkAPOcHBIPiLW34V7Fu', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`asset_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `assets_assignments`
--
ALTER TABLE `assets_assignments`
  ADD PRIMARY KEY (`assets_assign_id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `log_maintenance`
--
ALTER TABLE `log_maintenance`
  ADD PRIMARY KEY (`log_m`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`maintenance_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `assets_assignments`
--
ALTER TABLE `assets_assignments`
  MODIFY `assets_assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log_maintenance`
--
ALTER TABLE `log_maintenance`
  MODIFY `log_m` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `assets_assignments`
--
ALTER TABLE `assets_assignments`
  ADD CONSTRAINT `assets_assignments_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assets_assignments_ibfk_3` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`position_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_ibfk_3` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
