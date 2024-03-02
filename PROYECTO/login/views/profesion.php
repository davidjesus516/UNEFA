<?php 
require 'header.php';
?>

  <div class="container">
    <div class="titulo">Registro Profesión</div>
    <form id="task-form">
        <div class="user-details">
            <div class="input-box">
                <span class="detalles">Código</span>
                <input type="text" readonly id="codigo" placeholder="Código"  class="campo-entrada" required>
            </div>
            
            <div class="input-box">
                <span class="detalles">Profesión</span>
                <input type="text" id="nombre" placeholder="Nombre de la Profesión"  class="campo-entrada" required>
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
              <th>Código</th>
              <th>Profesión</th>
              <th colspan="2">Acción</th>
          </tr>
      </thead>
      <tbody id="datos"></tbody>
  </table>
</div>

<script src="js/profesion/jquery-3.7.0.min.js"></script>    
<script src="js/profesion/main.js"></script>    
    <script src="js/profesion/validar.js"></script>
</body>
</html>