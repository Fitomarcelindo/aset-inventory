-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2024 at 10:10 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.24

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
  `area_id` int NOT NULL,
  `area_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `area_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`area_id`, `area_code`, `area_name`) VALUES
(1, 'asdsa', 'asdas'),
(2, '12', 'as'),
(3, '7282', 'aja'),
(4, '2342', 'dsfsd');

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `asset_id` int NOT NULL,
  `area_id` int DEFAULT NULL,
  `puserif_number` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `puslibtang_number` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `asset_class` int DEFAULT NULL,
  `acquisition_date` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `acquisition_value` int NOT NULL,
  `removed_date` date DEFAULT NULL,
  `lab_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`asset_id`, `area_id`, `puserif_number`, `puslibtang_number`, `name`, `status`, `description`, `asset_class`, `acquisition_date`, `location`, `acquisition_value`, `removed_date`, `lab_id`) VALUES
(1, 2, '423', '12312', '12312', 'removed', '12321', 123123, '2024-10-30', '123213', 0, '2024-10-31', 1),
(2, 3, '34543', '4354', '43456', 'idle', '435', 1, '2024-11-03', 'fgdf', 7686, NULL, 1),
(3, 3, '34543', '4354', '43456', 'idle', '435', 1, '2024-11-03', 'fgdf', 7686, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `asset_mutations`
--

CREATE TABLE `asset_mutations` (
  `mutation_id` int NOT NULL,
  `asset_id` int DEFAULT NULL,
  `mutation_date` date NOT NULL,
  `physical_mutation` int NOT NULL,
  `currency_mutation` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asset_mutations`
--

INSERT INTO `asset_mutations` (`mutation_id`, `asset_id`, `mutation_date`, `physical_mutation`, `currency_mutation`) VALUES
(604943, 1, '2024-11-03', 3409, 3238),
(604943, 2, '2024-11-03', 329928, 3829),
(604943, 3, '2024-11-03', 3289, 218);

-- --------------------------------------------------------

--
-- Table structure for table `asset_quantities`
--

CREATE TABLE `asset_quantities` (
  `asset_quantity_id` int NOT NULL,
  `asset_id` int DEFAULT NULL,
  `quantity_date` date NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_data`
--

CREATE TABLE `financial_data` (
  `financial_data_id` int NOT NULL,
  `asset_id` int DEFAULT NULL,
  `balance_date` date NOT NULL,
  `balance_quantity` int NOT NULL,
  `balance_value` int DEFAULT NULL,
  `acquisition_value` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_evaluations`
--

CREATE TABLE `inventory_evaluations` (
  `inventory_evaluation_id` int NOT NULL,
  `evaluation_date` date NOT NULL,
  `code_o` int DEFAULT '0',
  `code_d` int DEFAULT '0',
  `code_i` int DEFAULT '0',
  `code_u` int DEFAULT '0',
  `code_p` int DEFAULT '0',
  `code_t` int DEFAULT '0',
  `total` int GENERATED ALWAYS AS ((((((`code_o` + `code_d`) + `code_i`) + `code_u`) + `code_p`) + `code_t`)) STORED,
  `asset_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `lab_id` int NOT NULL,
  `lab_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`lab_id`, `lab_name`) VALUES
(1, '12312');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0'
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
  ADD KEY `area_id` (`area_id`),
  ADD KEY `lab_id` (`lab_id`);

--
-- Indexes for table `asset_mutations`
--
ALTER TABLE `asset_mutations`
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
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`lab_id`);

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
  MODIFY `area_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `asset_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `asset_quantities`
--
ALTER TABLE `asset_quantities`
  MODIFY `asset_quantity_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_data`
--
ALTER TABLE `financial_data`
  MODIFY `financial_data_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_evaluations`
--
ALTER TABLE `inventory_evaluations`
  MODIFY `inventory_evaluation_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labs`
--
ALTER TABLE `labs`
  MODIFY `lab_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `assets_ibfk_2` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`lab_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `asset_mutations`
--
ALTER TABLE `asset_mutations`
  ADD CONSTRAINT `asset_mutations_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `asset_quantities`
--
ALTER TABLE `asset_quantities`
  ADD CONSTRAINT `asset_quantities_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `financial_data`
--
ALTER TABLE `financial_data`
  ADD CONSTRAINT `financial_data_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `inventory_evaluations`
--
ALTER TABLE `inventory_evaluations`
  ADD CONSTRAINT `inventory_evaluations_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
