<?php
require 'header.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="styles/dashboard.css">

<span class="text">Ventana -> Configuración</span>
<div>
    <aside class="settings-nav">
        <ul class="settings-menu">
            <h3>USUARIO:</h3>
            <li class="menu-item active">
                <a href="nuevo_usuario.php">
                    <i class="fas fa-user-plus"></i> <span>Registro Usuarios</span>
                </a>
            </li>

            <h3>GESTIÓN USUARIO:</h3>

            <li class="menu-item active">
                <a href="#">
                    <i class="fas fa-user-cog"></i> <span>Gestión Usuario</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="#">
                    <i class="fas fa-user-shield"></i> <span>Gestión Roles</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="#">
                    <i class="fas fa-user-lock"></i> <span>Gestión Permisos</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="historial_session.php">
                    <i class="fas fa-history"></i> <span>Historial Ingreso Usuario</span>
                </a>
            </li>

            <h3>SEGURIDAD Y ACCESO:</h3>
            <li class="menu-item active">
                <a href="preguntas.php">
                    <i class="fas fa-question-circle"></i> <span>Gestión Preguntas Preestablecidas</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="config_contraseña.php">
                    <i class="fas fa-key"></i> <span>Configuración Contraseña</span>
                </a>
            </li>
            
            <li class="menu-item active">
                <a href="config_preguntas.php">
                    <i class="fas fa-shield-alt"></i> <span>Configuración Preguntas de Seguridad</span>
                </a>
            </li>
            <li class="menu-item active">
                <a href="config_usuario.php">
                    <i class="fas fa-user-edit"></i> <span>Configuración Usuario</span>
                </a>
            </li>
        </ul>
    </aside>

</div>

<?php
require 'footer.php';
?>
