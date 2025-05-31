<?php require("../../model/periodo.php"); 
if ($_SERVER["REQUEST_METHOD"] === "POST") { if ( isset($_POST["PERIOD_ID"], 
$_POST["ACADEMIC_LAPSE"], 
$_POST["T_INTERNSHIPS_CODE"], 
$_POST["START_DATE"], 
$_POST["END_DATE"], 
$_POST["PERIOD_STATUS"]) ) 
{ $PERIOD_ID = $_POST["PERIOD_ID"]; $ACADEMIC_LAPSE = strtoupper(trim($_POST["ACADEMIC_LAPSE"])); 
$T_INTERNSHIPS_CODE =strtoupper(trim($_POST["T_INTERNSHIPS_CODE"])); $START_DATE = $_POST["START_DATE"]; 
$END_DATE = $_POST["END_DATE"]; 
$PERIOD_STATUS = strtoupper(trim($_POST["PERIOD_STATUS"])); 

// Add the missing seventh argument, e.g., $additional_param
$ADDITIONAL_PARAM = isset($_POST["ADDITIONAL_PARAM"]) ? $_POST["ADDITIONAL_PARAM"] : null;

$periodo = new Periodo(); 
$resultado = $periodo->editarPeriodo( 
	$PERIOD_ID, 
	$ACADEMIC_LAPSE, 
	$T_INTERNSHIPS_CODE, 
	$START_DATE, 
	$END_DATE, 
	$PERIOD_STATUS, 
	$ADDITIONAL_PARAM
); 
if ($resultado) { 
	echo "Periodo editado correctamente"; 
} else { 
	echo "Error al editar el periodo"; 
} 
} else { 
	echo "Faltan campos requeridos"; 
} 
} else { 
	echo "Método no permitido"; 
}
?>
