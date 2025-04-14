<?php
if (isset($_POST['id'])) {
require_once '..\..\model\usuario.php';
$usuario = new Usuario();
$id = $_POST['id'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$question1 = $_POST['question1'];
$answer1 = mb_strtoupper($_POST['answer1']);
$question2 = $_POST['question2'];
$answer2 = mb_strtoupper($_POST['answer2']);   
$question3 = $_POST['question3'];
$answer3 = mb_strtoupper($_POST['answer3']);
$correo = mb_strtoupper($_POST['correo']);
$telefono = $_POST['tlf'];
$questions_answers = array(
    $question1 => $answer1,
    $question2 => $answer2,
    $question3 => $answer3
);
$search_actual_password = $usuario->SearchUserKey($_SESSION["USER_ID"]);
if (password_verify($_POST['passwordinput0'], $search_actual_password['KEY'])) {
    $users = $usuario->SearchLastNUserKey($id);
foreach ($users as $key => $value) {
    $new_password_status = password_verify($password, $value['KEY']);
    if ($new_password_status){
        break;
    }
}
if (!$new_password_status) {
    $row = $usuario->basic_login_config($id, $password, $questions_answers, $correo, $telefono);
if ($row === true) {
    $row = array(
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
} else {$row = array(
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
}}
else {
    $row = array(
        'message' =>'<     
            <dialog id="dialog">
            <h2>La contraseña actual no puede ser la misma que la anterior.</h2>
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
        'status' => 0); // La contraseña actual no puede ser la misma que la anterior
}
}
else {
    $row = array(
        'message' =>'<     
            <dialog id="dialog">
            <h2>Contraseña actual incorrecta.</h2>
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
        'status' => 0);  // Contraseña actual incorrecta
}
} else {
    $row = array(
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
        'status' => 0);  // Error al procesar la solicitud

}

echo json_encode($row); //devuelvo el resultado en formato json
?>