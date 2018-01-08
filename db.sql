SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `cp018101_nwh` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cp018101_nwh`;

CREATE TABLE `account` (
  `EmailAddress` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `AccountType` varchar(10) DEFAULT 'User',
  `ProfilePicture` varchar(105) DEFAULT 'default.png',
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `ContactNumber` varchar(20) NOT NULL,
  `BirthDate` date NOT NULL,
  `DateRegistered` date NOT NULL,
  `SessionID` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `account` (`EmailAddress`, `Password`, `AccountType`, `ProfilePicture`, `FirstName`, `LastName`, `ContactNumber`, `BirthDate`, `DateRegistered`, `SessionID`) VALUES
('arias_louie@hotmail.com', '$2y$10$psTt7F23OHGFeEvCGxEq0O55urRDQ89LvJWYuHsnW0E01X6KMYkl6', 'Admin', 'default.png', 'Arias', 'Louie', '123', '1998-08-22', '2017-12-23', '11bfab5d094090fb6086d87ae0c27563'),
('beajewelcvines@gmail.com', '$2y$10$VFNjVijVyv73K1tq8Fs5.uds4JwDpaRvMh1yy2BWKETxlj9PQ7Aw2', 'Admin', 'default.png', 'Bea Jewel', 'Vines', '123', '2017-12-13', '2017-12-04', 'ioccmabmgrhh7j9700gbi3ni0h'),
('gunorica@yahoo.com', '$2y$10$q5alrj46v/YhpATxazJ/1OVCF6lrnPFezh3YYc98vQQm/QXKUP9wG', 'Admin', 'default.png', 'Rica', 'Guno', '123', '2017-12-13', '2017-10-29', 'j5n0c4noiqmgdk44b2iou3jca5'),
('jasonallego08@gmail.com', '$2y$10$FmDkJc0xJwpN6DMpnR16U.RjGsyLODqVUJvfUorWwlCdsipdY/e1C', 'Admin', 'JasonAllego.jpg', 'Jason', 'Allego', '123', '2017-12-13', '2017-11-20', 'cuv527khttgpq9r22ufkv30ru0'),
('jasonallego@gmail.com', '$2y$10$2yIzczzn3a2bKPagrBPq7uiDE4kF.Mv1mY.vI7y4rED7RPB1o1F7e', 'User', 'JasonnnAllego.jpg', 'Jasonnn', 'Allego', '09154949632', '1998-08-22', '2018-01-03', NULL),
('katebolanos2@gmail.com', '$2y$10$SqvhZvQpQCMFdLFnIPVbd.Z7MQuhin0OlJgkf2JgUwqcu0/Wr6wPa', 'Admin', 'KateBolanos.png', 'Kate', 'Bolanos', '123', '2017-12-13', '2017-11-29', '581tl75evccq32dpuia8e263u7'),
('neonspectrumph@gmail.com', '$2y$10$dN4w8mXxLSNlFsWNWbUbqOhBKPMCLbYFXfYKM32/DqaR0uEUGs3xC', 'User', 'default.png', 'Manny', 'Young', '1231231', '2004-07-21', '2018-01-05', NULL),
('youngskymann@gmail.com', '$2y$10$pOAZskKoy6tllQHjdrPpO.ltVtZzcc7daO/WAHVZjKRRoUhmNydXK', 'Creator', 'MannyYoung.png', 'Manny', 'Young', '123', '1998-10-07', '2017-11-25', '3drcql42kcc09lp72642djrtg8');

CREATE TABLE `booking` (
  `BookingID` int(11) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `CheckInDate` date NOT NULL,
  `CheckOutDate` date NOT NULL,
  `Adults` int(11) NOT NULL,
  `Children` int(11) NOT NULL,
  `AmountPaid` int(11) NOT NULL,
  `TotalAmount` int(11) DEFAULT NULL,
  `PaymentMethod` varchar(10) NOT NULL,
  `DateCreated` date NOT NULL,
  `DateUpdated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_cancelled` (
  `BookingID` int(11) NOT NULL,
  `DateCancelled` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_check` (
  `CheckID` int(11) NOT NULL,
  `BookingID` int(11) NOT NULL,
  `CheckIn` datetime NOT NULL,
  `CheckOut` datetime DEFAULT NULL,
  `ExtraCharges` int(11) NOT NULL,
  `Discount` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_paypal` (
  `BookingID` int(11) NOT NULL,
  `PayerID` varchar(50) NOT NULL,
  `PaymentID` varchar(50) NOT NULL,
  `Token` varchar(50) NOT NULL,
  `Amount` int(11) NOT NULL,
  `TimeStamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_room` (
  `BookingID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `forgot_password` (
  `id` int(11) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `token` varchar(50) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `log` (
  `ID` int(11) NOT NULL,
  `EmailAddress` varchar(100) DEFAULT NULL,
  `Action` varchar(100) NOT NULL,
  `TimeStamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `room` (
  `RoomID` int(3) NOT NULL,
  `RoomTypeID` int(11) NOT NULL,
  `Status` varchar(10) NOT NULL DEFAULT 'Enabled'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `room` (`RoomID`, `RoomTypeID`, `Status`) VALUES
(101, 1, 'Enabled'),
(102, 1, 'Enabled'),
(103, 1, 'Enabled'),
(104, 5, 'Enabled'),
(105, 5, 'Enabled'),
(106, 5, 'Enabled'),
(107, 5, 'Enabled'),
(108, 6, 'Enabled'),
(109, 6, 'Enabled'),
(110, 5, 'Enabled'),
(111, 5, 'Enabled'),
(112, 5, 'Enabled'),
(201, 1, 'Enabled'),
(202, 1, 'Enabled'),
(203, 2, 'Enabled'),
(204, 2, 'Enabled'),
(205, 4, 'Enabled'),
(206, 3, 'Enabled'),
(207, 4, 'Enabled'),
(208, 3, 'Enabled'),
(209, 2, 'Enabled'),
(210, 2, 'Enabled'),
(211, 1, 'Enabled'),
(212, 1, 'Enabled');

CREATE TABLE `room_type` (
  `RoomTypeID` int(11) NOT NULL,
  `RoomType` varchar(50) NOT NULL,
  `RoomDescription` text NOT NULL,
  `RoomSimplifiedDescription` text NOT NULL,
  `Icons` text NOT NULL,
  `Capacity` int(11) NOT NULL,
  `PeakRate` int(11) NOT NULL,
  `LeanRate` int(11) NOT NULL,
  `DiscountedRate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `room_type` (`RoomTypeID`, `RoomType`, `RoomDescription`, `RoomSimplifiedDescription`, `Icons`, `Capacity`, `PeakRate`, `LeanRate`, `DiscountedRate`) VALUES
(1, 'Standard_Single', 'STANDARD SINGLE FEATURES AND AMENITIES (w/ 1 complimentary breakfast) Total Room Inventory: 7 rooms Size: 18 sqm., with front-view glass window Bed Configuration: 1 Queen bed Bathroom with hotcold shower HD Signal Caable TV.', 'Good for 2 persons', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=Smart TV\r\nwifi=Wifi\r\nphone=Phone', 2, 2250, 1350, 1650),
(2, 'Standard_Double', 'STANDARD DOUBLE FEATURES AND AMENITIES (w/ 2 complimentary breakfast) Total Room Inventory: 4 rooms Size: 22 sqm, with front/back-view balcony Bed Configuration: 2 separate single & double beds Bathroom with hot & cold shower...', 'Good for 3 persons', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=Smart TV\r\nwifi=Wifi\r\nphone=Phone', 3, 2900, 1850, 2300),
(3, 'Family_Room', 'FAMILY ROOM FEATURES AND AMENITIES (w/ 2 complimentary breakfast) Total Room Inventory: 2 rooms Size: 25 sqm, with front-view glass window Bed Configuration: 2 separate Queen beds Bathroom with hot & cold shower With Smart TV...', 'Good for 4 persons', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=Smart TV\r\nwifi=Wifi\r\nphone=Phone', 4, 3850, 3000, 3500),
(4, 'Junior_Suites', 'JUNIOR SUITES FEATURES AND AMENITIES (w/ 2 complimentary breakfast) Total Room Inventory: 2 rooms Size: 27 sqm, with one (1) step-out veranda Bed Configuration: 2 separate Queen beds Bathroom with hot & cold shower With...', 'Good for 4 persons', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=Smart TV\r\nwifi=Wifi\r\nphone=Phone', 4, 4900, 3800, 4500),
(5, 'Studio_Type', 'I AM STUDIO TYPE', 'Good for 4 persons', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=Smart TV\r\nwifi=Wifi\r\nphone=Phone', 4, 1500, 1100, 1300),
(6, 'Barkada_Room', 'I AM BARKADA ROOM', 'Good for 5 persons', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=Smart TV\r\nwifi=Wifi\r\nphone=Phone', 5, 3500, 2000, 2600);

CREATE TABLE `visitor-count` (
  `Date` date NOT NULL,
  `Count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `account`
  ADD PRIMARY KEY (`EmailAddress`);

ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingID`,`EmailAddress`),
  ADD KEY `EmailAddress` (`EmailAddress`);

ALTER TABLE `booking_cancelled`
  ADD KEY `BookingID` (`BookingID`);

ALTER TABLE `booking_check`
  ADD PRIMARY KEY (`CheckID`),
  ADD KEY `BookingID` (`BookingID`);

ALTER TABLE `booking_paypal`
  ADD UNIQUE KEY `PaymentID` (`PaymentID`),
  ADD KEY `BookingID` (`BookingID`);

ALTER TABLE `booking_room`
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `RoomID` (`RoomID`);

ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmailAddress` (`EmailAddress`);

ALTER TABLE `log`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `room`
  ADD PRIMARY KEY (`RoomID`),
  ADD KEY `RoomTypeID` (`RoomTypeID`);

ALTER TABLE `room_type`
  ADD PRIMARY KEY (`RoomTypeID`);


ALTER TABLE `booking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

ALTER TABLE `booking_check`
  MODIFY `CheckID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `forgot_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

ALTER TABLE `room_type`
  MODIFY `RoomTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`EmailAddress`) REFERENCES `account` (`EmailAddress`);

ALTER TABLE `booking_cancelled`
  ADD CONSTRAINT `booking_cancelled_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

ALTER TABLE `booking_check`
  ADD CONSTRAINT `booking_check_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

ALTER TABLE `booking_paypal`
  ADD CONSTRAINT `booking_paypal_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

ALTER TABLE `booking_room`
  ADD CONSTRAINT `booking_room_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`),
  ADD CONSTRAINT `booking_room_ibfk_2` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`);

ALTER TABLE `forgot_password`
  ADD CONSTRAINT `forgot_password_ibfk_1` FOREIGN KEY (`EmailAddress`) REFERENCES `account` (`EmailAddress`);

ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`RoomTypeID`) REFERENCES `room_type` (`RoomTypeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
