<?php
require 'header.php';
?>
<style>
    .contenedor-mensaje {
        display: flex;
        flex-direction: column;
        /* Coloca los elementos uno debajo del otro */
        align-items: center;
        /* Centra los elementos del contenedor */
    }

    .mensaje {
        font-size: larger;
        font-weight: bold;
        text-align: center;
    }

    /* Estilo para el SVG (opcional, puedes ajustar el tamaño aquí también) */
    .contenedor-mensaje img {
        max-width: 70vh;
        /* Asegura que el SVG no sea demasiado grande */
        height: auto;
    }
</style>
<div class="contenedor-mensaje" >
    <img src="../../img/construccion_5.svg" alt="" style="height: 30rem;">
    
    <p class="mensaje">ESTA PÁGINA ESTA EN CONSTRUCCIÓN!<br>PROXIMAMENTE ESTARÁ EN FUNCIONAMIENTO!</p>
    <p class="mensaje">Regresar al <a href="intranet.php">inicio</a></p>
</div>
<?php
require 'footer.php';
?>