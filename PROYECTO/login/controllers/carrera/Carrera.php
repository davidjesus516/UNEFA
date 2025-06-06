<?php
require_once '../../model/carrera.php'; // Asegúrate de que la ruta sea correcta

class CareerController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Usuario();
    }

    public function manejarSolicitud()
    {
        $accion = $_REQUEST['accion'] ?? '';

        switch ($accion) {
            case 'buscar_por_codigo':
                $this->buscarPorCodigo();
                break;
            case 'buscar_por_nombre':
                $this->buscarPorNombre();
                break;
            case 'insertar':
                $this->insertar();
                break;
            case 'listar':
                $this->listarActivos();
                break;
            case 'listar_inactivos':
                $this->listarInactivos();
                break;
            case 'eliminar':
                $this->eliminar();
                break;
            case 'restaurar':
                $this->restaurar();
                break;
            case 'buscar_para_editar':
                $this->buscarParaEditar();
                break;
            case 'actualizar':
                $this->actualizar();
                break;
            case 'listar_tipos_pasantias':
                $this->listarTiposPasantias();
                break;
            default:
                echo json_encode(['error' => 'Acción no válida']);
                break;
        }
    }

    private function buscarPorCodigo()
    {
        $codigo = $_GET['codigo'] ?? '';
        $resultado = $this->modelo->buscarCodigo($codigo);
        echo json_encode($resultado);
    }

    private function buscarPorNombre()
    {
        $nombre = $_GET['nombre'] ?? '';
        $resultado = $this->modelo->buscarNombre('%' . $nombre . '%');
        echo json_encode($resultado);
    }

    private function insertar()
    {
        $datos = $this->obtenerDatosFormulario();
        $tiposPasantias = json_decode($_POST['tipos_pasantias'] ?? '[]', true);
        
        $resultado = $this->modelo->insertarUsuario(
            $datos['nombre'],
            $datos['codigo'],
            $datos['nota_minima'],
            $tiposPasantias
        );
        
        echo json_encode(['success' => $resultado]);
    }

    private function listarActivos()
    {
        $datos = $this->modelo->listarUsuarios();
        echo json_encode($datos);
    }

    private function listarInactivos()
    {
        $datos = $this->modelo->listarUsuariosI();
        echo json_encode($datos);
    }

    private function eliminar()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = $this->modelo->eliminarUsuario($id);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function restaurar()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = $this->modelo->RestaurarUsuario($id);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function buscarParaEditar()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $resultado = $this->modelo->searcheditUsuario($id);
            echo json_encode($resultado);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function actualizar()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'ID no proporcionado']);
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        $tiposPasantias = json_decode($_POST['tipos_pasantias'] ?? '[]', true);
        
        $resultado = $this->modelo->editarUsuario(
            $id,
            $datos['nombre'],
            $datos['codigo'],
            $datos['nota_minima'],
            $tiposPasantias
        );
        
        echo json_encode(['success' => $resultado]);
    }

    private function listarTiposPasantias()
    {
        $resultado = $this->modelo->internshipsTypeList();
        echo json_encode($resultado);
    }

    private function obtenerDatosFormulario()
    {
        return [
            'nombre' => $_POST['nombre'] ?? '',
            'codigo' => $_POST['codigo'] ?? '',
            'nota_minima' => $_POST['nota_minima'] ?? 0
        ];
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controlador = new CareerController();
$controlador->manejarSolicitud();