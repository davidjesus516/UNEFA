<?php
require 'header.php';
?>
<span class="text">Ventana -> <a href="usuario.php">Usuario</a> -> Listado Usuario</span>
<div class="page-content">


    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th colspan="2">Accion</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>

</div>
<script src="js/estudiante/jquery-3.7.0.min.js"></script>
<script src="js/estudiante/main.js"></script>
<?php
require 'footer.php';
?>