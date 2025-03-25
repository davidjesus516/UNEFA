<?php
require_once "../../model/usuario.php";
$username = $_POST["user"];
$user = new Usuario;
$row = $user->userSecurityQuestionSearch($username);
if (count($row) === 0) {
    $row = array(
        'message' => array(
            'text' => '<dialog id="dialog">
            <h2>usuario no existente o bloqueado</h2>
            <div class="error-banmark">
            <div class="ban-icon">
                <span class="icon-line line-long-invert"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            <button aria-label="close" class="x">❌</button>
            </dialog>',
            'status' => 0
        )
    );
}else{
    $row += array(
        'message' => array(
            'text' => '<dialog id="dialog">
            <h2>Bienvenido.</h2>
            <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
            <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            </dialog>',
            'status' => 1
        )
    );
};
$json = json_encode($row);
echo($json);
?>