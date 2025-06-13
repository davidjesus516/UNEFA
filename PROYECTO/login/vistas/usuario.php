<?php
require 'header.php';
?>

<span class="text">Ventana -> Configuración</span>
<div class="user-settings-page-content">

    <aside class="settings-nav">
        <ul class="settings-menu">
            <h3>USUARIO:</h3>
            <li class="menu-item active">
                <a href="nuevo_usuario.php">
                    <i class="icon-placeholder"></i> <span>Registro Usuarios</span>
                </a>
            </li>
            <br>
            <h3>GESTIÓN USUARIO:</h3>

            <li class="menu-item active">
                <a href="#">
                    <i class="icon-placeholder"></i> <span>Gestión Usuario</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="#">
                    <i class="icon-placeholder"></i> <span>Gestión Roles</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="#">
                    <i class="icon-placeholder"></i> <span>Gestión Permisos</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="historial_session.php">
                    <i class="icon-placeholder"></i> <span>Historial Ingreso Usuario</span>
                </a>
            </li>

            </li>
            <h3>SEGURIDAD Y ACCESO:</h3>
            <li class="menu-item active">
                <a href="preguntas.php">
                    <i class="icon-placeholder"></i> <span>Gestión Preguntas Preestablecidas</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="config_contraseña.php">
                    <i class="icon-placeholder"></i> <span>Configuración Contraseña</span>
                </a>
            </li>
            
            <li class="menu-item active">
                <a href="config_preguntas.php">
                    <i class="icon-placeholder"></i> <span>Configuración Preguntas de Seguridad</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="config_usuario.php">
                    <i class="icon-placeholder"></i> <span>Configuración Usuario</span>
                </a>
            </li>


        </ul>
    </aside>

</div>

<?php
require 'footer.php';
?>