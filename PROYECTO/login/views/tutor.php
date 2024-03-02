<?php 
require 'header.php';
?>


    <div class="container">
        <div class="titulo">Registro Tutor Empresarial</div>
        <form id="task-form">
            <div class="user-details">
                <div class="input-box">
                    <input type="hidden" id="id">
                    <span class="detalles">Cédula</span>
                    <div class="input-box-rif">
                        <select id="" class="selecion" name="tipo-cedula" >
                            <option value="">V-</option>
                            <option value="">E-</option>
                            <option value="">J-</option>
                            <option value="">G-</option>
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
                    <select id="genero" aria-placeholder="Genero" class="selector" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                    </select>
                </div>

                <div class="input-box">
                    <span class="detalles">Dirección</span>
                    <input type="text" id="direccion" placeholder="Dirección"  class="campo-entrada" required>
                </div>

                <div class="input-box">
                    <span class="detalles">Profesión</span>
                    <select id="profesion" class="selector" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                </div>
                <div class="input-box">
                    <span class="detalles">Empresa</span>
                    <select id="empresa" class="selector" required>
                        <option value="" disabled selected>Seleccione una opción</option>>
                    </select>
                </div>
            </div>
                
                <div class="button">
                   <button type="submit" value="Registrar">Registrar</button>
                </div>
         
        </form>
    </div>

    <div class="resultado">
    <table border="1">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Género</th>
                <th>Dirección</th>
                <th>Profesión</th>
                <th>Empresa</th>
                <th colspan="2">Acción</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>
</div>
<br>
 <!-- <footer>
    <h3>aaaaaaaaaaa</h3>
</footer>
      -->
    
    
    
    
    
    
    <script src="js/tutor_empresarial/jquery-3.7.0.min.js"></script>
    <script src="js/tutor_empresarial/main.js"></script>
</body>
</html>