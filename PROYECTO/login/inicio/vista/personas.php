<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Clientes</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="css/styles.css">

		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/estilos.css">
		<link rel="stylesheet" href="js/bootstrap.bundle.min.js">
		<link rel="stylesheet" href="js/jquery-3.6.0.min.js">

		<script src="assets/js/bootstrap.min.js" ></script>
	</head>

<script type="text/javascript">
	
function ConfirmDelete()
{
	var respuesta = confirm("¿Estas seguro de Eliminar?");

	if (respuesta == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

</script>

<body class="py-3">

<main class="container contenedor">
	
	<div class="row py-3 col">
	<a href="../index.php" class="btn btn-primary pull-right">Inicio</a>
	</div>
	<br>
	<table class="table table-border">
		<thead>	
			<tr>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Correo Electronico</th>
				<th>Telefono</th>
				<th>Forma de contactar</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data["personas"] as $dato) {
				echo "<tr>";
				echo "<td>".$dato["Fname"]."</td>";
				echo "<td>".$dato["Lname"]."</td>";
				echo "<td>".$dato["Email"]."</td>";
				echo "<td>".$dato["PhoneNumber"]."</td>";
				echo "<td>".$dato["preferredcontact"]."</td>";
				echo "<td><a href='index.php?c=personas&a=modificar&id=".$dato["id"]."' class='btn btn-warning'>Modificar</a></td>";
				echo "<td><a href='index.php?c=personas&a=eliminar&id=".$dato["id"]."' class='btn btn-danger' onclick='return ConfirmDelete()'>Eliminar</a></td>";
				echo "</tr>";
			} ?>
		</tbody>
	</table>
	<a href="index.php?c=personas&a=nuevo" class="btn btn-primary pull-right">Agregar Cliente</a>
</main>
	
</body>
</html>