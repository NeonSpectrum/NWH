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

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `EmailAddress` varchar(100) NOT NULL,
  `Password` text NOT NULL,
  `AccountType` varchar(10) DEFAULT 'User',
  `ProfilePicture` varchar(50) DEFAULT 'default.png',
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `ContactNumber` varchar(20) NOT NULL,
  `BirthDate` date NOT NULL,
  `DateRegistered` date NOT NULL,
  `SessionID` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `account` (`EmailAddress`, `Password`, `AccountType`, `ProfilePicture`, `FirstName`, `LastName`, `ContactNumber`, `BirthDate`, `DateRegistered`, `SessionID`) VALUES
('beajewelcvines@gmail.com', '$2y$10$VFNjVijVyv73K1tq8Fs5.uds4JwDpaRvMh1yy2BWKETxlj9PQ7Aw2', 'Admin', 'default.png', 'Bea Jewel', 'Vines', '123', '2017-12-13', '2017-12-04', 'ioccmabmgrhh7j9700gbi3ni0h'),
('gunorica@yahoo.com', '$2y$10$q5alrj46v/YhpATxazJ/1OVCF6lrnPFezh3YYc98vQQm/QXKUP9wG', 'Admin', 'default.png', 'Rica', 'Guno', '123', '2017-12-13', '2017-10-29', 'k9mnvrc9su4m29e2fahve2uglm'),
('jasonallego08@gmail.com', '$2y$10$FmDkJc0xJwpN6DMpnR16U.RjGsyLODqVUJvfUorWwlCdsipdY/e1C', 'Admin', 'JasonAllego.jpg', 'Jason', 'Allego', '123', '2017-12-13', '2017-11-20', 'cuv527khttgpq9r22ufkv30ru0'),
('katebolanos2@gmail.com', '$2y$10$SqvhZvQpQCMFdLFnIPVbd.Z7MQuhin0OlJgkf2JgUwqcu0/Wr6wPa', 'Admin', 'KateBolanos.png', 'Kate', 'Bolanos', '123', '2017-12-13', '2017-11-29', '581tl75evccq32dpuia8e263u7'),
('youngskymann@gmail.com', '$2y$10$luX9F27Y3LawOTgXiTXZh.VBNdGawSHEIdvpuE2wwz9y3rILcBZlC', 'Owner', 'MannyYoung.png', 'Manny', 'Young', '123', '2017-12-13', '2017-11-25', 'u78ctlu9taelpp90ratt43drfq');

DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking` (
  `BookingID` int(11) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `CheckInDate` date NOT NULL,
  `CheckOutDate` date NOT NULL,
  `Adults` int(11) NOT NULL,
  `Children` int(11) NOT NULL,
  `AmountPaid` int(11) NOT NULL,
  `TotalAmount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `ReservationID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `WalkInID` int(11) DEFAULT NULL,
  `CheckIn` datetime NOT NULL,
  `CheckOut` datetime DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `RoomID` int(3) NOT NULL,
  `RoomTypeID` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Enabled'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `room` (`RoomID`, `RoomTypeID`, `Status`) VALUES
(101, 1, 'Occupied'),
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

DROP TABLE IF EXISTS `room_type`;
CREATE TABLE `room_type` (
  `RoomTypeID` int(11) NOT NULL,
  `RoomType` varchar(50) NOT NULL,
  `RoomDescription` text NOT NULL,
  `Capacity` int(11) NOT NULL,
  `PeakRate` int(11) NOT NULL,
  `LeanRate` int(11) NOT NULL,
  `DiscountedRate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `room_type` (`RoomTypeID`, `RoomType`, `RoomDescription`, `Capacity`, `PeakRate`, `LeanRate`, `DiscountedRate`) VALUES
(1, 'Standard_Single', 'STANDARD SINGLE FEATURES AND AMENITIES (w/ 1 complimentary breakfast) Total Room Inventory: 7 rooms Size: 18 sqm., with front-view glass window Bed Configuration: 1 Queen bed Bathroom with hotcold shower HD Signal Caable TV.', 2, 2250, 1350, 1650),
(2, 'Standard_Double', 'STANDARD DOUBLE FEATURES AND AMENITIES (w/ 2 complimentary breakfast) Total Room Inventory: 4 rooms Size: 22 sqm, with front/back-view balcony Bed Configuration: 2 separate single & double beds Bathroom with hot & cold shower...', 3, 2900, 1850, 2300),
(3, 'Family_Room', 'FAMILY ROOM FEATURES AND AMENITIES (w/ 2 complimentary breakfast) Total Room Inventory: 2 rooms Size: 25 sqm, with front-view glass window Bed Configuration: 2 separate Queen beds Bathroom with hot & cold shower With Smart TV...', 4, 3850, 3000, 3500),
(4, 'Junior_Suites', 'JUNIOR SUITES FEATURES AND AMENITIES (w/ 2 complimentary breakfast) Total Room Inventory: 2 rooms Size: 27 sqm, with one (1) step-out veranda Bed Configuration: 2 separate Queen beds Bathroom with hot & cold shower With...', 4, 4900, 3800, 4500),
(5, 'Studio_Type', 'I AM STUDIO TYPE', 2, 1500, 1100, 1300),
(6, 'Barkada_Room', 'I AM BARKADA ROOM', 4, 3500, 2000, 2600);

DROP TABLE IF EXISTS `walk_in`;
CREATE TABLE `walk_in` (
  `WalkInID` int(11) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `CheckInDate` date NOT NULL,
  `CheckOutDate` date NOT NULL,
  `Adults` int(11) NOT NULL,
  `Children` int(11) NOT NULL,
  `AmountPaid` int(11) NOT NULL,
  `TotalAmount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `account`
  ADD PRIMARY KEY (`EmailAddress`);

ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingID`,`EmailAddress`,`RoomID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `EmailAddress` (`EmailAddress`);

ALTER TABLE `reservation`
  ADD PRIMARY KEY (`ReservationID`),
  ADD UNIQUE KEY `BookingID` (`BookingID`),
  ADD UNIQUE KEY `WalkInID` (`WalkInID`);

ALTER TABLE `room`
  ADD PRIMARY KEY (`RoomID`),
  ADD KEY `RoomTypeID` (`RoomTypeID`);

ALTER TABLE `room_type`
  ADD PRIMARY KEY (`RoomTypeID`);

ALTER TABLE `walk_in`
  ADD PRIMARY KEY (`WalkInID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `EmailAddress` (`EmailAddress`);


ALTER TABLE `booking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `reservation`
  MODIFY `ReservationID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `room_type`
  MODIFY `RoomTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `walk_in`
  MODIFY `WalkInID` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`EmailAddress`) REFERENCES `account` (`EmailAddress`);

ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`WalkInID`) REFERENCES `walk_in` (`WalkInID`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`RoomTypeID`) REFERENCES `room_type` (`RoomTypeID`);

ALTER TABLE `walk_in`
  ADD CONSTRAINT `walk_in_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`),
  ADD CONSTRAINT `walk_in_ibfk_2` FOREIGN KEY (`EmailAddress`) REFERENCES `account` (`EmailAddress`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
