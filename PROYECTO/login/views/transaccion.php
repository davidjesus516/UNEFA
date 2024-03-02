<?php 
require 'header.php';
?>

    <div class="container">
        <div class="titulo">Transacción de Estudiante</div>
        <form id="task-form" >
            <div class="user-details">

                <div class="input-box">
                    <span class="detalles">Lapso Academico</span>
                    <select name="lapso_academico" id="lapso" class="selector" required>
                    </select>
                </div>

                
                <div class="input-box">
                    <span class="detalles">Carrera</span>
                    <select name="carrera" id="carrera" class="selector" required>
                    </select>
                </div>


                <div class="input-box">
                    <span class="detalles">Cedula del Estudiante</span>
                    <input type="text" name="" id="search" placeholder="Buscar Cedula..." class="campo-entrada" class="validacion" required>
                    <select name="estudiante" id="estudiante" class="selector" required>
                    </select>
                </div>
                
                <div class="input-box">
                    <span class="detalles">Empresa</span>
                    <input type="text" name="" id="empresaSearch" placeholder="Buscar Rif..." class="campo-entrada" required>
                    <select name="empresa" id="empresa" class="selector" required>
                    </select>
                </div>

                <div class="input-box">
                    <span class="detalles">Docente</span>
                    <input type="text" name="" id="docenteSearch" placeholder="Buscar Cedula..."  class="campo-entrada" required>
                    <select name="estudiante" id="docente" class="selector" required>
                    </select>
                </div>

                <div class="input-box">
                    <span class="detalles">Tutor Empresarial</span>
                    <input type="text" name="" id="tutorSearch" placeholder="Buscar Cedula..."  class="campo-entrada" required>
                    <select name="estudiante" id="tutor" class="selector" required>
                    </select>
                </div>
                
            </div>
            
                <div class="button">
                   <button type="submit" value="Enviar">Enviar</button>
                </div>
         
        </form>
    </div>

    

    <script src="js/transaccion_estudiante/jquery-3.7.0.min.js"></script>
    <script src="js/transaccion_estudiante/main.js"></script>
    <script src="js/transaccion_estudiante/validar.js"></script>
    <script>
        function imprimir(){
            window.print();
        }
    </script>
</body>
</html>