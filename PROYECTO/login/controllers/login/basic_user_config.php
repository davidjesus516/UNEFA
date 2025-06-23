<?php
session_start(); // Asegúrate de que la sesión esté iniciada para acceder a $_SESSION['USER_ID']

if (isset($_POST['id'])) {
    require_once '..\..\model\usuario.php';
    $usuario = new Usuario();

    $id = $_POST['id'];
    $passwordinput0 = $_POST['passwordinput0']; // Contraseña actual ingresada por el usuario
    $new_password = $_POST['password']; // La nueva contraseña ingresada por el usuario

    $question1 = $_POST['question1'];
    $answer1 = mb_strtoupper($_POST['answer1']);
    $question2 = $_POST['question2'];
    $answer2 = mb_strtoupper($_POST['answer2']);   
    $question3 = $_POST['question3'];
    $answer3 = mb_strtoupper($_POST['answer3']);
    $correo = mb_strtoupper($_POST['correo']);
    $telefono = $_POST['number_tel']; // Asegúrate de que el nombre del campo POST sea correcto

    $questions_answers = array(
        $question1 => $answer1,
        $question2 => $answer2,
        $question3 => $answer3
    );

    // Buscar la contraseña actual del usuario en la base de datos
    $search_actual_password = $usuario->SearchUserKey($_SESSION["USER_ID"]);

    // Verificar si la contraseña actual ingresada por el usuario es correcta
    if ($search_actual_password && password_verify($passwordinput0, $search_actual_password['KEY'])) {
        // La contraseña actual es correcta, ahora validamos la nueva contraseña

        // Obtener las últimas N contraseñas del usuario para verificar si la nueva ya fue usada
        $users_last_keys = $usuario->SearchLastNUserKey($id);
        $new_password_already_used = false;

        foreach ($users_last_keys as $key_data) {
            if (password_verify($new_password, $key_data['KEY'])) {
                $new_password_already_used = true;
                break;
            }
        }

        if (!$new_password_already_used) {
            // La nueva contraseña no ha sido usada anteriormente.
            // Primero, actualizamos la información básica del usuario (sin la contraseña).
            // Pasamos null para el parámetro de la contraseña ya que no se usará en este método.
            $row_update_result = $usuario->BasicLoginConfig($id, null, $questions_answers, $correo, $telefono);
            
            if ($row_update_result === true) {
                // La configuración básica se actualizó con éxito. Ahora, actualizamos la contraseña.
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $password_update_success = $usuario->NewPassword($id, $hashed_new_password);

                if ($password_update_success === true) {
                    // Si la contraseña también se actualizó con éxito, enviamos la respuesta de éxito.
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
                        'redirect' => 'logout.php'
                    );
                } else {
                    // Si falló la actualización de la contraseña, enviamos un error específico.
                    $row = array(
                        'message' => '<dialog id="dialog">
                        <h2>Error al actualizar la contraseña.</h2>
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
                        'status' => 0
                    );
                }
            } else {
                // Si falló la actualización de la información básica, enviamos un error general.
                $row = array(
                    'message' => '<dialog id="dialog">
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
                    'status' => 0
                );   
            }
        } else {
            // La nueva contraseña es igual a una de las anteriores
            $row = array(
                'message' => '<dialog id="dialog">
                <h2>La nueva contraseña no puede ser la misma que una de las anteriores.</h2>
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
                'status' => 0
            );
        }
    } else {
        // Contraseña actual incorrecta
        $row = array(
            'message' => '<dialog id="dialog">
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
            'status' => 0
        );
    }
} else {
    // Error al procesar la solicitud (falta el ID)
    $row = array(
        'message' => '<dialog id="dialog">
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
        'status' => 0
    );
}

echo json_encode($row); // Devuelve el resultado en formato JSON
