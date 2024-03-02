<?php 
if(isset($_POST)){
$ID = $_POST['ID'];
require_once '../../model/login.php';
$usuario = new Usuario();

    // llamar al método para buscar un usuario por su codigo
$row = $usuario->validar($ID);
if ($row["respuesta".$_POST["n1"].""] == $_POST["respuesta1"] && $row["respuesta".$_POST["n2"].""] == $_POST["respuesta2"])
        {	

         	header('location: ../../recuperar.php?id='.$ID);


              } 
          
        else {
            echo "respuesta incorrecta";
            header('location: ../../olvidar.php');
            }


}

 ?>