-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 05, 2018 at 11:51 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BILETY_LOTNICZE`
--

-- --------------------------------------------------------

--
-- Table structure for table `KLIENCI`
--

CREATE TABLE `KLIENCI` (
  `ID` int(11) NOT NULL,
  `NAZWISKO` text COLLATE utf8_polish_ci NOT NULL,
  `IMIE` text COLLATE utf8_polish_ci NOT NULL,
  `HASLO` text COLLATE utf8_polish_ci NOT NULL,
  `MAIL` text COLLATE utf8_polish_ci NOT NULL,
  `TELEFON` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `KLIENCI`
--

INSERT INTO `KLIENCI` (`ID`, `NAZWISKO`, `IMIE`, `HASLO`, `MAIL`, `TELEFON`) VALUES
(1, 'user', 'user', '$2y$10$FQwQYXaw3llGGw5rj2Z87ex63HlmV6E.cXB7Ivletbf3jDc4.K9gy', 'user@baza.pl', 999999999);

-- --------------------------------------------------------

--
-- Table structure for table `LINIE_LOTNICZE`
--

CREATE TABLE `LINIE_LOTNICZE` (
  `ID_LINII` int(11) NOT NULL,
  `NAZWA_LINII` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `LINIE_LOTNICZE`
--

INSERT INTO `LINIE_LOTNICZE` (`ID_LINII`, `NAZWA_LINII`) VALUES
(1, 'LOT'),
(2, 'Ryanair'),
(3, 'Lufthansa'),
(4, 'British Airways'),
(5, 'Air France'),
(6, 'Qatar Airways'),
(7, 'Norwegian Air Shuttle');

-- --------------------------------------------------------

--
-- Table structure for table `LOTY`
--

CREATE TABLE `LOTY` (
  `ID_LOTU` int(11) NOT NULL,
  `ID_SAMOLOTU` int(11) NOT NULL,
  `SKAD` text COLLATE utf8_polish_ci NOT NULL,
  `DATA_ODLOTU` date NOT NULL,
  `GODZINA_ODLOTU` time NOT NULL,
  `DOKAD` text COLLATE utf8_polish_ci NOT NULL,
  `DATA_PRZYLOTU` date NOT NULL,
  `CZAS_PRZYLOTU` time NOT NULL,
  `WOLNE_MIEJSCA` text COLLATE utf8_polish_ci NOT NULL,
  `Uwagi` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `LOTY`
--

INSERT INTO `LOTY` (`ID_LOTU`, `ID_SAMOLOTU`, `SKAD`, `DATA_ODLOTU`, `GODZINA_ODLOTU`, `DOKAD`, `DATA_PRZYLOTU`, `CZAS_PRZYLOTU`, `WOLNE_MIEJSCA`, `Uwagi`) VALUES
(1, 6, 'Warszawa', '2018-07-02', '08:15:00', 'Wrocław', '2018-07-02', '09:25:00', '000000000000000000', '-BRAK-'),
(2, 16, 'Poznań', '2018-07-11', '03:40:00', 'Londyn', '2018-07-11', '00:28:00', '0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000', '-BRAK-'),
(3, 21, 'Warszawa', '2018-05-24', '15:00:00', 'Wrocław', '2018-05-24', '16:00:00', '00', '-BRAK-');

-- --------------------------------------------------------

--
-- Table structure for table `POJEMNOSC_SAMOLOTU`
--

CREATE TABLE `POJEMNOSC_SAMOLOTU` (
  `ID_WERSJI_SAMOLOTU` int(11) NOT NULL,
  `NAZWA_WERSJI_SAMOLOTU` text COLLATE utf8_polish_ci NOT NULL,
  `ILOSC_MIEJSC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `POJEMNOSC_SAMOLOTU`
--

INSERT INTO `POJEMNOSC_SAMOLOTU` (`ID_WERSJI_SAMOLOTU`, `NAZWA_WERSJI_SAMOLOTU`, `ILOSC_MIEJSC`) VALUES
(154, 'Tupolew Tu154M', 180),
(170, 'Embraer 270', 70),
(380, 'Airbus A380', 853),
(500, 'Eclipse 500', 5),
(737, 'Boeing 737', 146),
(787, 'Boeing 787', 330);

-- --------------------------------------------------------

--
-- Table structure for table `PRACOWNICY`
--

