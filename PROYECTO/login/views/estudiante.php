
<?php 
require 'header.php';
?>

<div class="container">
        <div class="titulo">Registro Estudiante</div>
        <form id="task-form">
            <div class="user-details">
                <div class="input-box">
                    <input type="hidden" id="id">
                    <span class="detalles">Cédula</span>
                    <div class="input-box-rif">
                        <select id="" class="selecion" name="tipo-cedula">
                            <option value="">V-</option>
                            <option value="">E-</option>
                            <option value="">P-</option>
                         
                          </select>
                          <input type="text" id="cedula" placeholder="Cedula"  class="campo-entrada" required>
                    </div>
                </div>
                
                <div class="input-box">
                    <span class="detalles">Nombre</span>
                    <input type="text" id="nombre" placeholder="Nombre"  class="campo-entrada" required>
                </div>

                <div class="input-box">
                    <span class="detalles">Apellido</span>
                    <input type="text" id="apellido" placeholder="Apellido"  class="campo-entrada" required>
                </div>

                <div class="input-box">
                    <span class="detalles">Género</span>
                    <select id="genero" aria-placeholder="Género" class="selector" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                    </select>
                </div>


                <div class="input-box">
                    <span class="detalles">Dirección</span>
                    <input type="text" id="direccion" placeholder="Dirección"  class="campo-entrada" required>
                </div>

            </div>
                
                <div class="button">
                   <button type="submit" value="Registrar">Registrar</button>
                </div>
        </form>

<div class="resultado">
    <table border="1">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Género</th>
                <th>Dirección</th>
                <th colspan="2">Acción</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>
</div>
    
    
    
    
    
    
    
    
<script src="js/estudiante/jquery-3.7.0.min.js"></script>
<script src="js/estudiante/main.js"></script>        
</body>
</html>