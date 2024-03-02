<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Actualizar Pais</title>
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
			
			<h2>Actualizar Pais</h2>
			
			<form id="nuevo" name="nuevo" method="POST" action="index.php?c=paises&a=actualizar" autocomplete="off">
				
				<input type="hidden" id="id" name="id" value="<?php echo $data["id"]; ?>" />
				
				<div class="col-md-4">
					<label class="form-label" for="iso">ISO</label>
					<input type="text"  class="form-control" id="iso" name="iso" value="<?php echo $data["paises"]["ISO"]?>" />
				</div>
				
				<div class="col-md-4">
					<label class="form-label" for="iso3">ISO3</label>
					<input type="text" class="form-control" id="iso3" name="iso3" value="<?php echo $data["paises"]["ISO3"]?>" />
				</div>
				
				<div class="col-md-4">
					<label class="form-label" for="isonumerico">ISO Numerico</label>
					<input type="text" class="form-control" id="isonumerico" name="isonumerico" value="<?php echo $data["paises"]["ISONumeric"]?>" />
				</div>
				
				<div class="col-md-4">
					<label class="form-label" for="pais">Pais</label>
					<input type="text" class="form-control" id="pais" name="pais" value="<?php echo $data["paises"]["CountryName"]?>" />
				</div>
				
				<div class="col-md-4">
					<label class="form-label" for="capital">Capial</label>
					<input type="text" class="form-control" id="capital" name="capital" value="<?php echo $data["paises"]["Capital"]?>" />
				</div>
				<div class="col-md-4">
					<label class="form-label" for="continente">Continente</label>
					<input type="text" class="form-control" id="continente" name="continente" value="<?php echo $data["paises"]["ContinentCode"]?>" />
				</div>
				<div class="col-md-4">
					<label class="form-label" for="moneda">Moneda</label>
					<input type="text" class="form-control" id="moneda" name="moneda" value="<?php echo $data["paises"]["CurrencyCode"]?>" />
				</div>
				
				<div class="col-md-12">
                	<a class="btn btn-secondary" href="index.php?c=paises&a=index">Regresar</a>
                	<button id="guardar" name="guardar" type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</form>
		</body>
	</html>		