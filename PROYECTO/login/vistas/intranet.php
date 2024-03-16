<?php
require 'header.php';
?>
<style>
  .e-card {
    margin: 20PX;
    background: transparent;
    box-shadow: 0px 8px 28px -9px rgba(0, 0, 0, 0.45);
    position: relative;
    width: 160PX;
    height: 260px;
    border-radius: 16px;
    overflow: hidden;
  }

  .wave {
    position: absolute;
    width: 540px;
    height: 700px;
    opacity: 0.6;
    left: 0;
    top: 0;
    margin-left: -50%;
    margin-top: -70%;
    background: linear-gradient(744deg, #192dd4, #0035ff 60%, #00ddeb);  }

  .icon {
    width: 3em;
    margin-top: -5em;
    padding-bottom: 1em;
  }

  .infotop {
    text-align: center;
    font-size: 17px;
    position: absolute;
    top: 2rem;
    left: 0;
    right: 0;
    color: rgb(255, 255, 255);
    font-weight: 600;
  }

  .name {
    font-size: 8px;
    font-weight: 100;
    position: relative;
    top: 1em;
    text-transform: lowercase;
    scale: 0.9;
  }

  .name p {
    color: #fff;
  }

  .wave:nth-child(2),
  .wave:nth-child(3) {
    top: 210px;
  }

  .playing .wave {
    border-radius: 40%;
    animation: wave 3000ms infinite linear;
  }

  .wave {
    border-radius: 40%;
    animation: wave 55s infinite linear;
  }

  .playing .wave:nth-child(2) {
    animation-duration: 4000ms;
  }

  .wave:nth-child(2) {
    animation-duration: 50s;
  }

  .playing .wave:nth-child(3) {
    animation-duration: 5000ms;
  }

  .wave:nth-child(3) {
    animation-duration: 45s;
  }

  @keyframes wave {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }
</style>
<span class="text">Inicio</span>

<!-- A Continuacion un ejemplo del modal utilizado en el proyecto
  
<div id="modal" class="modal">
  <button class="primary" onclick="window.dialog.showModal();">Abrir Dialogo</button>

  <dialog id="dialog">
    <h2>Hello.</h2>
    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
  </dialog>
</div> -->

<div class="e-card playing">
  <div class="image"></div>

  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>


  <div class="infotop">
    <i class='bx bx-grid-alt icon'></i>
    <br>
    Periodo Actual
    <br>
    <div class="name" style="color: #fff;">Has el php que lo muestre</div>
  </div>
</div>
<script src="js/intranet/jquery-3.7.0.min.js"></script>
<script src="js/intranet/main.js"></script> 
<?php
require 'footer.php';
?>