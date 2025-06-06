-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2025 a las 22:55:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-activity_log`
--

CREATE TABLE `t-activity_log` (
  `LOG_ID` int(11) NOT NULL,
  `SESSION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ACTION` varchar(45) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-career`
--

CREATE TABLE `t-career` (
  `CAREER_ID` int(8) NOT NULL,
  `CAREER_NAME` varchar(255) NOT NULL,
  `CAREER_CODE` int(11) NOT NULL,
  `MINIMUM_GRADE` decimal(10,2) UNSIGNED NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-career`
--

INSERT INTO `t-career` (`CAREER_ID`, `CAREER_NAME`, `CAREER_CODE`, `MINIMUM_GRADE`, `CREATION_DATE`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) VALUES
(3, 'TECNICO SUPERIOR UNIVERSITARIO EN ENFERMERIA', 3016, 14.00, '2025-05-04 17:58:15', 3, '2025-05-26 17:36:52', 3, '2025-05-04 17:58:15', 3, '2025-05-04 17:58:15', 1),
(4, 'INGENIERIA INFORMATICA', 2016, 15.00, '2025-05-10 15:09:45', 3, '2025-05-17 22:17:55', 3, '2025-05-10 15:09:45', 3, '2025-05-10 15:09:45', 1),
(5, 'INGENIERIA AGROINSDUSTRIAL', 1916, 15.00, '2025-05-19 22:08:26', 3, '2025-05-19 22:31:50', 3, '2025-05-19 22:08:26', 3, '2025-05-19 22:08:26', 1),
(7, 'CARRERA DE PRUEBA', 1561, 16.00, '2025-05-19 22:11:07', 3, '2025-05-25 17:20:09', 3, '2025-05-19 22:11:07', 3, '2025-05-19 22:11:07', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-career_internship_type`
--

CREATE TABLE `t-career_internship_type` (
  `ID_CAREER_INTERNSHIP_TYPE_ID` int(8) NOT NULL,
  `CAREER_ID` int(8) NOT NULL,
  `INTERNSHIP_TYPE_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-career_internship_type`
--

INSERT INTO `t-career_internship_type` (`ID_CAREER_INTERNSHIP_TYPE_ID`, `CAREER_ID`, `INTERNSHIP_TYPE_ID`) VALUES
(4, 5, 2),
(5, 5, 3),
(9, 7, 2),
(10, 7, 3),
(17, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-change_log`
--

CREATE TABLE `t-change_log` (
  `CHANGE_LOG_ID` int(11) NOT NULL,
  `DATE_TIME` datetime NOT NULL,
  `TABLE_ID` int(11) NOT NULL,
  `COLUMN_ID` int(11) NOT NULL,
  `OPERATION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `NEW_VALUE` varchar(45) NOT NULL,
  `OLD_VALUE` varchar(45) NOT NULL,
  `IP_ADDRESS` varchar(45) NOT NULL,
  `FORM_ID` int(11) NOT NULL,
  `PRINT_EMAIL` varchar(60) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-columns`
--

CREATE TABLE `t-columns` (
  `COLUMN_ID` int(11) NOT NULL,
  `TABLE_ID` int(11) NOT NULL,
  `COLUMN_NAME` varchar(25) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-config`
--

CREATE TABLE `t-config` (
  `CONFIG_ID` int(11) NOT NULL,
  `RECOVERY_EMAIL` tinyint(4) NOT NULL,
  `BLOCKING_DAYS` tinyint(4) NOT NULL,
  `WRONG_KEY_LOCK` tinyint(4) NOT NULL,
  `ATTEMPTS_KEY_BLOCK` tinyint(4) NOT NULL,
  `KEY_EXPIRATION` int(11) NOT NULL,
  `EXPIRATION_DAYS` tinyint(4) NOT NULL,
  `USER_UPPERCASE` tinyint(4) NOT NULL,
  `USER_LOWERCASE` tinyint(4) NOT NULL,
  `USER_NUMBERS` tinyint(4) NOT NULL,
  `USER_SPECIAL_CHARACTERS` tinyint(4) NOT NULL,
  `USER_NUM_UPPERCASE` int(11) NOT NULL,
  `USER_NUM_LOWERCASE` int(11) NOT NULL,
  `USER_NUM_NUMBERS` int(11) NOT NULL,
  `USER_NUM_SPECIAL_CHARACTERS` int(11) NOT NULL,
  `KEY_UPPERCASE` tinyint(4) NOT NULL,
  `KEY_LOWERCASE` tinyint(4) NOT NULL,
  `KEY_NUMBERS` tinyint(4) NOT NULL,
  `KEY_SPECIAL_CHARACTERS` tinyint(4) NOT NULL,
  `KEY_NUM_UPPERCASE` int(11) NOT NULL,
  `KEY_NUM_LOWERCASE` int(11) NOT NULL,
  `KEY_NUM_NUMBERS` int(11) NOT NULL,
  `KEY_NUM_SPECIAL_CHARACTERS` int(11) NOT NULL,
  `USER_LENGTH` int(11) NOT NULL,
  `KEY_LEGTH` int(11) NOT NULL,
  `SECURITY_QUESTIONS` tinyint(4) NOT NULL,
  `TOTAL_QUESTIONS` int(11) NOT NULL,
  `TOTAL_PRESET_QUESTIONS` int(11) NOT NULL,
  `TOTAL_USER_QUESTIONS` int(11) NOT NULL,
  `TOTAL_ANSWERS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-config`
--

INSERT INTO `t-config` (`CONFIG_ID`, `RECOVERY_EMAIL`, `BLOCKING_DAYS`, `WRONG_KEY_LOCK`, `ATTEMPTS_KEY_BLOCK`, `KEY_EXPIRATION`, `EXPIRATION_DAYS`, `USER_UPPERCASE`, `USER_LOWERCASE`, `USER_NUMBERS`, `USER_SPECIAL_CHARACTERS`, `USER_NUM_UPPERCASE`, `USER_NUM_LOWERCASE`, `USER_NUM_NUMBERS`, `USER_NUM_SPECIAL_CHARACTERS`, `KEY_UPPERCASE`, `KEY_LOWERCASE`, `KEY_NUMBERS`, `KEY_SPECIAL_CHARACTERS`, `KEY_NUM_UPPERCASE`, `KEY_NUM_LOWERCASE`, `KEY_NUM_NUMBERS`, `KEY_NUM_SPECIAL_CHARACTERS`, `USER_LENGTH`, `KEY_LEGTH`, `SECURITY_QUESTIONS`, `TOTAL_QUESTIONS`, `TOTAL_PRESET_QUESTIONS`, `TOTAL_USER_QUESTIONS`, `TOTAL_ANSWERS`) VALUES
(1, 1, 0, 0, 3, 0, 120, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-institution`
--

CREATE TABLE `t-institution` (
  `INSTITUTION_ID` int(8) NOT NULL,
  `INSTITUTION_NAME` varchar(255) NOT NULL,
  `INSTITUTION_ADDRESS` varchar(255) NOT NULL,
  `INSTITUTION_CONTACT` varchar(12) NOT NULL,
  `PRACTICE_TYPE` varchar(255) NOT NULL,
  `REGION` varchar(255) NOT NULL,
  `NUCLEUS` varchar(255) NOT NULL,
  `EXTENSION` varchar(255) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `INSTITUTION_TYPE` varchar(255) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `RIF` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-institution_manager`
--

CREATE TABLE `t-institution_manager` (
  `MANAGER_ID` int(8) NOT NULL,
  `MANAGER_CI` varchar(10) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `SECOND_NAME` varchar(255) DEFAULT NULL,
  `SURNAME` varchar(255) NOT NULL,
  `SECOND_SURNAME` varchar(255) DEFAULT NULL,
  `CONTACT_PHONE` varchar(12) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `INSTITUTION_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-internships_period`
--

CREATE TABLE `t-internships_period` (
  `PERIOD_ID` int(8) NOT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `DESCRIPTION` varchar(45) NOT NULL,
  `PERIOD_STATUS` varchar(45) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `T-INTERNSHIPS_CODE` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-internship_type`
--

CREATE TABLE `t-internship_type` (
  `INTERNSHIP_TYPE_ID` int(8) NOT NULL,
  `NAME` varchar(40) NOT NULL,
  `PRIORITY` tinyint(1) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-internship_type`
--

INSERT INTO `t-internship_type` (`INTERNSHIP_TYPE_ID`, `NAME`, `PRIORITY`, `CREATION_DATE`, `STATUS`) VALUES
(1, 'ORDINARIA', 0, '2025-05-05 01:24:07', 1),
(2, 'HOSPITALARIA', 1, '2025-05-05 01:25:00', 1),
(3, 'COMUNITARIA', 2, '2025-05-05 01:25:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-key_history`
--

CREATE TABLE `t-key_history` (
  `KEY_HISTORY_ID` int(11) NOT NULL,
  `USER_KEY_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `END_DATE` varchar(45) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-list`
--

CREATE TABLE `t-list` (
  `LIST_ID` int(8) NOT NULL,
  `NAME` varchar(40) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `t-list`
--

INSERT INTO `t-list` (`LIST_ID`, `NAME`, `CREATION_DATE`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) VALUES
(1, 'Sexo', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(2, 'Registro Civil', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(3, 'Nacionalidad ', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(4, 'Regimen/Turno', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(5, 'Trabajo', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(6, 'Tipo de empresa', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(7, 'Rif', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(8, 'Tipo de Practica', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(9, 'Condicion', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(10, 'Dedicacion', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(11, 'Categoria', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(12, 'Tipo de estudiante', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(13, 'Rango Militar', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(14, 'Estatus Pasantia', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(15, 'Estatus Periodo', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(16, 'Region', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(17, 'Nucleo', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(18, 'Extensión', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(19, 'Traslado', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(20, 'Profesión', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1),
(21, 'Carrera', '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1, '2025-03-11 17:03:01', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-operation`
--

CREATE TABLE `t-operation` (
  `OPERATION_ID` int(11) NOT NULL,
  `ACTION` varchar(45) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-permissions`
--

CREATE TABLE `t-permissions` (
  `PERMISSIONS_ID` int(11) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-preset_questions`
--

CREATE TABLE `t-preset_questions` (
  `PRESET_QUESTION_ID` int(11) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  `ANSWER` varchar(255) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-preset_questions`
--

INSERT INTO `t-preset_questions` (`PRESET_QUESTION_ID`, `DESCRIPTION`, `ANSWER`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) VALUES
(1, '¿Cuál era el apodo de tu mejor amigo de la infancia?', 'QWE', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1),
(2, '¿En qué ciudad se conocieron sus padres?', 'ASD', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1),
(3, '¿Cuál es el apellido de tu vecino?', 'ZXC', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-professional_practices`
--

CREATE TABLE `t-professional_practices` (
  `PROFESSIONAL_PRACTICE_ID` int(8) NOT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `REPORT_TITLE` varchar(255) NOT NULL,
  `REGISTRATION_DATE` datetime NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `GRADE` decimal(5,0) UNSIGNED ZEROFILL NOT NULL,
  `PRACTICES_STATUS` varchar(45) NOT NULL,
  `TRANSFER` tinyint(1) NOT NULL,
  `TOUR` varchar(255) NOT NULL,
  `PERIOD_ID` int(8) NOT NULL,
  `TUTOR_ID` int(8) NOT NULL,
  `TUTOR_TYPE` varchar(45) NOT NULL,
  `INSTITUTION_ID` int(8) NOT NULL,
  `STUDENTS_ID` int(8) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `MANAGER_ID` int(8) NOT NULL,
  `OBSERVATION` varchar(255) NOT NULL,
  `INTERSHIP_STATUS` int(2) NOT NULL,
  `INTERNSHIP_TYPE_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-roles`
--

CREATE TABLE `t-roles` (
  `ID_ROLS` int(11) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-roles_permissions`
--

CREATE TABLE `t-roles_permissions` (
  `ROLES_ID` int(11) NOT NULL,
  `PERMISSIONS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-security_questions`
--

CREATE TABLE `t-security_questions` (
  `SECURITY_QUESTIONS_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `PRESET_QUESTION_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-security_questions`
--

INSERT INTO `t-security_questions` (`SECURITY_QUESTIONS_ID`, `USER_ID`, `PRESET_QUESTION_ID`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-session`
--

CREATE TABLE `t-session` (
  `SESSION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `LOGIN_TIME` datetime NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-session`
--

INSERT INTO `t-session` (`SESSION_ID`, `USER_ID`, `LOGIN_TIME`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) VALUES
(1, 3, '2025-05-01 21:14:42', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 3, '2025-05-01 21:19:26', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 3, '2025-05-01 21:27:58', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, 3, '2025-05-03 18:05:10', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(5, 3, '2025-05-04 17:23:06', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(6, 3, '2025-05-04 17:31:22', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(7, 3, '2025-05-06 19:14:57', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(8, 3, '2025-05-06 19:23:11', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(9, 3, '2025-05-06 19:24:49', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(10, 3, '2025-05-06 19:53:54', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(11, 3, '2025-05-06 20:16:02', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(12, 3, '2025-05-06 20:55:48', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(13, 3, '2025-05-10 15:05:26', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(14, 3, '2025-05-13 18:38:43', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(15, 3, '2025-05-17 13:32:38', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(16, 3, '2025-05-17 19:46:24', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(17, 3, '2025-05-18 14:49:54', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(18, 3, '2025-05-19 21:48:42', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(19, 3, '2025-05-20 20:33:18', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(20, 3, '2025-05-25 15:19:25', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(21, 3, '2025-05-25 17:12:28', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1),
(22, 3, '2025-05-26 17:24:49', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1),
(23, 3, '2025-06-01 15:58:28', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-session_attempts`
--

CREATE TABLE `t-session_attempts` (
  `ATTEMPT_ID` int(11) NOT NULL,
  `ATTEMPT_TIME` datetime NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ACTION` tinyint(4) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-session_attempts`
--

INSERT INTO `t-session_attempts` (`ATTEMPT_ID`, `ATTEMPT_TIME`, `USER_ID`, `ACTION`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) VALUES
(1, '2025-05-04 17:31:14', 3, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, '2025-05-04 17:31:17', 3, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, '2025-05-06 20:55:35', 3, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, '2025-05-06 20:55:41', 3, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(5, '2025-05-25 15:19:19', 3, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-session_history`
--

CREATE TABLE `t-session_history` (
  `SESSION_HISTORY_ID` int(11) NOT NULL,
  `SESSION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `LOGIN_TIME` datetime NOT NULL,
  `LOGOUT_TIME` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-session_history`
--

INSERT INTO `t-session_history` (`SESSION_HISTORY_ID`, `SESSION_ID`, `USER_ID`, `LOGIN_TIME`, `LOGOUT_TIME`, `STATUS`) VALUES
(1, 1, 3, '2025-05-01 21:14:42', '2025-05-01 21:19:09', 1),
(2, 2, 3, '2025-05-01 21:19:26', '2025-05-01 21:27:49', 1),
(3, 3, 3, '2025-05-01 21:27:58', '2025-05-01 21:29:08', 1),
(4, 4, 3, '2025-05-03 18:05:10', '2025-05-03 18:16:15', 1),
(5, 5, 3, '2025-05-04 17:23:06', '2025-05-04 17:26:47', 1),
(6, 6, 3, '2025-05-04 17:31:22', '2025-05-06 19:17:24', 1),
(7, 8, 3, '2025-05-06 19:23:11', '2025-05-06 19:24:44', 1),
(8, 9, 3, '2025-05-06 19:24:49', '2025-05-06 19:53:48', 1),
(9, 10, 3, '2025-05-06 19:53:54', '2025-05-06 20:15:49', 1),
(10, 11, 3, '2025-05-06 20:16:02', '2025-05-06 20:54:33', 1),
(11, 12, 3, '2025-05-06 20:55:48', '2025-05-20 20:58:31', 1),
(12, 20, 3, '2025-05-25 15:19:25', '2025-05-25 15:19:28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-students`
--

CREATE TABLE `t-students` (
  `STUDENTS_ID` int(8) NOT NULL,
  `STUDENTS_CI` varchar(10) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `SECOND_NAME` varchar(255) DEFAULT NULL,
  `SURNAME` varchar(255) NOT NULL,
  `SECOND_SURNAME` varchar(255) DEFAULT NULL,
  `GENDER` char(10) NOT NULL,
  `BIRTHDATE` date NOT NULL,
  `CONTACT_PHONE` varchar(15) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `ADDRESS` varchar(255) NOT NULL,
  `MARITAL_STATUS` varchar(45) NOT NULL,
  `SEMESTER` varchar(45) NOT NULL,
  `SECTION` varchar(45) NOT NULL,
  `REGIME` varchar(45) NOT NULL,
  `STUDENT_TYPE` varchar(45) NOT NULL,
  `MILITARY_RANK` varchar(45) DEFAULT NULL,
  `EMPLOYMENT` varchar(2) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `REGISTRATION_DATE` datetime DEFAULT NULL,
  `CAREER_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-students`
--

INSERT INTO `t-students` (`STUDENTS_ID`, `STUDENTS_CI`, `NAME`, `SECOND_NAME`, `SURNAME`, `SECOND_SURNAME`, `GENDER`, `BIRTHDATE`, `CONTACT_PHONE`, `EMAIL`, `ADDRESS`, `MARITAL_STATUS`, `SEMESTER`, `SECTION`, `REGIME`, `STUDENT_TYPE`, `MILITARY_RANK`, `EMPLOYMENT`, `STATUS`, `REGISTRATION_DATE`, `CAREER_ID`) VALUES
(1, 'V-29847715', 'JESUS', 'DAVID', 'PEREIRA', 'TORCATES', 'M', '2002-10-04', '0426-5311144', 'DAVIDTORCATES0410@GMAIL.COM', '', 'S', '341', '123', 'S', 'CIV', ' ', 'NO', 1, '2025-05-17 00:00:00', 4),
(3, 'V-13227478', 'ADASD', 'ASDA', 'ADFWS', 'QWER', 'M', '1970-02-14', '123', 'DA@F', '', 'S', '341', '123', 'D', 'CIV', ' ', 'NO', 1, '2025-05-17 00:00:00', 3),
(4, 'V-1245647', 'ADDA', 'NMASDL', 'QPORE', 'SOLLD', 'F', '2007-11-27', '0412-5313443', 'CADALE6601@BETZENN.COM', '', 'S', '341', '123', 'S', 'CIV', ' ', 'NO', 1, '2025-05-25 17:43:10', 7),
(5, 'V-12', 'QWEQE ', ' ', ' ', ' ', 'F', '2007-12-30', '1123112', 'BASELOV910@ACEDBY.COM', '', 'V', '123', '123', 'N', 'MIL', ' ', 'NO', 1, '2025-06-01 16:55:45', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-tables`
--

CREATE TABLE `t-tables` (
  `TABLE_ID` int(11) NOT NULL,
  `NAME` varchar(25) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `PHYSICAL_NAME` varchar(25) NOT NULL,
  `LOG` tinyint(4) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-tutors`
--

CREATE TABLE `t-tutors` (
  `TUTOR_ID` int(8) NOT NULL,
  `TUTOR_CI` varchar(10) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `SECOND_NAME` varchar(255) DEFAULT NULL,
  `SURNAME` varchar(255) NOT NULL,
  `SECOND_SURNAME` varchar(255) DEFAULT NULL,
  `CONTACT_PHONE` varchar(12) NOT NULL,
  `GENDER` varchar(45) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PROFESSION` varchar(255) NOT NULL,
  `CONDITION` varchar(45) NOT NULL,
  `DEDICATION` varchar(45) NOT NULL,
  `CATEGORY` varchar(45) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-user`
--

CREATE TABLE `t-user` (
  `USER_ID` int(11) NOT NULL,
  `USER` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `USER_CI` varchar(10) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `SECOND_NAME` varchar(255) DEFAULT NULL,
  `SURNAME` varchar(255) NOT NULL,
  `SECOND_SURNAME` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PHONE_NUMBER` varchar(12) DEFAULT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `LOGIN` tinyint(4) NOT NULL,
  `TERMS_CONDITIONS` varchar(45) NOT NULL,
  `STATUS_SESSION` tinyint(4) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-user`
--

INSERT INTO `t-user` (`USER_ID`, `USER`, `USER_CI`, `NAME`, `SECOND_NAME`, `SURNAME`, `SECOND_SURNAME`, `EMAIL`, `PHONE_NUMBER`, `CREATION_DATE`, `LOGIN`, `TERMS_CONDITIONS`, `STATUS_SESSION`, `STATUS`) VALUES
(3, 'admin', '00000000', 'admin', '', '', '', 'VIFAMIX371@BOCAPIES.COM', '04245313443', '2025-05-01 21:14:36', 1, '0', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-user_key`
--

CREATE TABLE `t-user_key` (
  `USER_KEY_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `KEY` varchar(255) NOT NULL,
  `START_DATE` datetime NOT NULL,
  `END_DATE` datetime NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `t-user_key`
--

INSERT INTO `t-user_key` (`USER_KEY_ID`, `USER_ID`, `KEY`, `START_DATE`, `END_DATE`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) VALUES
(3, 3, '$2y$10$D70iEW4rD6BpccXjnKgzk.KWoEX4s/qhRqebwbU6hwMye.aCFGlzq', '2025-05-01 21:14:36', '2025-05-01 21:27:46', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(10, 3, '$2y$10$JBXuzrJAzJ0eJgR/Pmq43uhezSoVKOo7KF4MwFmXsybb8riabTtfe', '2025-05-01 21:27:46', '2025-08-29 21:27:46', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-user_questions`
--

CREATE TABLE `t-user_questions` (
  `USER_QUESTION_ID` int(11) NOT NULL,
  `QUESTION` varchar(45) NOT NULL,
  `ANSWER` varchar(45) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-user_roles`
--

CREATE TABLE `t-user_roles` (
  `ID_USER` int(11) NOT NULL,
  `ID_ROLES` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-value_list`
--

CREATE TABLE `t-value_list` (
  `VALUE_LIST_ID` int(8) NOT NULL,
  `NAME` varchar(45) NOT NULL,
  `ABBREVIATION` varchar(8) DEFAULT NULL,
  `LIST_ID` int(11) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `t-value_list`
--

INSERT INTO `t-value_list` (`VALUE_LIST_ID`, `NAME`, `ABBREVIATION`, `LIST_ID`, `CREATION_DATE`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) VALUES
(1, 'FEMENINO', 'F', 1, '2025-03-22 18:38:48', 1, '2025-03-22 18:38:48', 1, '2025-03-22 18:38:48', 1, '2025-03-22 18:38:48', 1),
(2, 'MASCULINO', 'M', 1, '2025-03-22 18:41:55', 1, '2025-03-22 18:41:55', 1, '2025-03-22 18:41:55', 1, '2025-03-22 18:41:55', 1),
(3, 'SOLTERO', 'S', 2, '2025-03-22 18:42:40', 1, '2025-03-22 18:42:40', 1, '2025-03-22 18:42:40', 1, '2025-03-22 18:42:40', 1),
(4, 'CASADO', 'C', 2, '2025-03-22 18:43:33', 1, '2025-03-22 18:43:33', 1, '2025-03-22 18:43:33', 1, '2025-03-22 18:43:33', 1),
(5, 'DIVORCIADO', 'D', 2, '2025-03-22 18:44:03', 1, '2025-03-22 18:44:03', 1, '2025-03-22 18:44:03', 1, '2025-03-22 18:44:03', 1),
(6, 'CONCUBINO', 'CB', 2, '2025-03-22 18:44:27', 1, '2025-03-22 18:44:27', 1, '2025-03-22 18:44:27', 1, '2025-03-22 18:44:27', 1),
(7, 'VIUDO', 'V', 2, '2025-03-22 18:45:11', 1, '2025-03-22 18:45:11', 1, '2025-03-22 18:45:11', 1, '2025-03-22 18:45:11', 1),
(8, 'VENEZOLANO', 'V', 3, '2025-03-22 18:45:36', 1, '2025-03-22 18:45:36', 1, '2025-03-22 18:45:36', 1, '2025-03-22 18:45:36', 1),
(9, 'EXTRANJERO', 'E', 3, '2025-03-22 18:46:02', 1, '2025-03-22 18:46:02', 1, '2025-03-22 18:46:02', 1, '2025-03-22 18:46:02', 1),
(10, 'DIURNO', 'D', 4, '2025-03-22 18:46:52', 1, '2025-03-22 18:46:52', 1, '2025-03-22 18:46:52', 1, '2025-03-22 18:46:52', 1),
(11, 'NOCTURNO', 'N', 4, '2025-03-22 18:47:17', 1, '2025-03-22 18:47:17', 1, '2025-03-22 18:47:17', 1, '2025-03-22 18:47:17', 1),
(12, 'SABATINO', 'S', 4, '2025-03-22 18:47:41', 1, '2025-03-22 18:47:41', 1, '2025-03-22 18:47:41', 1, '2025-03-22 18:47:41', 1),
(13, 'SI', 'SI', 5, '2025-03-22 18:48:08', 1, '2025-03-22 18:48:08', 1, '2025-03-22 18:48:08', 1, '2025-03-22 18:48:08', 1),
(14, 'NO', 'NO', 5, '2025-03-22 18:48:35', 1, '2025-03-22 18:48:35', 1, '2025-03-22 18:48:35', 1, '2025-03-22 18:48:35', 1),
(15, 'PUBLICA', 'PUB', 6, '2025-03-22 18:48:49', 1, '2025-03-22 18:48:49', 1, '2025-03-22 18:48:49', 1, '2025-03-22 18:48:49', 1),
(16, 'PRIVADA', 'PRIV', 6, '2025-03-22 18:49:21', 1, '2025-03-22 18:49:21', 1, '2025-03-22 18:49:21', 1, '2025-03-22 18:49:21', 1),
(17, 'MIXTA', 'MIX', 6, '2025-03-22 18:49:56', 1, '2025-03-22 18:49:56', 1, '2025-03-22 18:49:56', 1, '2025-03-22 18:49:56', 1),
(18, 'JURIDICO', 'J', 7, '2025-03-22 18:50:20', 1, '2025-03-22 18:50:20', 1, '2025-03-22 18:50:20', 1, '2025-03-22 18:50:20', 1),
(19, 'GOBIERNO', 'G', 7, '2025-03-22 18:50:43', 1, '2025-03-22 18:50:43', 1, '2025-03-22 18:50:43', 1, '2025-03-22 18:50:43', 1),
(20, 'COMUNA O CONSEJO COMUNAL', 'C', 7, '2025-03-22 18:51:04', 1, '2025-03-22 18:51:04', 1, '2025-03-22 18:51:04', 1, '2025-03-22 18:51:04', 1),
(21, 'HOSPITALARIA', 'HOSP', 8, '2025-03-22 18:51:32', 1, '2025-03-22 18:51:32', 1, '2025-03-22 18:51:32', 1, '2025-03-22 18:51:32', 1),
(22, 'COMUNITARIA', 'COM', 8, '2025-03-22 18:52:00', 1, '2025-03-22 18:52:00', 1, '2025-03-22 18:52:00', 1, '2025-03-22 18:52:00', 1),
(23, 'ORDINARIA', 'ORD', 8, '2025-03-22 18:52:22', 1, '2025-03-22 18:52:22', 1, '2025-03-22 18:52:22', 1, '2025-03-22 18:52:22', 1),
(24, 'ORDINARIO', 'ORD', 9, '2025-03-22 18:52:43', 1, '2025-03-22 18:52:43', 1, '2025-03-22 18:52:43', 1, '2025-03-22 18:52:43', 1),
(25, 'CONTRATADO', 'CONT', 9, '2025-03-22 18:53:10', 1, '2025-03-22 18:53:10', 1, '2025-03-22 18:53:10', 1, '2025-03-22 18:53:10', 1),
(26, 'DEDICACIÓN EXCLUSIVA', 'DE', 10, '2025-03-22 18:53:42', 1, '2025-03-22 18:53:42', 1, '2025-03-22 18:53:42', 1, '2025-03-22 18:53:42', 1),
(27, 'TIEMPO COMPLETO', 'TC', 10, '2025-03-22 18:54:04', 1, '2025-03-22 18:54:04', 1, '2025-03-22 18:54:04', 1, '2025-03-22 18:54:04', 1),
(28, 'TIEMPO CONVECIONAL', 'TV', 10, '2025-03-22 18:54:28', 1, '2025-03-22 18:54:28', 1, '2025-03-22 18:54:28', 1, '2025-03-22 18:54:28', 1),
(29, 'MEDIO TIEMPO', 'MV', 10, '2025-03-22 18:54:49', 1, '2025-03-22 18:54:49', 1, '2025-03-22 18:54:49', 1, '2025-03-22 18:54:49', 1),
(30, 'AUXILIAR DOCENTE', 'AUXILIAR', 11, '2025-03-22 18:55:11', 1, '2025-03-22 18:55:11', 1, '2025-03-22 18:55:11', 1, '2025-03-22 18:55:11', 1),
(31, 'DOCENTE INSTRUCTOR', 'INSTRUCT', 11, '2025-03-22 18:55:46', 1, '2025-03-22 18:55:46', 1, '2025-03-22 18:55:46', 1, '2025-03-22 18:55:46', 1),
(32, 'DOCENTE ASISTENTE', 'ASISTENT', 11, '2025-03-22 18:56:58', 1, '2025-03-22 18:56:58', 1, '2025-03-22 18:56:58', 1, '2025-03-22 18:56:58', 1),
(33, 'DOCENTE AGREGADO', 'AGREGADO', 11, '2025-03-22 18:57:26', 1, '2025-03-22 18:57:26', 1, '2025-03-22 18:57:26', 1, '2025-03-22 18:57:26', 1),
(34, 'DOCENTE ASOCIADO', 'ASOCIADO', 11, '2025-03-22 18:57:50', 1, '2025-03-22 18:57:50', 1, '2025-03-22 18:57:50', 1, '2025-03-22 18:57:50', 1),
(35, 'DOCENTE TITULAR', 'TITULAR', 11, '2025-03-22 18:58:14', 1, '2025-03-22 18:58:14', 1, '2025-03-22 18:58:14', 1, '2025-03-22 18:58:14', 1),
(36, 'CIVIL', 'CIV', 12, '2025-03-22 18:58:31', 1, '2025-03-22 18:58:31', 1, '2025-03-22 18:58:31', 1, '2025-03-22 18:58:31', 1),
(37, 'MILITAR', 'MIL', 12, '2025-03-22 18:58:59', 1, '2025-03-22 18:58:59', 1, '2025-03-22 18:58:59', 1, '2025-03-22 18:58:59', 1),
(38, 'SUBTENIENTE', 'SBTTE', 13, '2025-03-22 18:59:22', 1, '2025-03-22 18:59:22', 1, '2025-03-22 18:59:22', 1, '2025-03-22 18:59:22', 1),
(39, 'TENIENTE', 'TTE', 13, '2025-03-22 18:59:43', 1, '2025-03-22 18:59:43', 1, '2025-03-22 18:59:43', 1, '2025-03-22 18:59:43', 1),
(40, 'CAPITAN', 'CAP', 13, '2025-03-22 19:00:21', 1, '2025-03-22 19:00:21', 1, '2025-03-22 19:00:21', 1, '2025-03-22 19:00:21', 1),
(41, 'MAYOR', 'MY', 13, '2025-03-22 19:00:41', 1, '2025-03-22 19:00:41', 1, '2025-03-22 19:00:41', 1, '2025-03-22 19:00:41', 1),
(42, 'TENIENTE CORONEL', 'TTE CNEL', 13, '2025-03-22 19:01:00', 1, '2025-03-22 19:01:00', 1, '2025-03-22 19:01:00', 1, '2025-03-22 19:01:00', 1),
(43, 'CORONEL', 'CNEL', 13, '2025-03-22 19:01:33', 1, '2025-03-22 19:01:33', 1, '2025-03-22 19:01:33', 1, '2025-03-22 19:01:33', 1),
(44, 'APROBADO', 'A', 14, '2025-03-22 19:02:06', 1, '2025-03-22 19:02:06', 1, '2025-03-22 19:02:06', 1, '2025-03-22 19:02:06', 1),
(45, 'REPROBADO', 'R', 14, '2025-03-22 19:02:24', 1, '2025-03-22 19:02:24', 1, '2025-03-22 19:02:24', 1, '2025-03-22 19:02:24', 1),
(46, 'PENDIENTE', 'PEN', 15, '2025-03-22 19:02:46', 1, '2025-03-22 19:02:46', 1, '2025-03-22 19:02:46', 1, '2025-03-22 19:02:46', 1),
(47, 'ABIERTO', 'ABT', 15, '2025-03-22 19:03:08', 1, '2025-03-22 19:03:08', 1, '2025-03-22 19:03:08', 1, '2025-03-22 19:03:08', 1),
(48, 'CULMINADO', 'CULM', 15, '2025-03-22 19:03:28', 1, '2025-03-22 19:03:28', 1, '2025-03-22 19:03:28', 1, '2025-03-22 19:03:28', 1),
(49, 'ANULADO', 'NULL', 15, '2025-03-22 19:03:51', 1, '2025-03-22 19:03:51', 1, '2025-03-22 19:03:51', 1, '2025-03-22 19:03:51', 1),
(50, 'LOS LLANOS', 'LOS LLAN', 16, '2025-03-22 19:04:11', 1, '2025-03-22 19:04:11', 1, '2025-03-22 19:04:11', 1, '2025-03-22 19:04:11', 1),
(51, 'PORTUGUESA', 'PORTUGUE', 17, '2025-03-22 19:04:35', 1, '2025-03-22 19:04:35', 1, '2025-03-22 19:04:35', 1, '2025-03-22 19:04:35', 1),
(52, 'ACARIGUA', 'ACARIGUA', 18, '2025-03-22 19:05:21', 1, '2025-03-22 19:05:21', 1, '2025-03-22 19:05:21', 1, '2025-03-22 19:05:21', 1),
(53, 'SI', 'SI', 19, '2025-03-22 19:05:45', 1, '2025-03-22 19:05:45', 1, '2025-03-22 19:05:45', 1, '2025-03-22 19:05:45', 1),
(54, 'NO', 'NO', 19, '2025-03-22 19:06:11', 1, '2025-03-22 19:06:11', 1, '2025-03-22 19:06:11', 1, '2025-03-22 19:06:11', 1),
(55, 'ENFERMERIA', 'ENF', 20, '2025-03-22 19:06:30', 1, '2025-03-22 19:06:30', 1, '2025-03-22 19:06:30', 1, '2025-03-22 19:06:30', 1),
(56, 'INGENIERIA', 'ING', 20, '2025-03-22 19:08:26', 1, '2025-03-22 19:08:26', 1, '2025-03-22 19:08:26', 1, '2025-03-22 19:08:26', 1),
(57, 'TSU EN ENFERMERIA', 'ENF', 21, '2025-03-22 19:06:48', 1, '2025-03-22 19:06:48', 1, '2025-03-22 19:06:48', 1, '2025-03-22 19:06:48', 1),
(58, 'INGENIERIA', 'ING', 21, '2025-03-22 19:07:16', 1, '2025-03-22 19:07:16', 1, '2025-03-22 19:07:16', 1, '2025-03-22 19:07:16', 1),
(59, 'NO APLICA', ' ', 13, '2025-05-18 15:37:12', 1, '2025-05-18 15:37:12', 1, '2025-05-18 15:37:12', 1, '2025-05-18 15:37:12', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-visit`
--

CREATE TABLE `t-visit` (
  `VISIT_ID` int(11) NOT NULL,
  `VISIT_DATE` date NOT NULL,
  `NOTE` varchar(255) DEFAULT NULL,
  `REQUESTED_ACTIVITY` varchar(45) NOT NULL,
  `CARRIED_ACTIVITY` varchar(45) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `TUTOR_ID` int(8) NOT NULL,
  `PROFESSIONAL_PRACTICE_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `t-activity_log`
--
ALTER TABLE `t-activity_log`
  ADD PRIMARY KEY (`LOG_ID`,`SESSION_ID`,`USER_ID`),
  ADD KEY `fk_REGISTRO_ACTIVIDAD_SESION1_idx` (`SESSION_ID`,`USER_ID`);

--
-- Indices de la tabla `t-career`
--
ALTER TABLE `t-career`
  ADD PRIMARY KEY (`CAREER_ID`),
  ADD UNIQUE KEY `CAREER_CODE_UNIQUE` (`CAREER_CODE`);

--
-- Indices de la tabla `t-career_internship_type`
--
ALTER TABLE `t-career_internship_type`
  ADD PRIMARY KEY (`ID_CAREER_INTERNSHIP_TYPE_ID`);

--
-- Indices de la tabla `t-change_log`
--
ALTER TABLE `t-change_log`
  ADD PRIMARY KEY (`CHANGE_LOG_ID`,`TABLE_ID`,`COLUMN_ID`,`OPERATION_ID`,`USER_ID`),
  ADD KEY `fk_T-CHANGE_LOG_T-TABLES1_idx` (`TABLE_ID`),
  ADD KEY `fk_T-CHANGE_LOG_T-COLUMNS1_idx` (`COLUMN_ID`),
  ADD KEY `fk_T-CHANGE_LOG_T-USER1_idx` (`USER_ID`),
  ADD KEY `fk_T-CHANGE_LOG_T-OPERATION1_idx` (`OPERATION_ID`);

--
-- Indices de la tabla `t-columns`
--
ALTER TABLE `t-columns`
  ADD PRIMARY KEY (`COLUMN_ID`,`TABLE_ID`),
  ADD KEY `fk_T-COLUMNS_T-TABLES1_idx` (`TABLE_ID`);

--
-- Indices de la tabla `t-config`
--
ALTER TABLE `t-config`
  ADD PRIMARY KEY (`CONFIG_ID`);

--
-- Indices de la tabla `t-institution`
--
ALTER TABLE `t-institution`
  ADD PRIMARY KEY (`INSTITUTION_ID`),
  ADD UNIQUE KEY `RIF_UNIQUE` (`RIF`);

--
-- Indices de la tabla `t-institution_manager`
--
ALTER TABLE `t-institution_manager`
  ADD PRIMARY KEY (`MANAGER_ID`),
  ADD UNIQUE KEY `MANAGER_CI_UNIQUE` (`MANAGER_CI`),
  ADD KEY `INSTITUTION_ID_idx` (`INSTITUTION_ID`);

--
-- Indices de la tabla `t-internships_period`
--
ALTER TABLE `t-internships_period`
  ADD PRIMARY KEY (`PERIOD_ID`),
  ADD UNIQUE KEY `T-INTERNSHIPS_CODE_UNIQUE` (`T-INTERNSHIPS_CODE`);

--
-- Indices de la tabla `t-internship_type`
--
ALTER TABLE `t-internship_type`
  ADD PRIMARY KEY (`INTERNSHIP_TYPE_ID`);

--
-- Indices de la tabla `t-key_history`
--
ALTER TABLE `t-key_history`
  ADD PRIMARY KEY (`KEY_HISTORY_ID`,`USER_KEY_ID`,`USER_ID`),
  ADD KEY `fk_HISTORIAL_CLAVE_CLAVE_USUARIO1_idx` (`USER_KEY_ID`,`USER_ID`);

--
-- Indices de la tabla `t-list`
--
ALTER TABLE `t-list`
  ADD PRIMARY KEY (`LIST_ID`);

--
-- Indices de la tabla `t-operation`
--
ALTER TABLE `t-operation`
  ADD PRIMARY KEY (`OPERATION_ID`);

--
-- Indices de la tabla `t-permissions`
--
ALTER TABLE `t-permissions`
  ADD PRIMARY KEY (`PERMISSIONS_ID`);

--
-- Indices de la tabla `t-preset_questions`
--
ALTER TABLE `t-preset_questions`
  ADD PRIMARY KEY (`PRESET_QUESTION_ID`);

--
-- Indices de la tabla `t-professional_practices`
--
ALTER TABLE `t-professional_practices`
  ADD PRIMARY KEY (`PROFESSIONAL_PRACTICE_ID`),
  ADD KEY `IdPeriodo_Pasantias_idx` (`PERIOD_ID`),
  ADD KEY `Ci_Tutor_idx` (`TUTOR_ID`),
  ADD KEY `Id_Institucion_idx` (`INSTITUTION_ID`),
  ADD KEY `Id_Estudiantes_idx` (`STUDENTS_ID`),
  ADD KEY `MANAGER_ID_idx` (`MANAGER_ID`),
  ADD KEY `INTERNSHIP_TYPE_ID_idx` (`INTERNSHIP_TYPE_ID`);

--
-- Indices de la tabla `t-roles`
--
ALTER TABLE `t-roles`
  ADD PRIMARY KEY (`ID_ROLS`);

--
-- Indices de la tabla `t-roles_permissions`
--
ALTER TABLE `t-roles_permissions`
  ADD PRIMARY KEY (`ROLES_ID`,`PERMISSIONS_ID`),
  ADD KEY `fk_ROLES_has_PERMISOS_PERMISOS1_idx` (`PERMISSIONS_ID`),
  ADD KEY `fk_ROLES_has_PERMISOS_ROLES1_idx` (`ROLES_ID`);

--
-- Indices de la tabla `t-security_questions`
--
ALTER TABLE `t-security_questions`
  ADD PRIMARY KEY (`SECURITY_QUESTIONS_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `PRESET_QUESTION_ID` (`PRESET_QUESTION_ID`);

--
-- Indices de la tabla `t-session`
--
ALTER TABLE `t-session`
  ADD PRIMARY KEY (`SESSION_ID`,`USER_ID`),
  ADD KEY `fk_SESION_USUARIO1_idx` (`USER_ID`);

--
-- Indices de la tabla `t-session_attempts`
--
ALTER TABLE `t-session_attempts`
  ADD PRIMARY KEY (`ATTEMPT_ID`,`USER_ID`),
  ADD KEY `fk_INTENTOS_DE_SESION_USUARIO1_idx` (`USER_ID`);

--
-- Indices de la tabla `t-session_history`
--
ALTER TABLE `t-session_history`
  ADD PRIMARY KEY (`SESSION_HISTORY_ID`,`SESSION_ID`,`USER_ID`),
  ADD KEY `fk_HISTORIAL_SESION_SESION1_idx` (`SESSION_ID`,`USER_ID`);

--
-- Indices de la tabla `t-students`
--
ALTER TABLE `t-students`
  ADD PRIMARY KEY (`STUDENTS_ID`),
  ADD UNIQUE KEY `STUDENTS_CI_UNIQUE` (`STUDENTS_CI`),
  ADD KEY `CAREER_ID_idx` (`CAREER_ID`);

--
-- Indices de la tabla `t-tables`
--
ALTER TABLE `t-tables`
  ADD PRIMARY KEY (`TABLE_ID`);

--
-- Indices de la tabla `t-tutors`
--
ALTER TABLE `t-tutors`
  ADD PRIMARY KEY (`TUTOR_ID`),
  ADD UNIQUE KEY `TUTOR_CI_UNIQUE` (`TUTOR_CI`);

--
-- Indices de la tabla `t-user`
--
ALTER TABLE `t-user`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `USER_CI_UNIQUE` (`USER_CI`);

--
-- Indices de la tabla `t-user_key`
--
ALTER TABLE `t-user_key`
  ADD PRIMARY KEY (`USER_KEY_ID`,`USER_ID`),
  ADD KEY `fk_CLAVE_USUARIO_USUARIO_idx` (`USER_ID`);

--
-- Indices de la tabla `t-user_questions`
--
ALTER TABLE `t-user_questions`
  ADD PRIMARY KEY (`USER_QUESTION_ID`);

--
-- Indices de la tabla `t-user_roles`
--
ALTER TABLE `t-user_roles`
  ADD PRIMARY KEY (`ID_USER`,`ID_ROLES`),
  ADD KEY `fk_USUARIO_has_ROLES_ROLES1_idx` (`ID_ROLES`),
  ADD KEY `fk_USUARIO_has_ROLES_USUARIO1_idx` (`ID_USER`);

--
-- Indices de la tabla `t-value_list`
--
ALTER TABLE `t-value_list`
  ADD PRIMARY KEY (`VALUE_LIST_ID`),
  ADD KEY `LIST_VALUE` (`LIST_ID`);

--
-- Indices de la tabla `t-visit`
--
ALTER TABLE `t-visit`
  ADD PRIMARY KEY (`VISIT_ID`),
  ADD KEY `TUTOR_ID_idx` (`TUTOR_ID`),
  ADD KEY `PROFESSIONAL_PRACTICE_ID_idx` (`PROFESSIONAL_PRACTICE_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `t-activity_log`
--
ALTER TABLE `t-activity_log`
  MODIFY `LOG_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-career`
--
ALTER TABLE `t-career`
  MODIFY `CAREER_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `t-career_internship_type`
--
ALTER TABLE `t-career_internship_type`
  MODIFY `ID_CAREER_INTERNSHIP_TYPE_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `t-change_log`
--
ALTER TABLE `t-change_log`
  MODIFY `CHANGE_LOG_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-columns`
--
ALTER TABLE `t-columns`
  MODIFY `COLUMN_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-config`
--
ALTER TABLE `t-config`
  MODIFY `CONFIG_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `t-institution_manager`
--
ALTER TABLE `t-institution_manager`
  MODIFY `MANAGER_ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-internship_type`
--
ALTER TABLE `t-internship_type`
  MODIFY `INTERNSHIP_TYPE_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t-key_history`
--
ALTER TABLE `t-key_history`
  MODIFY `KEY_HISTORY_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-list`
--
ALTER TABLE `t-list`
  MODIFY `LIST_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `t-operation`
--
ALTER TABLE `t-operation`
  MODIFY `OPERATION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-permissions`
--
ALTER TABLE `t-permissions`
  MODIFY `PERMISSIONS_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-preset_questions`
--
ALTER TABLE `t-preset_questions`
  MODIFY `PRESET_QUESTION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t-professional_practices`
--
ALTER TABLE `t-professional_practices`
  MODIFY `PROFESSIONAL_PRACTICE_ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-roles`
--
ALTER TABLE `t-roles`
  MODIFY `ID_ROLS` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-security_questions`
--
ALTER TABLE `t-security_questions`
  MODIFY `SECURITY_QUESTIONS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t-session`
--
ALTER TABLE `t-session`
  MODIFY `SESSION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `t-session_attempts`
--
ALTER TABLE `t-session_attempts`
  MODIFY `ATTEMPT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `t-session_history`
--
ALTER TABLE `t-session_history`
  MODIFY `SESSION_HISTORY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `t-students`
--
ALTER TABLE `t-students`
  MODIFY `STUDENTS_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `t-tables`
--
ALTER TABLE `t-tables`
  MODIFY `TABLE_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-tutors`
--
ALTER TABLE `t-tutors`
  MODIFY `TUTOR_ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-user`
--
ALTER TABLE `t-user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t-user_key`
--
ALTER TABLE `t-user_key`
  MODIFY `USER_KEY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `t-user_questions`
--
ALTER TABLE `t-user_questions`
  MODIFY `USER_QUESTION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-value_list`
--
ALTER TABLE `t-value_list`
  MODIFY `VALUE_LIST_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `t-visit`
--
ALTER TABLE `t-visit`
  MODIFY `VISIT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `t-activity_log`
--
ALTER TABLE `t-activity_log`
  ADD CONSTRAINT `fk_REGISTRO_ACTIVIDAD_SESION1` FOREIGN KEY (`SESSION_ID`,`USER_ID`) REFERENCES `t-session` (`SESSION_ID`, `USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-career_internship_type`
--
ALTER TABLE `t-career_internship_type`
  ADD CONSTRAINT `CAREER_ID2` FOREIGN KEY (`CAREER_ID`) REFERENCES `t-career` (`CAREER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `INTERNSHIP_TYPE_ID2` FOREIGN KEY (`INTERNSHIP_TYPE_ID`) REFERENCES `t-internship_type` (`INTERNSHIP_TYPE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-change_log`
--
ALTER TABLE `t-change_log`
  ADD CONSTRAINT `fk_T-CHANGE_LOG_T-COLUMNS1` FOREIGN KEY (`COLUMN_ID`) REFERENCES `t-columns` (`COLUMN_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T-CHANGE_LOG_T-OPERATION1` FOREIGN KEY (`OPERATION_ID`) REFERENCES `t-operation` (`OPERATION_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T-CHANGE_LOG_T-TABLES1` FOREIGN KEY (`TABLE_ID`) REFERENCES `t-tables` (`TABLE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T-CHANGE_LOG_T-USER1` FOREIGN KEY (`USER_ID`) REFERENCES `t-user` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-columns`
--
ALTER TABLE `t-columns`
  ADD CONSTRAINT `fk_T-COLUMNS_T-TABLES1` FOREIGN KEY (`TABLE_ID`) REFERENCES `t-tables` (`TABLE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-institution_manager`
--
ALTER TABLE `t-institution_manager`
  ADD CONSTRAINT `INSTITUTION_ID` FOREIGN KEY (`INSTITUTION_ID`) REFERENCES `t-institution` (`INSTITUTION_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-key_history`
--
ALTER TABLE `t-key_history`
  ADD CONSTRAINT `fk_HISTORIAL_CLAVE_CLAVE_USUARIO1` FOREIGN KEY (`USER_KEY_ID`,`USER_ID`) REFERENCES `t-user_key` (`USER_KEY_ID`, `USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-professional_practices`
--
ALTER TABLE `t-professional_practices`
  ADD CONSTRAINT `Ci_Tutor` FOREIGN KEY (`TUTOR_ID`) REFERENCES `t-tutors` (`TUTOR_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `INTERNSHIP_TYPE_ID` FOREIGN KEY (`INTERNSHIP_TYPE_ID`) REFERENCES `t-internship_type` (`INTERNSHIP_TYPE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `IdPeriodo_Pasantias` FOREIGN KEY (`PERIOD_ID`) REFERENCES `t-internships_period` (`PERIOD_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Id_Estudiantes` FOREIGN KEY (`STUDENTS_ID`) REFERENCES `t-students` (`STUDENTS_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Id_Institucion` FOREIGN KEY (`INSTITUTION_ID`) REFERENCES `t-institution` (`INSTITUTION_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `MANAGER_ID` FOREIGN KEY (`MANAGER_ID`) REFERENCES `t-institution_manager` (`MANAGER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-roles_permissions`
--
ALTER TABLE `t-roles_permissions`
  ADD CONSTRAINT `fk_ROLES_has_PERMISOS_PERMISOS1` FOREIGN KEY (`PERMISSIONS_ID`) REFERENCES `t-permissions` (`PERMISSIONS_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ROLES_has_PERMISOS_ROLES1` FOREIGN KEY (`ROLES_ID`) REFERENCES `t-roles` (`ID_ROLS`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-security_questions`
--
ALTER TABLE `t-security_questions`
  ADD CONSTRAINT `t-security_questions_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `t-user` (`USER_ID`),
  ADD CONSTRAINT `t-security_questions_ibfk_2` FOREIGN KEY (`PRESET_QUESTION_ID`) REFERENCES `t-preset_questions` (`PRESET_QUESTION_ID`);

--
-- Filtros para la tabla `t-session`
--
ALTER TABLE `t-session`
  ADD CONSTRAINT `fk_SESION_USUARIO1` FOREIGN KEY (`USER_ID`) REFERENCES `t-user` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-session_attempts`
--
ALTER TABLE `t-session_attempts`
  ADD CONSTRAINT `fk_INTENTOS_DE_SESION_USUARIO1` FOREIGN KEY (`USER_ID`) REFERENCES `t-user` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-session_history`
--
ALTER TABLE `t-session_history`
  ADD CONSTRAINT `fk_HISTORIAL_SESION_SESION1` FOREIGN KEY (`SESSION_ID`,`USER_ID`) REFERENCES `t-session` (`SESSION_ID`, `USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-students`
--
ALTER TABLE `t-students`
  ADD CONSTRAINT `t-students_ibfk_1` FOREIGN KEY (`CAREER_ID`) REFERENCES `t-career` (`CAREER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-user_key`
--
ALTER TABLE `t-user_key`
  ADD CONSTRAINT `fk_CLAVE_USUARIO_USUARIO` FOREIGN KEY (`USER_ID`) REFERENCES `t-user` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-user_roles`
--
ALTER TABLE `t-user_roles`
  ADD CONSTRAINT `fk_USUARIO_has_ROLES_ROLES1` FOREIGN KEY (`ID_ROLES`) REFERENCES `t-roles` (`ID_ROLS`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USUARIO_has_ROLES_USUARIO1` FOREIGN KEY (`ID_USER`) REFERENCES `t-user` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-value_list`
--
ALTER TABLE `t-value_list`
  ADD CONSTRAINT `t-value_list_ibfk_1` FOREIGN KEY (`LIST_ID`) REFERENCES `t-list` (`LIST_ID`);

--
-- Filtros para la tabla `t-visit`
--
ALTER TABLE `t-visit`
  ADD CONSTRAINT `PROFESSIONAL_PRACTICE_ID` FOREIGN KEY (`PROFESSIONAL_PRACTICE_ID`) REFERENCES `t-professional_practices` (`PROFESSIONAL_PRACTICE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `TUTOR_ID` FOREIGN KEY (`TUTOR_ID`) REFERENCES `t-tutors` (`TUTOR_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;