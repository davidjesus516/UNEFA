<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<title>Registrar</title>
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
                    <h4>Registrar</h4>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form class="row g-3" id="nuevo" name="nuevo" method="POST" action="index.php?c=example&a=guarda" autocomplete="off">

                        <div class="col-md-4">
                            <label for="campo1" class="form-label">Campo 1</label>
                            <input type="text" name="campo1" id="campo1" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="campo2" class="form-label">Campo 2</label>
                            <input type="text" name="campo2" id="campo2" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="campo3" class="form-label">Campo 3</label>
                            <input type="text" name="campo3" id="campo3" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="campo4" class="form-label">Campo 4</label>
                            <input type="text" name="campo4" id="campo4" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="campo5" class="form-label">Campo 5</label>
                            <input type="text" name="campo5" id="campo5" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <a class="btn btn-secondary" href="index.php?c=example&a=index">Regresar</a>
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
})
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</body>

</html>