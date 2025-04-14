<?php //inicializo el contador de intentos de login
$username = $_POST["username"]; //guardo lo q mando
$password = $_POST["password"];

// incluir la clase Usuario
require_once("../../model/usuario.php");
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0; //inicializo el contador de intentos de login
}
// crear una instancia de la clase Usuario
$UserData = new Usuario();

// llamar al método para buscar un usuario por su codigo
$UserSessionData = $UserData->login($username);
if ($UserSessionData == null) {
    $row = array(
        'message' =>'      
            <dialog id="dialog">
            <h2>usuario o contraseña incorrecta </h2>
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
        'status' => 0);
}   elseif ($UserSessionData['STATUS_SESSION'] == 0) {
    $row = array(
        'message' =>'<     
            <dialog id="dialog">
            <h2>Usuario bloqueado, contacte al administrador.</h2>
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
} else {
    if (
        password_verify($password, $UserSessionData['KEY'])
    ) {
        $today = date('Y-m-d H:i:s');
        $today = date_create($today);
        $today = date_format($today, 'Y-m-d');
        $endDate = date_create($UserSessionData['END_DATE']);
        $endDate = date_format($endDate, 'Y-m-d');
        $_SESSION = array(
                'USER' => $UserSessionData['USER'],
                'USER_ID' => $UserSessionData['USER_ID'],
                'USER_CI' => $UserSessionData['USER_CI'],
                'NAME' => $UserSessionData['NAME'],
                'SURNAME' => $UserSessionData['SURNAME'],
                'STATUS_SESSION' => $UserSessionData['STATUS_SESSION']
            );
            $_SESSION['login_attempts'] = 0; //reinicio el contador de intentos de login
            if ($_SESSION['STATUS_SESSION'] === 1){
                if ($today >= $endDate) {
                $_SESSION = array(
                    'USER_ID' => $UserSessionData['USER_ID']
                );
                $row = array( 
                    'message' =>'<dialog id="dialog">
                    <h2>Contraseña Vencida.</h2>
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
                    'status' => 1,
                    'redirect' => 'new_password.php'
                );
            }else {
            $row = array(
                'message' => '    
                <dialog id="dialog">
                <h2>Bienvenido ' . ucfirst($_SESSION['NAME']) . '.</h2>
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
                'redirect' => 'vistas/intranet.php');}
            }else if($_SESSION['STATUS_SESSION'] === 2){
                $row = array(
                    'message' => '    
                    <dialog id="dialog">
                    <h2>Bienvenido ' . ucfirst($_SESSION['NAME']) . '.</h2>
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
                    'redirect' => 'first_login.php');
                
            }else if($_SESSION['STATUS_SESSION'] === 3){
                $row = array(
                    'message' => '    
                    <dialog id="dialog">
                    <h2>Bienvenido ' . ucfirst($_SESSION['NAME']) . '.</h2>
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
                    'redirect' => 'basic_user_config.php');
                
            }
        
        
    } else {
        $_SESSION['login_attempts'] += 1; //incremento el contador de intentos de login
        if ($_SESSION['login_attempts'] >= 3) {
            $UserData->UserBlock($UserSessionData['USER_ID']); //bloqueo el usuario
            $row = array(
                'message' =>'     
                <dialog id="dialog">
            <h2>Usuario bloqueado, contacte al administrador.</h2>
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
                'status' => 0);
        }elseif ($_SESSION['login_attempts'] > 1) {
            $row = array(
                'message' => '    
                <dialog id="dialog">
                <h2>usuario o contraseña incorrecta</h2>
                <h3>intentos restantes: ' . (3 - $_SESSION['login_attempts']) . '</h3>
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
                'status' => 0);}
                else {
                    $row = array(
                        'message' =>'      
                            <dialog id="dialog">
                            <h2>usuario o contraseña incorrecta </h2>
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
                        'status' => 0);}
    }
}
echo json_encode($row); //devuelvo el resultado en formato json
?>
