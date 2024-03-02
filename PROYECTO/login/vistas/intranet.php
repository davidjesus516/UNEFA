
<?php
require 'header.php';
?>
<style>

</style>
<span class="text">Inicio</span>
<!-- <button id="open-modal-btn">Open Modal</button>

<button id="open-modal-btn">Open Modal</button> -->

<div id="modal" class="modal">
  <button class="primary" onclick="window.dialog.showModal();">Abrir Dialogo</button>

  <dialog id="dialog">
    <h2>Hello.</h2>
    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    <!-- <p>You can also change the styles of the <code>::backdrop</code> from the CSS.</p> -->
    <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
  </dialog>
</div>
<?php
require 'footer.php';
?>