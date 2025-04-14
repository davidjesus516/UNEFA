<?php
require_once '..\..\model\usuario.php';
$usuario = new Usuario();
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $users = $usuario->SearchLastNUserKey($user_id);
foreach ($users as $key => $value) {
    $new_password_status = password_verify($_POST['password'], $value['KEY']);
    if ($new_password_status){
        break;
    }
}
if (!$new_password_status) {
    $row = $usuario->NewPassword($user_id, $password);
    if ($row === true) {
        $json = array(
        'message' => '    
        <dialog id="dialog">
        <h2>Registro Completado</h2>
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
        'status' => 1,
        'redirect' => 'logout.php');
    } else {
        $json = array(
        'message' =>'<     
            <dialog id="dialog">
            <h2>Error al procesar la solicitud.</h2>
            <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
            <div class="error-banmark">
            <div class="ban-icon">
                <span class="icon-line line-long-invert"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            </dialog>',
        'status' => 0);   
    }
} else {
    $json = array(
    'message' =>'<     
        <dialog id="dialog">
        <h2> La contraseña actual no puede ser la misma que la anterior.</h2>
        <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
        <div class="error-banmark">
        <div class="ban-icon">
            <span class="icon-line line-long-invert"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
        </div>
        </div>
        </dialog>',
    'status' => 0);  // La contraseña actual no puede ser la misma que la anterior
}
} else {
    $json = array(
    'message' =>'<     
        <dialog id="dialog">
        <h2>Error al procesar la solicitud.</h2>
        <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
        <div class="error-banmark">
        <div class="ban-icon">
            <span class="icon-line line-long-invert"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
        </div>
        </div>
        </dialog>',
    'status' => 0); // Error al procesar la solicitud
}

echo json_encode($json); //devuelvo el resultado en formato json
?>