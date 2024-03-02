<?php 
require 'header.php';
?>

    <div class="container">
        <div class="titulo">Cierre de Pasantia</div>
        <form id="task-form" >
            <div class="user-details">
                
                <div class="input-box">
                    <span class="detalles">Campo Aprobado</span>
                    <select name="carrera" id="carrera" class="selector" required>
                    </select>
                </div>


                <div class="input-box">
                    <span class="detalles">Buscar Inscripcion:</span>
                    <input type="text" name="" id="search" placeholder="Buscar Inscripcion..." class="campo-entrada" class="validacion" required>
                    <select name="estudiante" id="estudiante" class="selector" required>
                    </select>
                </div>
                
                <div class="input-box">
                    <span class="detalles">Buscar Area de Investigacion</span>
                    <input type="text" name="" id="areaSearch" placeholder="Buscar Area..." class="campo-entrada" required>
                    <select name="empresa" id="area" class="selector" required>
                    </select>
                </div>

                <div class="input-box">
                    <span class="detalles">Titulo del Proyecto</span>
                    <input type="text" name="" id="titulo-proyecto" placeholder="Buscando..."  class="campo-entrada" required>
                </div>
                
            </div>
            
                <div class="button">
                   <button type="submit" value="Enviar">Enviar</button>
                </div>
         
        </form>
    </div>

    

    <script src="js/cierre_pasantia/jquery-3.7.0.min.js"></script>
    <script src="js/cierre_pasantia/main.js"></script>
    <script src="js/cierre_pasantia/validar.js"></script>
    <script>
        function imprimir(){
            window.print();
        }
    </script>
</body>
</html>