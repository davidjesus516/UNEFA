<?php 
 ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Clientes</title>
		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
<body>

	<div class="table col-xl" id="bg">
	<a href="../index.php"><h1 class="lead">INICIO</h1></a>
	<br>
	<br>
	<table border=".5"  width="100%" class="table  table-striped  table-hover">
		<thead>	
			<tr>
				<th style=" background-color: #5DACCD; color:#fff">id</th>
				<th style=" background-color: #5DACCD; color:#fff">usuario</th>
				<th style=" background-color: #5DACCD; color:#fff">contraseña</th>
				<th style=" background-color: #5DACCD; color:#fff">tipo de rol</th>
				<th style=" background-color: #5DACCD; color:#fff">pregunta1</th>
				<th style=" background-color: #5DACCD; color:#fff">respuesta1</th>
				<th style=" background-color: #5DACCD; color:#fff">pregunta2</th>
				<th style=" background-color: #5DACCD; color:#fff">respuesta2</th>
			</tr>
		</thead>
		<tbody class="table">
			<?php foreach ($data["usuarios"] as $dato) {
				echo "<tr>";
				echo "<td>".$dato["id"]."</td>";
				echo "<td>".$dato["usuario"]."</td>";
				echo "<td>".$dato["password"]."</td>";
				echo "<td>".$dato["rol_id"]."</td>";
				echo "<td>".$dato["pregunta1"]."</td>";
				echo "<td>".$dato["respuesta1"]."</td>";
				echo "<td>".$dato["pregunta2"]."</td>";
				echo "<td>".$dato["respuesta2"]."</td>";
				echo "</tr>";
			} ?>
		</tbody>
	</table>
	</div>


	
</body>
</html>