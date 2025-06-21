<?php require 'header.php'; ?>
<span class="text">Ventana → <a href="usuario.php">Configuración</a> → Nuevo Usuario</span>

<div class="page-content">


  <!-- Modal nuevo usuario -->
  <div id="modal" class="modal">
    <button class="primary" id="" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>
    <dialog id="dialog">
      <h2>Registrar Usuario</h2>
      <form id="formulario" class="formulario">
        <div class="formulario__grupo">
          <label>Usuario *</label>
          <input type="text" id="usuario" class="formulario__input" required>
        </div>
        <div class="formulario__grupo">
          <label>Nombre *</label>
          <input type="text" id="nombre" class="formulario__input" required>
        </div>
        <div class="formulario__grupo">
          <label>Rol *</label>
          <select id="rol" class="formulario__input" required>
            <option value="" disabled selected>Seleccione una opción</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </div>
        <div class="formulario__grupo">
          <label>Contraseña Provisional *</label>
          <div style="position: relative;">
            <input type="password" id="clave" class="formulario__input" autocomplete="new-password">
            <button type="button" id="toggleClave" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
              <i class="fa-solid fa-eye" id="iconoClave"></i>
            </button>
          </div>
        </div>


        <div class="formulario__grupo-btn-enviar">
          <button type="submit" class="formulario__btn">Guardar</button>
        </div>
      </form>
      <button class="x" id="btnCerrarModal" onclick="cerrarModal()">❌</button>
    </dialog>
  </div>
  <!-- Pestañas -->
  <div class="tabs">
    <button class="tab-button active" onclick="cambiarTabEstudiante('activos', event)">Usuarios Activos</button>
    <button class="tab-button" onclick="cambiarTabEstudiante('inactivos', event)">Usuarios Inactivos</button>
  </div>
  <!-- Tabla usuarios -->
  <table class="w3-table-all w3-hoverable">
    <thead>
      <tr class="w3-light-grey">
        <th>Cédula</th>
        <th>Nombre</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="datos"></tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="js/usuario.js"></script>

<script>
  const usuarioInput = document.getElementById("usuario");
  const claveInput = document.getElementById("clave");
  const toggleBtn = document.getElementById("toggleClave");
  const iconoClave = document.getElementById("iconoClave");

  // Solo permitir números en campo Usuario
  usuarioInput.addEventListener("input", () => {
    usuarioInput.value = usuarioInput.value.replace(/\D/g, "");
    claveInput.value = usuarioInput.value; // Llenar contraseña automáticamente
  });

  // Mostrar/Ocultar contraseña con clic
  toggleBtn.addEventListener("click", () => {
    const esTexto = claveInput.type === "text";
    claveInput.type = esTexto ? "password" : "text";
    iconoClave.classList.toggle("fa-eye", esTexto);
    iconoClave.classList.toggle("fa-eye-slash", !esTexto);
  });
</script>

<?php require 'footer.php'; ?>