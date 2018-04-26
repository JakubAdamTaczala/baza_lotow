-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 25 Kwi 2018, 11:54
-- Wersja serwera: 10.1.31-MariaDB
-- Wersja PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `baza_lotow`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `KLIENCI`
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
-- Zrzut danych tabeli `KLIENCI`
--

INSERT INTO `KLIENCI` (`ID`, `NAZWISKO`, `IMIE`, `HASLO`, `MAIL`, `TELEFON`) VALUES
(1, 'user', 'user', '$2y$10$FQwQYXaw3llGGw5rj2Z87ex63HlmV6E.cXB7Ivletbf3jDc4.K9gy', 'user@baza.pl', 999999999),
(2, 'Adamczewski', 'Franciszek', 'haslo123', 'franicszek.adamczewski@baza.pl', 644634879),
(3, 'Kwaśniewska', 'Anna', 'toJestHaslo', 'anna.kwasniewska@baza.pl', 845364879),
(4, 'Rutkowska', 'Aleksandra', 'haselko', 'aleksandra.rutkowska.pl', 845000879),
(5, 'test', 'test', '$2y$10$sMSR.i58dlkyflTwadQWW.d9XsOK/6CML5F227kF2YjOQHVoq7ZO.', 'test@baza.pl', 999111555);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `LINIE_LOTNICZE`
--

