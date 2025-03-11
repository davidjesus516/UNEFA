<?php

session_start();


if (!isset($_SESSION['USER'])) {
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=manage_search" />
    <link rel="icon" href="../../img/logo_unefa.ico">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="vistas/css/estilos.css">
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

                <!-- List Gestion -->

                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                    <path d="M80-200v-80h400v80H80Zm0-200v-80h200v80H80Zm0-200v-80h200v80H80Zm744 400L670-354q-24 17-52.5 25.5T560-320q-83 0-141.5-58.5T360-520q0-83 58.5-141.5T560-720q83 0 141.5 58.5T760-520q0 29-8.5 57.5T726-410l154 154-56 56ZM560-400q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Z" />
                                </svg></i>
                            <span class="link_name">Gestión</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Gestión</a></li>
                        <li><a href="periodo.php">Periodo</a></li>
                        <li><a href="matricula.php">Matricula</a></li>
                        <li><a href="carrera.php">Carrera</a></li>
                    </ul>
                </li>

                <!-- List Estudiante -->

                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                    <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                                </svg></i>
                            <span class="link_name">Estudiante</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Estudiante</a></li>
                        <li><a href="#"><span>+ </span> Agregar</a></li>
                        <li><a href="#"><span>> </span> Listado</a></li>
                    </ul>
                </li>

                <!-- List Tutores -->

                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                    <path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z" />
                                </svg></i>
                            <span class="link_name">Tutores</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Tutores</a></li>
                        <li><a href="#"><span>+ </span> Agregar</a></li>
                        <li><a href="#"><span>> </span> Listado</a></li>
                    </ul>
                </li>

                <!-- List Institucion -->

                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                    <path d="M160-120q-33 0-56.5-23.5T80-200v-560q0-33 23.5-56.5T160-840h200q33 0 56.5 23.5T440-760v560q0 33-23.5 56.5T360-120H160Zm440 0q-33 0-56.5-23.5T520-200v-560q0-33 23.5-56.5T600-840h200q33 0 56.5 23.5T880-760v560q0 33-23.5 56.5T800-120H600Zm-440-80h200v-560H160v560Zm440 0h200v-560H600v560ZM200-360h120v-80H200v80Zm440 0h120v-80H640v80ZM200-480h120v-80H200v80Zm440 0h120v-80H640v80ZM200-600h120v-80H200v80Zm440 0h120v-80H640v80ZM160-200h200-200Zm440 0h200-200Z" />
                                </svg></i>
                            <span class="link_name">Institución</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Institución</a></li>
                        <li><a href="#"><span>+ </span> Agregar</a></li>
                        <li><a href="#"><span>> </span> Listado</a></li>
                    </ul>
                </li>

                <!-- List Reportes -->

                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx bx-book-alt'></i>
                            <span class="link_name">Reportes</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Reportes</a></li>
                        <li><a href="#">Reporte 1</a></li>
                        <li><a href="#">Reporte 2</a></li>
                        <li><a href="#">Reporte 3</a></li>
                    </ul>
                </li>

                <!-- Configuracion -->

                <li>
                    <a href="#">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Configuración</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="formulario.php">Configuración</a></li>
                    </ul>
                </li>

                <!-- Salir -->

                <li>
                    <a href="../logout.php">
                        <i class='bx bx-log-out'></i>
                        <span class="link_name">Salir</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Salir</a></li>
                    </ul>
                </li>

                <!-- Form -->

                <li>
                    <a href="#">
                        <i class='bx'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M240-160q-33 0-56.5-23.5T160-240q0-33 23.5-56.5T240-320q33 0 56.5 23.5T320-240q0 33-23.5 56.5T240-160Zm240 0q-33 0-56.5-23.5T400-240q0-33 23.5-56.5T480-320q33 0 56.5 23.5T560-240q0 33-23.5 56.5T480-160Zm240 0q-33 0-56.5-23.5T640-240q0-33 23.5-56.5T720-320q33 0 56.5 23.5T800-240q0 33-23.5 56.5T720-160ZM240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400ZM240-640q-33 0-56.5-23.5T160-720q0-33 23.5-56.5T240-800q33 0 56.5 23.5T320-720q0 33-23.5 56.5T240-640Zm240 0q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Zm240 0q-33 0-56.5-23.5T640-720q0-33 23.5-56.5T720-800q33 0 56.5 23.5T800-720q0 33-23.5 56.5T720-640Z"/></svg></i>
                        <span class="link_name">Example Form</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="formulario.php">Example Form</a></li>
                    </ul>
                </li>

                <!-- Panel user -->

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
