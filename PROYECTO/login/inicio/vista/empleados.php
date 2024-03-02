<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Registrar Empleado</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="css/styles.css">

		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/estilos.css">
		<link rel="stylesheet" href="js/bootstrap.bundle.min.js">
		<link rel="stylesheet" href="js/jquery-3.6.0.min.js">

		<script src="assets/js/bootstrap.min.js" ></script>
	</head>
<body class="py-3">

<main class="container contenedor">
	<div class="row py-3 col">
	<a href="../index.php" class="btn btn-primary pull-right">Inicio</a>
	</div>
	<br>
	<table class="table table-border">
		<thead>	
			<tr>
				<th">#</th>
				<th">Nombre</th>
				<th">Apellido</th>
				<th">Telefono</th>
				<th">idManager</th>
				<th">idDepartamento</th>
				<th">Salario</th>
				<th">Fecha de Contratación</th>
				<th"></th>
				<th"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data["empleados"] as $dato) {
				echo "<tr>";
				echo "<td>".$dato["Id"]."</td>";
				echo "<td>".$dato["FName"]."</td>";
				echo "<td>".$dato["LName"]."</td>";
				echo "<td>".$dato["PhoneNumber"]."</td>";
				echo "<td>".$dato["ManagerId"]."</td>";
				echo "<td>".$dato["DepartamentId"]."</td>";
				echo "<td>".$dato["Salary"]."</td>";
				echo "<td>".$dato["HireDate"]."</td>";
				echo "<td><a href='index.php?c=empleados&a=modificar&id=".$dato["Id"]."' class='btn btn-warning'>Modificar</a></td>";
				echo "<td><a href='index.php?c=empleados&a=eliminar&id=".$dato["Id"]."' class='btn btn-danger'>Eliminar</a></td>";
				echo "</tr>";
			} ?>
		</tbody>
	</table>
	<a href="index.php?c=empleados&a=nuevo" class="btn btn-primary pull-right">Agregar Empleados</a>
</main>
	
</body>
</html>