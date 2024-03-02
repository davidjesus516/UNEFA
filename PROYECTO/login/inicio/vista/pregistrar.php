<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<title>Registrar Pais</title>
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
                    <h4>Registrar Pais</h4>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form class="row g-3" id="nuevo" name="nuevo" method="POST" action="index.php?c=paises&a=guarda" autocomplete="off">

                        <div class="col-md-4">
                            <label for="iso" class="form-label">ISO</label>
                            <input type="text" name="iso" id="iso" class="form-control" required>
                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="iso3" class="form-label">ISO 3</label>
                            <input type="text" name="iso3" id="iso3" class="form-control" required>
                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="isonumerico" class="form-label">ISO Númerico</label>
                            <input type="text" name="isonumerico" id="isonumerico" class="form-control" required>
                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="pais" class="form-label">Pais</label>
                            <input type="text" name="pais" id="pais" class="form-control" required>
                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="capital" class="form-label">Capital</label>
                            <input type="text" name="capital" id="capital" class="form-control" required>
                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="continente" class="form-label">Continente</label>
                            <input type="text" name="continente" id="continente" class="form-control" required>
                        </div>
                        <br>

                        <div class="col-md-4">
                            <label for="moneda" class="form-label">Moneda</label>
                            <input type="text" name="moneda" id="moneda" class="form-control" required>
                        </div>
                        <br>

                        <div class="col-md-12">
                            <a class="btn btn-secondary" href="index.php?c=paises&a=index">Regresar</a>
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