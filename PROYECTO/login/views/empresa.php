<?php 
require 'header.php';
?>

 <div class="container">
        <div class="titulo">Registro Empresa</div>
        <form id="task-form">
            <div class="user-details">
                <div class="input-box ">
                    <input type="hidden" id="id">
                    <span class="detalles">Rif</span>
                    <div class="input-box-rif">
                    <select id="rif" name="tipo-cedula" required>
                        <option value="V-">V-</option>
                        <option value="E-">E-</option>
                        <option value="J-">J-</option>
                        <option value="G-">G-</option>
                        <option value="P-">P-</option>
                     
                      </select>
                    <input type="text" id="rif2" placeholder="Rif"  class="campo-entrada" required>
                </div>
                </div>
                
                <div class="input-box">
                    <span class="detalles">Empresa</span>
                    <input type="text" id="nombre" placeholder="Nombre de la Empresa"  class="campo-entrada" required>
                </div>

                <div class="input-box">
                    <span class="detalles">Dirección</span>
                    <input type="text" id="direccion" placeholder="Dirección"  class="campo-entrada" required>
                </div>

                <div class="input-box">
                    <span class="detalles">Nombre de Contacto</span>
                    <input type="text" id="nombre_contacto" placeholder="Nombre de Contacto" max="2008-12-31"  class="campo-entrada" required>
                </div>

                <div class="input-box ">
                    <span class="detalles">Teléfono de Contacto</span>
                    <div class="input-box-telefono">
                    <select id="telefono_contacto" required>
                        <option value="0412-">0412-</option>
                        <option value="0414-">0414-</option>
                        <option value="0424-">0424-</option>
                        <option value="0426-">0426-</option>
                        <option value="0255-">0255-</option>
                     
                      </select>
                    <input type="text" id="telefono_contacto2" placeholder="Teléfono"  class="campo-entrada" required>
                </div>
                </div>

                <div class="input-box">
                    <span class="detalles">Teléfono de Empresa</span>
                    <div class="input-box-telefono">
                        <select id="telefono_empresa" required>
                            <option value="0412-">0412-</option>
                            <option value="0414-">0414-</option>
                            <option value="0424-">0424-</option>
                            <option value="0426-">0426-</option>
                            <option value="0255-">0255-</option>
                        </select>
                        <input type="text" id="telefono_empresa2" placeholder="Teléfono "  class="campo-entrada" required>
                    </div>
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
                <th>RIF</th>
                <th>Nombre De Empresa</th>
                <th>Dirección Empresa</th>
                <th>Nombre De Contacto</th>
                <th>Teléfono De Contacto</th>
                <th>Teléfono De Empresa</th>
                <th colspan="2">Acción</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>
</div>
    
    
    
    
    
    
    
    
    <script
  src="https://code.jquery.com/jquery-3.6.4.min.js"
  integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
  crossorigin="anonymous"></script>
    <script src="js/empresa/main.js"></script>
    <script src="js/empresa/valida.js"></script>
</body>
</html>