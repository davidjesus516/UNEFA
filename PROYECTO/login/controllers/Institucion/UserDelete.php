<?php

require("../../model/Institucion.php");

if(isset($_POST)){// si js me manda datos yo hago:
    $id = $_POST["id"];//guardo lo que mando
    $estatus = 0;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método eliminarUsuario() para eliminar un nuevo Usuario
    $usuario->eliminar($id,$estatus);
    echo '
    <h1>Usuario Eliminado</h1>
        <button id = close aria-label="close" class="x">❌</button>
            <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            ';//le respondo a js
}
?>