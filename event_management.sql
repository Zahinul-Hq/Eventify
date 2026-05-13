-- phpMyAdmin SQL Dump
-- Eventify — Event Management System
-- Database: event_management

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table structure for table `admin`
-- --------------------------------------------------------
CREATE TABLE `admin` (
  `A_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Demo admin (password: admin123 — change before any real use)
INSERT INTO `admin` (`A_ID`, `Name`, `Email`, `Password`) VALUES
(1, 'Admin', 'admin@eventify.com', '$2y$10$exampleHashedPasswordHere');

-- --------------------------------------------------------
-- Table structure for table `assign`
-- --------------------------------------------------------
CREATE TABLE `assign` (
  `Assign_ID` int(11) NOT NULL,
  `Staff_ID` int(11) DEFAULT NULL,
  `R_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `assign` (`Assign_ID`, `Staff_ID`, `R_ID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(4, 4, 2),
(5, 1, 3);

-- --------------------------------------------------------
-- Table structure for table `customer`
-- --------------------------------------------------------
CREATE TABLE `customer` (
  `C_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone_No` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Demo customers (passwords are hashed with password_hash())
INSERT INTO `customer` (`C_ID`, `Name`, `Email`, `Password`, `Phone_No`) VALUES
(1, 'Alice Johnson', 'alice@example.com', '$2y$10$exampleHashedPasswordHere', '01700000001'),
(2, 'Bob Smith',    'bob@example.com',   '$2y$10$exampleHashedPasswordHere', '01700000002');

-- --------------------------------------------------------
-- Table structure for table `event`
-- --------------------------------------------------------
CREATE TABLE `event` (
  `E_ID` int(11) NOT NULL,
  `Event_Type` varchar(255) DEFAULT NULL,
  `Menu` varchar(255) DEFAULT NULL,
  `Total_Guests` int(11) DEFAULT NULL,
  `Zip_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `event` (`E_ID`, `Event_Type`, `Menu`, `Total_Guests`, `Zip_code`) VALUES
(1, 'Wedding',   'Delux',      200, '1205'),
(2, 'Birthday',  'Simple',     50,  '1205'),
(3, 'Corporate', 'Super Delux',100, '1212');

-- --------------------------------------------------------
-- Table structure for table `payment`
-- --------------------------------------------------------
CREATE TABLE `payment` (
  `Pay_ID` int(11) NOT NULL,
  `R_ID` int(11) DEFAULT NULL,
  `Card_No` varchar(16) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `payment` (`Pay_ID`, `R_ID`, `Card_No`, `Amount`) VALUES
(1, 1, '4111111111111111', 111500.00),
(2, 2, '4111111111111111', 17000.00),
(3, 3, '4111111111111111', 78000.00);

-- --------------------------------------------------------
-- Table structure for table `reservation`
-- --------------------------------------------------------
CREATE TABLE `reservation` (
  `R_ID` int(11) NOT NULL,
  `C_ID` int(11) DEFAULT NULL,
  `V_ID` int(11) DEFAULT NULL,
  `E_ID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `reservation` (`R_ID`, `C_ID`, `V_ID`, `E_ID`, `Date`, `Status`) VALUES
(1, 1, 1, 1, '2024-08-10', 'Approved'),
(2, 2, 2, 2, '2024-08-15', 'Approved'),
(3, 1, 3, 3, '2024-08-20', 'Pending');

-- --------------------------------------------------------
-- Table structure for table `staff`
-- --------------------------------------------------------
CREATE TABLE `staff` (
  `Staff_ID` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `staff` (`Staff_ID`, `phone`, `image`, `name`, `designation`) VALUES
(1, '01700000010', 'placeholder.jpg', 'John Doe',      'Manager'),
(2, '01700000011', 'placeholder.jpg', 'Jane Smith',    'Cleaner'),
(3, '01700000012', 'placeholder.jpg', 'Alice Brown',   'Waiter'),
(4, '01700000013', 'placeholder.jpg', 'Bob Williams',  'Decorator');

-- --------------------------------------------------------
-- Table structure for table `venue`
-- --------------------------------------------------------
CREATE TABLE `venue` (
  `V_ID` int(11) NOT NULL,
  `V_Name` varchar(255) NOT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Cost` decimal(10,2) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Zip_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `venue` (`V_ID`, `V_Name`, `Type`, `Capacity`, `Cost`, `Image`, `Zip_code`) VALUES
(1, 'Grand Ballroom',   'Wedding',       500,  150000.00, 'placeholder.jpg', '1205'),
(2, 'Garden Terrace',   'Birthday',      200,  15000.00,  'placeholder.jpg', '1205'),
(3, 'Convention Center','Corporate',     1000, 75000.00,  'placeholder.jpg', '1212');

-- --------------------------------------------------------
-- Indexes
-- --------------------------------------------------------
ALTER TABLE `admin`       ADD PRIMARY KEY (`A_ID`), ADD UNIQUE KEY `Email` (`Email`);
ALTER TABLE `assign`      ADD PRIMARY KEY (`Assign_ID`), ADD KEY `Staff_ID` (`Staff_ID`), ADD KEY `R_ID` (`R_ID`);
ALTER TABLE `customer`    ADD PRIMARY KEY (`C_ID`), ADD UNIQUE KEY `Email` (`Email`);
ALTER TABLE `event`       ADD PRIMARY KEY (`E_ID`);
ALTER TABLE `payment`     ADD PRIMARY KEY (`Pay_ID`), ADD KEY `R_ID` (`R_ID`);
ALTER TABLE `reservation` ADD PRIMARY KEY (`R_ID`), ADD KEY `C_ID` (`C_ID`), ADD KEY `V_ID` (`V_ID`), ADD KEY `E_ID` (`E_ID`);
ALTER TABLE `staff`       ADD PRIMARY KEY (`Staff_ID`);
ALTER TABLE `venue`       ADD PRIMARY KEY (`V_ID`);

-- AUTO_INCREMENT
ALTER TABLE `admin`       MODIFY `A_ID`      int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `assign`      MODIFY `Assign_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `customer`    MODIFY `C_ID`      int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `event`       MODIFY `E_ID`      int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `payment`     MODIFY `Pay_ID`    int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `reservation` MODIFY `R_ID`      int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `staff`       MODIFY `Staff_ID`  int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `venue`       MODIFY `V_ID`      int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- Foreign Keys
ALTER TABLE `assign`
  ADD CONSTRAINT `assign_ibfk_1` FOREIGN KEY (`Staff_ID`) REFERENCES `staff` (`Staff_ID`),
  ADD CONSTRAINT `assign_ibfk_2` FOREIGN KEY (`R_ID`) REFERENCES `reservation` (`R_ID`);

ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`R_ID`) REFERENCES `reservation` (`R_ID`);

ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`C_ID`) REFERENCES `customer` (`C_ID`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`V_ID`) REFERENCES `venue` (`V_ID`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`E_ID`) REFERENCES `event` (`E_ID`);

COMMIT;
