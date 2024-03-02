<?php 
require 'header.php';
?>

    <div class="container">
        <div class="titulo">Registro Lapso Académico</div>
        <form id="task-form">
            <div class="user-details">
                <div class="input-box">
                    <input type="hidden" id="id">
                    <span class="detalles">Código</span>
                    <input type="text" readonly id="codigo" placeholder="Código"  class="campo-entrada" required>
                </div>
                
                <div class="input-box">
                    <span class="detalles">Lapso Académico</span>
                    <input type="text" id="nombre" placeholder="Lapso Académico"  class="campo-entrada" required>
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
                <th id="dato-actual" colspan="5">Lapso Actual:</th>
            </tr>
              <tr>
                  <th>Código</th>
                  <th>Lapso Académico</th>
                  <th colspan="3">Accion</th>
              </tr>
          </thead>
          <tbody id="datos"></tbody>
      </table>
    </div>
    
    
    
    
    
    
    
<script src="js/lapso/jquery-3.7.0.min.js"></script>    
<script src="js/lapso/main.js"></script>    
    <script src="js/lapso/validar.js"></script>
</body>
</html>