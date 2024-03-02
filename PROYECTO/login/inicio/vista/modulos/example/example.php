<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Example</title>
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
	<a href="../admin.php" class="btn btn-primary pull-right">Home</a>
	</div>
	<br>
	<table class="table table-border">
		<thead>	
			<tr>
				<th>Campo 1</th>
				<th>Campo 2</th>
				<th>Campo 3</th>
				<th>Campo 4</th>
				<th>Campo 5</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data["example"] as $dato) {
				echo "<tr>";
				echo "<td>".$dato["Campo1"]."</td>";
				echo "<td>".$dato["Campo2"]."</td>";
				echo "<td>".$dato["Campo3"]."</td>";
				echo "<td>".$dato["Campo4"]."</td>";
				echo "<td>".$dato["Campo5"]."</td>";
				echo "<td><a href='index.php?c=example&a=modificar&id=".$dato["id"]."' class='btn btn-warning'>Modificar</a></td>";
				echo "<td><a href='index.php?c=example&a=eliminar&id=".$dato["id"]."' class='btn btn-danger' onclick='return ConfirmDelete()'>Eliminar</a></td>";
				echo "</tr>";
			} ?>
		</tbody>
	</table>
	<a href="index.php?c=example&a=nuevo" class="btn btn-primary pull-right">Agregar</a>
</main>
	
</body>
</html>