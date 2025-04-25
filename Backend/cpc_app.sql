-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 25, 2025 at 05:26 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cpc_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_suggestions`
--

DROP TABLE IF EXISTS `announcement_suggestions`;
CREATE TABLE IF NOT EXISTS `announcement_suggestions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `suggestion` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcement_suggestions`
--

INSERT INTO `announcement_suggestions` (`id`, `staff_id`, `suggestion`, `created_at`) VALUES
(2, 1, 'Ramdan is on its way!!!', '2025-04-14 21:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `reason_for_visit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`appointment_id`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `date`, `time`, `status`, `reason_for_visit`) VALUES
(201, 4, 11, '2025-04-24', '09:00:00', 'Scheduled', 'Follow-up Consultation'),
(202, 5, 2, '2025-04-24', '10:00:00', 'Scheduled', 'Fever'),
(203, 6, 3, '2025-04-24', '11:00:00', 'Scheduled', 'Blood Pressure Check'),
(204, 4, 1, '2025-04-25', '09:30:00', 'Scheduled', 'Lab Results Review'),
(205, 5, 2, '2025-04-25', '10:30:00', 'Scheduled', 'Allergy Symptoms'),
(206, 6, 3, '2025-04-25', '11:30:00', 'Scheduled', 'Chronic Cough');

-- --------------------------------------------------------

--
-- Table structure for table `appointments_pt`
--

DROP TABLE IF EXISTS `appointments_pt`;
CREATE TABLE IF NOT EXISTS `appointments_pt` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `reason_for_visit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`appointment_id`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments_pt`
--

INSERT INTO `appointments_pt` (`appointment_id`, `patient_id`, `doctor_id`, `date`, `time`, `status`, `reason_for_visit`) VALUES
(201, 4, 1, '2025-04-24', '09:00:00', 'Scheduled', 'Follow-up Consultation'),
(202, 5, 2, '2025-04-24', '10:00:00', 'Scheduled', 'Fever'),
(203, 6, 3, '2025-04-24', '11:00:00', 'Scheduled', 'Blood Pressure Check'),
(204, 4, 1, '2025-04-25', '09:30:00', 'Scheduled', 'Lab Results Review'),
(205, 5, 2, '2025-04-25', '10:30:00', 'Scheduled', 'Allergy Symptoms'),
(206, 6, 3, '2025-04-25', '11:30:00', 'Scheduled', 'Chronic Cough');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `doctor_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  PRIMARY KEY (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `first_name`, `last_name`) VALUES
(1, 'Ibrahim', 'Mabrouki'),
(2, 'Layla', 'Farah'),
(3, 'Omar', 'Nassif'),
(11, 'Abullah', 'Jrad');

-- --------------------------------------------------------

--
-- Table structure for table `generated_lab_tests`
--

DROP TABLE IF EXISTS `generated_lab_tests`;
CREATE TABLE IF NOT EXISTS `generated_lab_tests` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hidden_records`
--

DROP TABLE IF EXISTS `hidden_records`;
CREATE TABLE IF NOT EXISTS `hidden_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hidden_records`
--