CREATE TABLE `LINIE_LOTNICZE` (
  `ID_LINI` int(11) NOT NULL,
  `NAZWA_LINI` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `LINIE_LOTNICZE`
--

INSERT INTO `LINIE_LOTNICZE` (`ID_LINI`, `NAZWA_LINI`) VALUES
(1, 'LOT'),
(2, 'Ryanair'),
(3, 'Lufthansa'),
(4, 'British Airways'),
(5, 'Air France'),
(6, 'Qatar Airways'),
(7, 'Norwegian Air Shuttle');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `LOTY`
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
  `WOLNE_MIEJSCA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `LOTY`
--

INSERT INTO `LOTY` (`ID_LOTU`, `ID_SAMOLOTU`, `SKAD`, `DATA_ODLOTU`, `GODZINA_ODLOTU`, `DOKAD`, `DATA_PRZYLOTU`, `CZAS_PRZYLOTU`, `WOLNE_MIEJSCA`) VALUES
(1, 6, 'Warszawa', '2018-07-02', '08:15:00', 'Wrocław', '2018-07-02', '09:25:00', 70),
(2, 16, 'Poznań', '2018-07-11', '03:40:00', 'Londyn', '2018-07-11', '00:28:00', 850);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `POJEMNOSC_SAMOLOTU`
--

CREATE TABLE `POJEMNOSC_SAMOLOTU` (
  `ID_WERSJI_SAMOLOTU` int(11) NOT NULL,
  `NAZWA_WERSJI_SAMOLOTU` text COLLATE utf8_polish_ci NOT NULL,
  `ILOSC_MIEJSC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `POJEMNOSC_SAMOLOTU`
--

INSERT INTO `POJEMNOSC_SAMOLOTU` (`ID_WERSJI_SAMOLOTU`, `NAZWA_WERSJI_SAMOLOTU`, `ILOSC_MIEJSC`) VALUES
(154, 'Tupolew Tu150', 180),
(170, 'Embraer 270', 70),
(380, 'Airbud A380', 853),
(737, 'Boeing 737', 146),
(787, 'Boeing 787', 330);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `PRACOWNICY`
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
-- Zrzut danych tabeli `PRACOWNICY`
--

INSERT INTO `PRACOWNICY` (`ID`, `NAZWISKO`, `IMIE`, `HASLO`, `MAIL`, `TELEFON`) VALUES
(1, 'root', 'root', '$2y$10$0nrdLY0oa/9hHokLB48XQ.l6vc7.xbU091lY.Z3.563dipDOryI8K', 'root@lotnisko.pl', 111111111),
(2, 'Bożydar', 'Natalia', 'password', 'natalia.bozydar@lotnisko.pl', 111222333);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `REZERWACJE`
--

CREATE TABLE `REZERWACJE` (
  `ID_REZERWACJI` int(11) NOT NULL,
  `ID_KLIENTA` int(11) NOT NULL,
  `ID_LOTU` int(11) NOT NULL,
  `ILOSC_MIEJSC` int(11) NOT NULL,
  `STATUS` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `REZERWACJE`
--

INSERT INTO `REZERWACJE` (`ID_REZERWACJI`, `ID_KLIENTA`, `ID_LOTU`, `ILOSC_MIEJSC`, `STATUS`) VALUES
(1, 3, 2, 2, 'REZERWACJA'),
(2, 1, 2, 1, 'ZAPŁACONO'),
(3, 2, 1, 1, 'ANULOWANO');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `SAMOLOTY`
--

CREATE TABLE `SAMOLOTY` (
  `ID_SAMOLOTU` int(11) NOT NULL,
  `ID_WERSJI_SAMOLOTU` int(11) NOT NULL,
  `ID_LINI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `SAMOLOTY`
--

INSERT INTO `SAMOLOTY` (`ID_SAMOLOTU`, `ID_WERSJI_SAMOLOTU`, `ID_LINI`) VALUES
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
(20, 154, 7);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `KLIENCI`
--
ALTER TABLE `KLIENCI`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `LINIE_LOTNICZE`
--
ALTER TABLE `LINIE_LOTNICZE`
  ADD PRIMARY KEY (`ID_LINI`);

--
-- Indeksy dla tabeli `LOTY`
--
ALTER TABLE `LOTY`
  ADD PRIMARY KEY (`ID_LOTU`),
  ADD KEY `ID_SAMOLOTU` (`ID_SAMOLOTU`);

--
-- Indeksy dla tabeli `POJEMNOSC_SAMOLOTU`
--
ALTER TABLE `POJEMNOSC_SAMOLOTU`
  ADD PRIMARY KEY (`ID_WERSJI_SAMOLOTU`);

--
-- Indeksy dla tabeli `PRACOWNICY`
--
ALTER TABLE `PRACOWNICY`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `REZERWACJE`
--
ALTER TABLE `REZERWACJE`
  ADD PRIMARY KEY (`ID_REZERWACJI`),
  ADD KEY `ID_KLIENTA` (`ID_KLIENTA`),
  ADD KEY `ID_LOTU` (`ID_LOTU`);

--
-- Indeksy dla tabeli `SAMOLOTY`
--
ALTER TABLE `SAMOLOTY`
  ADD PRIMARY KEY (`ID_SAMOLOTU`),
  ADD KEY `ID_WERSJI_SAMOLOTU` (`ID_WERSJI_SAMOLOTU`),
  ADD KEY `ID_LINI` (`ID_LINI`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `KLIENCI`
--
ALTER TABLE `KLIENCI`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `LINIE_LOTNICZE`
--
ALTER TABLE `LINIE_LOTNICZE`
  MODIFY `ID_LINI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `LOTY`
--
ALTER TABLE `LOTY`
  MODIFY `ID_LOTU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `PRACOWNICY`
--
ALTER TABLE `PRACOWNICY`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `REZERWACJE`
--
ALTER TABLE `REZERWACJE`
  MODIFY `ID_REZERWACJI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `SAMOLOTY`
--
ALTER TABLE `SAMOLOTY`
  MODIFY `ID_SAMOLOTU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `LOTY`
--
ALTER TABLE `LOTY`
  ADD CONSTRAINT `loty_ibfk_1` FOREIGN KEY (`ID_SAMOLOTU`) REFERENCES `SAMOLOTY` (`ID_SAMOLOTU`);

--
-- Ograniczenia dla tabeli `REZERWACJE`
--
ALTER TABLE `REZERWACJE`
  ADD CONSTRAINT `rezerwacje_ibfk_1` FOREIGN KEY (`ID_KLIENTA`) REFERENCES `KLIENCI` (`ID`),
  ADD CONSTRAINT `rezerwacje_ibfk_2` FOREIGN KEY (`ID_LOTU`) REFERENCES `LOTY` (`ID_LOTU`);

--
-- Ograniczenia dla tabeli `SAMOLOTY`
--
ALTER TABLE `SAMOLOTY`
  ADD CONSTRAINT `samoloty_ibfk_1` FOREIGN KEY (`ID_WERSJI_SAMOLOTU`) REFERENCES `POJEMNOSC_SAMOLOTU` (`ID_WERSJI_SAMOLOTU`),
  ADD CONSTRAINT `samoloty_ibfk_2` FOREIGN KEY (`ID_LINI`) REFERENCES `LINIE_LOTNICZE` (`ID_LINI`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
