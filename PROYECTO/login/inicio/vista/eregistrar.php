<!DOCTYPE html>
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

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@s5.0.2/dist/css/bootstrap.min.css">
        <script scr="https://cdn.jsdelivr.net/npm/bootstrap@s5.0.2/dist/js/bootstrap.bundle.min.js"></script>

		<script src="assets/js/bootstrap.min.js" ></script>
	</head>
	
<body class="py-3">

<main class="container contenedor">
	<div class="p-3 rounded">
	<div class="row">
        <div class="col">
            <h4>Registrar Empleado</h4>
        </div>
    </div>

	<div class="row">
		<div class="col">
			<form class="row g-3" id="nuevo" name="nuevo" method="POST" action="index.php?c=empleados&a=guarda" autocomplete="off">

				<div class="col-md-4">
					<label for="id">#</label>
					<input type="text"name="id" class="form-control"/>
				</div>
				
				<div class="col-md-4">
					<label for="nombre">Nombre</label>
					<input type="text"name="nombre" class="form-control" required/>
				</div>
				
				<div class="col-md-4">
					<label for="apellido">Apellido</label>
					<input type="text" name="apellido"class="form-control" required />
				</div>
				
				<div class="col-md-4">
					<label for="telefono">Telefono</label>
					<input type="tel" name="telefono" class="form-control" required/>
				</div>

				<div class="col-md-4">
					<label for="idManager">Manager</label>
					<input type="text" name="idManager" class="form-control" required/>
				</div>
				
				
				<div class="col-md-4">
					<label for="idDepartamento">Departamento</label>
					<input type="text" name="idDepartamento" class="form-control" required/>
				</div>

				<div class="col-md-4">
					<label for="salario">Salario</label>
					<input type="text" name="salario" class="form-control" required/>
				</div>

				<div class="col-md-4">
					<label for="fecha_contrato">Fecha de Contratación</label>
					<input type="datetime-local" name="fecha_contrato" class="form-control" required/>
				</div>
				
				<div class="col-md-12">
                    <a class="btn btn-secondary" href="index.php?c=empleados&a=index">Regresar</a>
                    <button class="btn btn-primary" id="guarda" name="guarda" type="submit">Guardar</button>
                </div>		
	</form>
		</div>
	</div>

	</div>
</main>

<script>
    
(function(){
    'use strict'
    var forms =document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
    .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefaul()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</body>
</html>