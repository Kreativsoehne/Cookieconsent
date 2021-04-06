-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cookieconsent_dev`
--

--
-- Updateing data for table `tl_page`
--
UPDATE `tl_page` SET `cookieconsent_enable`='0', `cookieconsent_message`='<p>Mit der Auswahl \"Tracking akzeptieren\" stimmen Sie der Nutzung von Cookies und ähnlichen Technologien auf unserer Webseite zu. Dadurch können wir Ihre Aktivitäten anhand von Geräte- und Browsereinstellungen nachvollziehen. Dies ermöglicht es uns, Funktionalitäten unserer Website sicherzustellen und stetig zu verbessern. Die Verarbeitung erfolgt zur statistischen Analyse und Reichweitenmessung. Dabei werden Daten an Dritte auch außerhalb der Europäischen Union weitergegeben und dort verarbeitet. Sie können Ihre Einwilligung auf Grundlage weiterer Informationen auch für einzelne Zwecke oder einzelne Funktionen erteilen oder jederzeit für die Zukunft widerrufen.</p>', `cookieconsent_settings_message`='<p>Einwilligung für Cookies und ähnliche Funktionen</p>', `cookieconsent_heading`='<i class=\"fa fa-cookie-bite\" aria-hidden=\"true\"></i> Datenschutz[-]einstellungen' WHERE `id`='1';

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
