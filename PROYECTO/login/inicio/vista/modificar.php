<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Actualizar Cliente</title>
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
		<div class="container">
			
			<h2>Actualizar CLiente</h2>
			
			<form id="nuevo" name="nuevo" method="POST" action="index.php?c=personas&a=actualizar" autocomplete="off" class="form-group">
				
				<input type="hidden" id="id" name="id" value="<?php echo $data["id"]; ?>" />
				
				<div class="list-group">
					<label for="nombre">Nombre</label>
					<input type="text"  class="form-control" id="nombre" name="nombre" value="<?php echo $data["personas"]["Fname"]?>" />
				</div>
				
				<div class="list-group">
					<label for="apellido">Apellido</label>
					<input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $data["personas"]["Lname"]?>" />
				</div>
				
				<div class="list-group">
					<label for="correo_electronico">Correo</label>
					<input type="text" class="form-control" id="correo_electronico" name="correo_electronico" value="<?php echo $data["personas"]["Email"]?>" />
				</div>
				
				<div class="list-group">
					<label for="nro_de_telefono">Telefono</label>
					<input type="text" class="form-control" id="nro_de_telefono" name="nro_de_telefono" value="<?php echo $data["personas"]["PhoneNumber"]?>" />
				</div>
				
				<div class="list-group">
					<label for="forma__de_contactar">Como contactar</label>
					<input type="text" class="form-control" id="forma__de_contactar" name="forma__de_contactar" value="<?php echo $data["personas"]["preferredcontact"]?>" />
				</div>
				
				<div class="col-md-12">
                	<a class="btn btn-secondary" href="index.php?c=personas&a=index">Regresar</a>
                	<button id="guardar" name="guardar" type="submit" class="btn btn-primary">Guardar</button>
                </div>
				
			</form>
		</body>
	</html>		