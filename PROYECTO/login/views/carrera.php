<?php
require 'header.php';
?>


<div class="container">
    <div class="titulo">Registro Carrera</div>
    <form id="task-form">
        <div class="user-details">
            <div class="input-box">
                <input type="hidden" id="id">
                <span class="detalles">id</span>
                <input type="text" readonly id="id" placeholder="id" class="campo-entrada" required>
            </div>
            <div class="input-box">
                <span class="detalles">Código</span>
                <input type="text" id="codigo" placeholder="Código" class="campo-entrada" required>
            </div>
            <div class="input-box">
                <span class="detalles">Carrera</span>
                <input type="text" id="nombre" placeholder="Nombre de la Carrera" class="campo-entrada" required>
            </div>
        </div>

        <div class="button">
            <button type="submit" value="Registrar">Registrar</button>
        </div>

    </form>
</div>

<div class="resultado">
    <table border="1">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th colspan="2">Acción</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>
</div>

<script src="js/carrera/jquery-3.7.0.min.js"></script>
<script src="js/carrera/main.js"></script>
<script src="js/carrera/valiar.js"></script>

</body>

</html>