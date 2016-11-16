<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }

  function _print_menu()
  { ?>
    <div class="top-banner-grids wow bounceInUp" data-wow-delay="0.4s">
      <a href="/radiologo">
        <div class="banner-grid text-center" id="btn-pagina-principal">
          <span class="top-icon1"></span>
          <h3>Pagina Principal</h3>
        </div>
      </a>
      <a href="buscar-paciente.php">
        <div class="banner-grid text-center" id="btn-buscar-paciente">
          <span class="top-icon2"></span>
          <h3>Buscar Paciente</h3>
        </div>
      </a>
      <!-- a href="edit.php">
        <div class="banner-grid text-center">
          <span class="top-icon3"></span>
          <h3>Actualizar mis Datos</h3>
        </div>
      </a-->
      <a href="../logout.php">
        <div class="banner-grid text-center">
          <span class="top-icon5"></span>
          <h3>Cerrar Sesión</h3>
        </div>
      </a>
      <div class="clearfix"></div>
    </div>
  <?php } ?>