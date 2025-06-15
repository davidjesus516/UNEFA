<?php
require_once '../../model/carrera_m.php';

class CarreraController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Carrera();
    }

    public function manejarSolicitud()
    {
        $accion = $_REQUEST['accion'] ?? '';

        try {
            switch ($accion) {

                case 'listar_activos':
                    $this->listarActivas();
                    break;
                case 'listar_inactivos':
                    $this->listarInactivas();
                    break;
                case 'insertar':
                    $this->insertar();
                    break;
                case 'actualizar':
                    $this->actualizar();
                    break;
                case 'eliminar':
                    $this->eliminar();
                    break;
                case 'restaurar':
                    $this->restaurar();
                    break;
                case 'listar_tipos_pasantias':
                    $this->listarTiposPasantias();
                    break;
                case 'buscar_para_editar':
                    $this->buscarParaEditar();
                    break;
                case 'codigo_existe':
                    $this->codigoExiste();
                    break;
                case 'nombre_existe':
                    $this->nombreExiste();
                    break;
                default:
                    $this->responder(['error' => 'Acción no válida'], 400);
                    break;
            }
        } catch (Exception $e) {
            $this->responder(['error' => $e->getMessage()], 500);
        }
    }

    private function listarActivas()
    {
        $carreras = $this->modelo->listarActivas();
        $this->responder($carreras);
    }

    private function listarInactivas()
    {
        $carreras = $this->modelo->listarInactivas();
        $this->responder($carreras);
    }

    private function insertar()
    {
        $datos = $this->obtenerDatosFormulario();
        // Validar código único
        if ($this->modelo->codigoExiste($datos['codigo'])) {
            $this->responder(['error' => 'El código ya está registrado'], 400);
            return;
        }
        // Validar nombre único
        if ($this->modelo->nombreExiste($datos['nombre'])) {
            $this->responder(['error' => 'El nombre ya está registrado'], 400);
            return;
        }
        $usuario = 1; // Cambia esto por el usuario real de sesión
        $datos['usuario'] = $usuario;
        $id = $this->modelo->insertar($datos);

        if ($id !== false) {
            $this->responder([
                'success' => true,
                'id' => $id,
                'message' => 'Carrera registrada exitosamente'
            ]);
        } else {
            $this->responder(['error' => 'Error al registrar la carrera'], 500);
        }
    }
    private function codigoExiste()
    {
        // Permitir tanto GET como POST para compatibilidad con fetch JS
        $codigo = $_REQUEST['codigo'] ?? '';
        $id = $_REQUEST['id'] ?? null;
        if (empty($codigo)) {
            $this->responder(['error' => 'Código de carrera requerido'], 400);
            return;
        }
        $existe = $this->modelo->codigoExiste($codigo, $id);
        if ($existe && !empty($id)) {
            // Si se está actualizando, no considerar el ID actual
            $carreraActual = $this->modelo->buscarPorId($id);
            if ($carreraActual && $carreraActual['CAREER_CODE'] === $codigo) {
                $existe = false; // No existe si es el mismo código
            }
        }
        $this->responder(['existe' => $existe]);
    }

    private function nombreExiste()
    {
        // Permitir tanto GET como POST para compatibilidad con fetch JS
        $nombre = $_REQUEST['nombre'] ?? '';
        $id = $_REQUEST['id'] ?? null;
        if (empty($nombre)) {
            $this->responder(['error' => 'Nombre de carrera requerido'], 400);
            return;
        }
        $existe = $this->modelo->nombreExiste($nombre, $id);
        if ($existe && !empty($id)) {
            // Si se está actualizando, no considerar el ID actual
            $carreraActual = $this->modelo->buscarPorId($id);
            if ($carreraActual && $carreraActual['CAREER_NAME'] === $nombre) {
                $existe = false; // No existe si es el mismo nombre
            }
        }
        $this->responder(['existe' => $existe]);
    }
    private function actualizar()

    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de carrera requerido'], 400);
            return;
        }
        $datos = $this->obtenerDatosFormulario();
        $usuario = 1; // Cambia esto por el usuario real de sesión
        $datos['usuario'] = $usuario;

        // Validar código solo si ha cambiado
        $carreraActual = $this->modelo->buscarPorId($id);
        if ($carreraActual && $carreraActual['CAREER_CODE'] !== $datos['codigo'] && $this->modelo->codigoExiste($datos['codigo'], $id)) {
            $this->responder(['error' => 'El nuevo código ya está registrado'], 400);
            return;
        }
        // Validar nombre solo si ha cambiado
        if ($carreraActual && $carreraActual['CAREER_NAME'] !== $datos['nombre'] && $this->modelo->nombreExiste($datos['nombre'], $id)) {
            $this->responder(['error' => 'El nuevo nombre ya está registrado'], 400);
            return;
        }

        $resultado = $this->modelo->actualizar($id, $datos);
        $this->responder([
            'success' => $resultado,
            'message' => $resultado
                ? 'Carrera actualizada correctamente'
                : 'Error al actualizar la carrera'
        ]);
    }

    private function eliminar()
    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de carrera requerido'], 400);
            return;
        }
        $usuario = 1; // Cambia esto por el usuario real de sesión
        $resultado = $this->modelo->eliminar($id, $usuario);
        $this->responder([
            'success' => $resultado,
            'message' => $resultado
                ? 'Carrera desactivada correctamente'
                : 'Error al desactivar la carrera'
        ]);
    }

    private function restaurar()
    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de carrera requerido'], 400);
            return;
        }
        $usuario = 1; // Cambia esto por el usuario real de sesión
        $resultado = $this->modelo->restaurar($id, $usuario);
        $this->responder([
            'success' => $resultado,
            'message' => $resultado
                ? 'Carrera restaurada correctamente'
                : 'Error al restaurar la carrera'
        ]);
    }

    private function listarTiposPasantias()
    {
        $tipos = $this->modelo->internshipsTypeList();
        $this->responder($tipos);
    }

    private function buscarParaEditar()
    {
        $id = $_GET['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de carrera requerido'], 400);
            return;
        }
        $carrera = $this->modelo->buscarPorId($id);
        if ($carrera) {
            // Formato esperado por la vista: array con un elemento
            $carrera['CAREER_INTERNSHIP_TYPES'] = array_map(function ($tipo_id) {
                return ['INTERNSHIP_TYPE_ID' => $tipo_id];
            }, $carrera['CAREER_INTERNSHIP_TYPES'] ?? []);
            $this->responder([$carrera]);
        } else {
            $this->responder(['error' => 'Carrera no encontrada'], 404);
        }
    }

    private function obtenerDatosFormulario()
    {
        $tipos = json_decode($_POST['tipos_pasantias'] ?? '[]', true);
        return [
            'codigo' => $_POST['codigo'] ?? '',
            'nombre' => mb_strtoupper(trim($_POST['nombre'])) ?? '',
            'minimo' => $_POST['nota'] ?? '',
            'tipos_pasantia' => is_array($tipos) ? $tipos : [],
            'abreviatura' => mb_strtoupper(trim($_POST['abreviatura'])) ?? ''
        ];
    }

    private function responder($datos, $codigoEstado = 200)
    {
        http_response_code($codigoEstado);
        header('Content-Type: application/json');
        echo json_encode($datos);
        exit;
    }
}

// Uso del controlador
$controlador = new CarreraController();
$controlador->manejarSolicitud();
