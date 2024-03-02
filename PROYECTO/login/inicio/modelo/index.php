<?php 
//clientes
	class personas_model {
		private $db;
		private $personas;

		public function __construct(){
			$this-> db = conectar::conexion();
			$this-> personas = array();
			}
		public function get_personas(){

			$sql = "SELECT * FROM personas";
			$resultado = $this-> db -> query($sql);
			while ($row = $resultado-> fetch_assoc())
			{
				 $this->personas[] = $row;
			}
			return $this->personas;
			}
		public function insertar($nombre,$apellido,$correo_electronico,$nro_de_telefono,$forma__de_contactar){
			$sql = "INSERT INTO `personas`(`Fname`, `Lname`, `Email`, `PhoneNumber`, `preferredcontact`) VALUES ('$nombre','$apellido','$correo_electronico','$nro_de_telefono','$forma__de_contactar')";
			$resultado = $this->db->query($sql);
		}
		public function modificar($id, $nombre, $apellido, $correo_electronico, $nro_de_telefono, $forma__de_contactar){
				$sql = "UPDATE `personas` SET `Fname`='$nombre',`Lname`='$apellido',`Email`='$correo_electronico',`PhoneNumber`='$nro_de_telefono',`preferredcontact`='$forma__de_contactar' WHERE id= '$id' ";
				$resultado = $this->db->query($sql);	
				
			}
		public function eliminar($id){
				
			$resultado = $this->db->query("DELETE FROM personas WHERE id = '$id'");
				
			}

		public function get_persona($id)
		{
			$sql = "SELECT * FROM personas WHERE id='$id'";
			$resultado = $this->db->query($sql);
			$row = $resultado->fetch_assoc();

			return $row;		
	}
}
//paises
	class paises_model {
		private $db;
		private $paises;

		public function __construct(){
			$this-> db = conectar::conexion();
			$this-> paises = array();
			}
		public function get_paises(){

			$sql = "SELECT * FROM paises";
			$resultado = $this-> db -> query($sql);
			while ($row = $resultado-> fetch_assoc())
			{
				 $this->paises[] = $row;
			}
			return $this->paises;
			}
		public function insertar($iso, $iso3, $isonumerico, $pais, $capital, $continente, $moneda){
			$sql = "INSERT INTO `paises`(`ISO`, `ISO3`, `ISONumeric`, `CountryName`, `Capital`, `ContinentCode`, `CurrencyCode`) VALUES ('$iso', '$iso3', '$isonumerico', '$pais', '$capital', '$continente', '$moneda')";
			$resultado = $this->db->query($sql);
		}
		public function modificar($id, $iso, $iso3, $isonumerico, $pais, $capital, $continente, $moneda){
				$sql = "UPDATE `paises` SET `ISO`='$iso',`ISO3`='$iso3',`ISONumeric`='$isonumerico',`CountryName`= '$pais',`Capital`='$capital',`ContinentCode`='$continente',`CurrencyCode`='$moneda' WHERE `Id`= '$id' ";
				$resultado = $this->db->query($sql);	
				
			}
		public function eliminar($id){
				
			$resultado = $this->db->query("DELETE FROM `paises` WHERE Id = '$id'");
				
			}

		public function get_pais($id)
		{
			$sql = "SELECT * FROM `paises` WHERE id='$id'";
			$resultado = $this->db->query($sql);
			$row = $resultado->fetch_assoc();

			return $row;		
	}

}
//empleados
	class empleados_model {
		private $db;
		private $empleados;

		public function __construct(){
			$this-> db = conectar::conexion();
			$this-> empleados = array();
			}
		public function get_empleados(){

			$sql = "SELECT * FROM employees";
			$resultado = $this-> db -> query($sql);
			while ($row = $resultado-> fetch_assoc())
			{
				 $this->empleados[] = $row;
			}
			return $this->empleados;
			}
		public function insertar($nombre,$apellido,$telefono,$idManager,$idDepartamento,$salario,$fecha_contrato){
			$sql = "INSERT INTO `employees`( `FName`, `LName`, `PhoneNumber`, `ManagerId`, `DepartamentId`, `Salary`, `HireDate`) VALUES ('$nombre','$apellido','$telefono','$idManager','$idDepartamento','$salario','$fecha_contrato')";
			$resultado = $this->db->query($sql);
		}
		public function modificar($id, $nombre, $apellido, $telefono, $idManager, $idDepartamento, $salario, $fecha_contrato){
				$sql = "UPDATE `employees` SET `Fname`='$nombre',`Lname`='$apellido',`PhoneNumber`='$telefono',`ManagerId`='$idManager',`DepartamentId`='$idDepartamento',`Salary`='$salario',`HireDate`='$fecha_contrato' WHERE Id = '$id'";
				$resultado = $this->db->query($sql);
			}
		public function eliminar($id){
				
			$resultado = $this->db->query("DELETE FROM employees WHERE Id = '$id'");
				
			}

		public function get_empleado($id)
		{
			$sql = "SELECT * FROM employees WHERE Id='$id'";
			$resultado = $this->db->query($sql);
			$row = $resultado->fetch_assoc();

			return $row;		
	}
}

class usuarios_model {
		private $db;
		private $usuarios;

		public function __construct(){
			$this-> db = conectar::conexion();
			$this-> usuarios = array();
			}
		public function get_usuarios(){

			$sql = "SELECT * FROM usuarios";
			$resultado = $this-> db -> query($sql);
			while ($row = $resultado-> fetch_assoc())
			{
				 $this->usuarios[] = $row;
			}
			return $this->usuarios;
		}
		public function contraseñanueva($id, $password){
		$sql = "UPDATE `usuarios` SET `password`='$password' WHERE id = '$id'";
		$resultado = $this->db->query($sql);}
			}


//Example
	class example_model {
		private $db;
		private $example;

		public function __construct(){
			$this-> db = conectar::conexion();
			$this-> example = array();
			}
		public function get_example(){

			$sql = "SELECT * FROM example";
			$resultado = $this-> db -> query($sql);
			while ($row = $resultado-> fetch_assoc())
			{
				 $this->example[] = $row;
			}
			return $this->example;
			}
		public function insertar($campo1,$campo2,$campo3,$campo4,$campo5){
			$sql = "INSERT INTO `example`( `Campo1`, `Campo2`, `Campo3`, `Campo4`, `Campo5`) 
			VALUES ('$campo1','$campo2','$campo3','$campo4','$campo5')"; 
			$resultado = $this->db->query($sql);
		}
		public function modificar($id,$campo1, $campo2, $campo3, $campo4, $campo5){
				$sql = "UPDATE `example` SET `Campo1`='$campo1',`Campo2`='$campo2',`Campo3`='$campo3',`Campo4`='$campo4',`Campo5`='$campo5' WHERE id= '$id' ";
				$resultado = $this->db->query($sql);	
				
			}
		public function eliminar($id){
				
			$resultado = $this->db->query("DELETE FROM example WHERE id = '$id'");
				
			}

		public function get_example1($id)
		{
			$sql = "SELECT * FROM example WHERE id='$id'";
			$resultado = $this->db->query($sql);
			$row = $resultado->fetch_assoc();

			return $row;		
	}
}

?>