CREATE TABLE `PRACOWNICY` (
  `ID` int(11) NOT NULL,
  `NAZWISKO` text COLLATE utf8_polish_ci NOT NULL,
  `IMIE` text COLLATE utf8_polish_ci NOT NULL,
  `HASLO` text COLLATE utf8_polish_ci NOT NULL,
  `MAIL` text COLLATE utf8_polish_ci NOT NULL,
  `TELEFON` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `PRACOWNICY`
--

INSERT INTO `PRACOWNICY` (`ID`, `NAZWISKO`, `IMIE`, `HASLO`, `MAIL`, `TELEFON`) VALUES
(1, 'root', 'root', '$2y$10$0nrdLY0oa/9hHokLB48XQ.l6vc7.xbU091lY.Z3.563dipDOryI8K', 'root@lotnisko.pl', 111111111);

-- --------------------------------------------------------

--
-- Table structure for table `REZERWACJE`
--

CREATE TABLE `REZERWACJE` (
  `ID_REZERWACJI` int(11) NOT NULL,
  `ID_KLIENTA` int(11) NOT NULL,
  `ID_LOTU` int(11) NOT NULL,
  `NUMER_MIEJSCA` int(11) NOT NULL,
  `STATUS` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SAMOLOTY`
--

CREATE TABLE `SAMOLOTY` (
  `ID_SAMOLOTU` int(11) NOT NULL,
  `ID_WERSJI_SAMOLOTU` int(11) NOT NULL,
  `ID_LINII` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `SAMOLOTY`
--

INSERT INTO `SAMOLOTY` (`ID_SAMOLOTU`, `ID_WERSJI_SAMOLOTU`, `ID_LINII`) VALUES
(1, 380, 1),
(2, 380, 1),
(3, 737, 1),
(4, 737, 1),
(5, 737, 1),
(6, 170, 1),
(7, 154, 2),
(8, 787, 2),
(9, 787, 3),
(10, 787, 3),
(11, 737, 3),
(12, 380, 4),
(13, 380, 4),
(14, 170, 5),
(15, 154, 5),
(16, 380, 6),
(17, 737, 6),
(18, 170, 6),
(19, 154, 7),
(20, 154, 7),
(21, 500, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `KLIENCI`
--
ALTER TABLE `KLIENCI`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `LINIE_LOTNICZE`
--
ALTER TABLE `LINIE_LOTNICZE`
  ADD PRIMARY KEY (`ID_LINII`);

--
-- Indexes for table `LOTY`
--
ALTER TABLE `LOTY`
  ADD PRIMARY KEY (`ID_LOTU`),
  ADD KEY `ID_SAMOLOTU` (`ID_SAMOLOTU`);

--
-- Indexes for table `POJEMNOSC_SAMOLOTU`
--
ALTER TABLE `POJEMNOSC_SAMOLOTU`
  ADD PRIMARY KEY (`ID_WERSJI_SAMOLOTU`);

--
-- Indexes for table `PRACOWNICY`
--
ALTER TABLE `PRACOWNICY`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `REZERWACJE`
--
ALTER TABLE `REZERWACJE`
  ADD PRIMARY KEY (`ID_REZERWACJI`),
  ADD KEY `ID_KLIENTA` (`ID_KLIENTA`),
  ADD KEY `ID_LOTU` (`ID_LOTU`);

--
-- Indexes for table `SAMOLOTY`
--
ALTER TABLE `SAMOLOTY`
  ADD PRIMARY KEY (`ID_SAMOLOTU`),
  ADD KEY `ID_WERSJI_SAMOLOTU` (`ID_WERSJI_SAMOLOTU`),
  ADD KEY `ID_LINI` (`ID_LINII`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `KLIENCI`
--
ALTER TABLE `KLIENCI`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `LINIE_LOTNICZE`
--
ALTER TABLE `LINIE_LOTNICZE`
  MODIFY `ID_LINII` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `LOTY`
--
ALTER TABLE `LOTY`
  MODIFY `ID_LOTU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `PRACOWNICY`
--
ALTER TABLE `PRACOWNICY`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `REZERWACJE`
--
ALTER TABLE `REZERWACJE`
  MODIFY `ID_REZERWACJI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `SAMOLOTY`
--
ALTER TABLE `SAMOLOTY`
  MODIFY `ID_SAMOLOTU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `LOTY`
--
ALTER TABLE `LOTY`
  ADD CONSTRAINT `loty_ibfk_1` FOREIGN KEY (`ID_SAMOLOTU`) REFERENCES `SAMOLOTY` (`ID_SAMOLOTU`);

--
-- Constraints for table `REZERWACJE`
--
ALTER TABLE `REZERWACJE`
  ADD CONSTRAINT `rezerwacje_ibfk_1` FOREIGN KEY (`ID_KLIENTA`) REFERENCES `KLIENCI` (`ID`),
  ADD CONSTRAINT `rezerwacje_ibfk_2` FOREIGN KEY (`ID_LOTU`) REFERENCES `LOTY` (`ID_LOTU`);

--
-- Constraints for table `SAMOLOTY`
--
ALTER TABLE `SAMOLOTY`
  ADD CONSTRAINT `samoloty_ibfk_1` FOREIGN KEY (`ID_WERSJI_SAMOLOTU`) REFERENCES `POJEMNOSC_SAMOLOTU` (`ID_WERSJI_SAMOLOTU`),
  ADD CONSTRAINT `samoloty_ibfk_2` FOREIGN KEY (`ID_LINII`) REFERENCES `LINIE_LOTNICZE` (`ID_LINII`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