INSERT INTO `hidden_records` (`record_id`, `patient_id`, `doctor_id`, `type`, `content`, `created_at`) VALUES
(303, 6, 3, 'LabTest', 'Test: Lipid Panel\nReason: Check cholesterol\nInstructions: Fasting required', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

DROP TABLE IF EXISTS `medical_records`;
CREATE TABLE IF NOT EXISTS `medical_records` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `appointment_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=312 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`record_id`, `patient_id`, `doctor_id`, `type`, `content`, `created_at`, `appointment_id`) VALUES
(301, 4, 1, 'Medical', 'Diagnosis: Hypertension\nSymptoms: High blood pressure\nNotes: Regular exercise recommended', '2025-04-23 01:13:26', 201),
(302, 5, 2, 'Prescription', 'Medication: Ibuprofen\r\nDosage: 400mg every 6 hours\r\nInstructions: After meals', '2025-04-24 10:15:00', 202),
(304, 4, 1, 'Prescription', 'Medication: Amoxicillin\nDosage: 500mg three times a day\nInstructions: With water', '2025-04-25 09:45:00', 204),
(305, 5, 2, 'Medical', 'Diagnosis: Allergic Rhinitis\nSymptoms: Sneezing, congestion\nNotes: Avoid allergens', '2025-04-25 10:45:00', 205),
(306, 6, 3, 'LabTest', 'Test: Chest X-Ray\nReason: Persistent cough\nInstructions: None', '2025-04-25 11:45:00', 206);

-- --------------------------------------------------------

--
-- Table structure for table `medical_records_pt`
--

DROP TABLE IF EXISTS `medical_records_pt`;
CREATE TABLE IF NOT EXISTS `medical_records_pt` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `appointment_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=308 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medical_records_pt`
--

INSERT INTO `medical_records_pt` (`record_id`, `patient_id`, `doctor_id`, `type`, `content`, `created_at`, `appointment_id`) VALUES
(301, 4, 1, 'Medical', 'Diagnosis: Hypertension\nSymptoms: High blood pressure\nNotes: Regular exercise recommended', '2025-04-24 09:15:00', 201),
(302, 5, 2, 'Prescription', 'Medication: Ibuprofen\nDosage: 400mg every 6 hours\nInstructions: After meals', '2025-04-24 10:15:00', 202),
(303, 6, 3, 'LabTest', 'Test: Lipid Panel\nReason: Check cholesterol\nInstructions: Fasting required', '2025-04-24 11:15:00', 203),
(304, 4, 1, 'Prescription', 'Medication: Amoxicillin\nDosage: 500mg three times a day\nInstructions: With water', '2025-04-25 09:45:00', 204),
(305, 5, 2, 'Medical', 'Diagnosis: Allergic Rhinitis\nSymptoms: Sneezing, congestion\nNotes: Avoid allergens', '2025-04-25 10:45:00', 205),
(306, 6, 3, 'LabTest', 'Test: Chest X-Ray\nReason: Persistent cough\nInstructions: None', '2025-04-25 11:45:00', 206),
(307, 4, 1, 'Medical', 'Diagnosis: Hypertension\nSymptoms: High blood pressure\nNotes: Regular exercise recommended', '2025-04-23 01:13:26', 201);

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

DROP TABLE IF EXISTS `medicines`;
CREATE TABLE IF NOT EXISTS `medicines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `quantity`, `expiry_date`, `image_url`) VALUES
(1, 'Paracetamol', 125, NULL, 'med_paracetamol'),
(2, 'Ibuprofen', 85, NULL, 'med_ibuprofen'),
(4, 'Cough Syrup', 45, NULL, 'med_cough_syrup'),
(5, 'Vitamin C', 200, NULL, 'med_vitamin_c'),
(6, 'Antacid Tablets', 100, NULL, 'med_antacid'),
(7, 'Insulin', 30, NULL, 'med_insulin'),
(8, 'Azithromycin', 50, NULL, 'med_azithromycin');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivered` tinyint(1) DEFAULT 0,
  `read` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `recipient_id`, `message`, `timestamp`, `delivered`, `read`) VALUES
(1, 2, 1, 'sa', '2025-04-05 12:00:25', 1, 1),
(2, 1, 2, 'ok', '2025-04-05 12:01:04', 1, 1),
(3, 2, 1, 'sa', '2025-04-05 12:01:48', 1, 1),
(6, 2, 1, 'sa', '2025-04-05 12:05:14', 1, 1),
(5, 1, 2, 'sa', '2025-04-05 12:02:22', 1, 1),
(7, 2, 1, 'sa', '2025-04-05 12:30:35', 1, 1),
(8, 2, 1, 'sa', '2025-04-05 12:30:55', 1, 1),
(9, 2, 1, 'sa', '2025-04-05 13:02:07', 1, 1),
(10, 2, 1, 'sa', '2025-04-05 13:02:32', 0, 1),
(11, 2, 1, 'aaaaaaa', '2025-04-05 13:03:25', 1, 1),
(12, 1, 2, 'sa', '2025-04-05 13:03:41', 0, 1),
(13, 2, 1, 'wowww', '2025-04-05 13:03:51', 0, 1),
(14, 2, 1, 'wwwwwwww', '2025-04-05 13:04:05', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

DROP TABLE IF EXISTS `otps`;
CREATE TABLE IF NOT EXISTS `otps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_value` varchar(100) NOT NULL,
  `code` varchar(6) NOT NULL,
  `expiry` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `contact_value`, `code`, `expiry`) VALUES
(2, 'ibrahim@clinic.com', '927225', '2025-04-23 20:39:36'),
(3, 'ibrahim@clinic.com', '740969', '2025-04-23 20:43:25');

-- --------------------------------------------------------

--
-- Table structure for table `submitted_lab_tests`
--

DROP TABLE IF EXISTS `submitted_lab_tests`;
CREATE TABLE IF NOT EXISTS `submitted_lab_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submitted_lab_tests`
--

INSERT INTO `submitted_lab_tests` (`id`, `record_id`, `patient_id`, `doctor_id`, `content`, `submitted_at`) VALUES
(1, 303, 6, 3, 'Great X Ray', '2025-04-23 21:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `submitted_prescriptions`
--

DROP TABLE IF EXISTS `submitted_prescriptions`;
CREATE TABLE IF NOT EXISTS `submitted_prescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `contact_type` varchar(20) DEFAULT NULL,
  `contact_value` varchar(50) DEFAULT NULL,
  `flag` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `contact_type`, `contact_value`, `flag`, `type`) VALUES
(1, 'dr.ibrahim', '$2y$10$WV.AQbj6UmB9kk03RGMr.uj.XKQw1lWcj608j.iXxHTNRSLSouWtC', 'Email', 'ibrahim@clinic.com', NULL, 'Doctor'),
(2, 'dr.layla', '123', 'Email', 'layla@clinic.com', NULL, 'Doctor'),
(3, 'dr.omar', '123', 'Email', 'omar@clinic.com', NULL, 'Doctor'),
(4, 'adamjrad', '123', 'Email', 'adam@clinic.com', NULL, 'Patient'),
(5, 'ranaamoury', '123', 'Email', 'rana@clinic.com', NULL, 'Patient'),
(6, 'kareemnajib', '123', 'Email', 'kareem@clinic.com', NULL, 'Patient'),
(7, 'pharmacist1', '123', 'Email', 'pharmacy@clinic.com', NULL, 'Pharmacist'),
(8, 'med.manager', '123', 'Email', 'manager@clinic.com', NULL, 'Pharmacist'),
(9, 'lab.tech1', '123', 'Email', 'lab1@clinic.com', NULL, 'Lab Technician'),
(10, 'analyst.joe', '123', 'Email', 'joe.lab@clinic.com', NULL, 'Lab Technician'),
(11, 'AbdullahJrad', '$2y$10$vzs5UsWK9VAxGNgeGo4n6upBs7gA9VeVrbUZLqEOkeePm77tuieFa', 'Email', 'abdullah@clinic.com', NULL, 'Doctor');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `medical_records_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
