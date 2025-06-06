<?php
require_once '../../model/institucion_m.php';



class InstitucionController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Institucion();
    }

    /**
     * Maneja las solicitudes HTTP y dirige a los métodos correspondientes
     */
    public function manejarSolicitud()
    {
        $accion = $_REQUEST['accion'] ?? '';

        try {
            switch ($accion) {
                case 'buscar':
                    $this->buscar();
                    break;
                case 'insertar':
                    $this->insertar();
                    break;
                case 'listar_activas':
                    $this->listarActivas();
                    break;
                case 'listar_inactivas':
                    $this->listarInactivas();
                    break;
                case 'eliminar':
                    $this->eliminar();
                    break;
                case 'restaurar':
                    $this->restaurar();
                    break;
                case 'buscar_por_id':
                    $this->buscarPorId();
                    break;
                case 'actualizar':
                    $this->actualizar();
                    break;
                case 'verificar_rif':
                    $this->verificarRif();
                    break;
                default:
                    $this->responder(['error' => 'Acción no válida'], 400);
                    break;
            }
        } catch (Exception $e) {
            $this->responder(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Buscar instituciones por nombre o RIF
     */
    private function buscar()
    {
        $busqueda = $_GET['busqueda'] ?? '';
        if (empty($busqueda)) {
            $this->responder(['error' => 'Texto de búsqueda requerido'], 400);
            return;
        }

        $resultados = $this->modelo->buscar($busqueda);
        $this->responder($resultados);
    }

    /**
     * Insertar nueva institución
     */
    private function insertar()
    {
        $datos = $this->obtenerDatosFormulario();
        
        // Validación del RIF
        if ($this->modelo->rifExiste($datos['rif'])) {
            $this->responder(['error' => 'El RIF ya está registrado'], 400);
            return;
        }

        $id = $this->modelo->insertar($datos);
        
        if ($id !== false) {
            $this->responder([
                'success' => true,
                'id' => $id,
                'message' => 'Institución registrada exitosamente'
            ]);
        } else {
            $this->responder(['error' => 'Error al registrar la institución'], 500);
        }
    }

    /**
     * Listar instituciones activas
     */
    private function listarActivas()
    {
        $instituciones = $this->modelo->listarActivas();
        $this->responder($instituciones);
    }

    /**
     * Listar instituciones inactivas
     */
    private function listarInactivas()
    {
        $instituciones = $this->modelo->listarInactivas();
        $this->responder($instituciones);
    }

    /**
     * Eliminar (desactivar) institución
     */
    private function eliminar()
    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de institución requerido'], 400);
            return;
        }

        $resultado = $this->modelo->eliminar($id);
        $this->responder([
            'success' => $resultado,
            'message' => $resultado 
                ? 'Institución desactivada correctamente' 
                : 'Error al desactivar la institución'
        ]);
    }

    /**
     * Restaurar (activar) institución
     */
    private function restaurar()
    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de institución requerido'], 400);
            return;
        }

        $resultado = $this->modelo->restaurar($id);
        $this->responder([
            'success' => $resultado,
            'message' => $resultado 
                ? 'Institución restaurada correctamente' 
                : 'Error al restaurar la institución'
        ]);
    }

    /**
     * Buscar institución por ID
     */
    private function buscarPorId()
    {
        $id = $_GET['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de institución requerido'], 400);
            return;
        }

        $institucion = $this->modelo->buscarPorId($id);
        if ($institucion) {
            $this->responder($institucion);
        } else {
            $this->responder(['error' => 'Institución no encontrada'], 404);
        }
    }

    /**
     * Actualizar datos de institución
     */
    private function actualizar()
    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de institución requerido'], 400);
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        
        // Validar RIF solo si ha cambiado
        $institucionActual = $this->modelo->buscarPorId($id);
        if ($institucionActual['RIF'] !== $datos['rif'] && $this->modelo->rifExiste($datos['rif'], $id)) {
            $this->responder(['error' => 'El nuevo RIF ya está registrado'], 400);
            return;
        }

        $resultado = $this->modelo->actualizar($id, $datos);
        $this->responder([
            'success' => $resultado,
            'message' => $resultado 
                ? 'Institución actualizada correctamente' 
                : 'Error al actualizar la institución'
        ]);
    }

    /**
     * Verificar si un RIF existe
     */
    private function verificarRif()
    {
        $rif = $_GET['rif'] ?? null;
        $idExcluir = $_GET['id_excluir'] ?? null;
        
        if (empty($rif)) {
            $this->responder(['error' => 'RIF requerido'], 400);
            return;
        }

        $existe = $this->modelo->rifExiste($rif, $idExcluir);
        $this->responder(['existe' => $existe]);
    }

    /**
     * Obtiene y valida los datos del formulario
     */
    private function obtenerDatosFormulario()
    {
        return [
            'nombre' => $this->obtenerValor('nombre', true),
            'direccion' => $this->obtenerValor('direccion', true),
            'contacto' => $this->obtenerValor('contacto', true),
            'tipo_practica' => $this->obtenerValor('tipo_practica', true),
            'region' => $this->obtenerValor('region', true),
            'nucleo' => $this->obtenerValor('nucleo', true),
            'extension' => $this->obtenerValor('extension', true),
            'tipo_institucion' => $this->obtenerValor('tipo_institucion', true),
            'rif' => $this->obtenerValor('rif', true)
        ];
    }

    /**
     * Obtiene un valor del POST/GET con validación básica
     */
    private function obtenerValor($campo, $requerido = false)
    {
        $valor = $_POST[$campo] ?? $_GET[$campo] ?? null;
        
        if ($requerido && empty($valor)) {
            throw new Exception("El campo $campo es requerido");
        }
        
        return $valor;
    }

    /**
     * Envía una respuesta JSON con el código de estado HTTP
     */
    private function responder($datos, $codigoEstado = 200)
    {
        http_response_code($codigoEstado);
        header('Content-Type: application/json');
        echo json_encode($datos);
        exit;
    }
}

// Uso del controlador
$controlador = new InstitucionController();
$controlador->manejarSolicitud();