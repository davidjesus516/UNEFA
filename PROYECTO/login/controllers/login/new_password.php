<?php
require_once '..\..\model\usuario.php';
header('Content-Type: application/json'); // Es una buena práctica establecer el tipo de contenido.
$usuario = new Usuario();
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $password = $_POST['password']; // No hashear aquí, se hashea en el modelo o se asume que ya viene hasheada si es de otro controlador
    
    // Si la contraseña no viene hasheada desde el JS, hashearla aquí antes de usarla para comparar y guardar
    // $hashed_password_for_comparison = password_hash($password, PASSWORD_DEFAULT); 
    // O si ya viene hasheada desde el JS (como en new_password.js), usarla directamente.
    // Para este caso, new_password.js envía la contraseña en texto plano, así que la hasheamos aquí.
    $hashed_password_to_save = password_hash($password, PASSWORD_DEFAULT);

    $users = $usuario->SearchLastNUserKey($user_id);
    $new_password_status = false; // Inicializar la variable
    foreach ($users as $key => $value) {
        // Comparar la contraseña en texto plano recibida con las hasheadas en la DB
        if (password_verify($password, $value['KEY'])) {
            $new_password_status = true;
            break;
        }
    }

    if (!$new_password_status) {
        // Pasar la contraseña ya hasheada al método NewPassword
        $row = $usuario->NewPassword($user_id, $hashed_password_to_save);
        if ($row === true) {
            $json = array(
                'message' => '    
            <dialog id="dialog">
            <h2>Contraseña Cambiada</h2>
            <button aria-label="close" class="x">❌</button>
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
                'redirect' => 'logout.php'
            );
        } else {
            $json = array(
                'message' => '<dialog id="dialog">
                <h2>Error al procesar la solicitud.</h2>
                <button aria-label="close" class="x">❌</button>
                <div class="error-banmark">
                <div class="ban-icon">
                    <span class="icon-line line-long-invert"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
                </div>
                </dialog>',
                'status' => 0
            );
        }
    } else {
        $json = array(
            'message' => '<dialog id="dialog">
            <h2> La contraseña actual no puede ser la misma que una de las anteriores.</h2>
            <button aria-label="close" class="x">❌</button>
            <div class="error-banmark">
            <div class="ban-icon">
                <span class="icon-line line-long-invert"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            </dialog>',
            'status' => 0
        );  // La contraseña actual no puede ser la misma que la anterior
    }
} else {
    $json = array(
        'message' => '<dialog id="dialog">
        <h2>Error al procesar la solicitud.</h2>
        <button aria-label="close" class="x">❌</button>
        <div class="error-banmark">
        <div class="ban-icon">
            <span class="icon-line line-long-invert"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
        </div>
        </div>
        </dialog>',
        'status' => 0
    ); // Error al procesar la solicitud
}

echo json_encode($json); //devuelvo el resultado en formato json
