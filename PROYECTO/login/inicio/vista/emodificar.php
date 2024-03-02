<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Actualizar Empleado</title>
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
			
			<h2>Actualizar Empleado</h2>
			
			<form id="nuevo" name="nuevo" method="POST" action="index.php?c=empleados&a=actualizar" autocomplete="off" class="form-group">
				
				<div class="list-group">
					<label for="id">#</label>
					<input type="text"  class="form-control" id="id" name="id" value="<?php echo $data["empleados"]["Id"]?>" />
				</div>

				<div class="list-group">
					<label for="nombre">Nombre</label>
					<input type="text"  class="form-control" id="nombre" name="nombre" value="<?php echo $data["empleados"]["FName"]?>" />
				</div>
				
				<div class="list-group">
					<label for="apellido">Apellido</label>
					<input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $data["empleados"]["LName"]?>" />
				</div>
				
				<div class="list-group">
					<label for="telefono">Telefono</label>
					<input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $data["empleados"]["PhoneNumber"]?>" />
				</div>
				
				<div class="list-group">
					<label for="idManager">Id Manager</label>
					<input type="text" class="form-control" id="idManager" name="idManager" value="<?php echo $data["empleados"]["ManagerId"]?>" />
				</div>
				
				<div class="list-group">
					<label for="idDepartamento">Id Departamento</label>
					<input type="text" class="form-control" id="idDepartamento" name="idDepartamento" value="<?php echo $data["empleados"]["DepartamentId"]?>" />
				</div>
				<div class="list-group">
					<label for="salario">Salario</label>
					<input type="text" class="form-control" id="salario" name="salario" value="<?php echo $data["empleados"]["Salary"]?>" />
				</div>
				<div class="list-group">
					<label for="fecha_contrato">Fecha de Contrato</label>
					<input type="datetime-local" class="form-control" id="fecha_contrato" name="fecha_contrato" value="<?php echo $data["empleados"]["HireDate"]?>" />
				</div>
				
				<div class="col-md-12">
                	<a class="btn btn-secondary" href="index.php?c=empleados&a=index">Regresar</a>
                	<button id="guardar" name="guardar" type="submit" class="btn btn-primary">Guardar</button>
                </div>
				
			</form>
		</body>
	</html>		