-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-04-2025 a las 04:31:32
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb`
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
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-career`
--

CREATE TABLE `t-career` (
  `CAREER_ID` int(8) NOT NULL,
  `CAREER_NAME` varchar(40) NOT NULL,
  `CAREER_CODE` int(11) NOT NULL,
  `MINIMUM_GRADE` decimal(10,0) UNSIGNED ZEROFILL NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-columns`
--

CREATE TABLE `t-columns` (
  `COLUMN_ID` int(11) NOT NULL,
  `TABLE_ID` int(11) NOT NULL,
  `COLUMN_NAME` varchar(25) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-config`
--

CREATE TABLE `t-config` (
  `RECOVERY_EMAIL` int(11) NOT NULL,
  `BLOCKING_DAYS` int(11) DEFAULT NULL,
  `WRONG_KEY_LOCK` int(11) NOT NULL,
  `ATTEMPTS_KEY_BLOCK` int(11) NOT NULL,
  `KEY_EXPIRATION` int(11) NOT NULL,
  `EXPIRATION_DAYS` int(11) NOT NULL,
  `USER_UPPERCASE` int(11) NOT NULL,
  `USER_LOWERCASE` int(11) NOT NULL,
  `USER_NUMBERS` int(11) NOT NULL,
  `USER_SPECIAL_CHARACTERS` int(11) NOT NULL,
  `USER_NUM_UPPERCASE` int(11) NOT NULL,
  `USER_NUM_LOWERCASE` int(11) NOT NULL,
  `USER_NUM_NUMBERS` int(11) NOT NULL,
  `USER_NUM_SPECIAL_CHARACTERS` int(11) NOT NULL,
  `KEY_UPPERCASE` int(11) NOT NULL,
  `KEY_LOWERCASE` int(11) NOT NULL,
  `KEY_NUMBERS` int(11) DEFAULT NULL,
  `KEY_SPECIAL_CHARACTERS` int(11) NOT NULL,
  `KEY_NUM_UPPERCASE` int(11) DEFAULT NULL,
  `KEY_NUM_LOWERCASE` int(11) NOT NULL,
  `KEY_NUM_NUMBERS` int(11) DEFAULT NULL,
  `KEY_NUM_SPECIAL_CHARACTERS` int(11) NOT NULL,
  `USER_LENGTH` int(11) DEFAULT NULL,
  `KEY_LENGTH` int(11) NOT NULL,
  `SECURITY_QUESTIONS` int(11) DEFAULT NULL,
  `TOTAL_QUESTIONS` int(11) NOT NULL,
  `TOTAL_PRESET_QUESTIONS` int(11) DEFAULT NULL,
  `TOTAL_USER_QUESTIONS` int(11) NOT NULL,
  `TOTAL_ANSWERS` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-enrollment`
--

CREATE TABLE `t-enrollment` (
  `ENROLLMENT_ID` int(8) NOT NULL,
  `DESCRIPTION` varchar(50) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `CAREER_ID` int(8) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-institution`
--

CREATE TABLE `t-institution` (
  `INSTITUTION_ID` int(8) NOT NULL,
  `INSTITUTION_NAME` varchar(50) NOT NULL,
  `INSTITUTION_ADDRESS` varchar(100) NOT NULL,
  `INSTITUTION_CONTACT` varchar(12) NOT NULL,
  `PRACTICE_TYPE` varchar(45) NOT NULL,
  `REGION` varchar(45) NOT NULL,
  `NUCLEUS` varchar(45) NOT NULL,
  `EXTENSION` varchar(45) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `INSTITUTION_TYPE` int(8) NOT NULL,
  `MANAGER_ID` int(10) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-institution_manager`
--

CREATE TABLE `t-institution_manager` (
  `MANAGER_ID` int(8) NOT NULL,
  `MANAGER_CI` varchar(10) NOT NULL,
  `NAME` varchar(45) NOT NULL,
  `SECOND_NAME` varchar(45) DEFAULT NULL,
  `SURNAME` varchar(45) NOT NULL,
  `SECOND_SURNAME` varchar(45) DEFAULT NULL,
  `CONTACT_PHONE` varchar(12) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `INTERNSHIP_TYPE_ID` int(8) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-internship_type`
--

CREATE TABLE `t-internship_type` (
  `INTERNSHIP_TYPE_ID` int(8) NOT NULL,
  `NAME` varchar(40) NOT NULL,
  `PRIORITY` varchar(10) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-nucleus`
--

CREATE TABLE `t-nucleus` (
  `NUCLEUS_ID` int(11) NOT NULL,
  `DESCRIPTION` varchar(45) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-operation`
--

CREATE TABLE `t-operation` (
  `OPERATION_ID` int(11) NOT NULL,
  `ACTION` varchar(45) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-permissions`
--

CREATE TABLE `t-permissions` (
  `PERMISSIONS_ID` int(11) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-preset_questions`
--

CREATE TABLE `t-preset_questions` (
  `PRESET_QUESTION_ID` int(11) NOT NULL,
  `DESCRIPTION` varchar(45) NOT NULL,
  `ANSWER` varchar(45) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-professional_practices`
--

CREATE TABLE `t-professional_practices` (
  `PROFESSIONAL_PRACTICE_ID` int(8) NOT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `REPORT_TITLE` varchar(60) NOT NULL,
  `PROFESSIONAL_PRACTICES` datetime NOT NULL,
  `REGISTRATION_DATE` datetime NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `SCHEDULE` varchar(45) NOT NULL,
  `GRADE` decimal(5,0) UNSIGNED ZEROFILL NOT NULL,
  `PRACTICES_STATUS` varchar(45) NOT NULL,
  `TRANSFER` varchar(45) NOT NULL,
  `TOUR` varchar(45) NOT NULL,
  `PERIOD_ID` int(8) NOT NULL,
  `TUTOR_ID` int(10) NOT NULL,
  `VISIT_ID` int(11) NOT NULL,
  `INSTITUTION_ID` int(8) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-roles`
--

CREATE TABLE `t-roles` (
  `ROL_ID` int(11) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-roles_permissions`
--

CREATE TABLE `t-roles_permissions` (
  `ROL_ID` int(11) NOT NULL,
  `PERMISSIONS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-security_questions`
--

CREATE TABLE `t-security_questions` (
  `SECURITY_QUESTION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `PRESET_QUESTION_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-session`
--

CREATE TABLE `t-session` (
  `SESSION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `LOGIN_TIME` datetime NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-session_attempts`
--

CREATE TABLE `t-session_attempts` (
  `ATTEMPT_ID` int(11) NOT NULL,
  `ATTEMPT_TIME` datetime NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ACTION` tinyint(4) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-students`
--

CREATE TABLE `t-students` (
  `STUDENTS_ID` int(8) NOT NULL,
  `STUDENTS_CI` varchar(8) NOT NULL,
  `NAME` varchar(45) NOT NULL,
  `SECOND_NAME` varchar(45) DEFAULT NULL,
  `SURNAME` varchar(45) NOT NULL,
  `SECOND_SURNAME` varchar(45) DEFAULT NULL,
  `GENDER` varchar(10) NOT NULL,
  `BIRTHDATE` date NOT NULL,
  `CONTACT_PHONE` varchar(12) NOT NULL,
  `EMAIL` varchar(40) NOT NULL,
  `ADDRESS` varchar(100) NOT NULL,
  `MARITAL_STATUS` varchar(45) NOT NULL,
  `NATIONALITY` varchar(45) NOT NULL,
  `SEMESTER` varchar(45) NOT NULL,
  `SECTION` varchar(45) NOT NULL,
  `REGIME` varchar(45) NOT NULL,
  `STUDENT_TYPE` varchar(45) NOT NULL,
  `MILITARY_RANK` varchar(45) DEFAULT NULL,
  `EMPLOYMENT` varchar(45) NOT NULL,
  `REGISTRATION_DATE` datetime DEFAULT NULL,
  `ENROLLMENT_ID` int(8) NOT NULL,
  `NUCLEUS_ID` int(11) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-students_professional_practices`
--

CREATE TABLE `t-students_professional_practices` (
  `STUDENTS_ID` int(8) NOT NULL,
  `STUDENTS_CI` varchar(10) NOT NULL,
  `PROFESSIONAL_PRACTICE_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-tutors`
--

CREATE TABLE `t-tutors` (
  `TUTOR_ID` int(8) NOT NULL,
  `TUTOR_CI` varchar(10) NOT NULL,
  `NAME` varchar(45) NOT NULL,
  `SECOND_NAME` varchar(45) DEFAULT NULL,
  `SURNAME` varchar(45) NOT NULL,
  `SECOND_SURNAME` varchar(45) DEFAULT NULL,
  `CONTACT_PHONE` varchar(12) NOT NULL,
  `GENDER` varchar(45) NOT NULL,
  `EMAIL` varchar(45) NOT NULL,
  `PROFESSION` varchar(45) NOT NULL,
  `CONDITION` varchar(45) NOT NULL,
  `DEDICATION` varchar(45) NOT NULL,
  `CATEGORY` varchar(45) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-user`
--

CREATE TABLE `t-user` (
  `USER_ID` int(11) NOT NULL,
  `USER` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `USER_CI` varchar(8) NOT NULL,
  `NAME` varchar(45) NOT NULL,
  `SECOND_NAME` varchar(45) DEFAULT NULL,
  `SURNAME` varchar(45) NOT NULL,
  `SECOND_SURNAME` varchar(45) DEFAULT NULL,
  `EMAIL` varchar(45) NOT NULL,
  `PHONE_NUMBER` varchar(45) DEFAULT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `LOGIN` tinyint(4) NOT NULL,
  `TERMS_CONDITIONS` varchar(45) NOT NULL,
  `STATUS_SESSION` tinyint(4) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-user_questions`
--

CREATE TABLE `t-user_questions` (
  `USER_QUESTION_ID` int(11) NOT NULL,
  `QUESTION` varchar(45) NOT NULL,
  `ANSWER` varchar(45) NOT NULL,
  `STATUS` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-user_roles`
--

CREATE TABLE `t-user_roles` (
  `USER_ID` int(11) NOT NULL,
  `ROL_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-visits`
--

CREATE TABLE `t-visits` (
  `VISIT_ID` int(11) NOT NULL,
  `VISIT_DATE` date NOT NULL,
  `NOTE` varchar(45) DEFAULT NULL,
  `REQUESTED_ACTIVITY` varchar(45) NOT NULL,
  `CARRIED_ACTIVITY` varchar(45) NOT NULL,
  `MODIF_USER_ID` int(11) NOT NULL,
  `MODIF_USER_DATE` datetime NOT NULL,
  `ELIM_USER_ID` int(11) NOT NULL,
  `ELIM_USER_DATE` datetime NOT NULL,
  `REST_USER_ID` int(11) NOT NULL,
  `REST_USER_DATE` datetime NOT NULL,
  `STATUS` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`CAREER_ID`);

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
-- Indices de la tabla `t-enrollment`
--
ALTER TABLE `t-enrollment`
  ADD PRIMARY KEY (`ENROLLMENT_ID`),
  ADD KEY `Id_Carrera_idx` (`CAREER_ID`);

--
-- Indices de la tabla `t-institution`
--
ALTER TABLE `t-institution`
  ADD PRIMARY KEY (`INSTITUTION_ID`),
  ADD KEY `id_Responsable_idx` (`MANAGER_ID`);

--
-- Indices de la tabla `t-institution_manager`
--
ALTER TABLE `t-institution_manager`
  ADD PRIMARY KEY (`MANAGER_ID`,`MANAGER_CI`);

--
-- Indices de la tabla `t-internships_period`
--
ALTER TABLE `t-internships_period`
  ADD PRIMARY KEY (`PERIOD_ID`),
  ADD KEY `IdTipo_Pasantias_idx` (`INTERNSHIP_TYPE_ID`);

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
-- Indices de la tabla `t-nucleus`
--
ALTER TABLE `t-nucleus`
  ADD PRIMARY KEY (`NUCLEUS_ID`);

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
  ADD KEY `id_Tutor_idx` (`TUTOR_ID`),
  ADD KEY `Id_Institucion_idx` (`INSTITUTION_ID`),
  ADD KEY `fk_Practicas_Profesionales_Visita1_idx` (`VISIT_ID`);

--
-- Indices de la tabla `t-roles`
--
ALTER TABLE `t-roles`
  ADD PRIMARY KEY (`ROL_ID`);

--
-- Indices de la tabla `t-roles_permissions`
--
ALTER TABLE `t-roles_permissions`
  ADD PRIMARY KEY (`ROL_ID`,`PERMISSIONS_ID`),
  ADD KEY `fk_ROLES_has_PERMISOS_PERMISOS1_idx` (`PERMISSIONS_ID`),
  ADD KEY `fk_ROLES_has_PERMISOS_ROLES1_idx` (`ROL_ID`);

--
-- Indices de la tabla `t-security_questions`
--
ALTER TABLE `t-security_questions`
  ADD PRIMARY KEY (`SECURITY_QUESTION_ID`),
  ADD KEY `fk_USUARIO_has_PREGUNTA_PREESTABLECIDA_PREGUNTA_PREESTABLEC_idx` (`PRESET_QUESTION_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

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
  ADD PRIMARY KEY (`STUDENTS_ID`,`STUDENTS_CI`),
  ADD KEY `Id_Trayecto_idx` (`ENROLLMENT_ID`),
  ADD KEY `IdNucleo_idx` (`NUCLEUS_ID`);

--
-- Indices de la tabla `t-students_professional_practices`
--
ALTER TABLE `t-students_professional_practices`
  ADD PRIMARY KEY (`STUDENTS_ID`,`STUDENTS_CI`,`PROFESSIONAL_PRACTICE_ID`),
  ADD KEY `fk_T-STUDENTS_has_T-PROFESSIONAL_PRACTICES_T-PROFESSIONAL_P_idx` (`PROFESSIONAL_PRACTICE_ID`),
  ADD KEY `fk_T-STUDENTS_has_T-PROFESSIONAL_PRACTICES_T-STUDENTS1_idx` (`STUDENTS_ID`,`STUDENTS_CI`);

--
-- Indices de la tabla `t-tables`
--
ALTER TABLE `t-tables`
  ADD PRIMARY KEY (`TABLE_ID`);

--
-- Indices de la tabla `t-tutors`
--
ALTER TABLE `t-tutors`
  ADD PRIMARY KEY (`TUTOR_ID`,`TUTOR_CI`);

--
-- Indices de la tabla `t-user`
--
ALTER TABLE `t-user`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `USER_CI_UNIQUE` (`USER_CI`),
  ADD UNIQUE KEY `USER` (`USER`);

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
  ADD PRIMARY KEY (`USER_ID`,`ROL_ID`),
  ADD KEY `fk_USUARIO_has_ROLES_ROLES1_idx` (`ROL_ID`),
  ADD KEY `fk_USUARIO_has_ROLES_USUARIO1_idx` (`USER_ID`);

--
-- Indices de la tabla `t-value_list`
--
ALTER TABLE `t-value_list`
  ADD PRIMARY KEY (`VALUE_LIST_ID`),
  ADD KEY `LIST_VALUE` (`LIST_ID`);

--
-- Indices de la tabla `t-visits`
--
ALTER TABLE `t-visits`
  ADD PRIMARY KEY (`VISIT_ID`);

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
  MODIFY `CAREER_ID` int(8) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `t-institution_manager`
--
ALTER TABLE `t-institution_manager`
  MODIFY `MANAGER_ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-internship_type`
--
ALTER TABLE `t-internship_type`
  MODIFY `INTERNSHIP_TYPE_ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-key_history`
--
ALTER TABLE `t-key_history`
  MODIFY `KEY_HISTORY_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-list`
--
ALTER TABLE `t-list`
  MODIFY `LIST_ID` int(8) NOT NULL AUTO_INCREMENT;

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
  MODIFY `PRESET_QUESTION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-professional_practices`
--
ALTER TABLE `t-professional_practices`
  MODIFY `PROFESSIONAL_PRACTICE_ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-roles`
--
ALTER TABLE `t-roles`
  MODIFY `ROL_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-security_questions`
--
ALTER TABLE `t-security_questions`
  MODIFY `SECURITY_QUESTION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-session`
--
ALTER TABLE `t-session`
  MODIFY `SESSION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-session_attempts`
--
ALTER TABLE `t-session_attempts`
  MODIFY `ATTEMPT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-session_history`
--
ALTER TABLE `t-session_history`
  MODIFY `SESSION_HISTORY_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-students`
--
ALTER TABLE `t-students`
  MODIFY `STUDENTS_ID` int(8) NOT NULL AUTO_INCREMENT;

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
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-user_key`
--
ALTER TABLE `t-user_key`
  MODIFY `USER_KEY_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-user_questions`
--
ALTER TABLE `t-user_questions`
  MODIFY `USER_QUESTION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t-visits`
--
ALTER TABLE `t-visits`
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
-- Filtros para la tabla `t-enrollment`
--
ALTER TABLE `t-enrollment`
  ADD CONSTRAINT `Id_Carrera` FOREIGN KEY (`CAREER_ID`) REFERENCES `t-career` (`CAREER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-institution`
--
ALTER TABLE `t-institution`
  ADD CONSTRAINT `id_Responsable` FOREIGN KEY (`MANAGER_ID`) REFERENCES `t-institution_manager` (`MANAGER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-internships_period`
--
ALTER TABLE `t-internships_period`
  ADD CONSTRAINT `IdTipo_Pasantias` FOREIGN KEY (`INTERNSHIP_TYPE_ID`) REFERENCES `t-internship_type` (`INTERNSHIP_TYPE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-key_history`
--
ALTER TABLE `t-key_history`
  ADD CONSTRAINT `fk_HISTORIAL_CLAVE_CLAVE_USUARIO1` FOREIGN KEY (`USER_KEY_ID`,`USER_ID`) REFERENCES `t-user_key` (`USER_KEY_ID`, `USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-professional_practices`
--
ALTER TABLE `t-professional_practices`
  ADD CONSTRAINT `IdPeriodo_Pasantias` FOREIGN KEY (`PERIOD_ID`) REFERENCES `t-internships_period` (`PERIOD_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Id_Institucion` FOREIGN KEY (`INSTITUTION_ID`) REFERENCES `t-institution` (`INSTITUTION_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Practicas_Profesionales_Visita1` FOREIGN KEY (`VISIT_ID`) REFERENCES `t-visits` (`VISIT_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_Tutor` FOREIGN KEY (`TUTOR_ID`) REFERENCES `t-tutors` (`TUTOR_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-roles_permissions`
--
ALTER TABLE `t-roles_permissions`
  ADD CONSTRAINT `fk_ROLES_has_PERMISOS_PERMISOS1` FOREIGN KEY (`PERMISSIONS_ID`) REFERENCES `t-permissions` (`PERMISSIONS_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ROLES_has_PERMISOS_ROLES1` FOREIGN KEY (`ROL_ID`) REFERENCES `t-roles` (`ROL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-security_questions`
--
ALTER TABLE `t-security_questions`
  ADD CONSTRAINT `fk_USUARIO_has_PREGUNTA_PREESTABLECIDA_PREGUNTA_PREESTABLECIDA1` FOREIGN KEY (`PRESET_QUESTION_ID`) REFERENCES `t-preset_questions` (`PRESET_QUESTION_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `t-security_questions_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `t-user` (`USER_ID`);

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
  ADD CONSTRAINT `IdNucleo` FOREIGN KEY (`NUCLEUS_ID`) REFERENCES `t-nucleus` (`NUCLEUS_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Id_Trayecto` FOREIGN KEY (`ENROLLMENT_ID`) REFERENCES `t-enrollment` (`ENROLLMENT_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-students_professional_practices`
--
ALTER TABLE `t-students_professional_practices`
  ADD CONSTRAINT `fk_T-STUDENTS_has_T-PROFESSIONAL_PRACTICES_T-PROFESSIONAL_PRA1` FOREIGN KEY (`PROFESSIONAL_PRACTICE_ID`) REFERENCES `t-professional_practices` (`PROFESSIONAL_PRACTICE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T-STUDENTS_has_T-PROFESSIONAL_PRACTICES_T-STUDENTS1` FOREIGN KEY (`STUDENTS_ID`,`STUDENTS_CI`) REFERENCES `t-students` (`STUDENTS_ID`, `STUDENTS_CI`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-user_key`
--
ALTER TABLE `t-user_key`
  ADD CONSTRAINT `fk_CLAVE_USUARIO_USUARIO` FOREIGN KEY (`USER_ID`) REFERENCES `t-user` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-user_roles`
--
ALTER TABLE `t-user_roles`
  ADD CONSTRAINT `fk_USUARIO_has_ROLES_ROLES1` FOREIGN KEY (`ROL_ID`) REFERENCES `t-roles` (`ROL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USUARIO_has_ROLES_USUARIO1` FOREIGN KEY (`USER_ID`) REFERENCES `t-user` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `t-value_list`
--
ALTER TABLE `t-value_list`
  ADD CONSTRAINT `LIST_VALUE` FOREIGN KEY (`LIST_ID`) REFERENCES `t-list` (`LIST_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
