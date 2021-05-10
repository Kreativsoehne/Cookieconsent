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
UPDATE `tl_page` SET `cookieconsent_enable`='0', `cookieconsent_message`='<p>By selecting \"Accept\" you consent to the use of cookies and similar technologies on our website. This allows us to track your activities based on device and browser settings. As a result, we are able to ensure and continuously improve the functionality of our website. The processing is carried out for statistical analysis and reach metrics. This involves data being passed on to third parties, including those outside the European Union where it is processed. You can consent to further information also for individual purposes or individual functions or revoke your consent at any time in the future.</p>', `cookieconsent_settings_message`='<p>Consent to cookies and similar functions</p>', `cookieconsent_heading`='<i class=\"fa fa-cookie-bite\" aria-hidden=\"true\"></i> Privacy Policy' WHERE `id`='1';

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
