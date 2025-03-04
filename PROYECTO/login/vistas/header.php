<?php
session_start();


if(!isset($_SESSION['USER'])){
header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet</title>
    <!-- BOX ICONS -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../../img/logo_unefa.ico">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- CUSTOM JS -->
    <script src="../js/app.js" defer></script>
    <script src="js/app.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js" defer></script>
</head>

<body>

    <div class='dashboard'>

        <div class="sidebar close">
            <div class="logo-details">
                <i class="fa fa-university" aria-hidden="true"></i>
                <span class="logo_name">Intranet</span>
            </div>
            <ul class="nav-links">
                <li>
                    <a href="intranet.php">
                        <i class='bx bx-grid-alt'></i>
                        <span class="link_name">Inicio</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="intranet.php">Inicio</a></li>
                    </ul>
                </li>
                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx bx-collection'></i>
                            <span class="link_name">Gestión</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Gestión</a></li>                       
                        <li><a href="periodo.php">Lapso Academico</a></li>
                        <li><a href="carrera.php">Carrera</a></li>
                        <li><a href="Matrícula.php">Matrícula</a></li>
                        <li><a href="profesion.php">Profesión</a></li>
                        <li><a href="tutor_academico.php">Tutor Academico</a></li>
                        <li><a href="tutor_institucional.php">Tutor Institucional</a></li>
                        <li><a href="Institucion.php">Institución</a></li>
                    </ul>
                </li>
                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx bx-pie-chart-alt-2'></i>
                            <span class="link_name">Transacciones</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Transacciones</a></li>
                        <li><a href="transaccion_estudiante.php">Estudiante</a></li>
                        <li><a href="transaccion_seguimiento.php">Seguimiento</a></li>
                        <li><a href="transaccion_notas.php">Carga de Notas</a></li>
                        <li><a href="#">Cierre de Periodo</a></li>
                    </ul>
                </li>
                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx bx-book-alt'></i>
                            <span class="link_name">Procesos</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Procesos</a></li>
                        <li><a href="#">Inscripcion</a></li>
                        <li><a href="#">Seguimiento</a></li>
                        <li><a href="#">Cierre Periodo</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Reportes</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Reportes</a></li>
                    </ul>
                </li> 
                <li>
                <li>
                    <a href="#">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Configuración</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Configuración</a></li>
                    </ul>
                </li> 
                <li>
                    <a href="../logout.php">
                        <i class='bx bx-log-out'></i>
                        <span class="link_name">Salir</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Salir</a></li>
                    </ul>
                </li>
                <li>
                    <div class="profile-details">
                        <div class="profile-content">
                            <img src="https://static.vecteezy.com/system/resources/previews/000/550/731/original/user-icon-vector.jpg" alt="profileImg">
                        </div>
                        <div class="name-job">
                            <div class="profile_name">Usuario</div>
                            <div class="job">Administrador</div>
                        </div>
                        <i class='bx bx-log-out'></i>
                    </div>
                </li>
            </ul>
        </div>
        <section class="home-section">
            <div class="home-content">
                <i class='bx bx-menu'></i>
