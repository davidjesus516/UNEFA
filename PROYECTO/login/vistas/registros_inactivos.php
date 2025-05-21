<?php
require 'header.php';
?>

<span class="text">Ventana -> Registros Inactivos</span>
<div class="user-settings-page-content">

    <aside class="settings-nav">
        <ul class="settings-menu">
            <h3>USUARIO:</h3>
            <li class="menu-item active">
                <a href="nuevo_usuario.php">
                    <i class="icon-placeholder"></i> <span>Nuevo Usuario</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="listado_usuario.php">
                    <i class="icon-placeholder"></i> <span>Listado Usuario</span>
                </a>
            </li>
            <br>
            <h3>GESTIÓN USUARIO:</h3>

            <li class="menu-item active">
                <a href="#">
                    <i class="icon-placeholder"></i> <span>Gestion Usuario</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="#">
                    <i class="icon-placeholder"></i> <span>Gestion Roles</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="#">
                    <i class="icon-placeholder"></i> <span>Gestion Permisos</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="historial_session.php">
                    <i class="icon-placeholder"></i> <span>Historial de Ingreso de Usuario</span>
                </a>
            </li>
            <h3>NOTIFICACIÓN:</h3>
            <li class="menu-item active">
                <a href="#">
                    <i class="icon-placeholder"></i> <span>Activar</span>
                </a>
                <a href="#">
                    <i class="icon-placeholder"></i> <span>Desactivar</span>
                </a>
                <a href="#">
                    <i class="icon-placeholder"></i> <span>Recordatorio</span>
                </a>
                
            </li>
            <h3>SEGURIDAD Y ACCESO:</h3>
            <li class="menu-item active">
                <a href="config_contraseña.php">
                    <i class="icon-placeholder"></i> <span>Configuracion Contraseña</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="config_preguntas.php">
                    <i class="icon-placeholder"></i> <span>Configuracion Preguntas de Seguridad</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="#">
                    <i class="icon-placeholder"></i> <span>AUTENTICACIÓN</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="preguntas.php">
                    <i class="icon-placeholder"></i> <span>Gestion Preguntas Preestablecidas</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="config_usuario.php">
                    <i class="icon-placeholder"></i> <span>Configuracion Usuario</span>
                </a>
            </li>


        </ul>
    </aside>

</div>

<?php
require 'footer.php';
?>