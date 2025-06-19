<?php
// Incluye el modelo de usuario que contiene la lógica de base de datos.
require_once '../../model/usuario.php';

// Crea una instancia de la clase Usuario para interactuar con la base de datos.
$usuario = new Usuario();

// Utiliza un switch para manejar diferentes operaciones basadas en el parámetro 'op' de la URL.
switch ($_GET['op']) {
    // Caso para crear un nuevo usuario.
    case 'crear':
        // Recoge los datos enviados por POST, aplicando trim para limpiar espacios.
        $u = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
        $n = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $r = isset($_POST['rol']) ? (int)$_POST['rol'] : 0;
        $clave = isset($_POST['clave']) ? $_POST['clave'] : '';

        // Validación: todos los campos son requeridos.
        if (empty($u) || empty($n) || empty($r) || empty($clave)) {
            echo json_encode(['status' => false, 'error' => 'Todos los campos son requeridos. El rol no puede estar vacío.']);
            exit;
        }

        // Validación específica para el valor del rol (opcional, ya que la FK lo hará)
        // Esto es útil si quieres un mensaje más controlado antes del error de BD.
        // Asumiendo que los únicos roles válidos que vienen del formulario son 1 y 2.
        if (!in_array($r, [1, 2])) { // Ajusta [1, 2] si tienes más roles válidos desde el formulario.
            echo json_encode(['status' => false, 'error' => "El valor del rol ('$r') no es válido. Por favor, seleccione un rol existente."]);
            exit;
        }
        // Validación: formato de la cédula (usuario).
        if (!preg_match('/^\d{7,9}$/', $u)) {
            echo json_encode(['status' => false, 'error' => 'Cédula inválida (7-9 dígitos).']);
            exit;
        }
        // Validación: verifica si el nombre de usuario (cédula) ya existe.
        if ($usuario->SearchUsername($u)) {
            echo json_encode(['status' => false, 'error' => 'El usuario (cédula) ya existe.']);
            exit;
        }

        try {
            // Genera el hash de la contraseña.
            $hash = password_hash($clave, PASSWORD_DEFAULT);
            // Intenta crear el usuario en la tabla `t-user`.
            // Los campos no proporcionados por el modal se envían como cadenas vacías ('').
            // UserCreate ahora devuelve el ID del usuario si es exitoso, o false/0 si falla.
            $usrId = $usuario->UserCreate($u, $u, $n, '', '', '', '', '', $hash);

            if ($usrId && $usrId > 0) { // Verificar que usrId sea un ID válido y positivo
                // Asigna el rol al usuario en la tabla `t-user_roles`.
                $rolAsignado = $usuario->AsignarRol($usrId, $r);
                if ($rolAsignado) {
                    // Si el rol se asignó correctamente, envía respuesta de éxito.
                    echo json_encode(['status' => true, 'message' => 'Usuario creado exitosamente.']);
                } else {
                    // Si falla la asignación de rol, se intenta "eliminar" (marcar como inactivo) el usuario base creado.
                    $usuario->UserDelete($usrId); // UserDelete cambia STATUS a 0.
                    echo json_encode(['status' => false, 'error' => 'Usuario base creado, pero falló la asignación de rol. Creación revertida.']);
                }
            } else {
                // Si UserCreate devuelve false o 0, la creación del usuario base falló.
                // El mensaje de error específico (duplicado, etc.) ya debería haberse logueado en el modelo.
                echo json_encode(['status' => false, 'error' => 'No se pudo crear el registro base del usuario. Verifique los datos o consulte los logs del servidor para más detalles.']);
            }
        } catch (Exception $e) {
            // Captura cualquier otra excepción durante el proceso.
            error_log("Controlador Usuario (crear): Excepción - " . $e->getMessage()); // Loguear la excepción
            echo json_encode(['status' => false, 'error' => 'Excepción durante la creación: ' . $e->getMessage()]);
        }
        break;

    // Caso para editar un usuario existente.
    case 'obtener_datos':
        $id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        if ($id > 0) {
            $datos = $usuario->obtenerUsuarioParaEditar($id);
            echo json_encode($datos);
        } else {
            echo json_encode(['status' => false, 'error' => 'ID inválido']);
        }
        break;

    case 'editar':
        $id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        $username = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
        $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $rol = isset($_POST['rol']) ? (int)$_POST['rol'] : 0;
        $clave = isset($_POST['clave']) ? $_POST['clave'] : '';

        if (empty($id) || empty($username) || empty($nombre) || empty($rol)) {
            echo json_encode(['status' => false, 'error' => 'Faltan datos obligatorios']);
            exit;
        }

        try {
            $ok1 = $usuario->ActualizarNombre($id, $nombre);

            $ok2 = $usuario->ActualizarRol($id, $rol);

            $ok3 = $usuario->ActualizarUsername($id, $username);

            $ok4 = true;
            if (!empty($clave)) {
                $hash = password_hash($clave, PASSWORD_DEFAULT);
                $ok4 = $usuario->NewPassword($id, $hash);
            }

            if ($ok1 && $ok2 && $ok3 && $ok4) {
                echo json_encode(['status' => true, 'message' => 'Usuario actualizado correctamente.']);
            } else {
                echo json_encode(['status' => false, 'error' => 'No se pudieron actualizar todos los campos.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
        break;


    // Caso para listar usuarios (activos o inactivos).
    case 'listar':
        // Determina el estado a listar (1 para activos, 0 para inactivos).
        $e = $_GET['estado'] === 'inactivos' ? 0 : 1;
        // Obtiene los datos de los usuarios con su rol.
        $data = $usuario->listarUsuariosConRol($e);
        // Devuelve los datos en formato JSON.
        echo json_encode($data);
        break;

    // Caso para "eliminar" (marcar como inactivo) un usuario.
    case 'eliminar':
        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        if ($userId > 0) {
            $eliminado = $usuario->UserDelete($userId);
            if ($eliminado) {
                echo json_encode(['status' => true, 'message' => 'Usuario desactivado correctamente.']);
            } else {
                echo json_encode(['status' => false, 'error' => 'No se pudo desactivar el usuario.']);
            }
        } else {
            echo json_encode(['status' => false, 'error' => 'ID de usuario inválido.']);
        }
        break;

    // Caso para restaurar (marcar como activo) un usuario.
    case 'restaurar':
        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        if ($userId > 0) {
            $restaurado = $usuario->UserRestore($userId);
            if ($restaurado) {
                echo json_encode(['status' => true, 'message' => 'Usuario restaurado correctamente.']);
            } else {
                echo json_encode(['status' => false, 'error' => 'No se pudo restaurar el usuario.']);
            }
        } else {
            echo json_encode(['status' => false, 'error' => 'ID de usuario inválido.']);
        }
        break;
}
