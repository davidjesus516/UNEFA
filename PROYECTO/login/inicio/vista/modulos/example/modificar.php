<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Actualizar Cliente</title>
		<link rel="stylesheet" href="js/bootstrap.bundle.min.js">
		<link rel="stylesheet" href="js/jquery-3.6.0.min.js">
		<script src="assets/js/bootstrap.min.js" ></script>
	</head>
	
	<body class="py-3">
		<div class="container">
			
			<h2>Actualizar</h2>
			
			<form id="nuevo" name="nuevo" method="POST" action="index.php?c=example&a=actualizar" autocomplete="off" class="form-group">
				
				<input type="hidden" id="id" name="id" value="<?php echo $data["id"]; ?>" />
				
				<div class="list-group">
					<label for="campo1">Campo 1</label>
					<input type="text"  class="form-control" id="campo1" name="campo1" value="<?php echo $data["example"]["Campo1"]?>" />
				</div>
				
				<div class="list-group">
					<label for="campo2">Campo 2</label>
					<input type="text" class="form-control" id="campo2" name="campo2" value="<?php echo $data["example"]["Campo2"]?>" />
				</div>
				
				<div class="list-group">
					<label for="campo3">Campo 3</label>
					<input type="text" class="form-control" id="campo3" name="campo3" value="<?php echo $data["example"]["Campo3"]?>" />
				</div>
				
				<div class="list-group">
					<label for="campo4">Campo 4</label>
					<input type="text" class="form-control" id="campo4" name="campo4" value="<?php echo $data["example"]["Campo4"]?>" />
				</div>
				
				<div class="list-group">
					<label for="campo5">Campo 5</label>
					<input type="text" class="form-control" id="campo5" name="campo5" value="<?php echo $data["example"]["Campo5"]?>" />
				</div>
				
				<div class="col-md-12">
                	<a class="btn btn-secondary" href="index.php?c=example&a=index">Regresar</a>
                	<button id="guardar" name="guardar" type="submit" class="btn btn-primary">Guardar</button>
                </div>
				
			</form>
		</body>
	</html>		