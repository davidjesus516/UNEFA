<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<title>Registrar Cliente</title>
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
                    <h4>Registrar Cliente</h4>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form class="row g-3" id="nuevo" name="nuevo" method="POST" action="index.php?c=personas&a=guarda" autocomplete="off">

                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>

                            <div class="valid-feedback">
                            Correcto!
                            </div>
                            <div class="invalid-feedback">
                            Por favor, ingrese el nombre.
                            </div>

                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" required>

                            <div class="valid-feedback">
                            Correcto!
                            </div>
                            <div class="invalid-feedback">
                            Por favor, ingrese el apellido.
                            </div>

                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="correo_electronico" class="form-label">Correo</label>
                            <input type="email" name="correo_electronico" id="correo_electronico" class="form-control" required>

                            <div class="valid-feedback">
                            Correcto!
                            </div>
                            <div class="invalid-feedback">
                            Por favor, ingrese el correo.
                            </div>

                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="nro_de_telefono" class="form-label">Telefono</label>
                            <input type="number" name="nro_de_telefono" id="nro_de_telefono" class="form-control">

                            <div class="valid-feedback">
                            Correcto!
                            </div>
                            <div class="invalid-feedback">
                            Por favor, ingrese el número de telefono.
                            </div>

                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="forma__de_contactar" class="form-label">Como Contactar</label>
                            <input type="text" name="forma__de_contactar" id="forma__de_contactar" class="form-control" required>

                            <div class="valid-feedback">
                            Correcto!
                            </div>
                            <div class="invalid-feedback">
                            Por favor, diga como contactar.
                            </div>

                        </div>
                        <br>

                        <div class="col-md-12">
                            <a class="btn btn-secondary" href="index.php">Regresar</a>
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