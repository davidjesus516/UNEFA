<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Paises</title>
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
				<th>ISO</th>
				<th>ISO3</th>
				<th>Isonumerico</th>
				<th>Pais</th>
				<th>Capital</th>
				<th>Codigo Continente</th>
				<th>Codigo Moneda</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data["paises"] as $dato) {
				echo "<tr>";
				echo "<td>".$dato["ISO"]."</td>";
				echo "<td>".$dato["ISO3"]."</td>";
				echo "<td>".$dato["ISONumeric"]."</td>";
				echo "<td>".$dato["CountryName"]."</td>";
				echo "<td>".$dato["Capital"]."</td>";
				echo "<td>".$dato["ContinentCode"]."</td>";
				echo "<td>".$dato["CurrencyCode"]."</td>";
				echo "<td><a href='index.php?c=paises&a=modificar&id=".$dato["Id"]."' class='btn btn-warning'>Modificar</a></td>";
				echo "<td><a href='index.php?c=paises&a=eliminar&id=".$dato["Id"]."' class='btn btn-danger'>Eliminar</a></td>";
				echo "</tr>";
			} ?>
		</tbody>
	</table>
	<a href="index.php?c=paises&a=nuevo" class="btn btn-primary pull-right">Agregar Pais</a>
	</div>
</main>

	
</body>
</html>