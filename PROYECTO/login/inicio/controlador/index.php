<?php 

	class personascontroller{
		public function __construct(){
			require_once "modelo/index.php";
		}

		public function index(){ 	
			$personas = new personas_model();
			$data["personas"] = $personas->get_personas();

			require_once "vista/personas.php";
		}
		public function nuevo(){	
			require_once "vista/registrar.php";

		}
		public function guarda(){
				
			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$correo_electronico = $_POST['correo_electronico'];
			$nro_de_telefono = $_POST['nro_de_telefono'];
			$forma__de_contactar = $_POST['forma__de_contactar'];
				
			$personas = new personas_model();
			$personas->insertar($nombre, $apellido, $correo_electronico, $nro_de_telefono, $forma__de_contactar);
			$this->index();
			}
			
		public function modificar($id){
				
			$personas = new personas_model();	
			$data["id"] = $id;
			$data["personas"] = $personas->get_persona($id);
			require_once "vista/modificar.php";
			}
			
		public function actualizar(){

			$id = $_POST['id'];
			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$correo_electronico = $_POST['correo_electronico'];
			$nro_de_telefono = $_POST['nro_de_telefono'];
			$forma__de_contactar = $_POST['forma__de_contactar'];

			$personas = new personas_model();
			$personas->modificar($id, $nombre, $apellido, $correo_electronico, $nro_de_telefono, $forma__de_contactar);
			$this->index();
			}
			
		public function eliminar($id){
				
			$personas = new personas_model();
			$personas->eliminar($id);
			$this->index();
			}	
	}
	// Pais
	class paisescontroller{
		public function __construct(){
			require_once "modelo/index.php";
		}

		public function index(){ 	
			$paises = new paises_model();
			$data["paises"] = $paises->get_paises();

			require_once "vista/paises.php";
		}
		public function nuevo(){	
			require_once "vista/pregistrar.php";

		}
		public function guarda(){
				
			$iso = $_POST['iso'];
			$iso3 = $_POST['iso3'];
			$isonumerico = $_POST['isonumerico'];
			$pais = $_POST['pais'];
			$capital = $_POST['capital'];
			$continente = $_POST['continente'];
			$moneda = $_POST['moneda'];
				
			$paises = new paises_model();
			$paises->insertar($iso, $iso3, $isonumerico, $pais, $capital, $continente, $moneda);
			$this->index();
			}
			
		public function modificar($id){
				
			$paises = new paises_model();	
			$data["id"] = $id;
			$data["paises"] = $paises->get_pais($id);
			require_once "vista/pmodificar.php";
			}
			
		public function actualizar(){
			
			$id = $_POST['id'];	
			$iso = $_POST['iso'];
			$iso3 = $_POST['iso3'];
			$isonumerico = $_POST['isonumerico'];
			$pais = $_POST['pais'];
			$capital = $_POST['capital'];
			$continente = $_POST['continente'];
			$moneda = $_POST['moneda'];

			$paises = new paises_model();
			$paises->modificar($id, $iso, $iso3, $isonumerico, $pais, $capital, $continente, $moneda);
			$this->index();
			}
			
		public function eliminar($id){
				
			$paises = new paises_model();
			$paises->eliminar($id);
			$this->index();
			}	
	}

	// Empleados
	class empleadoscontroller{
		public function __construct(){
			require_once "modelo/index.php";
		}

		public function index(){ 	
			$empleados = new empleados_model();
			$data["empleados"] = $empleados->get_empleados();

			require_once "vista/empleados.php";
		}
		public function nuevo(){
			$empleados = new empleados_model();
			$data["empleados"] = $empleados->get_empleados();	
			require_once "vista/eregistrar.php";

		}
		public function guarda(){
				
			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$telefono = $_POST['telefono'];
			$idManager = $_POST['idManager'];
			$idDepartamento = $_POST['idDepartamento'];
			$salario = $_POST['salario'];
			$fecha_contrato = $_POST['fecha_contrato'];
				
			$empleados = new empleados_model();
			$empleados->insertar($nombre, $apellido, $telefono, $idManager, $idDepartamento, $salario, $fecha_contrato);
			$this->index();
			}
			
		public function modificar($id){
				
			$empleados = new empleados_model();	
			$data["id"] = $id;
			$data["empleados"] = $empleados->get_empleado($id);
			require_once "vista/emodificar.php";
			}
			
		public function actualizar(){
			
			$id = $_POST['id'];	
			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$telefono = $_POST['telefono'];
			$idManager = $_POST['idManager'];
			$idDepartamento = $_POST['idDepartamento'];
			$salario = $_POST['salario'];
			$fecha_contrato = $_POST['fecha_contrato'];

			$empleados = new empleados_model();
			$empleados->modificar($id, $nombre, $apellido, $telefono, $idManager, $idDepartamento, $salario, $fecha_contrato);
			$this->index();
			}
			
		public function eliminar($id){
				
			$empleados = new empleados_model();
			$empleados->eliminar($id);
			$this->index();
			}	
	}
	class usuarioscontroller{
		public function __construct(){
			require_once "modelo/index.php";
		}

		public function index(){ 	
			$usuarios = new usuarios_model();
			$data["usuarios"] = $usuarios->get_usuarios();

			require_once "vista/usuarios.php";
		}
		public function indexlogin(){
			header('location: ../index.php');
		}
		public function contraseñanueva(){
			$id = $_POST['id'];
			$password = $_POST['password'];
			$usuarios = new usuarios_model();
			$usuarios->contraseñanueva($id, $password);
			$this->indexlogin();
			}
			
		public function validar(){
		require_once '../inicio/config/db.php';
		$username = $_POST['username'];
        

        $db = new Database();
        $query = $db->connect()->prepare('SELECT *FROM usuarios WHERE username = :username');
        $query->execute(['username' => $username]);

        $row = $query->fetch(PDO::FETCH_NUM);
	    if ( $row[6] == $_POST["respuesta1"] && $row[7] == $_POST["respuesta2"])
        {
         	require_once "../recuperar.php";
              } 
          
        else {
            echo "respuesta incorrecta";
            header('location: ../olvidar.php');
            }

        return $row;


		}
}

class examplecontroller{
	public function __construct(){
		require_once "modelo/index.php";
	}

	public function index(){ 	
		$example = new example_model();
		$data["example"] = $example->get_example();

		require_once "vista/modulos/example/example.php";
	}
	public function nuevo(){	
		require_once "vista/modulos/example/registrar.php";

	}
	public function guarda(){

		$campo1 = $_POST['campo1'];
		$campo2 = $_POST['campo2'];
		$campo3 = $_POST['campo3'];
		$campo4 = $_POST['campo4'];
		$campo5 = $_POST['campo5'];
			
		$example = new example_model();
		$example->insertar($campo1,$campo2,$campo3,$campo4,$campo5);
		$this->index();
		}
		
	public function modificar($id){
			
		$example = new example_model();	
		$data["id"] = $id;
		$data["example"] = $example->get_example1($id);
		require_once "vista/modulos/example/modificar.php";
		}
		
	public function actualizar(){
		$id = $_POST['id'];
		$campo1 = $_POST['campo1'];
		$campo2 = $_POST['campo2'];
		$campo3 = $_POST['campo3'];
		$campo4 = $_POST['campo4'];
		$campo5 = $_POST['campo5'];

		$example = new example_model();
		$example->modificar($id,$campo1, $campo2, $campo3, $campo4, $campo5);
		$this->index();
		}
		
	public function eliminar($id){
			
		$example = new example_model();
		$example->eliminar($id);
		$this->index();
		}	
}

?>	