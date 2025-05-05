<?php
session_start();
if (!isset($_SESSION['USER'])) {
    header("Location: ../index.php");
}
?>
<input type="hidden" id="id" name="id" value=<?php echo $_SESSION["NAME"]; ?>>

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=app_registration" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
<style>
    .popup {
  --burger-line-width: 1.125em;
  --burger-line-height: 0.125em;
  --burger-offset: 0.625em;
  --burger-bg: #192DD4;
  --burger-color: #333;
  --burger-line-border-radius: 0.1875em;
  --burger-diameter: 3.125em;
  --burger-btn-border-radius: calc(var(--burger-diameter) / 2);
  --burger-line-transition: 0.3s;
  --burger-transition: all 0.1s ease-in-out;
  --burger-hover-scale: 1.1;
  --burger-active-scale: 0.95;
  --burger-enable-outline-color: var(--burger-bg);
  --burger-enable-outline-width: 0.125em;
  --burger-enable-outline-offset: var(--burger-enable-outline-width);
  /* nav */
  --nav-padding-x: 0.25em;
  --nav-padding-y: 0.625em;
  --nav-border-radius: 0.375em;
  --nav-border-color: #ccc;
  --nav-border-width: 0.0625em;
  --nav-shadow-color: rgba(0, 0, 0, 0.2);
  --nav-shadow-width: 0 1px 5px;
  --nav-bg: #eee;
  --nav-font-family: "Poppins", sans-serif;
  --nav-default-scale: 0.8;
  --nav-active-scale: 1;
  --nav-position-left: 0;
  --nav-position-right: unset;
  /* if you want to change sides just switch one property */
  /* from properties to "unset" and the other to 0 */
  /* title */
  --nav-title-size: 0.625em;
  --nav-title-color: #777;
  --nav-title-padding-x: 1rem;
  --nav-title-padding-y: 0.25em;
  /* nav button */
  --nav-button-padding-x: 1rem;
  --nav-button-padding-y: 0.375em;
  --nav-button-border-radius: 0.375em;
  --nav-button-font-size: 17px;
  --nav-button-hover-bg: #192DD4;
  --nav-button-hover-text-color: #fff;
  --nav-button-distance: 0.875em;
  /* underline */
  --underline-border-width: 0.0625em;
  --underline-border-color: #ccc;
  --underline-margin-y: 0.3125em;
}

/* popup settings 👆 */

.popup {
  display: inline-block;
  text-rendering: optimizeLegibility;
  position: relative;
}

.popup input {
  display: none;
}

.burger {
  display: flex;
  position: relative;
  align-items: center;
  justify-content: center;
  background: var(--burger-bg);
  width: var(--burger-diameter);
  height: var(--burger-diameter);
  border-radius: var(--burger-btn-border-radius);
  border: none;
  cursor: pointer;
  overflow: hidden;
  transition: var(--burger-transition);
  outline: var(--burger-enable-outline-width) solid transparent;
  outline-offset: 0;
  margin: 0 15px;
}

.popup-window {
  transform: scale(var(--nav-default-scale));
  visibility: hidden;
  opacity: 0;
  position: absolute;
  padding: var(--nav-padding-y) var(--nav-padding-x);
  background: var(--nav-bg);
  font-family: var(--nav-font-family);
  color: var(--nav-text-color);
  border-radius: var(--nav-border-radius);
  box-shadow: var(--nav-shadow-width) var(--nav-shadow-color);
  border: var(--nav-border-width) solid var(--nav-border-color);
  top: -9rem;
  left: 1rem;
  right: var(--nav-position-right);
  transition: var(--burger-transition);
  margin-top: 10px;
}

.popup-window legend {
  padding: var(--nav-title-padding-y) var(--nav-title-padding-x);
  margin: 0;
  color: var(--nav-title-color);
  font-size: var(--nav-title-size);
  text-transform: uppercase;
}

.popup-window ul {
  margin: 0;
  padding: 0;
  list-style-type: none;
}

.popup-window ul button {
  outline: none;
  width: 100%;
  border: none;
  background: none;
  display: flex;
  align-items: center;
  color: var(--burger-color);
  font-size: var(--nav-button-font-size);
  padding: var(--nav-button-padding-y) var(--nav-button-padding-x);
  white-space: nowrap;
  border-radius: var(--nav-button-border-radius);
  cursor: pointer;
  column-gap: var(--nav-button-distance);
}

.popup-window ul li:nth-child(1) svg,
.popup-window ul li:nth-child(2) svg {
  color: #192DD4;
}

.popup-window ul li:nth-child(4) svg,
.popup-window ul li:nth-child(5) svg {
  color: rgb(153, 153, 153);
}

.popup-window ul li:nth-child(7) svg {
  color: red;
}

.popup-window hr {
  margin: var(--underline-margin-y) 0;
  border: none;
  border-bottom: var(--underline-border-width) solid var(--underline-border-color);
}

/* actions */

.popup-window ul button:hover,
.popup-window ul button:focus-visible,
.popup-window ul button:hover svg,
.popup-window ul button:focus-visible svg {
  color: var(--nav-button-hover-text-color);
  background: var(--nav-button-hover-bg);
}

.burger:hover {
  transform: scale(var(--burger-hover-scale));
}

.burger:active {
  transform: scale(var(--burger-active-scale));
}

.burger:focus:not(:hover) {
  outline-color: var(--burger-enable-outline-color);
  outline-offset: var(--burger-enable-outline-offset);
}

