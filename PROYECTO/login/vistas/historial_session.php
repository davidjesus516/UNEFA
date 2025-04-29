<?php
require 'header.php';
?>
<?php
require_once __DIR__ . '/../controllers/FPDF/ControladorSession.php';
$historial = ControladorSessionHistory::obtenerHistorial();
?>

<span class="text">Ventana -> <a href="usuario.php">Configuración</a> -> Historial de Sesiones</span>
<div class="page-content">


<table  class="w3-table-all w3-hoverable">
    <thead>
        <tr class="w3-light-grey">
            <th>Nombre del Usuario</th>
            <th>Hora de Login</th>
            <th>Hora de Logout</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($historial as $fila): ?>
            <tr>
                <td><?= htmlspecialchars($fila['USER_NAME'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($fila['LOGIN_TIME']) ?></td>
                <td><?= htmlspecialchars($fila['LOGOUT_TIME']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
require 'footer.php';
?>