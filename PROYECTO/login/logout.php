<?php
require_once 'model/usuario.php';
$logout = new Usuario();
$logout->Logout($_SESSION["USER_ID"]);
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();
header('location: index.php');