.popup input:checked+.burger span:nth-child(1) {
  top: 50%;
  transform: translateY(-50%) rotate(45deg);
}

.popup input:checked+.burger span:nth-child(2) {
  bottom: 50%;
  transform: translateY(50%) rotate(-45deg);
}

.popup input:checked+.burger span:nth-child(3) {
  transform: translateX(calc(var(--burger-diameter) * -1 - var(--burger-line-width)));
}

.popup input:checked~nav {
  transform: scale(var(--nav-active-scale));
  visibility: visible;
  opacity: 1;
}
</style>
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
                        <li><a href="carrera.php">Carrera</a></li>
                    </ul>
                </li>

                <!-- List Registro -->

                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                    <path d="M240-160q-33 0-56.5-23.5T160-240q0-33 23.5-56.5T240-320q33 0 56.5 23.5T320-240q0 33-23.5 56.5T240-160Zm0-240q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm0-240q-33 0-56.5-23.5T160-720q0-33 23.5-56.5T240-800q33 0 56.5 23.5T320-720q0 33-23.5 56.5T240-640Zm240 0q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Zm240 0q-33 0-56.5-23.5T640-720q0-33 23.5-56.5T720-800q33 0 56.5 23.5T800-720q0 33-23.5 56.5T720-640ZM480-400q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm40 240v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z" />
                                </svg></i>
                            <span class="link_name">Registro</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Registro</a></li>
                        <li><a href="estudiante.php">Estudiante</a></li>
                        <li><a href="tutores.php">Tutores</a></li>
                        <li><a href="Institucion.php">Instituciones</a></li>
                    </ul>
                </li>

                <!-- List Practicas Profesionales -->

                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                    <path d="M120-120v-560h160v-160h400v320h160v400H520v-160h-80v160H120Zm80-80h80v-80h-80v80Zm0-160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm160 160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm160 320h80v-80h-80v80Zm0-160h80v-80h-80v80Zm0-160h80v-80h-80v80Zm160 480h80v-80h-80v80Zm0-160h80v-80h-80v80Z" />
                                </svg></i>
                            <span class="link_name">Practicas Profesionales</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Practicas Profesionales</a></li>
                        <li><a href="preinscripcion.php">Pre Inscripcion</a></li>
                        <li><a href="inscripcion.php">Inscripcion</a></li>
                        <li><a href="seguimiento.php">Seguimiento</a></li>
                        <li><a href="cul">Culminacion de Pasantia</a></li>
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
                        <li><a href="../PDF/listado_carrera.php" target="_blank">Listado de Carreras</a></li>
                    </ul>
                </li>

                <!-- Configuracion -->

                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx  bx-cog'></i>
                            <span class="link_name">Configuracion</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Configuracion</a></li>
                        <li><a href="#">Registros Inactivos</a></li>
                        <li><a href="#">Cambio de Registros</a></li>
                        <li><a href="usuario.php">Usuarios</a></li>
                        <li><a href="#">Combos</a></li>
                    </ul>
                </li>


                <!-- Form -->

                <li>
                    <a href="manuales.php">
                        <i class='bx'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-640v560h560v-560h-80v280l-100-60-100 60v-280H200Zm0 560v-560 560Z" />
                            </svg></i>
                        <span class="link_name">Manuales</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="manuales.php">Manuales</a></li>
                    </ul>
                </li>

                <!-- Salir -->
                <!-- 
                <li>
                    <a href="../logout.php">
                        <i class='bx bx-log-out'></i>
                        <span class="link_name">Salir</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Salir</a></li>
                    </ul>
                </li> -->

                <!-- Panel user -->

                <li>
                    <div class="profile-details">
                        <label class="popup">
                            <input type="checkbox" />
                            <div tabindex="0" class="burger">
                                <svg
                                    viewBox="0 0 24 24"
                                    fill="white"
                                    height="20"
                                    width="20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2c2.757 0 5 2.243 5 5.001 0 2.756-2.243 5-5 5s-5-2.244-5-5c0-2.758 2.243-5.001 5-5.001zm0-2c-3.866 0-7 3.134-7 7.001 0 3.865 3.134 7 7 7s7-3.135 7-7c0-3.867-3.134-7.001-7-7.001zm6.369 13.353c-.497.498-1.057.931-1.658 1.302 2.872 1.874 4.378 5.083 4.972 7.346h-19.387c.572-2.29 2.058-5.503 4.973-7.358-.603-.374-1.162-.811-1.658-1.312-4.258 3.072-5.611 8.506-5.611 10.669h24c0-2.142-1.44-7.557-5.631-10.647z"></path>
                                </svg>
                            </div>
                            <nav class="popup-window">
                                <legend>Perfil de Usuarios</legend>
                                <ul>
                                    <li>
                                        <a href="perfil_usuario.php">
                                            <button>
                                                <span>Perfil</span>
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../logout.php">
                                            <button>
                                                <span>Logout</span>
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </label>

                        <div class="name-job">
                            <div class="profile_name"><?php echo $_SESSION["NAME"]; ?></div>
                            <div class="job">Administrador</div>
                        </div>
                        <!-- <i class='bx bx-log-out'></i> -->
                    </div>
                </li>
            </ul>
        </div>
        <section class="home-section">
            <div class="home-content">
                <i class='bx bx-menu'></i>
                
                <div id="reloj-superior">
                    <div id="hora-actual">--:--:-- --</div>
                    <div id="fecha-actual">-- -- ----</div>
                </div>