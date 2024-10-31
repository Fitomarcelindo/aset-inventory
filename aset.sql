-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2024 at 05:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aset`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `area_id` int(11) NOT NULL,
  `area_code` varchar(50) NOT NULL,
  `area_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`area_id`, `area_code`, `area_name`) VALUES
(1, 'asdsa', 'asdas'),
(2, '12', 'as');

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `asset_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `puserif_number` varchar(50) DEFAULT NULL,
  `puslibtang_number` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `asset_class` int(11) DEFAULT NULL,
  `acquisition_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `removed_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`asset_id`, `area_id`, `puserif_number`, `puslibtang_number`, `name`, `status`, `description`, `asset_class`, `acquisition_date`, `location`, `removed_date`) VALUES
(1, 2, '423', '12312', '12312', 'removed', '12321', 123123, '2024-10-30', '123213', '2024-10-31');

-- --------------------------------------------------------

--
-- Table structure for table `asset_mutations`
--

CREATE TABLE `asset_mutations` (
  `mutation_id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `mutation_date` date NOT NULL,
  `physical_mutation` int(11) NOT NULL,
  `currency_mutation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_quantities`
--

CREATE TABLE `asset_quantities` (
  `asset_quantity_id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `quantity_date` date NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_data`
--

CREATE TABLE `financial_data` (
  `financial_data_id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `balance_date` date NOT NULL,
  `balance_quantity` int(11) NOT NULL,
  `balance_value` int(11) DEFAULT NULL,
  `acquisition_value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_evaluations`
--

CREATE TABLE `inventory_evaluations` (
  `inventory_evaluation_id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_evaluations`
--

CREATE TABLE `report_evaluations` (
  `report_evaluation_id` int(11) NOT NULL,
  `inventory_evaluation_id` int(11) NOT NULL,
  `evaluation_date` date NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `address`, `is_admin`) VALUES
(1, 'jose', 'jose rafael', '$2y$10$xnzDMjhUtogWj.NLy.ZiKeMESs9c.pkM0EbK8P/ROnCbEyTmDxw8.', 'ashiap', 1),
(2, 'Adinda Shafira Sholihin', 'adindasfrs', '$2y$10$s9wBwFXtixDqI2RlNZhvTeMGE/DXNKa0sKcrgpvks258Mho8MESUe', 'Jakarta Barat', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`asset_id`),
  ADD KEY `area_id` (`area_id`);

--
-- Indexes for table `asset_mutations`
--
ALTER TABLE `asset_mutations`
  ADD PRIMARY KEY (`mutation_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `asset_quantities`
--
ALTER TABLE `asset_quantities`
  ADD PRIMARY KEY (`asset_quantity_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `financial_data`
--
ALTER TABLE `financial_data`
  ADD PRIMARY KEY (`financial_data_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `inventory_evaluations`
--
ALTER TABLE `inventory_evaluations`
  ADD PRIMARY KEY (`inventory_evaluation_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `report_evaluations`
--
ALTER TABLE `report_evaluations`
  ADD PRIMARY KEY (`report_evaluation_id`),
  ADD KEY `inventory_evaluation_id` (`inventory_evaluation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_mutations`
--
ALTER TABLE `asset_mutations`
  MODIFY `mutation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_quantities`
--
ALTER TABLE `asset_quantities`
  MODIFY `asset_quantity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_data`
--
ALTER TABLE `financial_data`
  MODIFY `financial_data_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_evaluations`
--
ALTER TABLE `inventory_evaluations`
  MODIFY `inventory_evaluation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`) ON DELETE SET NULL;

--
-- Constraints for table `asset_mutations`
--
ALTER TABLE `asset_mutations`
  ADD CONSTRAINT `asset_mutations_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE;

--
-- Constraints for table `asset_quantities`
--
ALTER TABLE `asset_quantities`
  ADD CONSTRAINT `asset_quantities_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE;

--
-- Constraints for table `financial_data`
--
ALTER TABLE `financial_data`
  ADD CONSTRAINT `financial_data_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_evaluations`
--
ALTER TABLE `inventory_evaluations`
  ADD CONSTRAINT `inventory_evaluations_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE;

--
-- Constraints for table `report_evaluations`
--
ALTER TABLE `report_evaluations`
  ADD CONSTRAINT `report_evaluations_ibfk_1` FOREIGN KEY (`inventory_evaluation_id`) REFERENCES `inventory_evaluations` (`inventory_evaluation_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
