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
    background: linear-gradient(744deg, #192dd4, #0035ff 60%, #00ddeb);
  }

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

<!-- <div class="cards">
  <div class="card playing">
    <div class="image"></div>

    <div class="wave"></div>
    <div class="wave"></div>
    <div class="wave"></div>


    <div class="infotop">
      <br>
      T.S.U. Enfermería
      <br>
      <h5>N estudiantes</h5>
    </div>
  </div>

  <div class="card playing">
    <div class="image"></div>

    <div class="wave"></div>
    <div class="wave"></div>
    <div class="wave"></div>


    <div class="infotop">
      <br>

      <br>
      <h5>N estudiantes</h5>
    </div>
  </div>
</div> -->
<br>
<div class="contenedor-botones">
  <button class="primary" onclick="window.dialog.showModal();">Listado Practicas Profesionales</button>
  <div class="botones-adicionales">
    <button class="primary secundario">Enfermería</button>
    <button class="primary secundario">Ingeniería</button>
  </div>
</div>

<button class="primary-white">Agregar Practicas Profesionales <span>+</span></button>

<!-- <div class="tooltip-container">
  <div class="icon">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50">
      <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 22c-5.518 0-10-4.482-10-10s4.482-10 10-10 10 4.482 10 10-4.482 10-10 10zm-1-16h2v6h-2zm0 8h2v2h-2z"></path>
    </svg>
  </div>
  <div class="tooltip">
    <p>Alerts users to save their progress before leaving a page</p>
  </div>
</div> -->


<?php
require 'footer.php';
?>