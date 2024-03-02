<?php

session_start();


if(!isset($_SESSION['username'])){
  header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="UNEFA, Universidad de Venezuela, con Sedes y Extensiones en todo el país, Actualmente esta Casa de Estudios se caracteriza por ser una Institución comprometida e involucrada de modo muy activo y protagónico en el desarrollo económico, social y cultural de la Nación.  Excelencia Educativa Abierta al pueblo" />
    <meta name="keywords" content="Unefa, Abierta al pueblo, excelencia educativa, oportunidad de estudios, estudiar, carreras, pregrado, postgrado, Siceu" />
    <meta name="google-site-verification" content="IcSInzgtWZ61uIn_YB2oNVDIQ6c-uMXcFIPHHi64dg4" />
    <link href='img/favicon.png' rel='shortcut icon' type='image/x-icon' />
    <title>UNEFA Excelencia Educativa, Abierta al Pueblo</title>
    <link href="css/intranet.css" media="all" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo2.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
.nav-menu ul{
    box-shadow: none;
}
.submenu {
    display: grid;
}
</style>
<body>
    <header class="header-area">
        <div id="header" style="position: relative;">
            <div class="container">
                <div class="row align-items-center justify-content-between d-flex">
                    <nav id="nav-menu-container">
                        <ul class="nav-menu">
                            <li class="menu-active"><a href="intranet.php">Inicio</a></li>
                            <li><a href="lapso.php">Lapso Académico</a></li>
                            <li><a href="carrera.php">Carrera</a></li>
                            <li><a href="profesion.php">Profesión</a></li>
                            <li><a href="docente.php">Docente</a></li>
                            <li><a href="estudiante.php">Estudiante</a></li>
                            <li><a href="empresa.php">Empresa</a></li>
                            <li><a href="tutor.php">Tutor Empresarial</a></li>
                            <li><a href="">Transacciones</a>
                                <li class="submenu"><a href="transaccion.php">Transacción Estudiante</a></li>
                                <li class="submenu"><a href="cierre_pasantia.php">Transacción Cierre Pasantía</a></li>
                            </li>
                            <li><a href="">Reportes</a>
                                <li class="submenu"><a href="../PDF/fpdf/listado.php" target="_blank">Estudiante</a></li>
                                <li class="submenu"><a href="../PDF/fpdf/listado_docente.php" target="_blank">Docente</a></li>
                                <li class="submenu"><a href="../PDF/fpdf/listado_empresa.php" target="_blank">Empresa</a></li>
                            </li>

                            </li>
                            <li><a href="../logout.php"><span class="fi fi-br-power"></span>Cerrar Sesión</a></li>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- MENU DE LA UNEFA -->