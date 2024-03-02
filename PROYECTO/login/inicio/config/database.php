<?php 
#conexion a la database		
	class conectar {
		
		public static function conexion(){

			$conexion = new mysqli("localhost","root","","usuarios");
			return $conexion;

		}
	}

 ?>