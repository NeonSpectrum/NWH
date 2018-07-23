SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `account` (
  `EmailAddress` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `AccountType` set('User','Receptionist','Admin','Creator') NOT NULL,
  `ProfilePicture` varchar(105) DEFAULT 'default.png',
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `ContactNumber` varchar(20) NOT NULL,
  `BirthDate` date NOT NULL,
  `Nationality` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Feedback` tinyint(1) NOT NULL,
  `DateRegistered` date NOT NULL,
  `SessionID` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `account` (`EmailAddress`, `Password`, `AccountType`, `ProfilePicture`, `FirstName`, `LastName`, `ContactNumber`, `BirthDate`, `Nationality`, `Status`, `Feedback`, `DateRegistered`, `SessionID`) VALUES
('a@yahoo.com', '$2y$10$S.pAr43rEMnIp5mXX2ibdO.RjRnrOtpUQsYfK7suvIQELRmCRa/4i', 'Receptionist', 'default', 'Sy', 'Sy', '00000000000000000000', '1684-06-20', '', 1, 0, '2018-02-13', NULL),
('andreicruz14@yahoo.com', '$2y$10$/EI/IdyzkaKuFAtK6UdfhujDQeEBNVY5Lxxy9Wr0Lxw9pwPislRw2', 'Receptionist', 'wUsYZLpjdu2Ly5c5Q8Eu', 'Andrei', 'Cruzz', '09218889999', '1998-07-23', '', 1, 0, '2018-04-16', '29347109f07acce502f761ca09034cfa'),
('arias_louie@hotmail.com', '$2y$10$psTt7F23OHGFeEvCGxEq0O55urRDQ89LvJWYuHsnW0E01X6KMYkl6', 'Receptionist', 'default', 'Arias', 'Louie', '123', '2018-01-01', '', 1, 0, '2017-12-23', '11bfab5d094090fb6086d87ae0c27563'),
('ashellehinautan@gmail.com', '$2y$10$LWS0wRcliDo6EZo3.ZnFz.ScCDA.O1jaS1QD9mxGQQkG9PuN8GQLO', 'Receptionist', 'default', 'Ashelle', 'Hinautan', '09086430087', '1999-04-19', '', 1, 0, '2018-01-05', '087df65b6512551482ed71952c1f040f'),
('beajewelcvines@gmail.com', '$2y$10$a19.IwDcblKsjDdQUXjZseQlWKzuDDtB6KhzLM7TPawA2.FlMmLVS', 'Admin', 'default', 'Bea Jewel', 'Vines', '123', '2017-12-13', '', 1, 0, '2017-12-04', '4f6f1cd6780ce3749e60cf6d9a84f423'),
('cheliterkim@gmail.com', '$2y$10$CGYjMnOkjFMjeWs7opVK8uVqw3GUCVthztacaWEBkOXd42Qm1SbNm', 'User', 'default', 'Roth ', 'Fernando', '09765412456', '1998-12-23', '', 1, 0, '2018-01-05', '4f64734c1c5516d8bbbcbd9724c0b13b'),
('cheljung09@gmail.com', '$2y$10$/0Mdv5n/JlGxFhEOl5GzCu0gdzOEMO/G2ffY.mkOoyjI6rsAqfCYu', 'Admin', 'lYqju77WrNmAZRvRAQiG', 'Rochelle', 'Hinautan', '09084056076', '1999-04-19', '', 1, 0, '2018-01-05', '9124eafe20559808a5fd7693ed85a832'),
('chelkim77@gmail.com', '$2y$10$nxj8sSFwJU2URrr08DuC9e8cVRyWI5VWfopug0rX39esTCqRHTR2a', 'User', 'default', 'Chel', 'rami', '10628841', '1999-11-06', '', 1, 0, '2018-01-05', 'b1fdb12c9a0c4a4c692ba2326662fb1a'),
('chimeisha@yahoo.com', '$2y$10$rkpN4TCJCsZisdZvq/4U4eSlnFIN36O9VPU.N0efQAVsEcTktu08u', 'Admin', 'QFeNbMnXAuKG6mMglpSa', 'Chime', 'Isha', '09351117291', '1998-09-05', '', 1, 0, '2018-01-05', '5c1026fa74059429f4de64bf8d5cdca7'),
('Fran1946@dayrep.com', '$2y$10$ag17TLMmMtpSiGTyvDjo.eXg6lg5bP88YF/v/ow69P0Kyd7TIzSsO', 'User', 'default', 'Pobelter', 'Dela Cruz', '09351117291', '1999-01-01', '', 1, 0, '2018-02-16', 'cd9b7b70481026f0ad59167301e5dd50'),
('Fran1946@einrot.com', '$2y$10$QfOCuXN7tDyt37TYdLavWOdbvUj1UlRYl4jNIgGd7tIrtpFVCii66', 'User', 'default', 'Hahaha', 'Hahahahah', '59585', '1930-02-16', '', 1, 0, '2018-02-16', NULL),
('fran1946@fleckens.hu', '$2y$10$irukwDljS2TwqcusVueUvuRf21o3UTsazj3QghM.1zCACI3onH8/S', 'User', 'default', 'Umaru', 'Doma', '243223', '2009-02-17', '', 1, 0, '2018-02-17', NULL),
('Fran1946@rhyta.com', '$2y$10$CDD8Micjx65KWAfxn4sdzOV1wJRXHXmOhNcwRtT.Kw2Lda/pfiFda', 'User', 'default', 'Ss', 'Dsd', '13213123123131231313', '1980-01-01', '', 1, 0, '2018-02-17', '5c1026fa74059429f4de64bf8d5cdca7'),
('gunorica@yahoo.com', '$2y$10$LsCpdo2svB.FkflrOorvv.WKCXjbjKiyhIKiJXCZUyilUVlXhPyha', 'Admin', 'OiDmHw7anl7HouTYptGG', 'Chimeisha', 'NANI', '111111', '1930-02-11', '', 1, 0, '2017-10-29', '473377caa3a027318acdd937b18e8edf'),
('jasonallego01@gmail.com', '$2y$10$/OLoYaSBOhkVkBnuLkF6JOPoIExvQG4px4pgWg5i8UF02cTz62MjS', 'User', 'default', 'Jason', 'Allego', '09154949632', '2018-01-01', '', 1, 0, '2018-01-05', 'd9ea8e9c4058208ad7820a4740a4407b'),
('jasonallego02@gmail.com', '$2y$10$E7.5GwVcYbbPUzvOy5zmYOA8ZSsYPRrSFCMIHmWv0Qr8V2Yu/T1Ky', 'User', 'default', 'Facundo', 'Allego', '09154949632', '2018-01-01', '', 1, 0, '2018-01-05', 'f26d46dc54df2ffc8ac3d9ac89f8eaab'),
('jasonallego03@gmail.com', '$2y$10$OpiMkglUqkh6O33Jbn3ziuMT6uKlCs5KCdDjkHeR2RH/03Zr.C54.', 'User', 'default', 'Facundo', 'Allego', '09154949632', '2018-01-01', '', 1, 0, '2018-01-05', 'd9ea8e9c4058208ad7820a4740a4407b'),
('jasonallego04@gmail.com', '$2y$10$1/zPF/A3QwY392DfSMpl3.D0rPi3PR8fm2TtUp/t76Zb5a3BG1p7y', 'User', 'default', 'Fritos', 'Allego', '09154949632', '2018-01-01', '', 1, 0, '2018-01-05', 'd9ea8e9c4058208ad7820a4740a4407b'),
('jasonallego05@gmail.com', '$2y$10$.TSwZHJQpHfK8DY7W5RrBOp3ydjrZqnZXanT0PsrGl4/w07WFmYHW', 'User', 'default', 'Fujian', 'Allego', '09154949632', '2018-01-01', '', 1, 0, '2018-01-05', 'f26d46dc54df2ffc8ac3d9ac89f8eaab'),
('jasonallego06@gmail.com', '$2y$10$0xLi0Hv6XuBFMhriLLP15.WgE2uY7gwW79tF7yOK0ZntJl25XAZR6', 'User', 'default', 'Horizon', 'MiddleOfNoWhere', '09154949632', '1970-01-01', '', 1, 0, '2018-01-05', 'f26d46dc54df2ffc8ac3d9ac89f8eaab'),
('jasonallego07@gmail.com', '$2y$10$Th3QIsSReBWe15pYVUAPq.p1Fs0/YGB.wplMn.J6sYro2xw88VnTS', 'User', 'default', 'Chito', 'Melodrama', '09154949632', '1970-01-01', '', 1, 0, '2018-01-05', 'f26d46dc54df2ffc8ac3d9ac89f8eaab'),
('jasonallego08@gmail.com', '$2y$10$rkpN4TCJCsZisdZvq/4U4eSlnFIN36O9VPU.N0efQAVsEcTktu08u', 'Admin', 'default', 'Jason', 'Allego', '123', '2017-12-13', '', 1, 0, '2017-11-20', '1ea03b7f38977acffca5e5c4c2f33eef'),
('katebolanos2@gmail.com', '$2y$10$SqvhZvQpQCMFdLFnIPVbd.Z7MQuhin0OlJgkf2JgUwqcu0/Wr6wPa', 'Receptionist', 'default', 'Kate', 'Bolanos', '123', '2017-12-13', '', 1, 0, '2017-11-29', '581tl75evccq32dpuia8e263u7'),
('mayfatalla@gmail.com', '$2y$10$2jt2tpK9twJaDdDRrUlu5u1rF6pqXQKzYgIwvbEisaPXVTsdzoCKa', 'User', 'default', 'May', 'Fatalla', '09279780751', '1998-11-21', '', 1, 0, '2018-07-07', 'b22fcd089f3d4fb02178e2800913c71a'),
('neonspectrumph@gmail.com', '$2y$10$CMRnT3VukkwNwqYrx9Sb6OhAOmkvEl0fVq3Emv0f8UHMnL28.1IVO', 'Admin', 'default', 'Manny', 'Young', '0123123123', '2018-01-01', '', 1, 0, '2018-01-09', 'ca2a159673af7b435f2920090458f0f1'),
('northwoodhotelalaminos@gmail.com', '$2y$10$ANgQU3oGisyZ71Pb3HT5dezVaKIKqMcK924OZ7Yf9VWyfQAEPDcZG', 'Admin', 'default', 'Northwood', 'Hotel', '2312312312', '2009-01-05', '', 1, 0, '2018-07-21', '0c1cd454802cd29e5483effd282f622d'),
('r.guno1@yahoo.com', '$2y$10$FnU2/9Al7DnznudnujLApO4cpRAAlf0yiEX3l/kin7uKUgre1tUf.', 'Receptionist', 'default', 'Ririiiii', 'Chi', '123', '2018-01-01', '', 1, 0, '2018-01-05', 'd27335ff6affc2f321fbab28cace4f42'),
('r.guno2@yahoo.com', '$2y$10$gokdgeo85TC/scoaGPW9JuWMgut4u/L0IstBpfcrEJEii9sBai0qO', 'User', 'default', 'Riri', 'Chiii', '123', '2018-01-01', '', 1, 0, '2018-01-05', 'd27335ff6affc2f321fbab28cace4f42'),
('r.guno3@yahoo.com', '$2y$10$6a7d1LYtEhWbVUZhBndeieft/CPxylpwj3YeVqWw4BUuTagzm4vHW', 'User', 'default', 'Taho', 'Vendor', '123', '1998-09-05', '', 1, 0, '2018-01-05', 'd27335ff6affc2f321fbab28cace4f42'),
('r.guno4@yahoo.com', '$2y$10$JqlqoTenN5qrU0R6yCrh.eTw2wT7q1O901dq4tgWGUqgL92ijSd6O', 'User', 'default', 'Microsoft', 'Word', '123', '2000-10-25', '', 1, 0, '2018-01-05', 'd27335ff6affc2f321fbab28cace4f42'),
('r.guno5@yahoo.com', '$2y$10$XRraga//dTbGxqzAT8tWhuDwh/vhWtqpzRU2RU9elnQX126Zxk2Pu', 'Receptionist', 'default', 'Ri', 'Ri', '1', '2007-09-24', '', 1, 0, '2018-01-07', NULL),
('ramoschetojhon@gmail.com', '$2y$10$tcxlIJXGV7/HL3qn4Z7EsO9NSZMcd/npuM6Vvdi5ZOEjVuZ55Kk8O', 'User', 'default', 'Jhon', 'Ramos', '123414', '1993-02-07', '', 1, 0, '2018-02-11', '47203819e9f71e6a2b7fef2de8c4118a'),
('relliebalagat@gmail.com', '$2y$10$szgJeW0ositX64pDw0odQeyvkQ5Pv1unc.dgNRBbStkp3C/1PpIiy', 'User', 'default', 'Rellie', 'Balagat', '09069121383', '1994-08-25', '', 1, 0, '2018-06-26', '97059788c6d75c0201de1118c4ee175f'),
('rjohnsantos19@gmail.com', '$2y$10$hGvaXnIOoMVvYrsVUy/Bse/qT/Lv7BNc7FtqQqbnpK4B.d37YmoO2', 'Receptionist', 'default', 'Russell', 'Santos', '09293431059', '1998-11-19', '', 1, 0, '2018-01-14', '6f0c0dcdd09507f7a000065fc3b22901'),
('rochellehinautan@gmail.com', '$2y$10$QXzyvj4lmo1lONkhqOY0We3uYsWU5yj9hjuDIR/TssGt0NUrgZkze', 'User', 'default', 'Pitchel', 'kim', '09367916', '1999-11-06', '', 1, 0, '2018-01-05', '087df65b6512551482ed71952c1f040f'),
('youngskymann@gmail.com', '$2y$10$XGNkdYqpdSxU6shiKHYYwe5nGsWUO4Xcf2VJFxMl128w.pGRYw5zS', 'Creator', 'tzxs82WVcFw5x2Mi0mr3', 'Manny', 'Young', '123', '2017-12-13', '', 1, 0, '2017-11-25', '01bea5bc251d3bb92df5900c5d2059f5');

CREATE TABLE `booking` (
  `BookingID` int(11) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `CheckInDate` date NOT NULL,
  `CheckOutDate` date NOT NULL,
  `Adults` int(11) NOT NULL,
  `Children` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `DateUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_bank` (
  `BookingID` int(11) NOT NULL,
  `Filename` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_cancelled` (
  `BookingID` int(11) NOT NULL,
  `DateCancelled` date NOT NULL,
  `Reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_check` (
  `BookingID` int(11) NOT NULL,
  `CheckIn` datetime DEFAULT NULL,
  `CheckOut` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_discount` (
  `BookingID` int(11) NOT NULL,
  `DiscountID` int(11) NOT NULL,
  `Amount` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_expenses` (
  `BookingID` int(11) NOT NULL,
  `ExpensesID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_paypal` (
  `BookingID` int(11) NOT NULL,
  `PayerID` varchar(50) NOT NULL,
  `PaymentID` varchar(50) NOT NULL,
  `InvoiceNumber` varchar(50) NOT NULL,
  `Token` varchar(50) NOT NULL,
  `PaymentAmount` int(11) NOT NULL,
  `TimeStamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_room` (
  `BookingID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `booking_transaction` (
  `BookingID` int(11) NOT NULL,
  `PaymentMethod` set('Cash','Bank','PayPal','') NOT NULL,
  `AmountPaid` int(11) NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `PaymentChange` int(11) NOT NULL,
  `TimeStamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `discount` (
  `DiscountID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `TaxFree` tinyint(4) NOT NULL,
  `Amount` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `discount` (`DiscountID`, `Name`, `TaxFree`, `Amount`) VALUES
(1, 'Senior Citizen', 0, '20%'),
(2, 'Others', 0, '0');

CREATE TABLE `expenses` (
  `ExpensesID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `expenses` (`ExpensesID`, `Name`, `Amount`) VALUES
(1, 'Extra Bed', 500),
(2, 'Others', 0),
(3, '1 Hour Extension', 200);

CREATE TABLE `feedback` (
  `ID` int(11) NOT NULL,
  `Star` tinyint(4) NOT NULL,
  `Comment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `forgot_password` (
  `ID` int(11) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `Token` varchar(50) NOT NULL,
  `Used` tinyint(1) NOT NULL DEFAULT '0',
  `TimeStamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `log` (
  `ID` int(11) NOT NULL,
  `EmailAddress` varchar(100) DEFAULT NULL,
  `Action` varchar(100) NOT NULL,
  `TimeStamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `notification` (
  `ID` int(11) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Message` text NOT NULL,
  `MarkedAsRead` tinyint(1) NOT NULL,
  `TimeStamp` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `promo_dates` (
  `PromoType` set('Season','Holiday') NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `room` (
  `RoomID` int(3) NOT NULL,
  `RoomTypeID` int(11) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Cleaning` tinyint(1) NOT NULL,
  `Maintenance` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `room` (`RoomID`, `RoomTypeID`, `Status`, `Cleaning`, `Maintenance`) VALUES
(101, 1, 1, 0, 0),
(102, 1, 1, 0, 0),
(103, 1, 1, 0, 0),
(104, 5, 1, 0, 0),
(105, 5, 1, 0, 0),
(106, 5, 1, 0, 0),
(107, 5, 1, 0, 0),
(108, 6, 1, 0, 0),
(109, 6, 1, 0, 0),
(110, 5, 1, 0, 0),
(111, 5, 1, 0, 0),
(112, 5, 1, 0, 0),
(114, 5, 1, 0, 0),
(115, 7, 1, 0, 0),
(201, 1, 1, 0, 0),
(202, 1, 1, 0, 0),
(203, 2, 1, 0, 0),
(204, 2, 1, 0, 0),
(205, 4, 1, 0, 0),
(206, 3, 1, 0, 0),
(207, 4, 1, 0, 0),
(208, 3, 1, 0, 0),
(209, 2, 1, 0, 0),
(210, 2, 1, 0, 0),
(211, 1, 1, 0, 0),
(212, 1, 1, 0, 0);

CREATE TABLE `room_type` (
  `RoomTypeID` int(11) NOT NULL,
  `RoomType` varchar(50) NOT NULL,
  `RoomDescription` text NOT NULL,
  `RoomSimplifiedDescription` text NOT NULL,
  `Icons` text,
  `Capacity` int(11) NOT NULL,
  `RegularRate` int(11) NOT NULL,
  `SeasonRate` int(11) NOT NULL,
  `HolidayRate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `room_type` (`RoomTypeID`, `RoomType`, `RoomDescription`, `RoomSimplifiedDescription`, `Icons`, `Capacity`, `RegularRate`, `SeasonRate`, `HolidayRate`) VALUES
(1, 'Standard_Single', 'FEATURES AND AMENITIES:\r\n<li>Total Room Inventory: 7</li><li>Room Size: 18 sqm.</li><li>With front-view glass window.</li><li>Bed Type: 1 Queen bed</li><li>Bathroom with Hot & Cold shower.</li><li>HD Cignal Cable TV.</li><li>Free Wifi access.</li><li>Free access to swimming pool.</li><li>2 Complimentary Breakfasts.</li><li>Good for 2 persons.</li>\r\n*Standard rate is good for 2 persons only with an additional charge of Php 500.00 for an extra bed.\r\n*Additional bed can be inquired at the front desk of the hotel.', 'Good for 2 persons\r\n2 Complimentary Breakfasts', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=TV\r\nwifi=Wifi\r\nphone=Telephone\r\ncutlery=Complimentary Breakfast', 2, 1650, 1800, 2000),
(2, 'Standard_Double', 'FEATURES AND AMENITIES:\r\n <li>Total Room Inventory: 4 rooms</li><li>Size: 22 sqm</li><li>With front/back-view balcony</li><li>Bed Type: 1 Double Bed &amp; 1 Single Bed</li><li>Bathroom with Hot &amp; Cold shower.</li><li>With HD Cignal Cable TV.</li><li>Free Wifi access.</li><li>Free access to swimming pool.</li><li>2 Complimentary Breakfasts.</li><li>Good for 3 persons.</li>\r\n*Standard rate is good for 3 persons only with an additional charge of Php 500.00 for an extra bed.\r\n*Additional bed can be inquired at the front desk of the hotel.', 'Good for 3 persons\r\n2 Complimentary Breakfasts', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=TV\r\nwifi=Wifi\r\nphone=Telephone\r\ncutlery=Complimentary Breakfast', 3, 2650, 2850, 3200),
(3, 'Family_Room', 'FEATURES AND AMENITIES: <li>Total Room Inventory: 2 rooms</li><li>Size: 25 sqm.</li><li>Front-view glass window.</li><li>Bed Type: 2 separate Queen beds</li><li>Bathroom with Hot &amp; Cold shower.</li><li>With Smart TV &amp; HD Cignal Cable TV.</li><li>Free Wifi access.</li><li>Free access to swimming pool.</li><li>4 Complimentary Breakfasts.</li><li>Good for 4 persons.</li>\r\n*Standard rate is good for 4 persons only with an additional charge of Php 500.00 for an extra bed.\r\n*Additional bed can be inquired at the front desk of the hotel.', 'Good for 4 persons.\r\n4 Complimentary Breakfasts.', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=TV\r\nwifi=Wifi\r\nphone=Telephone\r\ncutlery=Complimentary Breakfast', 4, 3300, 3600, 4000),
(4, 'Junior_Suites', 'FEATURES AND AMENITIES: <li>Total Room Inventory: 2 rooms</li><li>Size: 27 sqm.</li><li>Bed Type: 2 separate Queen beds.</li><li>Bathroom with Hot &amp; Cold shower.</li><li>With Smart TV &amp; HD Cignal Cable TV.</li><li>Personal Refrigerator.</li><li>Free Wifi access.</li><li>Free access to swimming pool.</li><li>4 Complimentary Breakfasts.</li><li>Good for 4 persons.</li>\r\n*Standard rate is good for 4 persons only with an additional charge of Php 500.00 for an extra bed.\r\n*Additional bed can be inquired at the front desk of the hotel.', 'Good for 4 persons.\r\n4 Complimentary Breakfasts.', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=TV\r\nwifi=Wifi\r\nphone=Telephone\r\ncutlery=Complimentary Breakfast', 4, 4000, 4500, 5000),
(5, 'Studio_Type', 'FEATURES AND AMENITIES:<li>Total Room Inventory: 7 rooms</li><li>Size: 15 sqm.</li><li>Bed Type: Double bed.</li><li>Size: 15 sqm.</li><li>Bathroom with Hot & Cold shower.</li><li>TV Plus.</li><li>Free Wifi access.</li><li>Free access to swimming pool.</li><li>2 Complimentary Breakfasts.</li><li>Good for 2 persons</li>', 'Good for 2 persons\r\n2 Complimentary Breakfasts.', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=TV\r\nwifi=Wifi\r\nphone=Telephone\r\ncutlery=Complimentary Breakfast', 2, 1350, 1500, 1800),
(6, 'Barkada_Room', 'FEATURES AND AMENITIES: <li>Total Room Inventory: 2 rooms</li><li>Bed Type: Bunk Bed.</li><li>Size: 20 sqm.</li><li>Bathroom with Hot &amp; Cold shower.</li><li>TV Plus</li><li>Free Wifi access.</li><li>Free access to swimming pool.</li><li>2 Complimentary Breakfasts.</li><li>Good for 5 persons</li>', 'Good for 5 persons\r\n2 Complimentary Breakfasts.', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=TV\r\nwifi=Wifi\r\nphone=Telephone\r\ncutlery=Complimentary Breakfast', 5, 2500, 2750, 2900),
(7, 'Super_Barkada_Room', 'FEATURES AND AMENITIES: <li>Total Room Inventory: 2 rooms</li><li>Bed Type: Bunk Bed.</li><li>Size: 20 sqm.</li><li>Bathroom with Hot &amp; Cold shower.</li><li>TV Plus</li><li>Free Wifi access.</li><li>Free access to swimming pool.</li><li>2 Complimentary Breakfasts.</li><li>Good for 8 persons</li>', 'Good for 8 persons\r\n2 Complimentary Breakfasts.', 'snowflake-o=Aircon\r\nbed=Bed\r\nshower=Shower\r\ntelevision=TV\r\nwifi=Wifi\r\nphone=Telephone\r\ncutlery=Complimentary Breakfast', 8, 4000, 4800, 5600);

CREATE TABLE `visitor_count` (
  `Date` date NOT NULL,
  `Count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `account`
  ADD PRIMARY KEY (`EmailAddress`);

ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingID`,`EmailAddress`),
  ADD KEY `EmailAddress` (`EmailAddress`);

ALTER TABLE `booking_bank`
  ADD KEY `BookingID` (`BookingID`);

ALTER TABLE `booking_cancelled`
  ADD UNIQUE KEY `BookingID` (`BookingID`);

ALTER TABLE `booking_check`
  ADD PRIMARY KEY (`BookingID`);

ALTER TABLE `booking_discount`
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `DiscountID` (`DiscountID`);

ALTER TABLE `booking_expenses`
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `ExpensesID` (`ExpensesID`);

ALTER TABLE `booking_paypal`
  ADD UNIQUE KEY `PaymentID` (`PaymentID`),
  ADD KEY `BookingID` (`BookingID`);

ALTER TABLE `booking_room`
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `RoomID` (`RoomID`);

ALTER TABLE `booking_transaction`
  ADD KEY `BookingID` (`BookingID`);

ALTER TABLE `discount`
  ADD PRIMARY KEY (`DiscountID`);

ALTER TABLE `expenses`
  ADD PRIMARY KEY (`ExpensesID`);

ALTER TABLE `feedback`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EmailAddress` (`EmailAddress`);

ALTER TABLE `log`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `notification`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `room`
  ADD PRIMARY KEY (`RoomID`),
  ADD KEY `RoomTypeID` (`RoomTypeID`);

ALTER TABLE `room_type`
  ADD PRIMARY KEY (`RoomTypeID`);


ALTER TABLE `booking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `discount`
  MODIFY `DiscountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `expenses`
  MODIFY `ExpensesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `feedback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `forgot_password`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
ALTER TABLE `log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1807;
ALTER TABLE `notification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11521;
ALTER TABLE `room_type`
  MODIFY `RoomTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`EmailAddress`) REFERENCES `account` (`EmailAddress`);

ALTER TABLE `booking_bank`
  ADD CONSTRAINT `booking_bank_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

ALTER TABLE `booking_cancelled`
  ADD CONSTRAINT `booking_cancelled_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

ALTER TABLE `booking_check`
  ADD CONSTRAINT `booking_check_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

ALTER TABLE `booking_discount`
  ADD CONSTRAINT `booking_discount_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`),
  ADD CONSTRAINT `booking_discount_ibfk_2` FOREIGN KEY (`DiscountID`) REFERENCES `discount` (`DiscountID`);

ALTER TABLE `booking_expenses`
  ADD CONSTRAINT `booking_expenses_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`),
  ADD CONSTRAINT `booking_expenses_ibfk_2` FOREIGN KEY (`ExpensesID`) REFERENCES `expenses` (`ExpensesID`);

ALTER TABLE `booking_paypal`
  ADD CONSTRAINT `booking_paypal_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

ALTER TABLE `booking_room`
  ADD CONSTRAINT `booking_room_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`),
  ADD CONSTRAINT `booking_room_ibfk_2` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`);

ALTER TABLE `booking_transaction`
  ADD CONSTRAINT `booking_transaction_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

ALTER TABLE `forgot_password`
  ADD CONSTRAINT `forgot_password_ibfk_1` FOREIGN KEY (`EmailAddress`) REFERENCES `account` (`EmailAddress`);

ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`RoomTypeID`) REFERENCES `room_type` (`RoomTypeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
